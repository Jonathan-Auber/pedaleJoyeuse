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
        // $page = "views/index.phtml";
        // require_once "views/layout.phtml";
        Render::render("index");
        // Si connecté
    }

    public function login()
    {
        $login = $this->model->login();
        if ($login) {
            // $page = "views/index.phtml";
            // require_once "views/layout.phtml";
            Render::render("index");
        } else {
            throw new Exception("Vous n'êtes pas connecté !");
        }
    }
    public function logout()
    {
        $this->model->logout();
        header('Location: /pedaleJoyeuse');
    }
}
