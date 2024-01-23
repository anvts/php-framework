<?php

namespace Anvts\Framework\Tests;

use Anvts\Framework\Container\Container;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    public function testGetServiceFromContainer()
    {
        $container = new Container();
        $container->add('serviceId', ServiceTestClass::class);
        $this->assertInstanceOf(ServiceTestClass::class, $container->get('serviceId'));
    }
}