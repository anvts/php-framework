<?php

namespace Anvts\Framework\Tests;

class ServiceMock2
{
    public function __construct(
        private readonly ServiceMock3 $serviceMock3,
        private readonly ServiceMock4 $serviceMock4
    )
    {
    }

    public function getServiceMock3(): ServiceMock3
    {
        return $this->serviceMock3;
    }

    public function getServiceMock4(): ServiceMock4
    {
        return $this->serviceMock4;
    }

}