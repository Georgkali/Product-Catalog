<?php

namespace App\Repositories;

use App\Models\Database;
use App\Models\User;
use PDO;

class MsqlUsersRepositoryImplementation extends Database implements UsersRepositoryInterface
{

    public function addUser(User $user): void
    {
        $sql = "INSERT INTO users(id, name, email, password) VALUES (?,?,?,?)";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([$user->getId(), $user->getName(), $user->getEmail(), $user->getPassword()]);
    }

    public function getRow(array $params): array
    {
        $values = [];
        foreach ($params as $param) {
            $db = $this->pdo->query("SELECT " . $param . " FROM users");
            $db->execute();
            $values[] = $db->fetchAll(PDO::FETCH_COLUMN);
        }

        return $values;
    }

    public function getUserId(string $name): string
    {
        $users = $this->getRow(['name', 'id']);
        return $users[1][array_search($name, $users[0])];
    }

    public function getById(string $id): User
    {
        $db = $this->pdo->query("SELECT * FROM users WHERE id = '$id'");
        $db->execute();
        $user = $db->fetch(PDO::FETCH_ASSOC);
        return new User(
            $user['id'],
            $user['name'],
            $user['email'],
            $user['password']
        );

    }
}