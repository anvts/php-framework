<?php

namespace Anvts\Framework\Routing;

use Anvts\Framework\Http\Request;
use League\Container\Container;

interface RouterInterface
{
    public function dispatch(Request $request, Container $container);

    public function registerRoutes(array $routes): void;
}