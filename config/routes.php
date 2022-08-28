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
$router->post('/auth/register', 'App\Controller\RegisterController::run');

$router->get('/auth/login', 'App\Controller\LoginController::load');
$router->post('/auth/login', 'App\Controller\LoginController::run');

$router->get('/account', 'App\Controller\AccountController::load');

$router->get('/space', 'App\Controller\SpaceController::load');

$router->get('/bank', 'App\Controller\BankController::load');
$router->post('/bank/create', 'App\Controller\BankController::create');

$router->get('/bank/transfer', 'App\Controller\TransactionController::load');
$router->post('/bank/transfer', 'App\Controller\TransactionController::transfer');
$router->get('/bank/transfer/{token}', 'App\Controller\TransactionController::list');

$router->get('/bank/{address}', 'App\Controller\BankController::show');
$router->delete('/bank/{address}', 'App\Controller\BankController::delete');
$router->delete('/bank/{address}/{token}', 'App\Controller\BankController::delete');

$router->get('/contract', 'App\Controller\ContractController::load');
$router->get('/contract/{id}', 'App\Controller\ContractController::show');

$response = $router->dispatch($request);
(new \Laminas\HttpHandlerRunner\Emitter\SapiEmitter())->emit($response);
