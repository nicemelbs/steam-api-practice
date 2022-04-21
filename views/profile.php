<?php

use app\models\SteamUser;
use Stidges\CountryFlags\CountryFlag;

/***
 * @var $steamUser SteamUser
 */

$cc = 'Unknown';
if($steamUser->countryCode) {
    $cc = new CountryFlag();
    $cc = $cc->get($steamUser->countryCode);
}

?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1><?= $steamUser->personaName ?></h1>
                <img src="<?= $steamUser->avatarFull ?>" alt="<?= $steamUser->personaName ?>" class="img-responsive">
        </div>
        <div class="col-md-12">
            <h2>Basic Information</h2>
            <table class="table table-striped">
                <tr>
                    <td>Display name</td>
                    <td><?= $steamUser->personaName ?></td>
                </tr><tr>
                    <td>Profile Level</td>
                    <td><?= $steamUser->playerLevel ?></td>
                </tr>
                <tr>
                    <td>Country</td>
                    <td><?= $cc ?></td>
                </tr>
                <tr>
                    <td>Steam Profile</td>
                    <td><a href="<?= $steamUser->profileUrl ?>"><?= $steamUser->profileUrl ?></a></td>
                </tr>
                <tr>
                    <td><a href="/profile/<?= $steamUser->steamId ?>/friends">Friends: 130</a></td>
                    <td><a href="/profile/<?= $steamUser->steamId ?>/games">Games(<?=
                            $steamUser->gameCount ?>)</a></td>
                </tr>
            </table>
        </div>
    </div>
</div>