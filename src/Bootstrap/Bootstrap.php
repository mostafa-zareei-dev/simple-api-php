<?php

namespace App\Bootstrap;

use Dotenv\Dotenv;

class Bootstrap
{
    public static function loadEnvVariables(string $path = '')
    {
        if (!empty($path)) {
            $dotenv = Dotenv::createImmutable($path);
        } else {
            $dotenv = Dotenv::createImmutable(BASE_PATH);
        }

        $dotenv->load();
    }
}
