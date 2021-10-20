<?php

namespace App\Controllers;


use App\Repositories\ValidationRepository;


class MainController
{
    private ValidationRepository $validationRepository;

    public function __construct()
    {
        $this->validationRepository = new ValidationRepository();
    }

    public function login(): void
    {
        if ($this->validationRepository->loginValidate($_POST['name'], $_POST['password'])) {
            $_SESSION['name'] = $_POST['name'];
            header('location: /main');
        } else {
            echo 'invalid username/password';
        }
    }


    public function logout()
    {
        unset($_SESSION['name']);
        header('location: /');
    }


}