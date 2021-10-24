<?php


require "vendor/autoload.php";

use App\Controllers\ProductsController;
use App\Validation\LoginFormValidator;
use App\Validation\ProductFormValidator;
use Bramus\Router\Router;
use DI\Container;
use DI\ContainerBuilder;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Middlewares\ProductDataMiddleware;
use App\Validation\RegistrationFormValidator;
use App\Middlewares\UserRegistrationMiddleware;

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

$router->before('POST', '/login', function () use ($twig) {

    $validator = new LoginFormValidator();
    $validator->validate($_POST['name'], $_POST['password']);
    if (!empty(($validator->getErrors()))) {
        echo $twig->render('login.html.twig', ['errors' => [$validator->getErrors()]]);
        exit();
    }
});

$router->post('/login', 'MainController@login');

$router->get('/main', function () use ($twig, $productsController) {
    echo $twig->render('user.html.twig', [
        'products' => $productsController->get()->getProducts(),
        'tags' => $productsController->getProductTags()->getTags()]);
});

$router->get('/registration', function () use ($twig) {
    echo $twig->render('registration.html.twig');
});


$router->before('POST', '/registration', function () use ($twig) {

    $userRegistrationMiddleware = new UserRegistrationMiddleware($_POST);
    if (!$userRegistrationMiddleware->validate()) {
        echo $twig->render('registration.html.twig', ['middleware' => $userRegistrationMiddleware->getErrors()]);
        exit();
    }
    $registrationFormValidator = new RegistrationFormValidator($_POST);
    $errors = $registrationFormValidator->validateLogin();
    if (!empty($errors)) {
        echo $twig->render('registration.html.twig', ['errors' => $errors]);
        exit();
    }
});

$router->post('/registration', 'UsersController@register');


$router->before('POST', '/addProduct', function () use ($twig, $productsController) {
    $productDataMiddleware = new ProductDataMiddleware($_POST);
    $_POST = $productDataMiddleware->productDataMiddleware();
    $errors = (new ProductFormValidator($_POST))->validator();
    if (count($errors) > 0) {
        echo $twig->render(
            'user.html.twig', [
            'products' => $productsController->get()->getProducts(),
            'tags' => $productsController->getProductTags()->getTags(),
            'addErrors' => $errors]);
        exit();
    }
});


$router->post('/addProduct', 'ProductsController@addProduct');


$router->get('/{id}', function ($id = '{id}') use ($twig, $productsController) {
    echo $twig->render('product.html.twig', [
        'products' => $productsController->getProductById($id),
        'tags' => $productsController->getProductTags()->getTags()]);
});

$router->post('/delete', 'ProductsController@delete');

$router->before('POST', '/edit', function () use ($twig, $productsController) {
    $productDataMiddleware = new ProductDataMiddleware($_POST);
    $_POST = $productDataMiddleware->productDataMiddleware();
    $errors = (new ProductFormValidator($_POST))->validator();
    if (count($errors) > 0) {
        echo $twig->render(
            'product.html.twig', [
            'products' => $productsController->getProductById($_POST['id']),
            'tags' => $productsController->getProductTags()->getTags(),
            'editionErrors' => $errors]);
        exit();
    }
});
$router->post('/edit', 'ProductsController@edit');

$router->post('/searchByCategory', function () use ($twig, $productsController) {
    echo $twig->render('user.html.twig', ['products' => $productsController->searchByCategory()->getProducts()]);
});

$router->post('/searchByTags', function () use ($twig, $productsController) {
    echo $twig->render('user.html.twig', [
        'products' => $productsController->searchByTags()->getProducts(),
        'tags' => $productsController->getProductTags()->getTags()]);
});


$router->post('/logout', 'MainController@logout');

$router->run();


unset($_SESSION['_errors']);