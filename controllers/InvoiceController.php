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

    public function dataProduct()
    {
        $result = $this->product->findAll();
        echo json_encode($result);
    }

    public function createInvoice(int $id)
    {
        $this->user->isConnected();
        $pageTitle = "Création de facture";
        Render::render("newInvoice", compact("pageTitle", "id"));
    }

    public function insertInvoice(int $id)
    {
        $results = $this->model->postDataProcessing($_POST);
        $invoiceId = $this->model->insertInvoice($id);
        $this->model->insertInvoiceLines($results, $invoiceId);
        $invoiceData = $this->model->updateInvoice($invoiceId);
        extract($invoiceData);
        $customerData = $this->model->customerData($invoiceId);
        $pageTitle = "Facture";
        Render::render("invoice", compact("pageTitle", "results", "invoiceId", "invoiceLines", "totalInvoice", "totalInvoiceVat", "totalWithVat", "customerData"));
    }
}
