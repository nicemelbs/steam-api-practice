<?php
/**
 * @var $news \app\models\News
 */

if ($news) {
    $author = $news->getUser();
    $authorName = $author->getDisplayName();
}
?>

<div class="container">
    <h5><?= $news->title ?></h5>
    <h6><?= $authorName ?></h6>
    <div class="container">
        <?= $news->body ?>
    </div>
</div>
