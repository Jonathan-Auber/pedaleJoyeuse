<?php

namespace controllers;

use Exception;

class UsersController extends Controller
{
    protected $modelName = \models\UsersRepository::class;

    public function index()
    {
        // Si non connecté
        $page = "views/index.phtml";
        require_once "views/layout.phtml";

        // Si connecté
    }

    public function login()
    {
        $login = $this->model->login();
        if ($login) {
            $page = "views/index.phtml";
            require_once "views/layout.phtml";
        } else {
            throw new Exception("Vous n'êtes pas connecté !");
        }
    }
    public function disconnect()
    {
        $this->model->disconnect();
        header('Location: /pedaleJoyeuse');
    }
}
