<?php declare(strict_types=1);

$container = new \League\Container\Container();

/*
 *
 * Routes
 *
 * */

$container->add(\App\Controller\LoginController::class)
    ->addArgument(League\Plates\Engine::class)
    ->addArgument(\Envms\FluentPDO\Query::class)
    ->addArgument(\App\Helper\MessageHelper::class);

$container->add(\App\Controller\RegisterController::class)
    ->addArgument(\League\Plates\Engine::class)
    ->addArgument(\Envms\FluentPDO\Query::class)
    ->addArgument(\App\Helper\MessageHelper::class)
    ->addArgument(\App\Helper\EmailHelper::class);

$container->add(\App\Controller\ActivateAccountController::class)
    ->addArgument(\Envms\FluentPDO\Query::class)
    ->addArgument(\App\Helper\MessageHelper::class);

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

$container->add(\PHPMailer\PHPMailer\PHPMailer::class)
    ->addMethodCall('isSMTP')
    ->addMethodCall('set', ['Host', SMTP_HOST])
    ->addMethodCall('set', ['Username', SMTP_USER])
    ->addMethodCall('set', ['Password', SMTP_PASSWORD])
    ->addMethodCall('set', ['Port', SMTP_PORT])
    ->addMethodCall('set', [SMTP_DISPLAYMAIL, SMTP_DISPLAYNAME])
    ->addMethodCall('set', ['SMTPAuth', SMTP_AUTH])
    ->addMethodCall('set', ['SMTPSecure', \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS]);

$container->add(\App\Helper\MessageHelper::class);

$container->add(\App\Helper\EmailHelper::class)
    ->addArgument(\League\Plates\Engine::class)
    ->addArgument(\PHPMailer\PHPMailer\PHPMailer::class);

$strategy = (new \League\Route\Strategy\ApplicationStrategy())->setContainer($container);
$router = (new \League\Route\Router())->setStrategy($strategy);
