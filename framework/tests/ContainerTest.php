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
        $container->add('ServiceMock1', ServiceMock1::class);
        $this->assertInstanceOf(ServiceMock1::class, $container->get('ServiceMock1'));
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
        $container->add('ServiceMock1', ServiceMock1::class);
        $this->assertTrue($container->has('ServiceMock1'));
    }

    public function testContainerHasNotService()
    {
        $container = new Container();
        $container->add('ServiceMock1', ServiceMock1::class);
        $this->assertFalse($container->has('wrongServiceId'));
    }

    public function testServiceDependenciesAutoWiring()
    {
        $container = new Container();
        $container->add('ServiceMock1', ServiceMock1::class);

        /**
         * @var ServiceMock1 $serviceMock1
         */
        $serviceMock1 = $container->get('ServiceMock1');
        $serviceMock2 = $serviceMock1->getServiceMock2();

        $this->assertInstanceOf(ServiceMock2::class, $serviceMock1->getServiceMock2());
        $this->assertInstanceOf(ServiceMock3::class, $serviceMock2->getServiceMock3());
        $this->assertInstanceOf(ServiceMock4::class, $serviceMock2->getServiceMock4());
    }
}