<?php
session_start();
$title = 'Camagru-Montage';
ob_start();
?>
<div id="media">
	<video id="video" width="640" height="480" style="max-width:100%;background:#111;border:1px solid #666;" autoplay=""></video>
	<button id="takepicButton">Take picture</button>
	<canvas id="canvas"></canvas>
	<img src="http://placekitten.com/g/320/261" id="photo" alt="photo">
</div>

<script src="../scripts/script_montage.js"></script>
<?php $contents = ob_get_clean(); ?>
<?php require 'template.php'; ?>
