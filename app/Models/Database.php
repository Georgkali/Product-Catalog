<?php

namespace App\Models;

use PDO;
use PDOException;


class Database
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