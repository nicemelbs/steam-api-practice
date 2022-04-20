<?php
/**
 * @var $user \app\models\User
 */
?>

<div class="container">
    <?php if ($user): ?>
        <h3><?= $user->getDisplayName() ?></h3>
        <div class="container"><?= $user->email ?></div>

        <?php
        $allNews = $user->getAllNews();

        if (!empty($allNews)) {
            echo "<ul>";
            foreach ($allNews as $news) {
                echo "<li><a href='/news/" . $news->primaryValue() . "'>" . $news->title . "</a></li>";
            }

            echo "</ul>";
        }
        ?>

    <?php else: ?>
        <div class="alert alert-warning"><h4>User not found.</h4></div>
    <?php endif; ?>

</div>
