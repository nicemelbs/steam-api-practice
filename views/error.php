<?php
/**
 * @var Exception $exception
 */
?>

<h2 class="alert-danger">
    <?= 'HTTP ' . $exception->getCode() . ': ' . $exception->getMessage() ?>
</h2>
