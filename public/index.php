<?php
define("BASE_PATH", __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR);

require BASE_PATH . "vendor/autoload.php";

use App\Bootstrap\Bootstrap;
use App\Routing\Route;
use App\Controllers\UserController;
use App\Routing\Router;

Bootstrap::loadEnvVariables();

Route::get('/api/v1/users', [UserController::class, 'list']);
Route::post('/api/v1/users', [UserController::class, 'create']);

$router = Router::getInstance();

$router->routing();
