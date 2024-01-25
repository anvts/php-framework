<?php

namespace Anvts\Framework\Routing;

use Anvts\Framework\Http\Request;

interface RouterInterface
{
    public function dispatch(Request $request);

    public function registerRoutes(array $routes): void;
}