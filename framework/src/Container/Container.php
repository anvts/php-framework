<?php

namespace Anvts\Framework\Container;

use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    private array $services = [];

    public function add(string $id, string|object $service = null): void
    {
        $this->services[$id] = $service;
    }

    public function get(string $id)
    {
        return new $this->services[$id];
    }

    public function has(string $id): bool
    {
        // TODO: Implement has() method.
        return true;
    }
}