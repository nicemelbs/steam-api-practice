<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\core\Response;
use GuzzleHttp\Client;

class SteamUserController extends Controller
{

    public function show(Request $request, Response $response){


        $dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();

        $apiKey = $_ENV['STEAM_API_KEY'];
        
        $steam_id = $request->getRouteParams()['steam_id'];

        $client = new Client();
        $uri = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=$apiKey&steamids=$steam_id";

        echo '<pre>';
        var_dump($client->request('GET', $uri)->getBody()->getContents());
        echo '</pre>';
        exit;

//        $res = $client->request('GET', 'http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key='
//            .$apiKey .'&steamids='.$steam_id);


//        $steamUser = SteamUser::findById();
//        return null;
    }

}