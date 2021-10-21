<?php

namespace App\Controllers;

use App\Repositories\ValidationRepository;
use App\Validation\RegistrationFormValidator;
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
        if (!empty($_POST)) {
            $validation = new RegistrationFormValidator($_POST);
            $errors = $validation->validateLogin();
            echo implode(' ', $errors);
            if (empty($errors)) {

                if ($this->validationRepository->validate($_POST['name'], $_POST['email'])) {
                    $user = new User(
                        Uuid::uuid4(),
                        $_POST['name'],
                        $_POST['email'],
                        password_hash($_POST['password'], PASSWORD_BCRYPT)
                    );
                    $this->usersRepository->addUser($user);
                }
            } else {
                foreach ($errors as $key=>$value) {
                    echo "$key $value";
                }
            }

        }
    }


}