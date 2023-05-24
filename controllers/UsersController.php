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
            $this->adminView();
        } elseif (isset($_SESSION['id']) && $_SESSION['status'] === "seller") {
            $this->sellerView();
        } else {
            $pageTitle = "Login";
            $indexTitle = "Espace de connexion";
            Render::render("index", compact("pageTitle", "indexTitle"));
        }
    }

    public function sellerView()
    {
        $salesByMonth = $this->model->salesBy("MONTH", "AND i.user_id = ?", $_SESSION['id']);
        extract($salesByMonth);
        $monthSales = $period;
        $totalByMonth = $totalByPeriod;

        $salesByYear = $this->model->salesBy("YEAR", "AND i.user_id = ?", $_SESSION['id']);
        extract($salesByYear);
        $yearSales = $period;
        $totalByYear = $totalByPeriod;

        $pageTitle = "Seller";
        Render::render("sellerView", compact("pageTitle", "monthSales", "totalByMonth", "yearSales", "totalByYear"));
    }

    public function adminView()
    {
        $salesByDay = $this->model->salesBy("DAY");
        extract($salesByDay);
        $daySales = $period;
        $totalByDay = $totalByPeriod;

        $salesByYear = $this->model->salesBy("YEAR");
        extract($salesByYear);
        $yearSales = $period;
        $totalByYear = $totalByPeriod;

        $productByMonthWithVAT = $this->model->productByMonthWithVAT();
        extract($productByMonthWithVAT);
        $productData = $results;

        $pageTitle = "Admin";
        Render::render("adminView", compact("pageTitle", "daySales", "totalByDay", "yearSales", "totalByYear", "productData", "productsVAT", "totalVAT"));
    }

    public function salesView()
    {
        $this->model->isConnected();
        $this->model->isAdmin();
        $users = $this->model->findAll();
        $pageTitle = "Ventes des vendeurs";
        Render::render("salesView", compact("pageTitle", "users"));
    }

    public function salesBySeller(int $userId)
    {
        $this->model->isConnected();
        $this->model->isAdmin();
        $user = $this->model->find($userId);
        $results = $this->model->salesBySeller($userId);
        extract($results);
        $pageTitle = "Ventes des vendeurs";
        Render::render("salesBySeller", compact("pageTitle", "user", "resultByMonth", "resultByYear"));
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
