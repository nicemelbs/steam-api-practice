<?php

namespace app\models;

use app\core\Application;
use app\core\db\DbModel;

abstract class SteamAPIObject extends DbModel
{

    protected static function apiCall($url, array $queryParams, bool $needsApiKey = true)
    {

        if ($needsApiKey) {
            $queryParams['key'] = $_ENV['STEAM_API_KEY'];
        }

        foreach ($queryParams as $key => $value) {
            //if value is an array, convert to a + separated string
            if (is_array($value)) {
                $queryParams[$key] = implode('+', $value);
            }
        }

        $options = [
            'query' => $queryParams
        ];

        $client = Application::$client;

        $response = $client->request('GET', $url, $options);
        $body = $response->getBody();
        return json_decode($body, true);
    }
}