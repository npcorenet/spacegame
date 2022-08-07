<?php

declare(strict_types=1);

namespace App;

use Dotenv\Dotenv;

class Software
{

    public const VERSION = '0.0.1';
    public const VERSION_CODE = 'dev';

    public static function loadEnvironmentFile(string $environmentFileLocation): void
    {
        $dotEnv = Dotenv::createMutable($environmentFileLocation);
        $dotEnv->load();
    }

}
