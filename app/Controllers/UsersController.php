<?php

namespace App\Controllers;

use App\Repositories\ValidationRepository;
use Ramsey\Uuid\Uuid;
use App\Models\User;
use App\Repositories\UsersRepository;


class UsersController
{
    private ValidationRepository $validationRepository;
    private UsersRepository $usersRepository;

    public function __construct()
    {
        $this->validationRepository = new ValidationRepository();
        $this->usersRepository = new UsersRepository();
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

            } else {
                echo "User with this name/email already exist";
            }
        }
    }


}