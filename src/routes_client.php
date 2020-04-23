<?php

$app->get('/', \App\Controllers\ClientController::class.':pageIndex');

$app->get('/add', \App\Controllers\ClientController::class.':pageAdd');

$app->get('/edit/user/:id', \App\Controllers\ClientController::class.':pageEdit')->conditions(['id' => '[0-9]+']);

$app->get('/details/user/:id', \App\Controllers\ClientController::class.':pageDetails')->conditions(['id' => '[0-9]+']);
