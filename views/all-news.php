<h3>Latest News</h3>
<div class="container">
    <ul>
        <?php

        foreach ($allNews as $news) {
            echo "<li><a href='/news/" . $news->primaryValue() . "'>" . $news->title . "</a></li>";
        } ?>
    </ul>
</div>