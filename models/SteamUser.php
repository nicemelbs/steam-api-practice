<?php

namespace app\models;

use app\core\db\DbModel;
use app\core\exceptions\NotFoundException;
use GuzzleHttp\Client;
use function PHPUnit\Framework\arrayHasKey;

class SteamUser extends SteamAPIObject
{
    public string $steamid;
    public int $communityvisibilitystate;
    public int $profilestate;
    public string $personaname;
    public string $profileurl;
    public string $avatar;
    public string $avatarmedium;
    public string $avatarfull;
    public string $personastate;
    public string $playerlevel;
    public array $friends;
    public array $usergames;
    public int $gamecount;
    public string $loccountrycode;
    public $realname;

    /**
     * @var mixed|string
     */

    public static function findBySteamId($steam_id): ?SteamUser
    {
//        http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=XXXXXXXXXXXXXXXXXXXXXXX&steamids=76561197960435530

        // fetch user from the database
        // if not found, fetch from steam and save to the database
        $steamUser = self::findOne(['steamid' => $steam_id]);

        if (!$steamUser) {
            $steamUser = self::fetchFromSteam($steam_id);
            $steamUser->save();
        }

        return $steamUser;
    }

    private static function fetchFromSteam($steam_id): ?SteamUser
    {

        $url = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/";
        $queryParams = ['steamids' => [$steam_id]];
        $data = self::apiCall($url, $queryParams);

        $steamUser = new SteamUser();

        $player = $data['response']['players'][0] ?? null;


        $steamUser->steamid = $player['steamid'];
        $steamUser->communityvisibilitystate = $player['communityvisibilitystate'] ?? 0;
        $steamUser->profilestate = $player['profilestate'] ?? 0;
        $steamUser->personaname = $player['personaname'] ?? '';
        $steamUser->realname = $player['realname'] ?? '';
        $steamUser->profileurl = $player['profileurl'];
        $steamUser->avatar = $player['avatar'] ?? '';
        $steamUser->avatarmedium = $player['avatarmedium'] ?? '';
        $steamUser->avatarfull = $player['avatarfull'] ?? '';
        $steamUser->loccountrycode = $player['loccountrycode'] ?? '';
        $steamUser->playerlevel = self::getPlayerLevel($steam_id) ?? 0;
        $steamUser->usergames = self::fetchOwnedGames($steam_id);
        $steamUser->gamecount = count($steamUser->usergames);
        $steamUser->friends = self::fetchFriends($steam_id);

        return $steamUser;
    }

    public static function getPlayerLevel($steam_id)
    {
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
        foreach ($games as $game) {
            $steamGame = SteamGame::findOne(['appid' => $game['appid']]);

            $userGame = new UserGame();
            $userGame->appId = $game['appid'] ?? 0;

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
                $steamFriend->friend_since = (int)$friend['friend_since'];
                $steamFriends[] = $steamFriend;
            }
        } catch (\Exception $e) {
        }
        return $steamFriends;
    }

    public static function tableName()
    {
        return 'steam_users';
    }

    public function loadFriends(): array
    {
        return $this->friends = self::fetchFriends($this->steamid);
    }

    public function rules(): array
    {
        return [];
    }

    public function attributes(): array
    {
        return [
            'steamid',
            'communityvisibilitystate',
            'profilestate',
            'personaname',
            'realname',
            'profileurl',
            'avatar',
            'avatarmedium',
            'avatarfull',
            'loccountrycode',
            'gamecount',
        ];
    }

    public function fetchUserGames()
    {
        $this->usergames = self::fetchOwnedGames($this->steamid);
    }

    public function fetchUserFriends()
    {
        $this->friends = self::fetchFriends($this->steamid);
    }
}