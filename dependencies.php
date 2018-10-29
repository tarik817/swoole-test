<?php

$container = $app->getContainer();

// view renderer
$container['view'] = function ($app) {
    $settings = $app->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer(__DIR__ . '/templates/');
};