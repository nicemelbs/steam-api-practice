<?php
/**
 * @var $steamUser SteamUser
 */

use app\models\SteamUser;

$steamUser->fetchUserGames();
?>
<div class=" container-fluid">
    <h3><a href="/profile/<?= $steamUser->steamid ?>"><?= $steamUser->personaname ?></a>'s Games</h3>
</div>
<div class=" container-fluid">
    <table class="table table-striped">
        <tr>
            <th>&nbsp;</th>
            <th>Game</th>
            <th>Total Playing Time</th>
            <th>Last Two Weeks</th>
        </tr>
        <?php


        foreach ($steamUser->usergames as $userGame) {
            $game = $userGame->getSteamGame();

            //ignore games that are no longer
            //in the steam store
            if (!$game) {
                continue;
            }
            //display user's play time in a table
            echo '<tr>';
            echo '<td><img style="max-height: 50px;" src="' . $game->header_image . '"></td>';
            echo '<td><a href="/games/' . $game->appid . '/">' . $game->name . '</a></td>';
            echo '<td>' . round($userGame->playtimeForever / 60) . ' hours </td>';
            echo '<td>' . round($userGame->playtime2Weeks / 60) . ' hours </td>';
            echo '</tr>' . PHP_EOL;
        }

        ?>
    </table>
</div>