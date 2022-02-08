<?php
namespace Framework\Routing;

use Exception;
use Throwable;

class Router {
    protected array $routes = [];
    protected array $errorHandler = [];
    protected Route $current;

    public function current(): ?Route{
        return $this->current;
    }

    public function errorHandler(int $code, callable $handler){
        $this->errorHandlers[$code] = $handler;
    }

    public function dispatchNotAllowed(){
        $this->errorHandlers[400] ??= fn() => "not allowed";
        return $this->errorHandlers[400]();
    }

    public function dispatchNotFound(){
        $this->errorHandlers[404] ??= fn() => "not found";
        return $this->errorHandlers[404]();
    }

    public function dispatchError(){
        $this->errorHandlers[500] ??= fn() => "server error";
        return $this->errorHandlers[500]();
    }

    public function redirect($path){
        header(
            "Location: {$path}", $replace = true, $code = 301
        );
        exit;
    }

    public function add(string $method, string $path, callable $handler): Route
    {
        $route = $this->routes[] = new Route($method, $path, $handler);
        return $route;
    }

    public function dispatch(){
        $paths = $this->paths();

        $requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $requestPath = $_SERVER['REQUEST_URI'] ?? '/';

        #look through all routes and return the first one that match the request method and path

        $matching = $this->match($requestMethod, $requestPath);
        if($matching){
            try {
                return $matching->dispatch();
            }
            catch (Throwable $e) {
                return $this->dispatchError();
            }
        }
        if(in_array($requestPath, $paths)){
            return $this->dispatchNotAllowed();
        }
        return $this->dispatchNotFound();
    }

    private function paths(): array {
        $paths = [];
        foreach ($this->routes as $route) {
            $paths[] = $route->path();
        }
        return $paths;
    }

    private function match(string $method, string $path): ?Route
    {
        foreach ($this->routes as $route) {
            if($route->matches($method, $path)) {
                return $route;
            }
        }
        return null;
    }

    public function route(
        string $name,
        array $parameters = [],
    ):string {
        foreach ($this->routes as $route) {
            if($route->name() === $name) {
                $finds = [];
                $replaces = [];

                foreach ($parameters as $key => $value) {
                    // one set for required parameters
                    array_push($finds, "{{$key}}");
                    array_push($replaces, $value);

                    // another for optional parameters
                    array_push($finds, "{{$key}}");
                    array_push($replaces, $value);
                }
                $path = $route->path();
                $path = str_replace($finds, $replaces, $path);

                return $path;
            }
        }
        throw new Exception('no route with that name');
    }
}