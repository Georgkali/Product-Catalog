<?php

namespace App\Middlewares;

use App\Repositories\MysqlUsersRepositoryImplementation;
use App\Repositories\UsersRepositoryInterface;

class UserRegistrationMiddleware
{
    private UsersRepositoryInterface $usersRepository;
    private array $data;
    private array $errors;

    public function __construct(array $data)
    {
        $this->usersRepository = new MysqlUsersRepositoryImplementation();
        $this->data = $data;
      //  echo "<pre>";
       // var_dump($data, $this->usersRepository->getRow(['name', 'email']));
       // echo "</pre>";
    }
    private function addError(string $error) {
        $this->errors[] = $error;
    }
    public function validate(): bool
    {
        $values = $this->usersRepository->getRow(['name', 'email']);
        if (in_array($this->data['name'], $values[0]) || in_array($this->data['email'], $values[1])) {
            $this->addError('User with this name/email already exist');
            return false;
        } else {
            return true;
        }
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}