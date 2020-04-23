<?php

namespace App\Models;

class Models
{
    protected $app;

    public function __construct()
    {
        $this->app = \Slim\Slim::getInstance();
    }
}