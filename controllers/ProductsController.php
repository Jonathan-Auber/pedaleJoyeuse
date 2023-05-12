<?php

namespace controllers;

use Exception;
use models\ProductsRepository;
use utils\Render;

class ProductsController extends Controller
{
    protected $modelName = \models\ProductsRepository::class;

    public function stock()
    {
        $pageTitle = "Stock";
        $products = $this->model->findAll();
        if (isset($_SESSION['status'])) {
            // if ($_SESSION['status'] === "boss") {
                // Render::render("adminStock", compact('pageTitle', 'products'));
            // } else
            
            if ($_SESSION['status'] === "seller") {
                Render::render("stock", compact('pageTitle', 'products'));
            }
        } else {
            throw new Exception("Vous n'êtes pas connecté !");
        }
    }
}
