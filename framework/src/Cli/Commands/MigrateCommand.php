<?php

namespace Anvts\Framework\Cli\Commands;

use Anvts\Framework\Cli\CommandInterface;

class MigrateCommand implements CommandInterface
{
    private string $name = 'migrate';

    public function execute(array $args = []): int
    {
        return 0;
    }
}