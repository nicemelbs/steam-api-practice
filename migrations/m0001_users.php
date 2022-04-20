<?php


use app\core\Migration;

class m0001_users extends Migration
{
    public function up()
    {
        parent::up();
        $db = $this->getDB();
        $sql = "CREATE TABLE `users` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `firstname` varchar(255) NOT NULL,
            `lastname` varchar(255) NOT NULL,
            `email` varchar(255) NOT NULL,
            `password` varchar(255) NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

        $db->pdo->exec($sql);
    }

    public function down()
    {
        parent::down();
        $db = $this->getDb();
        $sql = "DROP TABLE `users`;";
        $db->pdo->exec($sql);
    }
}