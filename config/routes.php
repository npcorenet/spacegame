<?php declare(strict_types=1);

$request = \Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);

$router->get('/login', 'App\Controller\LoginController::get');
$router->get('/register', 'App\Controller\RegisterController::get');
$router->post('/register', 'App\Controller\RegisterController::get');

$router->get('/dashboard', 'App\Controller\DashboardController::get');

$router->get('/404', 'App\Controller\NotFoundController::get');


$router->get('/admin/info', 'App\Controller\Admin\InfoController::get');

try {
    $response = $router->dispatch($request);
    (new \Laminas\HttpHandlerRunner\Emitter\SapiEmitter())->emit($response);
} catch(\League\Route\Http\Exception\NotFoundException $exception) {
    header("Location: /404");
    die();
}