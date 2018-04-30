<?php
$title = 'Camagru-signup';
session_start();
ob_start();
?>
<div class="title">SUCCESS SIGNUP !</div>
<span>Signup success please check your mail box for confirmation your account.</span>
<?php $contents = ob_get_clean(); ?>
<?php require 'template.php'; ?>
