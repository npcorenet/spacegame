<?php

$container = new \League\Container\Container();

/*
 *
 * Routes
 *
 * */

$container->add(\App\Controller\LoginController::class)
    ->addArgument(League\Plates\Engine::class)
    ->addArgument(\Envms\FluentPDO\Query::class);

$container->add(\App\Controller\RegisterController::class)
    ->addArgument(\League\Plates\Engine::class)
    ->addArgument(\Envms\FluentPDO\Query::class);

$container->add(\App\Controller\DashboardController::class)
    ->addArgument(\League\Plates\Engine::class)
    ->addArgument(\Envms\FluentPDO\Query::class);

$container->add(\App\Controller\NotFoundController::class)
    ->addArgument(\League\Plates\Engine::class);

$container->add(\App\Controller\Admin\InfoController::class)
    ->addArgument(\League\Plates\Engine::class)
    ->addArgument(\Envms\FluentPDO\Query::class);

/*
 *
 * Software Related
 *
 * */

$container->add(\League\Plates\Extension\Asset::class)
    ->addArgument(__DIR__.'/../public')
    ->addArgument(false);

$container->add(\League\Plates\Extension\URI::class)
    ->addArgument($_SERVER['REQUEST_URI']);

$container->add(\League\Plates\Engine::class)
    ->addArgument(__DIR__.'/../template')
    ->addMethodCall('loadExtension',  [\League\Plates\Extension\Asset::class])
    ->addMethodCall('loadExtension', [\League\Plates\Extension\URI::class]);

$container->add(PDO::class)
    ->addArgument('mysql:host=db;dbname=db')
    ->addArgument('db')
    ->addArgument('db');

$container->add(Envms\FluentPDO\Query::class)
    ->addArgument(PDO::class);

$strategy = (new \League\Route\Strategy\ApplicationStrategy())->setContainer($container);
$router = (new \League\Route\Router())->setStrategy($strategy);
