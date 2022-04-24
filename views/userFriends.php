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
    <?php if (count($steamUser->friends) > 0): ?>

        <h3><?= $steamUser->personaname ?>'s Friends</h3>

        <table class="table-striped">
            <tr>
                <th>Photo</th>
                <th>Name</th>
                <th>Friends Since</th>
                <th>Steam Profile</th>
            </tr>

            <?php
            foreach ($steamUser->friends as $steamFriend) {
                $friend = SteamUser::findBySteamId($steamFriend->steamid);

                echo '<tr>' . PHP_EOL;
                echo '<td><img src="' . $friend->avatar . '" alt="' . $friend->personaname . '" /></td>';
                echo '<td><a href="/profile/' . $steamFriend->steamid . '">' . $friend->personaname . '</a></td>';
                echo '<td>' . date('F j, Y', $steamFriend->friend_since) . '</td>';
                echo '<td><a href="' . $friend->profileurl . '">' . $friend->profileurl . '</a></td>';
                echo '</tr>' . PHP_EOL;
            }
            ?>
        </table>
    <?php else: ?>
        <div class="container">
            <div class="alert-info">
                <?= $steamUser->personaname ?> either has no friends or their profile is set to private.
            </div>
        </div>
    <?php endif; ?>
</div>
