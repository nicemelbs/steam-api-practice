<?php

namespace app\models;

use app\core\db\DbModel;

class UserGame extends SteamAPIObject
{
    public $steamId;
    public $appId;
    public $playtimeForever;
    public $playtime2Weeks;

    public static function tableName()
    {
        return 'user_games';
    }

    public function rules(): array
    {
        return [];
    }

    public function getSteamGame(): SteamGame
    {
        return SteamGame::findOne(['appid' => $this->appId]);
    }
}