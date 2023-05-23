<?php

namespace controllers;

use Exception;
use utils\Render;

class UsersController extends Controller
{
    protected $modelName = \models\UsersRepository::class;


    public function index()
    {
        if (isset($_SESSION['id']) && $_SESSION['status'] === "boss") {
            $pageTitle = "Admin";
            Render::render("adminView", compact("pageTitle"));
        } elseif (isset($_SESSION['id']) && $_SESSION['status'] === "seller") {
            // En cours
            $this->sellerView();
        } else {
            $this->adminView();
        }
    }

    public function sellerView()
    {
        $monthSales = $this->model->salesByMonth($_SESSION['id']);
        $pageTitle = "Seller";
        Render::render("sellerView", compact("pageTitle", "monthSales"));
    }

    public function adminView()
    {
        $indexTitle = "Espace de connexion";
        Render::render("index", compact("indexTitle"));
    }
    public function login()
    {
        $this->model->login();
        $indexTitle = "Vous êtes connecté";
        header("Location: /pedaleJoyeuse");
    }

    public function logout()
    {
        $this->model->logout();
        $indexTitle = "Vous êtes bien déconnecté";
        Render::render("index", compact("indexTitle"));
    }
}
