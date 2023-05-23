<?php

namespace controllers;

use Exception;
use models\ProductsRepository;
use models\UsersRepository;
use utils\Render;

class ProductsController extends Controller
{
    protected $modelName = \models\ProductsRepository::class;
    protected $user;

    public function __construct()
    {
        parent::__construct();
        $this->user = new \models\UsersRepository();
    }

    public function stock()
    {
        $this->user->isConnected();
        $pageTitle = "Stock";
        $products = $this->model->findAll();
        Render::render("Stock", compact('pageTitle', 'products'));
    }

    public function formProduct(int $id) {
        $this->user->isAdmin();
        $pageTitle = "Edition des stock";
        $product = $this->model->find($id);
        Render::render("formProducts", compact("pageTitle", "product"));
    }

    public function updateProduct(int $id)
    {
        $this->user->isAdmin();
        $this->model->updateProduct($id);
        $pageTitle = "Stock";
        $products = $this->model->findAll();
        Render::render("stock", compact("pageTitle", "products"));
    }
}
