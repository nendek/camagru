<?php $this->title = 'Camagru-Error'; ?>

<?php
session_start();
?>
	<p>Error: <?= $_SESSION['error'] ?></p>
