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

        $args = array_slice($argv, 2);
        $options = $this->parseOptions($args);

        $status = $command->execute($options);

        return $status;
    }

    public function parseOptions(array $args): array
    {
        $options = [];

        foreach ($args as $arg) {
            if (str_starts_with($arg, '--')) {
                $option = explode('=', substr($arg, 2));
                $options[$option[0]] = $option[1] ?? true;
            }
        }

        return $options;
    }
}