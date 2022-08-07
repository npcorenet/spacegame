<?php declare(strict_types=1);
session_start();

require_once __DIR__.'/../vendor/autoload.php';

\App\Software::loadEnvironmentFile(__DIR__.'/../');

require_once __DIR__ . '/../config/general.php';
require_once __DIR__.'/../config/container.php';
require_once __DIR__.'/../config/routes.php';
