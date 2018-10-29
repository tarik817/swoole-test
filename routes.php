<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    return $this->view->render($response, 'index.phtml', $args);
});