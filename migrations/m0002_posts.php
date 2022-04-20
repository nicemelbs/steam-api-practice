<?php


use app\core\Migration;

class m0002_posts extends Migration
{
    public function up()
    {
        parent::up();
        $db = $this->getDB();

        $sql = "CREATE TABLE `news` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `title` varchar(255) NOT NULL,
            `body` varchar(3000) NOT NULL,
            `user_id` int(11) NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) 
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