<?php

namespace App\Controllers;

use App\Container;


class MainController
{
    private Container $container;
    public function __construct()
    {
    $this->container = new Container();
    }

    public function login(): void
    {
        $_SESSION['authId'] = $this->container->get('usersRepository')->getUserId($_POST['name']);
        header('location: /main');
    }

    public function logout()
    {
        unset($_SESSION['authId']);
        header('location: /');
    }
}