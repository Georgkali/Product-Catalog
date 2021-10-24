<?php

namespace App\Controllers;

use Ramsey\Uuid\Uuid;
use App\Models\User;
use App\Container;

class UsersController
{
    private Container $container;

    public function __construct()
    {
        $this->container = new Container();
    }

    public function register()
    {
        $user = new User(
            Uuid::uuid4(),
            $_POST['name'],
            $_POST['email'],
            password_hash($_POST['password'], PASSWORD_BCRYPT)
        );
        $this->container->get('usersRepository')->addUser($user);
        header('location: /');
    }

}