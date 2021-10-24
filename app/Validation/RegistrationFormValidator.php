<?php

namespace App\Validation;

class RegistrationFormValidator
{
    public array $data;
    private array $errors = [];

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function validateLogin(): array
    {
        $this->validateName();
        $this->validateEmail();
        $this->validatePassword();
        return $this->errors;
    }

    private function validateName()
    {
        $name = strtolower(trim($this->data['name']));
        if (empty($name)) {
            $this->addError('name', 'empty name');
        }
        if (!preg_match('/^[a-zA-Z0-9]{4,10}$/', $name)) {
            $this->addError('name', 'must be alphanumeric, 4-10 characters long');
        }
    }

    private function validateEmail()
    {
        $email = strtolower(trim($this->data['email']));
        if (empty($email)) {
            $this->addError('email', 'empty email');
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->addError('email', 'must be a valid email');
        }
    }

    private function validatePassword()
    {
        $password = $this->data['password'];
        $repeat_password = $this->data['repeat_password'];
        if ($password !== $repeat_password) {
            $this->addError('password', 'password and password repeating doesnt match');
        }
    }


    private function addError(string $key, string $value)
    {
        $this->errors[$key] = $value;
    }
}