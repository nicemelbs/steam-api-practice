<?php

require_once __DIR__ . '/../vendor/autoload.php';

use app\controllers\AuthController;
use app\controllers\SiteController;
use app\controllers\SteamUserController;
use app\core\Application;
use app\models\User;

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$config = [
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
        'dbname' => $_ENV['DB_NAME'],
        'host' => $_ENV['DB_HOST'],
        'port' => $_ENV['DB_PORT'],
    ],
    'steam' => [
        'api_key' => $_ENV['STEAM_API_KEY'],
        'api_url' => $_ENV['STEAM_API_URL'],
    ],
    'userClass' => User::class,
];

$app = new Application(dirname(__DIR__), $config);

$app->router->get('/', [SiteController::class, 'home']);
$app->router->get('/profile/{steam_id}', [SteamUserController::class, 'show']);
$app->router->get('/profile/{steam_id}/games', [SteamUserController::class, 'userGames']);

$app->run();
