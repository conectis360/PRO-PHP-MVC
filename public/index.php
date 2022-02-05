<?php
require_once __DIR__ . '/../vendor/autoload.php';

$router = new Framework\Routing\Router();

//expecting routes files to return a callable, or else this code will break;

$routes = require_once __DIR__ . '/../app/routes.php';
$routes($router);

print $router->dispatch();