<?php

$app->get('/database/mysql/', app\controllers\DataBaseMysql::class.':create');



$app->get('/users/', app\controllers\Users::class.':getUsers');

$app->get('/users/:id/', app\controllers\Users::class.':getUser')->conditions(['id' => '[0-9]+']);

$app->get('/users/:id/posts/', app\controllers\Users::class.':getPosts')->conditions(['id' => '[0-9]+']);

$app->post('/users/', app\controllers\Users::class.':add');

$app->put('/users/:id/', app\controllers\Users::class.':update')->conditions(['id' => '[0-9]+']);

$app->delete('/users/:id/', app\controllers\Users::class.':delete')->conditions(['id' => '[0-9]+']);



$app->post('/users/list/', app\controllers\Users::class.':all');

$app->post('/users/list/:id/posts/', app\controllers\Users::class.':allPosts')->conditions(['id' => '[0-9]+']);
