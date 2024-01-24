<?php

namespace Anvts\Framework\Tests;

use Anvts\Framework\Container\Container;
use Anvts\Framework\Container\Exceptions\ContainerException;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    public function testGetServiceFromContainer()
    {
        $container = new Container();
        $container->add('serviceId', ServiceTestClass::class);
        $this->assertInstanceOf(ServiceTestClass::class, $container->get('serviceId'));
    }

    public function testAddServiceByWrongId()
    {
        $container = new Container();
        $this->expectException(ContainerException::class);
        $container->add('wrongServiceId');
    }

    public function testContainerHasService()
    {
        $container = new Container();
        $container->add('serviceId', ServiceTestClass::class);
        $this->assertTrue($container->has('serviceId'));
    }

    public function testContainerHasNotService()
    {
        $container = new Container();
        $container->add('serviceId', ServiceTestClass::class);
        $this->assertFalse($container->has('wrongServiceId'));
    }
}