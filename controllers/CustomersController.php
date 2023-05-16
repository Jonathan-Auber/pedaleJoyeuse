<?php

namespace controllers;

use Exception;
use model\CustomersRepository;
use models\UsersRepository;
use utils\Render;

class CustomersController extends Controller
{
    protected $modelName = \models\CustomersRepository::class;
    protected $user;

    public function __construct()
    {
        parent::__construct();
        // $this->user = new \models\UsersRepository();
    }

    public function displayCustomers() {
        $customers = $this->model->findAll();
        $pageTitle = "Fichier client";
        Render::render("customers", compact("customers"));
    }
}
