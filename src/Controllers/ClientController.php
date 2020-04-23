<?php

namespace App\Controllers;

class ClientController extends Controller
{
    public function pageIndex()
    {
        $this->app->render('index.html');
    }

    public function pageAdd()
    {
        $this->app->render('add.html');
    }

    public function pageEdit($id)
    {
        $this->app->render('edit.html');
    }

    public function pageDetails($id)
    {
        $this->app->render('details.html');
    }
}