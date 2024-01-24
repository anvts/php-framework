<?php

use League\Container\Container;
use Anvts\Framework\Http\Kernel;
use Anvts\Framework\Routing\RouterInterface;
use Anvts\Framework\Routing\Router;

$container = new Container();

$container->add(RouterInterface::class, Router::class);
$container->add(Kernel::class)
    ->addArgument(RouterInterface::class);

return $container;