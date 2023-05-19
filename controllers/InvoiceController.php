<?php

namespace controllers;

use Exception;
use models\UsersRepository;
use models\CustomersRepository;
use models\InvoiceRepository;
use models\ProductsRepository;
use utils\Render;

class InvoiceController extends Controller
{
    protected $modelName = InvoiceRepository::class;
    protected $user;
    protected $customer;
    protected $product;

    public function __construct()
    {
        parent::__construct();
        $this->user = new UsersRepository();
        $this->customer = new CustomersRepository();
        $this->product = new ProductsRepository();
    }

    public function createInvoice() {
        $this->user->isConnected();
        $pageTitle = "Création de facture";
        Render::render("invoice", compact("pageTitle"));
    }

    public function dataProduct(){
        $result = $this->product->findAll();
        // header('Content-Type: application/json');
        echo json_encode($result);
        // exit;
    }
}
