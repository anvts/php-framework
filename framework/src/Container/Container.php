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

        $instance = $this->resolve($this->services[$id]);

        return $instance;
    }

    private function resolve($class)
    {
        $reflectionClass = new \ReflectionClass($class);
        $constructor = $reflectionClass->getConstructor();

        if (is_null($constructor)) {
            return $reflectionClass->newInstance();
        }

        $constructorParams = $constructor->getParameters();
        $classDependencies = $this->resolveClassDependencies($constructorParams);
        $instance = $reflectionClass->newInstanceArgs($classDependencies);

        return $instance;
    }

    public function has(string $id): bool
    {
        return isset($this->services[$id]);
    }
}