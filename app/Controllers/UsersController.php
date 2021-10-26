<?php

namespace App\Controllers;

use App\Services\UsersControllerService;


class UsersController
{
    private UsersControllerService $usersControllerService;

    public function __construct()
    {
        $this->usersControllerService = new UsersControllerService();
    }

    public function register()
    {
        $data = $_POST;
        $this->usersControllerService->register($data);
        header('location: /');
    }

}