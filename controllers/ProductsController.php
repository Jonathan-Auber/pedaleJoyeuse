<?php

namespace controllers;

use models\ProductsRepository;

class ProductsController extends Controller
{
    protected $modelName = \models\ProductsRepository::class;

    public function stock()
    {
        $products = $this->model->findAll();

        $page = "views/stock.phtml";
        require_once "views/base.phtml";
    }
}
