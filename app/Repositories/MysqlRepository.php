<?php

namespace App\Repositories;

use PDO;
use PDOException;


class MysqlRepository
{
    protected PDO $pdo;

    public function __construct()
    {
        try {
            $config = require 'config.php';
            $this->pdo = new PDO("{$config['connection']};dbname=$config[name]", "$config[username]", "$config[password]");
        } catch (PDOException $e) {
            die('Could not connect to database.');
        }
    }


}