<?php

namespace models;

class ProductsRepository extends Model
{
    protected string $table = "products";

    // protected $pdo;
    // public function __construct()
    // {
    //     $this->pdo = \config\Database::getpdo();
    // }

    // public function findAll()
    // {
    //     $select = $this->pdo->prepare("SELECT * FROM products");
    //     $select->execute();
    //     return $select->fetchAll();
    // }
}
