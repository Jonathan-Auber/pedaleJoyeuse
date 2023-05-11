<?php

namespace controllers;

use models\ProductsRepository;

class ProductsController
{
    public function index()
    {
        $page = "views/usersAccueil.phtml";
        require_once "views/base.phtml";
    }

    public function stock()
    {
        $data = new ProductsRepository;
        $results = $data->findAll();

        $page = "views/stock.phtml";
        require_once "views/base.phtml";
    }
}
