<?php

namespace controllers;

use Exception;
use models\ProductsRepository;
use models\UsersRepository;
use utils\Render;

class ProductsController extends Controller
{
    protected $modelName = \models\ProductsRepository::class;
    protected $controllerName = __CLASS__;

    public function stock()
    {
        $pageTitle = "Stock";
        $products = $this->model->findAll();
        if ($this->userIsConnected) {
            Render::render("Stock", compact('pageTitle', 'products'));
            
        } else {
            var_dump(__CLASS__);

            var_dump($this->controllerName);
            throw new Exception("Vous n'êtes pas connecté !");
        }
    }

    public function stockEdit()
    {
        $pageTitle = "Edition des Stocks";
        $products = $this->model->findAll();
        if ($this->userIsAdmin) {
            Render::render("stockEdit", compact('pageTitle', 'products'));
        } else {
            throw new Exception("Vous n'avez pas les droits pour accèder à cette page !");
        }
    }
}
