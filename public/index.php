<?php declare(strict_types=1);
session_start();

require_once __DIR__.'/../vendor/autoload.php';

\App\Software::loadEnvironmentFile(__DIR__.'/../');

if(!isset($_ENV['SOFTWARE_FORMAT_TIMESTAMP']))
{
    throw new \App\Exception\EnvironmentMissingException('Missing Variable: SOFTWARE_FORMAT_TIMESTAMP');
}
define("TIMEZONE", new DateTimeZone($_ENV['SOFTWARE_TIMEZONE']));

if(empty($_ENV['DB_HOST']) || empty($_ENV['DB_NAME']) || empty($_ENV['DB_USER']) || !isset($_ENV['DB_PASS']))
{
    throw new \App\Exception\EnvironmentMissingException('Missing or incomplete Database Configuration');
}

const CACHE_DIR = __DIR__.'/../cache/';

require_once __DIR__ . '/../config/general.php';
require_once __DIR__.'/../config/container.php';
require_once __DIR__.'/../config/routes.php';
