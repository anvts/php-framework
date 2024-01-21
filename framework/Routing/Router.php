<?php

namespace Anvts\Framework\Routing;

use Anvts\Framework\Http\Exceptions\MethodNotAllowedException;
use Anvts\Framework\Http\Exceptions\RouteNotFoundException;
use Anvts\Framework\Http\Request;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

class Router implements RouterInterface
{

    public function dispatch(Request $request): array
    {
        [$handler, $vars] = $this->extractRouteInfo($request);
        [$controller, $method] = $handler;

        return [[new $controller, $method], $vars];
    }

    private function extractRouteInfo(Request $request): array
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $collector) {
            $routes = include BASE_PATH . '/routes/web.php';

            foreach ($routes as $route) {
                $collector->addRoute(...$route);
            }
        });

        $routeInfo = $dispatcher->dispatch(
            $request->getMethod(),
            $request->getPath(),
        );

        switch ($routeInfo[0]) {
            case Dispatcher::FOUND:
                return [$routeInfo[1], $routeInfo[2]];
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = implode(', ', $routeInfo[1]);
                throw new MethodNotAllowedException("Not allowed method. Allowed HTTP methods: $allowedMethods");
            default:
                throw new RouteNotFoundException("Route not found");
        }
    }
}