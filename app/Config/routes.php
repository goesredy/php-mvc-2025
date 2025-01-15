<?php
use skensa\Belajar\PHP\MVC\App\Router;
use skensa\Belajar\PHP\MVC\Middleware\AuthMiddleware;
use skensa\Belajar\PHP\MVC\Controller\HomeController;
use skensa\Belajar\PHP\MVC\Controller\ProductController;

Router::add('GET', '/products/([0-9a-zA-Z]*)/categories/([0-9a-zA-Z]*)', ProductController::class, 'categories');

Router::add('GET', '/', HomeController::class, 'index');
Router::add('GET', '/hello', HomeController::class, 'hello', [AuthMiddleware::class]);
Router::add('GET', '/world', HomeController::class, 'world', [AuthMiddleware::class]);
Router::add('GET', '/about', HomeController::class, 'about');
Router::add('GET', '/login', HomeController::class, 'login');
Router::add('GET', '/register', HomeController::class, 'register');