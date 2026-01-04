<?php

use Phro\TheRig\Controller;
use Phro\TheRig\Dispatcher;
use Phro\TheRig\Route;
use Phro\TheRig\Router;
use Phro\TheRig\View;

require __DIR__ . '/../vendor/autoload.php';

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
