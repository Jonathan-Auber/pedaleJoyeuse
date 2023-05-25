<?php

namespace controllers;

use Exception;
use models\CustomersRepository;
use models\InvoiceRepository;
use utils\Render;

class CustomersController extends Controller
{
    protected $modelName = CustomersRepository::class;
    protected $invoice;

    public function __construct()
    {
        parent::__construct();
        $this->invoice = new InvoiceRepository();
    }

    public function displayCustomers()
    {
        $this->session->isConnected();
        $customers = $this->model->findAll();
        $pageTitle = "Fichier client";
        Render::render("customers", compact("pageTitle", "customers"));
    }

    public function addCustomer(?int $id = null)
    {
        $this->session->isConnected();
        if ($id) {
            $customer = $this->model->find($id);
            $pageTitle = "Editer un client";
            Render::render("addCustomer", compact("pageTitle", "customer"));
        } else {
            $pageTitle = "Ajout client";
            Render::render("addCustomer", compact("pageTitle"));
        }
    }

    public function insertCustomer(?int $id = null)
    {
        // $this->session->isConnected();
        if ($id) {
            $this->model->updateCustomer($id);
            $pageTitle = "Fichier client";
        } else {
            $this->model->insertCustomer();
            $pageTitle = "Fichier client";
        }
        $customers = $this->model->findAll();
        Render::render("customers", compact("pageTitle", "customers"));

    }

    public function invoiceByCustomer(int $id)
    {
        $this->session->isConnected();
        $customer = $this->model->find($id);
        $invoiceData = $this->invoice->invoiceData($id);
        $pageTitle = "Liste des factures client";
        Render::render("invoiceByCustomer", compact("pageTitle", "customer", "invoiceData"));
    }
}
