<?php


use app\core\Migration;

class m0004_caching extends Migration
{
    public function up()
    {
        parent::up();
        $db = $this->getDB();

        $sql = "CREATE TABLE `cache` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `cacheKey` varchar(255) UNIQUE,
            `cacheValue` LONGTEXT UNIQUE,
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
        $sql = "DROP TABLE `steam_games`;";
        $db->pdo->exec($sql);
    }

}