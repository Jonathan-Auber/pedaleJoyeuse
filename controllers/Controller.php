<?php

namespace controllers;

// Class abstraite parente des controller
abstract class Controller
{
    protected $model;
    protected $modelName;
    // protected $userIsConnected;
    // protected $userIsAdmin;

    public function __construct()
    {
        // La propriété model créer une nouvelle instance du model correspondant au controller
        $this->model = new $this->modelName();
        // $usersRepo = new \models\UsersRepository();
        // $this->productsRepo = new \models\ProductsRepository();
        // $this->userIsConnected = $usersRepo->isConnected();
        // $this->userIsAdmin = $usersRepo->isAdmin();
    }
}
