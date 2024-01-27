<?php

namespace Anvts\Framework\Cli;

use Anvts\Framework\Cli\Exceptions\CliException;
use League\Container\Container;

class Application
{
    public function __construct(
        private Container $container
    )
    {
    }

    public function run(): int
    {
        $argv = $_SERVER['argv'];
        $commandName = $argv[1] ?? null;

        if (!$commandName) {
            throw new CliException("Cli command isn't specified");
        }

        /**
         * @var CommandInterface $command
         */
        $command = $this->container->get("cli:$commandName");

        // TODO: Get cli options & arguments

        $status = $command->execute();

        return $status;
    }
}