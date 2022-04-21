<?php

use app\models\SteamUser;

/**
 * @var SteamUser $steamUser
 */
//echo '<pre>';
//var_dump(count($steamUser->friends));
//echo '</pre>';
//exit;
$steamUser->fetchUserFriends();
?>

<div class="container">
    <h3><?= $steamUser->personaname ?>'s Friends</h3>

    <table>
        <tr>
            <th>Name</th>
            <th>Friends Since</th>
            <th>Steam Profile</th>
        </tr>

        <?php
        foreach ($steamUser->friends as $steamFriend) {
            $friend = SteamUser::findBySteamId($steamFriend->steamid);
            echo '<tr>' . PHP_EOL;
            echo '<td><a href="/profile/' . $steamFriend->steamid . '">' . $friend->personaname . '</a></td>';
            echo '<td>' . date('F j, Y', $steamFriend->friend_since) . '</td>';
            echo '<td><a href="' . $friend->profileurl . '">' . $friend->profileurl . '</a></td>';
            echo '</tr>' . PHP_EOL;
        }
        ?>
    </table>
</div>
