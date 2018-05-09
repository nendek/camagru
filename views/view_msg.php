<?php $title = 'Camagru-Msg'; ?>

<?php ob_start() ?>
	<p><?= $_SESSION['msg'] ?></p>
<?php $contents = ob_get_clean(); ?>

<?php require 'template.php'; ?>
