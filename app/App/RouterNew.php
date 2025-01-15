<?php

namespace skensa\Belajar\PHP\MVC\App;
use skensa\Belajar\PHP\MVC\Middleware\Middleware;

class Router 
{

    private static array $routes = [];

    public static function add(string $method, 
        string $path, 
        string $controller, 
        string $action,
        array $middlewares = []): void
    {
        self::$routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'action' => $action,
            'middleware' => $middlewares,
        ];
    }

    public static function __callStatic($name, $arguments) {
        $method = strtoupper($name);
        list($uri, $action) = $arguments;
        // $uri = $arguments[0];
        // $action = $arguments[1];

        if (!in_array($method, ['GET', 'POST', 'PUT', 'DELETE'])) {
            throw new Exception("Metode HTTP $method tidak didukung.");
        }

        self::$routes[$method][$uri] = $action;
    }

    public static function dispatch($method, $uri): void {
        $method = strtoupper($method);
        if (!isset(self::$routes[$method][$uri])) {
            http_response_code(404);
            echo "404 Not Found";
            return;
        }
        list($controller, $action) = explode('@', self::$routes[$method][$uri]);
        if (!class_exists($controller) || !method_exists($controller, $action)) {
            http_response_code(500);
            echo "Controller atau metode tidak ditemukan.";
            return;
        }
        $controllerInstance = new $controller();
        echo $controllerInstance->$action();
    }

    public static function run(): void
    {
        $uri = '/';
        if (isset($_SERVER['PATH_INFO'])) {
            $uri = $_SERVER['PATH_INFO'];
        }

        $method = $_SERVER['REQUEST_METHOD'];

        self::dispatch($method, $uri);



        $path = '/';
        if (isset($_SERVER['PATH_INFO'])) {
            $path = $_SERVER['PATH_INFO'];
        }

        $method = $_SERVER['REQUEST_METHOD'];
        foreach (self::$routes as $route){
            $pattern = "#^" . $route['path'] . "$#";
            if (preg_match($pattern, $path, $variables) && (strcasecmp($method,$route['method']) == 0)){

                //call meddleware
                foreach ($route['middleware'] as $middleware){
                    $instance = new $middleware;
                    $instance->before();
                }
            
                $action = $route['action'];
                $controller = new $route['controller'];
                $controller->$action(...$variables);
                // self::dispatch($method, $uri);

                // array_shift($variables);
                // call_user_func_array([$controller, $action], $variables);

                return;
            }
        }
        http_response_code(404);
        print("Controller tidak ditemukan.");   
    }
}