<?php

namespace App\Controllers;

use App\Repositories\UsersRepositoryInterface;
use Ramsey\Uuid\Uuid;
use App\Models\User;
use App\Repositories\MsqlUsersRepositoryImplementation;


class UsersController
{
    private UsersRepositoryInterface $usersRepository;

    public function __construct()
    {
        $this->usersRepository = new MsqlUsersRepositoryImplementation();
    }

    public function register()
    {
        $user = new User(
            Uuid::uuid4(),
            $_POST['name'],
            $_POST['email'],
            password_hash($_POST['password'], PASSWORD_BCRYPT)
        );
        $this->usersRepository->addUser($user);
        header('location: /');
    }

}