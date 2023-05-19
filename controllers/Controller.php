<?php

namespace controllers;

// Class abstraite parente des controller
abstract class Controller
{
    protected $model;
    protected $modelName;

    public function __construct()
    {
        // La propriété model créer une nouvelle instance du model correspondant au controller
        $this->model = new $this->modelName();
    }
}
