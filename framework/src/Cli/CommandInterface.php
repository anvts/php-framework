<?php

namespace Anvts\Framework\Cli;

interface CommandInterface
{
    public function execute(array $args = []): int;
}