<?php
session_start();
$title = 'Camagru-Montage';
ob_start();
?>
<div id="webcam">
</div>

<div id="no_webcam">
	<p>CAMERA NOT AVAILABLE</p>
</div>

<script src="../scripts/script_montage.js"></script>
<?php $contents = ob_get_clean(); ?>
<?php require 'template.php'; ?>
