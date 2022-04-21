<?php


use app\core\Migration;

class m0002_steam_profile extends Migration
{
    public function up()
    {
        parent::up();
        $db = $this->getDB();

        $sql = "CREATE TABLE `steam_users` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `steamid` varchar(30) NOT NULL,
            `communityvisibilitystate` int(1) NOT NULL,
            `profilestate` int(1),
            `gamecount` int(5),
            `profileurl` varchar(255) NOT NULL,
            `avatar` varchar(255),
            `avatarmedium` varchar(255),
            `avatarfull` varchar(255),
            `personaname` varchar(255) NOT NULL,
            `realname` varchar(255),
            `playerlevel` int(6) NOT NUll DEFAULT 0,
            `timecreated` timestamp NOT NULL,
            `personastateflags` int(2),
            `loccountrycode` varchar(2),
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