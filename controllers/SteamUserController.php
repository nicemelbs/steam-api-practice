<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\SteamGame;
use app\models\SteamUser;

class SteamUserController extends Controller
{

    public function show(Request $request, Response $response)
    {

        $steam_id = $request->getRouteParams()['steam_id'];
        $steamUser = SteamUser::findBySteamId($steam_id);

        $steamUser->playerlevel = SteamUser::getPlayerLevel($steam_id);

        return $this->render('profile', [
            'steamUser' => $steamUser,
            'title' => $steamUser->personaname . '\'s Profile'
        ]);
    }

    public function userGames(Request $request, Response $response)
    {
        $steam_id = $request->getRouteParams()['steam_id'];
        $steamUser = SteamUser::findBySteamId($steam_id);

        return $this->render('userGames', [
            'steamUser' => $steamUser
        ]);
    }

    public function gameInfo(Request $request, Response $response)
    {
        $app_id = $request->getRouteParams()['app_id'];
        $game = SteamGame::findOne(['appid' => $app_id]);
        $owned = false;
        $hours = 0;

        //check if a user is logged in
        if (Application::isGuest()) {
            $steamUser = null;
        } else {
            $steamUser = SteamUser::findBySteamId($_SESSION['steamid']);
            $steamUser->fetchUserGames();

            //check if the user owns the game
            $games = $steamUser->usergames;
            foreach ($games as $usergame) {
                if ($usergame->appId == $app_id) {
                    $owned = true;
                    $hours = round($usergame->playtimeForever / 60);
                    break;
                }
            }
        }

        return $this->render('gameInfo', [
            'game' => $game,
            'owned' => $owned,
            'hours' => $hours,
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

    public function userProfile(Request $request, Response $response)
    {
        if (!Application::isGuest()) {
            $response->redirect('/profile/' . $_SESSION['steamid']);
        }

    }

    public function inventory(Request $request, Response $response)
    {
        $steam_id = $request->getRouteParams()['steam_id'];
        $steamUser = SteamUser::findBySteamId($steam_id);
        $steamUser->fetchItems();
        if (!Application::isGuest()) {
            return $this->render('inventory', ['steamUser' => $steamUser]);
        } else {
            return "Please sign in to view this player's inventory.";
        }

    }

}