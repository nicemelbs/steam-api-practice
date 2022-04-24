<?php

use app\models\SteamUser;

/**
 *
 * @var $steamUser SteamUser
 *
 */
?>

<table>
    <tr>
        <th>Image</th>
        <th>Item Name</th>
        <th>Type</th>
        <th>Inspect Link</th>
    </tr>
    <?php foreach ($steamUser->items as $item): ?>
        <tr>
            <td><img style="max-height: 100px" src="<?= $item['icon_url'] ?>" alt="<?= $item['market_hash_name']
                ?>"/></td>
            <td><?= $item['market_hash_name'] ?></td>
            <td><?= $item['type'] ?></td>
            <?php if (isset($item['inspect_link'])): ?>
                <td><a href="<?= $item['inspect_link'] ?>">Inspect</a></td>
            <?php else: ?>
                <td>&nbsp;</td>
            <?php endif; ?>
        </tr>

    <?php endforeach; ?>
</table>