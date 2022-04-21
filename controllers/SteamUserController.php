<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\SteamGame;
use app\models\SteamUser;

class SteamUserController extends Controller
{

    public function show(Request $request, Response $response){
        $steam_id = $request->getRouteParams()['steam_id'];
        $steamUser = SteamUser::findBySteamId($steam_id);

        return $this->render('profile', [
            'steamUser' => $steamUser
        ]);
    }

    public function userGames(Request $request, Response $response){
        $steam_id = $request->getRouteParams()['steam_id'];
        $steamUser = SteamUser::findBySteamId($steam_id);

        return $this->render('userGames', [
            'steamUser' => $steamUser
        ]);
    }

    public function gameInfo(Request $request, Response $response) {
        $app_id = $request->getRouteParams()['app_id'];
        $game = SteamGame::findOne(['appid' => $app_id]);

        return $this->render('gameInfo', [
            'game' => $game
        ]);
    }

    public function userFriends(Request $request, Response $response)
    {
        $steam_id = $request->getRouteParams()['steam_id'];
        $steamUser = SteamUser::findBySteamId($steam_id);

        return $this->render('userFriends', [
            'steamUser' => $steamUser
        ]);
    }

}