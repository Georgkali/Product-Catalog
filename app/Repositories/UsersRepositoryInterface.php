<?php

namespace App\Repositories;

use App\Models\User;

interface UsersRepositoryInterface
{
public function addUser(User $user);
public function getUserId(string $name): string;
public function getRow(array $params);
public function getById(string $id): User;
}