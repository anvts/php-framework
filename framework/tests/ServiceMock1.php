<?php

namespace Anvts\Framework\Tests;

class ServiceMock1
{
    public function __construct(
        private readonly ServiceMock2 $serviceMock2
    )
    {

    }

    public function getServiceMock2(): ServiceMock2
    {
        return $this->serviceMock2;
    }
}