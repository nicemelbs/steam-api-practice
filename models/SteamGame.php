<?php

namespace app\models;

use app\core\exceptions\NotFoundException;

class SteamGame extends SteamAPIObject
{
    public $appid;
    public $name;
    public $about_the_game;
    public $detailed_description;
    public $header_image;
    public $short_description;

    public static function findOne($attributes): ?SteamGame
    {
        //check if game is in the database
        //if not, get it from steam API and save it in the database
        $game = parent::findOne($attributes);

        if (!$game) {
            $game = new SteamGame();

            $url = "http://store.steampowered.com/api/appdetails/";

            $appId = $attributes['appid'];

            $queryParams = ['appids' => $appId];
            $fetchedObject = self::apiCall($url, $queryParams, false);

            //some games are not available in the steam store.
            //probably removed from the store or region locked
            if ($fetchedObject[$appId]['success']) {

                $fetchedObject = $fetchedObject[$appId]['data'];
                $game->appid = $fetchedObject['steam_appid'];
                $game->name = $fetchedObject['name'];
                $game->about_the_game = $fetchedObject['about_the_game'];
                $game->detailed_description = $fetchedObject['detailed_description'];
                $game->header_image = $fetchedObject['header_image'];
                $game->short_description = $fetchedObject['short_description'];

                $game->save();
            } else return null;
        }
        return $game;
    }

    public static function tableName()
    {
        return 'steam_games';
    }

    public function rules(): array
    {
        return [];
    }

    public function attributes(): array
    {
        return [
            'appid',
            'name',
            'about_the_game',
            'detailed_description',
            'header_image',
            'short_description',
        ];
    }
}
