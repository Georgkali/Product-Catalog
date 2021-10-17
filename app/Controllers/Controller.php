<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\ProductCategories;
use App\Models\ProductsCollection;
use App\Models\User;
use App\Repositories\ProductsRepository;
use App\Repositories\UsersRepository;
use Ramsey\Uuid\Uuid;
use App\Repositories\ValidationRepository;
use Carbon\Carbon;


class Controller
{
    private UsersRepository $usersRepository;
    private ValidationRepository $validationRepository;
    private ProductsRepository $productsRepository;

    public function __construct()
    {
        $this->usersRepository = new UsersRepository();
        $this->validationRepository = new ValidationRepository();
        $this->productsRepository = new ProductsRepository();
    }


    public function index()
    {
        require_once 'app/Views/login.view.php';
    }

    public function register()
    {
        if (!empty($_POST['name']) && !empty($_POST['email']) && $_POST['password'] === $_POST['repeat_password']) {

            if ($this->validationRepository->validate($_POST['name'], $_POST['email'])) {

                $user = new User(
                    Uuid::uuid4(),
                    $_POST['name'],
                    $_POST['email'],
                    password_hash($_POST['password'], PASSWORD_BCRYPT)
                );
                $this->usersRepository->addUser($user);
                header('location: /');
            } else {
                echo "User with this name/email already exist";
            }
        }

        require_once 'app/Views/register.php';
    }

    public function login()
    {
        if ($this->validationRepository->loginValidate($_POST['name'], $_POST['password'])) {
            $_SESSION['name'] = $_POST['name'];

            $id = $this->usersRepository->getUserId($_SESSION['name']);
            $products = $this->productsRepository->getProductsById($this->usersRepository->getUserId($_SESSION['name']));
            require_once 'app/Views/user.view.php';
        } else {
            var_dump('invalid username/password');
        }
    }

    public function addProduct()
    {
        if (in_array($_POST['category'], (new ProductCategories())->getCategories())) {
            $this->productsRepository->addProduct(
                new Product(
                    Uuid::uuid4(),
                    $_POST['productName'],
                    $_POST['qty'],
                    $this->usersRepository->getUserId($_SESSION['name']),
                    $_POST['category'],
                    Carbon::now(),
                )
            );
            $products = $this->productsRepository->getProductsById($this->usersRepository->getUserId($_SESSION['name']));
        } else {
            var_dump('invalid category');
        }
        require_once 'app/Views/user.view.php';
    }

    public function logout()
    {
        session_destroy();
        header('location: /');
    }


}