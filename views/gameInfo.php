<?php

use app\core\Application;
use app\models\SteamGame;

/**
 * @var $game SteamGame
 * @var $owned bool
 */

?>

<div class="container">

    <h3><?= $game->name ?></h3>

    <?php if (!Application::isGuest()): ?>

        <!--        if user owns the game, display their playtime and a link to its steam store page-->
        <?php if ($owned): ?>
            <div class="alert alert-success">
                <p>This game is already in your Steam library.</p>
                <p>Your playtime: <?= $hours ?> hours</p>
                <p><a href="https://store.steampowered.com/app/<?= $game->appid ?>" target="_blank">Go to Steam
                        Store</a></p>
            </div>
        <?php else: ?>
            <div class="alert alert-danger">
                <p>You don't own this game!</p>
                <p><a href="https://store.steampowered.com/app/<?= $game->appid ?>"> Buy it on Steam</a></p>
            </div>
        <?php endif; ?>
    <?php endif; ?>

</div>


<?php
//if $game->header_image is not empty string display image
if ($game->header_image != '') {
    echo '<img src="' . $game->header_image . '" alt="' . $game->name . '" >';
}
?>
<div class="container"> <?= $game->detailed_description ?> </div>
<!--    link to store page -->
</div>