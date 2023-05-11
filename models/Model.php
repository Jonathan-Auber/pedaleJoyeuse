<?php

namespace models;

use PDO;

abstract class Model
{
    protected PDO $pdo;
    protected string $table;

    public function __construct()
    {
        $this->pdo = \config\Database::getpdo();
    }

    public function findAll()
    {
        $query = $this->pdo->prepare("SELECT * FROM {$this->table}");
        $query->execute();
        return $query->fetchAll();
    }
}
