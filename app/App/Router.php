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

    public static function run(): void
    {
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
                $controller->$action();

                // array_shift($variables);
                // call_user_func_array([$controller, $action], $variables);

                return;
            }
        }
        http_response_code(404);
        print("Controller tidak ditemukan.");   
    }
}
    


