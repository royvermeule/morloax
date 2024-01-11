<?php

declare(strict_types=1);

namespace Morloax\Framework\Http;

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

class Kernel
{
    private array $middleware = [];
    private array $routes;

    public function __construct()
    {
        $routes = include BASE_PATH . '/routes/web.php';
        $this->routes = $routes;

        $this->addMiddleware();
    }

    public function addMiddleware(): void
    {
        foreach ($this->routes as $route) {
            if (isset($route[3])) {
                $url = $route[1];
                $middleware = $route[3];

                $this->middleware[$url] = $middleware;
            }
        }
    }

    public function addMiddlewareToAll(array $middleware): void
    {
        $this->middleware['all'] = $middleware;
    }

    public function handle(Request $request): Response
    {
        $this->executeMiddleware();

        $dispatcher = simpleDispatcher(function (RouteCollector $routeCollector) {
            foreach ($this->routes as $route) {
                $routeCollector->addRoute($route[0], $route[1], $route[2]);
            }
        });

        $routeInfo = $dispatcher->dispatch(
            $request->getMethod(),
            $request->getPathInfo()
        );

        [$status, [$controller, $method], $vars] = $routeInfo;

        return call_user_func_array([new $controller, $method], $vars);
    }

    public function hasMiddleware(string $uri): bool
    {
        if (isset($this->middleware[$uri])) {
            return true;
        }

        return false;
    }

    public function executeMiddleware(): ?Response
    {
        $request = Request::createFromGlobals();

        if ($this->middleware['all']) {
            $middlewares = $this->middleware['all'];

            foreach ($middlewares as $middleware => $item) {
                $response = call_user_func(new $item, $request);

                if ($response instanceof Response) {
                    return $response;
                }
            }
        }

        $pathInfo = $request->getPathInfo();

        if ($this->hasMiddleware($pathInfo)) {
            $middlewares = $this->middleware[$pathInfo];

            foreach ($middlewares as $middleware => $item) {
                $response = call_user_func(new $item, $request);

                if ($response instanceof Response) {
                    return $response;
                }
            }
        }

        return null;
    }
}
