<?php

declare(strict_types=1);

namespace App;

use Dotenv\Dotenv;

class Software
{

    public const VERSION = '0.0.1';
    public const VERSION_BUILD = 'dev';

    public static function loadEnvironmentFile(string $environmentFileLocation, string $filename = '.env'): void
    {
        $dotEnv = Dotenv::createMutable($environmentFileLocation, $filename);
        $dotEnv->load();
    }

    public function maintenanceStatus(): array|false
    {
        if(file_exists(__DIR__.'/../lock.json'))
        {

            return json_decode(file_get_contents(__DIR__.'/../lock.json'));

        }

        return false;
    }

}
