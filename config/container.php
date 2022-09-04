<?php
declare(strict_types=1);

$container = new \League\Container\Container();

#
# Controllers
#

$container->add(\App\Controller\IndexController::class)
    ->addArgument(\Envms\FluentPDO\Query::class);

$container->add(\App\Controller\RegisterController::class)
    ->addArgument(\Envms\FluentPDO\Query::class)
    ->addArgument(\App\Service\AccountService::class);

$container->add(\App\Controller\LoginController::class)
    ->addArgument(\Envms\FluentPDO\Query::class);

$container->add(\App\Controller\AccountController::class)
    ->addArgument(\Envms\FluentPDO\Query::class);

$container->add(\App\Controller\SpaceController::class)
    ->addArgument(\App\Table\SolarSystemTable::class)
    ->addArgument(\App\Table\PlanetTable::class);

$container->add(\App\Controller\BankController::class)
    ->addArgument(\Envms\FluentPDO\Query::class);

$container->add(\App\Controller\TransactionController::class)
    ->addArgument(\Envms\FluentPDO\Query::class);

$container->add(\App\Controller\ContractController::class)
    ->addArgument(\App\Service\ContractService::class)
    ->addArgument(\Envms\FluentPDO\Query::class);

#
# Services
#
$container->add(\App\Service\AccountService::class)
    ->addArgument(\App\Table\AccountTable::class)
    ->addArgument(\App\Service\SecurityService::class)
    ->addArgument(\App\Table\AccountTokenTable::class);

$container->add(\App\Service\SecurityService::class);

$container->add(\App\Service\ContractService::class)
    ->addArgument(\App\Table\ContractTable::class)
    ->addArgument(\App\Table\ContractAccountTable::class);

#
# Repositories
#
$container->add(\App\Table\AccountTable::class)
    ->addArgument(\Envms\FluentPDO\Query::class);

$container->add(\App\Table\AccountTokenTable::class)
    ->addArgument(\Envms\FluentPDO\Query::class);

$container->add(\App\Table\ContractTable::class)
    ->addArgument(\Envms\FluentPDO\Query::class);

$container->add(\App\Table\ContractAccountTable::class)
    ->addArgument(\Envms\FluentPDO\Query::class);

$container->add(\App\Table\SolarSystemTable::class)
    ->addArgument(\Envms\FluentPDO\Query::class);

$container->add(\App\Table\PlanetTable::class)
    ->addArgument(\Envms\FluentPDO\Query::class);

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
