<?php
//execute migrations

use app\core\Application;
use app\models\User;

require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
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


$app = new Application(__DIR__, $config);
$app->db->applyMigrations();