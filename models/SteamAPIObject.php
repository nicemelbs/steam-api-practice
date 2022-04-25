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

        //check if we have a cached version of the data from the database
        //if so, take it from the database
        //if not, fetch it from the API and store it in the database
        $cacheKey = md5($url . serialize($queryParams));

        $cacheBody = Cache::findOne(['cacheKey' => $cacheKey]);

        if (!$cacheBody) {
            $cache = new Cache();
            $cache->cacheKey = $cacheKey;

            $client = Application::$client;
            $response = $client->request('GET', $url, $options);
            $body = $response->getBody();
            $cache->cacheValue = $body;
            $cache->save();
        } else {
            $body = $cacheBody->cacheValue;
        }

        return json_decode($body, true);
    }
}