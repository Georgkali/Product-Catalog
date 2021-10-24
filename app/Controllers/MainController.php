<?php

namespace App\Controllers;

use App\Repositories\MsqlUsersRepositoryImplementation;

class MainController
{

    public function login(): void
    {
        $_SESSION['authId'] = (new MsqlUsersRepositoryImplementation())->getUserId($_POST['name']);
        header('location: /main');
    }

    public function logout()
    {
        unset($_SESSION['authId']);
        header('location: /');
    }
}