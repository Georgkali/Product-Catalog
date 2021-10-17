<?php


require "vendor/autoload.php";

use Bramus\Router\Router;

session_start();

$router = new Router;
$router->setNamespace('App\Controllers');

$router->get('/', 'Controller@index');
$router->get('/register', 'Controller@register');
$router->post('/register', 'Controller@register');
$router->post('/', 'Controller@login');
$router->post('/addProduct', 'Controller@addProduct');
$router->post('/logout', 'Controller@logout');

$router->run();

/*
echo "<pre>";
var_dump($_SESSION, (new \App\Repositories\UsersRepository())->getUserId($_SESSION['name']));
echo "</pre>";
*/