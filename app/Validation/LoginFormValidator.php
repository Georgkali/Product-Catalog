<?php

namespace App\Validation;


use App\Exceptions\LoginFormValidationException;
use App\Repositories\MsqlUsersRepositoryImplementation;

class LoginFormValidator
{
    private array $errors = [];

    public function validate(string $userName, string $password): void
    {
        $db = new MsqlUsersRepositoryImplementation();
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