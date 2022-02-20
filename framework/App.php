<?php

namespace Framework;

use Dotenv\Dotenv;
use Framework\Routing\Router;

class App extends Container {
    private static $instance;

    public static function getInstance(){
        if(!static::$instance){
            static::$instance = new static();
        }
        return static::$instance;
    }

    private function __construct(){}
    
    private function __clone(){}

    public function run(){
        session_start();

        $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
        $dotenv->load();

        $router = new Router();

        $routes = include __DIR__ . '/../app/routes.php';
        $routes($router);

        print $router->dispatch();
    }
}