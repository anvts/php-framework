<?php

namespace Anvts\Framework\Cli;

use League\Container\Container;

class Kernel
{
    public function __construct(
        private Container $container,
        private Application $application
    )
    {

    }

    public function handle(): int
    {
        $this->registerCommands();
        $status = $this->application->run();
        return $status;
    }

    public function registerCommands(): void
    {
        $commandFiles = new \DirectoryIterator(__DIR__ . '/Commands');
        $commandsNamespace = $this->container->get('framework-cli-commands-namespace');

        foreach ($commandFiles as $commandFile) {
            if (!$commandFile->isFile()) {
                continue;
            }

            $command = $commandsNamespace . pathinfo($commandFile, PATHINFO_FILENAME);

            if (is_subclass_of($command, CommandInterface::class)) {
                $commandName = (new \ReflectionClass($command))
                    ->getProperty('name')
                    ->getDefaultValue();

                $this->container->add("cli:$commandName", $command);
            }
        }
    }
}