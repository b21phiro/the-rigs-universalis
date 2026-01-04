<?php

namespace Phro\TheRig;

class Router {

    private array $routes;
    private Controller $controller;

    public function __construct(array $routes, Controller $controller) {
        $this->routes = $routes;
        $this->controller = $controller;
    }

    public function handler(\GuzzleHttp\Psr7\Request $request, \GuzzleHttp\Psr7\Response & $response): \GuzzleHttp\Psr7\Response {
        $requestedMethod = $request->getMethod();
        $requestedPath = $request->getUri()->getPath();
        for ($i = 0; $i < count($this->routes); $i++) {
            $route = $this->routes[$i];
            if ($route->method === $requestedMethod && $route->path === $requestedPath) {
                return $this->controller->{$route->action}($request, $response);
            }
        }
        return $response->withStatus(404);
    }

}