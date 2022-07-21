<?php declare(strict_types=1);

namespace App;

use Dotenv\Dotenv;

class Software
{

    public const VERSION = '0.0.1';
    public const VERSION_TYPE = 'dev';

    public const REPO_URI = 'https://github.com/npcorenet/spacegame';
    public const CHANGELOG_URI = '';

    public static function loadEnv(string $envLocation): void
    {

        $dotEnv = Dotenv::createMutable($envLocation);
        $dotEnv->load();

    }

}
