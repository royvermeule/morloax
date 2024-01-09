<?php

namespace Morloax\Framework\Middleware;

use Morloax\Framework\Http\Request;
use Morloax\Framework\Http\Response;
use Morloax\Framework\Middleware\Middleware;

class RouteExists implements Middleware
{
    public function __invoke(): ?Response
    {
        $routes = include BASE_PATH . '/routes/web.php';
        $request = Request::createFromGlobals();
        $uri = $request->getPathInfo();

        foreach ($routes as $route) {
            if ($route[1] === $uri) {
                return null;
            }
        }

        $content = file_get_contents(BASE_PATH . '/app/views/popup/404.php');
        return new Response($content);
    }
}