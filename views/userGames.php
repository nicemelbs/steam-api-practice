<?php
/**
 * @var $steamUser SteamUser
 */

use app\models\SteamUser;
?>
<div class="container container-fluid">
   <h1> <?= $steamUser->personaName ?>'s Game Data </h1>
</div>
<div class="container container-fluid">
<table class="container">
    <tr>
        <th>&nbsp;</th>
        <th>Game</th>
        <th>Total Playing Time</th>
        <th>Last Two Weeks</th>
    </tr>
<?php
foreach($steamUser->userGames as $userGame) {
    $game = $userGame->getSteamGame();

    if(!$game->name){
        continue;
    }
    
    //if name is empty, skip it
    //it likely means that the game has been delisted from the store
//
//    if($game->name == ''){
//        continue;
//    }
    //display user's play time in a table
    echo '<tr>';
    echo '<td><img style="max-height: 50px;" src="'. $game->header_image .'"></td>';
    echo '<td><a href="/games/' .  $game->appid  . '/">'. $game->name . '</a></td>';
    echo '<td>' . round($userGame->playtimeForever / 60) . ' hours </td>';
    echo '<td>' . round($userGame->playtime2Weeks / 60) . ' hours </td>';
    echo '</tr>';
}

?>
</table>
</div>