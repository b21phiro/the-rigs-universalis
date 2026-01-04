<?php

require __DIR__ . '/../vendor/autoload.php';

class Controller {

    private View $view;

    public function __construct(View $view) {
        $this->view = $view;
    }

    public function index(): \GuzzleHttp\Psr7\Response {
        $body = $this->view->html();
        return new \GuzzleHttp\Psr7\Response(200, [], $body);
    }

}

class View {

    public function html(): string {
        ob_start();
        include __DIR__ . '/../src/views/index.php';
        return ob_get_clean();
    }

}

class Route {

    public string $method;
    public string $path;
    public string $action;

    public function __construct(string $method, string $path, string $action) {
        $this->method = $method;
        $this->path = $path;
        $this->action = $action;
    }

}

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

class Dispatcher {

    private \GuzzleHttp\Psr7\Response $response;

    public function __construct(\GuzzleHttp\Psr7\Response $response) {
        $this->response = $response;
    }

    public function sendResponse(): void {
        http_response_code($this->response->getStatusCode());
        echo $this->response->getBody();
    }

}


$view = new View();
$controller = new Controller($view);

$request = \GuzzleHttp\Psr7\ServerRequest::fromGlobals();
$response = new \GuzzleHttp\Psr7\Response();

$routes = [
    new Route('GET', '/', 'index')
];
$router = new Router($routes, $controller);

$response = $router->handler($request, $response);

$dispatcher = new Dispatcher($response);
$dispatcher->sendResponse();
