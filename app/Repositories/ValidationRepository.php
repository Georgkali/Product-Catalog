<?php

namespace App\Repositories;


class ValidationRepository
{
    public function validate(string $newUserName, string $newUserEmail): bool
    {
        $row = new UsersRepository();
        $values = $row->getRow(['name', 'email']);
        echo "<pre>";
        var_dump($values);
        echo "</pre>";

        if (in_array($newUserName, $values[0]) || in_array($newUserEmail, $values[1])) {
            return false;
        } else {
            return true;
        }
    }

    public function loginValidate(string $userName, string $password): bool
    {
        $row = new UsersRepository();
        $values = $row->getRow(['name', 'password']);

        if (in_array($userName, $values[0]) && password_verify($password, $values[1][array_search($userName, $values[0])])) {
            return true;
        } else {
            return false;
        }
    }
}