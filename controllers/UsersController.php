<?php

namespace controllers;

use Exception;
use utils\Render;

class UsersController extends Controller
{
    protected $modelName = \models\UsersRepository::class;


    public function index()
    {
        // Si non connecté
        $indexTitle = "Espace de connexion";
        Render::render("index", compact("indexTitle"));
        // Si connecté
    }

    public function login()
    {
        $this->model->login();
        $indexTitle = "Vous êtes connecté";
        Render::render("index", compact("indexTitle"));
    }
    public function logout()
    {
        $this->model->logout();
        $indexTitle = "Vous êtes bien déconnecté";
        Render::render("index", compact("indexTitle"));
    }
}
