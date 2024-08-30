<?php
define("BASE_PATH", __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR);

require BASE_PATH . "vendor/autoload.php";

use App\Bootstrap\Bootstrap;

Bootstrap::loadEnvVariables();

