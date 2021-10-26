<?php

namespace App\Services;

use App\Container;
use App\Models\User;
use Ramsey\Uuid\Uuid;

class UsersControllerService
{
    private Container $container;

    public function __construct()
    {
        $this->container = new Container();
    }

    public function register(array $data)
    {
        $user = new User(
            Uuid::uuid4(),
            $data['name'],
            $data['email'],
            password_hash($data['password'], PASSWORD_BCRYPT)
        );
        $this->container->get('usersRepository')->addUser($user);

    }
}