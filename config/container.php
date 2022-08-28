<?php
declare(strict_types=1);

$container = new \League\Container\Container();

#
# Controllers
#

$container->add(\App\Controller\IndexController::class)
    ->addArgument(\Envms\FluentPDO\Query::class)
    ->addArgument(\App\Helper\ResponseHelper::class);

$container->add(\App\Controller\RegisterController::class)
    ->addArgument(\Envms\FluentPDO\Query::class)
    ->addArgument(\App\Helper\ResponseHelper::class);

$container->add(\App\Controller\LoginController::class)
    ->addArgument(\Envms\FluentPDO\Query::class)
    ->addArgument(\App\Helper\ResponseHelper::class);

$container->add(\App\Controller\AccountController::class)
    ->addArgument(\Envms\FluentPDO\Query::class)
    ->addArgument(\App\Helper\ResponseHelper::class);

$container->add(\App\Controller\SpaceController::class)
    ->addArgument(\Envms\FluentPDO\Query::class)
    ->addArgument(\App\Helper\ResponseHelper::class);

$container->add(\App\Controller\BankController::class)
    ->addArgument(\Envms\FluentPDO\Query::class)
    ->addArgument(\App\Helper\ResponseHelper::class);

$container->add(\App\Controller\TransactionController::class)
    ->addArgument(\Envms\FluentPDO\Query::class)
    ->addArgument(\App\Helper\ResponseHelper::class);

$container->add(\App\Controller\ContractController::class)
    ->addArgument(\Envms\FluentPDO\Query::class)
    ->addArgument(\App\Helper\ResponseHelper::class);

#
# Services
#

#
# Repositories
#

#
# Dependencies
#

$container->add(PDO::class)
    ->addArgument('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'])
    ->addArgument($_ENV['DB_USER'])
    ->addArgument($_ENV['DB_PASS']);

$container->add(\Envms\FluentPDO\Query::class)
    ->addArgument(PDO::class);

$container->add(\App\Helper\ResponseHelper::class);

$responseFactory = (new \Laminas\Diactoros\ResponseFactory());
$strategy = (new \League\Route\Strategy\JsonStrategy($responseFactory))->setContainer($container);
$router = (new \League\Route\Router())->setStrategy($strategy);
