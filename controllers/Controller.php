<?php

namespace controllers;

// Class abstraite parente des controller
abstract class Controller
{
    protected $model;
    protected $modelName;
    protected $controllerName;
    protected $userIsConnected;
    protected $userIsAdmin;

    public function __construct()
    {
        // La propriété model créer une nouvelle instance du model correspondant au controller
        $this->model = new $this->modelName();
        
        if($this->controllerName === "controllers\ProductsController") {
            $user = new \models\UsersRepository();
            $this->userIsConnected = $user->isConnected();
            $this->userIsAdmin = $user->isAdmin();
        }
    }
}
