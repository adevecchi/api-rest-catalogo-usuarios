<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

define('URL_BASE', __DIR__);

require 'vendor/autoload.php';

$app = new \Slim\Slim(['templates.path' => 'app/templates']);

require_once 'app/routes.php';

$app->run();
