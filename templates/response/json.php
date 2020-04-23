<?php

$app->response->headers->set('Content-Type', 'application/json; charset=utf-8');
$app->response->setStatus($code);

echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);