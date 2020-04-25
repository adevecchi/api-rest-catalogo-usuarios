<?php

$app->get('/users(/)', \App\Controllers\Api\UsersController::class.':getUsers');

$app->get('/users/:id(/)', \App\Controllers\Api\UsersController::class.':getUser')->conditions(['id' => '[0-9]+']);

$app->get('/users/:id/posts(/)', \App\Controllers\Api\UsersController::class.':getPosts')->conditions(['id' => '[0-9]+']);

$app->group('/api', function () use ($app) {

    $app->get('/users/:id(/)', \App\Controllers\Api\UsersController::class.':getUser')->conditions(['id' => '[0-9]+']);

    $app->post('/users(/)', \App\Controllers\Api\UsersController::class.':add');

    $app->put('/users/:id(/)', \App\Controllers\Api\UsersController::class.':update')->conditions(['id' => '[0-9]+']);

    $app->delete('/users/:id(/)', \App\Controllers\Api\UsersController::class.':delete')->conditions(['id' => '[0-9]+']);


    $app->post('/users/list(/)', \App\Controllers\Api\UsersController::class.':all');

    $app->post('/users/list/:id/posts(/)', \App\Controllers\Api\UsersController::class.':allPosts')->conditions(['id' => '[0-9]+']);


    $app->group('/create', function () use ($app) {

        $app->get('/mysql/database(/)', \App\Controllers\Api\CreateMysqlDBController::class.':create');
    });
});
