<?php

namespace controllers;

class UsersController extends Controller
{
    protected $modelName = \models\UsersRepository::class;

    public function index()
    {
        // Si non connecté
        $page = "views/index.phtml";
        require_once "views/base.phtml";

        // Si connecté
    }

    
}
