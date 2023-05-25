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
        $this->session->isConnected();
        $pageTitle = "Stock";
        $products = $this->model->findAll();
        Render::render("Stock", compact('pageTitle', 'products'));
    }

    public function formProduct(int $id) {
        $this->session->isAdmin();
        $pageTitle = "Edition des stock";
        $product = $this->model->find($id);
        Render::render("formProducts", compact("pageTitle", "product"));
    }

    public function updateProduct(int $id)
    {
        $this->session->isAdmin();
        $this->model->updateProduct($id);
        $pageTitle = "Stock";
        $products = $this->model->findAll();
        Render::render("stock", compact("pageTitle", "products"));
    }
}
