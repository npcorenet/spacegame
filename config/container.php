<?php declare(strict_types=1);

$container = new \League\Container\Container();

/*
 *
 * Routes
 *
 * */

$container->add(\App\Controller\IndexController::class);

$container->add(\App\Controller\RegisterController::class)
    ->addArgument(\Envms\FluentPDO\Query::class);

/*
 *
 * Software Related
 *
 * */

$container->add(PDO::class)
    ->addArgument('mysql:host='.$_ENV['DB_HOST'].';dbname='.$_ENV['DB_NAME'])
    ->addArgument($_ENV['DB_USER'])
    ->addArgument($_ENV['DB_PASS']);

$container->add(\Envms\FluentPDO\Query::class)
    ->addArgument(PDO::class);

$responseFactory = (new \Laminas\Diactoros\ResponseFactory());
$strategy = (new \League\Route\Strategy\JsonStrategy($responseFactory))->setContainer($container);
$router = (new \League\Route\Router())->setStrategy($strategy);
