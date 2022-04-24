<?php

use app\models\SteamUser;

/**
 *
 * @var $steamUser SteamUser
 *
 */
?>

<table class="table table-striped">
    <tr>
        <th class="col-1">Image</th>
        <th class="col-2">Item Name</th>
        <th class="col-2">Type</th>
        <th class="col-5">Descrption</th>
        <th class="col-4">Inspect Link</th>
        <th class="col-4">Steam Community Market Link</th>
    </tr>
    <?php foreach ($steamUser->items as $item): ?>
        <tr>
            <td><img style="max-height: 100px" src="<?= $item['icon_url'] ?>" alt="<?= $item['market_hash_name']
                ?>"/></td>
            <td><?= $item['market_hash_name'] ?></td>
            <td><?= $item['type'] ?></td>
            <td>
                <?= $item['description'] ?>
            </td>

            <td>
                <?php if (isset($item['inspect_link'])): ?>
                    <a href="<?= $item['inspect_link'] ?>">Inspect in game...</a>
                <?php else: ?>
                    &nbsp;
                <?php endif; ?>
            </td>

            <td>
                <?php if (isset($item['scm_link'])): ?>
                    <a href="<?= $item['scm_link'] ?>">View in the community market</a>
                <?php else: ?>
                    &nbsp;
                <?php endif; ?>
            </td>
        </tr>

    <?php endforeach; ?>
</table>