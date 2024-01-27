<?php

namespace Anvts\Framework\Cli\Commands;

use Anvts\Framework\Cli\CommandInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;

class MigrateCommand implements CommandInterface
{
    private string $name = 'migrate';
    private const MIGRATIONS_TABLE_NAME = 'migrations';

    public function __construct(
        private Connection $connection,
        private string $migrationFilesPath
    )
    {
    }

    public function execute(array $args = []): int
    {
        try {
            $this->createMigrationsTable();
            $this->connection->beginTransaction();

            $appliedMigrations = $this->getAppliedMigrations();
            $migrationFiles = $this->getMigrationFiles();
            $migrationsToApply = array_values(array_diff($migrationFiles, $appliedMigrations));

            $schema = new Schema();

            foreach ($migrationsToApply as $migration) {
                $migrationInstance = require $this->migrationFilesPath . "/$migration";
                $migrationInstance->up($schema);
            }

            dd($schema);

            $this->connection->commit();
        } catch (\Throwable $e) {
            $this->connection->rollBack();
            throw $e;
        }

        return 0;
    }

    private function createMigrationsTable(): void
    {
        $schemaManager = $this->connection->createSchemaManager();

        if (!$schemaManager->tablesExist(self::MIGRATIONS_TABLE_NAME)) {
            $schema = new Schema();
            $table = $schema->createTable(self::MIGRATIONS_TABLE_NAME);

            $table->addColumn('id', Types::INTEGER, [
                'unsigned' => true,
                'autoincrement' => true
            ]);
            $table->addColumn('migration', Types::STRING);
            $table->addColumn('created_at', Types::DATETIME_IMMUTABLE, [
                'default' => 'CURRENT_TIMESTAMP'
            ]);

            $table->setPrimaryKey(['id']);

            $sqlArray = $schema->toSql($this->connection->getDatabasePlatform());
            $this->connection->executeQuery($sqlArray[0]);

            echo 'Migrations table created' . PHP_EOL;
        }
    }

    private function getAppliedMigrations(): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        return $queryBuilder
            ->select('migration')
            ->from(self::MIGRATIONS_TABLE_NAME)
            ->executeQuery()
            ->fetchFirstColumn();
    }

    private function getMigrationFiles(): array
    {
        $migrationFiles = scandir($this->migrationFilesPath);

        $filteredFiles =  array_filter($migrationFiles, function ($fileName) {
            return !in_array($fileName, ['.', '..']);
        });

        return array_values($filteredFiles);
    }
}