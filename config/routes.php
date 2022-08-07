<?php declare(strict_types=1);

$request = \Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);

$router->get('/', 'App\Controller\IndexController::load');

$router->get('/auth/register', 'App\Controller\RegisterController::load');
$router->post('/auth/register', 'App\Controller\RegisterController::load');

$response = $router->dispatch($request);
(new \Laminas\HttpHandlerRunner\Emitter\SapiEmitter())->emit($response);
