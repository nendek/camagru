<?php $title = 'Camagru-Home'; ?>

<?php
ob_start();
session_start();
?>
<p>Coucou MEC</p>

<?php $contents = ob_get_clean(); ?>

<?php require 'template.php'; ?>
