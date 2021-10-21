<?php


require "vendor/autoload.php";


use App\Controllers\ProductsController;
use Bramus\Router\Router;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Middlewares\ProductDataMiddleware;
use App\Validation\RegistrationFormValidator;


//header('Cache-Control: no cache');
//session_cache_limiter('private_no_expire');
session_start();

$productsController = new ProductsController();


$loader = new FilesystemLoader('app/Views/');
$twig = new Environment($loader, []);

$router = new Router;
$router->setNamespace('App\Controllers');

$router->get('/', function () use ($twig) {
    echo $twig->render('login.html.twig');
});
$router->post('/login', 'MainController@login');

$router->get('/main', function () use ($twig, $productsController) {
    echo $twig->render('user.html.twig', ['products' => $productsController->get()->getProducts(),
        'tags' => $productsController->getProductTags()->getTags()]);
});

$router->get('/registration', function () use ($twig) {
    echo $twig->render('registration.html.twig');
});

$router->before('POST', '/registration', function () use ($twig) {
    $registrationFormValidator = new RegistrationFormValidator($_POST);
    $errors = $registrationFormValidator->validateLogin();
    if(!empty($errors)) {
        echo $twig->render('registration.html.twig', ['errors' => $errors]);
    }
});

$router->post('/registration', 'UsersController@register');


$router->before('POST', '/addProduct', function () {
    $productDataMiddleware = new ProductDataMiddleware($_POST);
    $_POST = $productDataMiddleware->productDataMiddleware();
});

$router->post('/addProduct', 'ProductsController@addProduct');


$router->get('/{id}', function ($id = '{id}') use ($twig, $productsController) {
    echo $twig->render('product.html.twig', ['products' => $productsController->getProductById($id)]);
});

$router->post('/delete', 'ProductsController@delete');
$router->post('/edit', 'ProductsController@edit');

$router->post('/searchByCategory', function () use ($twig, $productsController) {
    echo $twig->render('user.html.twig', ['products' => $productsController->searchByCategory()->getProducts()]);
});

$router->post('/searchByTags', function () use ($twig, $productsController) {
    echo $twig->render('user.html.twig', ['products' => $productsController->searchByTags()->getProducts(),
        'tags' => $productsController->getProductTags()->getTags()]);
});


$router->post('/logout', 'MainController@logout');

$router->run();
