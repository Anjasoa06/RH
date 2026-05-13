<?php
/**
 * CodeIgniter CLI Error Handler
 */
?>An error occurred:

<?php if (isset($title)) : ?>
Title: <?= $title . "\n" ?>
<?php endif; ?>

<?php if (isset($exception)) : ?>
Message:
<?= wordwrap($exception->getMessage(), 75, "\n") . "\n" ?>
<?php endif; ?>

<?php if (isset($file)) : ?>
File: <?= clean_path($file) . "\n" ?>
<?php endif; ?>

<?php if (isset($line)) : ?>
Line: <?= $line . "\n" ?>
<?php endif; ?>
