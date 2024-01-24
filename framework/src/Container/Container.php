<?php

namespace Anvts\Framework\Container;

use Anvts\Framework\Container\Exceptions\ContainerException;
use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    private array $services = [];

    public function add(string $id, string|object $service = null): void
    {
        if (is_null($service)) {
            if (!class_exists($id)) {
                throw new ContainerException("Service $id doesn't exist");
            }

            $service = $id;
        }

        $this->services[$id] = $service;
    }

    public function get(string $id)
    {
        if (!$this->has($id)) {
            if (!class_exists($id)) {
                throw new ContainerException("Service $id couldn't be resolved");
            }

            $this->add($id);
        }
        return new $this->services[$id];
    }

    public function has(string $id): bool
    {
        return isset($this->services[$id]);
    }
}