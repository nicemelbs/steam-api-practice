<?php

use app\models\SteamUser;
use Stidges\CountryFlags\CountryFlag;

/***
 * @var $steamUser SteamUser
 */

$cc = 'Unknown';

if ($steamUser) {

    if ($steamUser->loccountrycode) {
        $cc = new CountryFlag();
        $cc = $cc->get($steamUser->loccountrycode);
    }
    $steamUser->loadFriends();
}


?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1><?= $steamUser->personaname ?></h1>
            <img src="<?= $steamUser->avatarfull ?>" alt="<?= $steamUser->personaname ?>" class="img-responsive">
        </div>
        <div class="col-md-12">
            <h2>Basic Information</h2>
            <table class="table table-striped">
                <tr>
                    <td>Display name</td>
                    <td><?= $steamUser->personaname ?></td>
                </tr>
                <tr>
                    <td>Profile Level</td>
                    <td><?= $steamUser->playerlevel ?></td>
                </tr>
                <tr>
                    <td>Country</td>
                    <td><?= $cc ?></td>
                </tr>
                <tr>
                    <td>Steam Profile</td>
                    <td><a href="<?= $steamUser->profileurl ?>"><?= $steamUser->profileurl ?></a></td>
                </tr>
                <tr>
                <tr>
                    <td>CS:GO Inventory</td>
                    <td>
                        <a href="/profile/<?= $steamUser->steamid ?>/inventory">Inventory</a>
                    </td>
                </tr>
                <td><a href="/profile/<?= $steamUser->steamid ?>/friends">Friends (<?= count($steamUser->friends)
                        ?></a>)
                </td>
                <td><a href="/profile/<?= $steamUser->steamid ?>/games">Games (<?=
                        $steamUser->gamecount ?>)</a></td>
                </tr>
            </table>
        </div>
    </div>
</div>