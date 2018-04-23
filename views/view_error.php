<?php $title = 'Camagru-Error'; ?>

<?php ob_start() ?>
	<p>Error: <?= $_SESSION['error'] ?></p>
<?php $contents = ob_get_clean(); ?>

<?php require 'template.php'; ?>
