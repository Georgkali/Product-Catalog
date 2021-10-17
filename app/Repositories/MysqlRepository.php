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
            $this->pdo = new PDO('mysql:host=127.0.0.1;dbname=product_catalog', 'root', '');
        } catch (PDOException $e) {
            die('Could not connect to database.');
        }
    }


}