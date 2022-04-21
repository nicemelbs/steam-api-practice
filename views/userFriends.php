<?php

use app\models\SteamUser;

/*
 * @var SteamUser $steamUser
 */
//echo '<pre>';
//var_dump(count($steamUser->friends));
//echo '</pre>';
//exit;
foreach($steamUser->friends as $friend){
    $steamFriend = SteamUser::findBySteamId($friend->steamid);

    echo $steamFriend->personaName . '<br>';
}