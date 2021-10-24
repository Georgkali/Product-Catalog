<?php

namespace App;

use App\Repositories\MysqlUsersRepositoryImplementation;

class Auth
{
    public static function name()
    {
        if (!empty($_SESSION['authId'])) {
            return (new MysqlUsersRepositoryImplementation())->getById($_SESSION['authId'])->getName();
        }
    }
}