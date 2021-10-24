<?php

namespace App\Validation;


use App\Repositories\MysqlUsersRepositoryImplementation;

class LoginFormValidator
{
    private array $errors = [];

    public function validate(string $userName, string $password): void
    {
        $db = new MysqlUsersRepositoryImplementation();
        $values = $db->getRow(['name', 'password']);
        if (!in_array($userName, $values[0])) {
            $this->errors['username'] = 'Invalid username';
        }
        if (!password_verify($password, $values[1][array_search($userName, $values[0])])) {
            $this->errors['password'] = 'Invalid password';
        }
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

}