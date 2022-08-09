<?php
declare(strict_types=1);

$request = \Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

$router->get('/', 'App\Controller\IndexController::load');

$router->get('/auth/register', 'App\Controller\RegisterController::load');
$router->post('/auth/register', 'App\Controller\RegisterController::load');

$router->get('/auth/login', 'App\Controller\LoginController::load');
$router->post('/auth/login', 'App\Controller\LoginController::load');

$router->get('/account', 'App\Controller\AccountController::load');

$router->get('/space', 'App\Controller\SpaceController::load');

$router->get('/bank', 'App\Controller\BankController::load');
$router->post('/bank/create', 'App\Controller\BankController::create');
$router->get('/bank/{address}', 'App\Controller\BankController::show');

$response = $router->dispatch($request);
(new \Laminas\HttpHandlerRunner\Emitter\SapiEmitter())->emit($response);
