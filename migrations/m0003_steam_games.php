<?php


use app\core\Migration;

class m0003_steam_games extends Migration
{
    public function up()
    {
        parent::up();
        $db = $this->getDB();

        $sql = "CREATE TABLE `steam_games` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `appid` int(11) NOT NULL UNIQUE ,
            `name` varchar(255) NOT NULL,
            `detailed_description` varchar(5000),
            `about_the_game` varchar(5000),
            `short_description` varchar(500),
            `header_image` varchar(255),
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