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
    // Rajouter deuxième données
    public function find(string $condition, string $data)
    {
        $query = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE $condition = ?");
        $query->execute([$data]);
    }
    public function findAll()
    {
        $query = $this->pdo->prepare("SELECT * FROM {$this->table}");
        $query->execute();
        return $query->fetchAll();
    }
}
