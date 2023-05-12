<?php

namespace controllers;

// Class abstraite parente des controller
abstract class Controller
{
    protected $model;
    protected $modelName;

    public function __construct()
    {
        // La propriété model créer une nouvelle instance du controller enfant
        $this->model = new $this->modelName();
    }
}
