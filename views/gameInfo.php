<?php

use app\models\SteamGame;
/**
 * @var $game SteamGame
 */

?>

<div class="container">

<h3><?= $game->name ?></h3>
<?php
//if $game->header_image is not empty string display image
if ($game->header_image != '') {
    echo '<img src="' . $game->header_image . '" alt="' . $game->name . '" >';
}
?>
<div class="container"> <?= $game->detailed_description ?> </div>
<!--    link to store page -->
    <a href="https://store.steampowered.com/app/<?= $game->appid ?>" target="_blank">
        <button class="btn btn-primary">
            <i class="fa fa-shopping-cart"></i>
            Buy on Steam
        </button>
</div>