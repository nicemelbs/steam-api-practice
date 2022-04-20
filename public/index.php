<?php

require_once __DIR__ . '/../vendor/autoload.php';

use app\controllers\AuthController;
use app\controllers\SiteController;
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
    'userClass' => User::class,
];

$app = new Application(dirname(__DIR__), $config);
$app->router->get('/', [SiteController::class, 'home']);

$app->router->get('/contact', [SiteController::class, 'contact']);
$app->router->post('/contact', [SiteController::class, 'contact']);

$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);
$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);
$app->router->get('/logout', [AuthController::class, 'logout']);

$app->router->get('/profile', [AuthController::class, 'profile']);

//register routes with arguments
$app->router->get('/profile/{id}', [SiteController::class, 'profile']);
$app->router->get('/profile/{id:\d+}/{username}', [SiteController::class, 'profile']);

$app->router->get('/news/', [SiteController::class, 'allNews']);
$app->router->get('/news/{id}', [SiteController::class, 'news']);

$app->router->get('/write', [AuthController::class, 'write']);
$app->router->post('/write', [AuthController::class, 'write']);

$app->run();
