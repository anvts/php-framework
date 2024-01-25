<?php

use League\Container\Container;
use League\Container\Argument\Literal\ArrayArgument;
use Anvts\Framework\Http\Kernel;
use Anvts\Framework\Routing\RouterInterface;
use Anvts\Framework\Routing\Router;

// Application parameters

$routes = include BASE_PATH . '/routes/web.php';

// Application services

$container = new Container();

$container->add(RouterInterface::class, Router::class);
$container->extend(RouterInterface::class)
    ->addMethodCall('registerRoutes', [new ArrayArgument($routes)]);

$container->add(Kernel::class)
    ->addArgument(RouterInterface::class);

return $container;