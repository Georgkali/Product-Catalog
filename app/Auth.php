<?php

namespace App;

use App\Repositories\MsqlUsersRepositoryImplementation;

class Auth
{
    public static function name()
    {
        if (!empty($_SESSION['authId'])) {
            return (new MsqlUsersRepositoryImplementation())->getById($_SESSION['authId'])->getName();
        }
    }
}