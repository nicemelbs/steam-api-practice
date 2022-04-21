<?php

namespace app\models;

use app\core\db\DbModel;
use app\core\exceptions\NotFoundException;
use GuzzleHttp\Client;
use function PHPUnit\Framework\arrayHasKey;

class SteamUser extends SteamAPIObject
{
    public string $steamId;
    public int $communityVisibilityState;
    public int $profileState;
    public string $personaName;
    public string $realName;
    public string $profileUrl;
    public string $avatar;
    public string $avatarMedium;
    public string $avatarFull;
    public string $countryCode;
    public string $playerLevel;
    public array $userGames;
    public int $gameCount;
    public array $friends;

    public static function findBySteamId($steam_id): ?SteamUser
    {
//        http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=XXXXXXXXXXXXXXXXXXXXXXX&steamids=76561197960435530
        $steamUser = new SteamUser();

        $url = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/";
        $queryParams = ['steamids' => [$steam_id]];
        $data = self::apiCall($url,$queryParams);

        foreach ($data['response']['players'] as $player) {
            $steamUser->steamId = $player['steamid'];
            $steamUser->communityVisibilityState = $player['communityvisibilitystate'] ?? 0;
            $steamUser->profileState = $player['profilestate']?? 0;
            $steamUser->personaName = $player['personaname'] ?? '';
            $steamUser->realName = $player['realname'] ?? '';
            $steamUser->profileUrl = $player['profileurl'];
            $steamUser->avatar = $player['avatar'] ?? '';
            $steamUser->avatarMedium = $player['avatarmedium'] ?? '';
            $steamUser->avatarFull = $player['avatarfull'] ?? '';
            $steamUser->countryCode = $player['loccountrycode'] ?? '';
            $steamUser->gameCount = $player['game_count'] ?? 0;
            $steamUser->playerLevel = self::getPlayerLevel($steam_id) ?? 0;
            $steamUser->userGames  = self::fetchOwnedGames($steam_id);
            $steamUser->gameCount = count($steamUser->userGames);
            $steamUser->friends = self::fetchFriends($steam_id);
            return $steamUser;
        }

        return null;
    }

    private static function getPlayerLevel($steam_id){
        $uri = "http://api.steampowered.com/IPlayerService/GetSteamLevel/v1/";
        $queryParams = ['steamid' => $steam_id];
        return self::apiCall($uri, $queryParams)['response']['player_level'] ?? 0;
    }

    /**
     * @return array UserGame
     */
    private static function fetchOwnedGames($steam_id): array
    {
        $url = "http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/";
        $queryParams = ['steamid' => $steam_id, 'include_appinfo' => 0, 'include_played_free_games' => 0];

        $data = self::apiCall($url, $queryParams);
        $games = $data['response']['games'] ?? [];

        //sort games by playtime descending
        usort($games, function ($a, $b) {
            return $b['playtime_forever'] <=> $a['playtime_forever'];
        });


        $appIds = array_column($games, 'appid');
        //get data for games owned by user
        $userGames = [];
        foreach($games as $game) {
            $userGame = new UserGame();
            $userGame->appId = $game['appid'] ?? 0 ;

            if($userGame->appId === 0) {
                continue;
            }

            $userGame->steamId = $steam_id;
            $userGame->playtimeForever = $game['playtime_forever'] ?? 0;
            $userGame->playtime2Weeks = $game['playtime_2weeks'] ?? 0;
            $userGames[] = $userGame;
        }

        return $userGames;
    }

    private static function fetchFriends($steam_id): array
    {
        $url = "http://api.steampowered.com/ISteamUser/GetFriendList/v0001/";
        $queryParams = ['steamid' => $steam_id, 'relationship' => 'friend'];
        $steamFriends = [];
        try {
            $data = self::apiCall($url, $queryParams);
            $friends = $data['friendslist']['friends'] ?? [];
            foreach ($friends as $friend) {
                $steamFriend = new SteamFriend();
                $steamFriend->steamid = $friend['steamid'];
                $steamFriend->relationship = $friend['relationship'];
                $steamFriend->friend_since  = (int)$friend['friend_since'];
                $steamFriends[] = $steamFriend;
            }
        }   catch (\Exception $e) {
        }
        return $steamFriends;
    }

    public function rules(): array
    {
        return [];
    }


    public static function tableName()
    {
        // TODO: Implement tableName() method.
    }
}