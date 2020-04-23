<?php

require '../vendor/autoload.php';

$app = new \Slim\Slim([
        'debug' => true,
        'templates.path' => '../templates'
    ]);

require '../src/dependencies.php';

require '../src/routes_client.php';

require '../src/routes_api.php';

$app->run();