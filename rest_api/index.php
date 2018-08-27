<?php

//print_r($_GET);

include_once "Core\Routing\Route.php";
include_once "Core\Routing\Router.php";
include_once "App\Controller.php";

$route = new \Core\Routing\Route();
$route->name    = '';
$route->pattern = '/test';
$route->class   = 'App\Controller';
$route->method  = 'read';

$router = new \Core\Routing\Router(array($route));
$match  = $router->resolve('/test/view/2');
print_r(array($match));

// Dispatcher
// ????