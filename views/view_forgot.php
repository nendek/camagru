<?php
session_start();
$title = 'Camagru-forgot';
ob_start();
?>

	<div class="title">RESET PASSWORD</div>
<?php
if (isset($_GET['action'])) {
	if ($_GET['action'] == 'send_forgot_passwd') {
?>
	<form method="post" action="../index.php?action=forgot_passwd">
		<label for="form-email">Email:</label>
		<input id="form-email" name="email" placeholder="your email" maxlength="50" type="mail">
		<input name="submit_email" class="form-submit" type="submit" value="OK">
	</form>
<?php
	} elseif ($_GET['action'] == 'reset_forgot_passwd') {
?>
	<form method="post" action="../index.php?action=reset_passwd">
		<label for="form-passwd">Password:</label>
		<input id="form-passwd" name="passwd" placeholder="your new password" maxlength="50" minlength="6" type="password">
		<label for="form-passwd-conf">Password:</label>
		<input id="form-passwd-conf" name="passwd_conf" placeholder="confirm your new password" maxlength="50" minlength="6" type="password">
		<input name="submit_passwd" class="form-submit" type="submit" value="OK">
	</form>
	<div id="errors"></div>
<?php
	}
}
?>
<?php
if (isset($_SESSION['error'])) {
	echo $_SESSION['error'];
	$_SESSION['error'] = null;
}
?>
<script src="../scripts/script_parse_form.js"></script>
<?php $contents = ob_get_clean(); ?>
<?php require 'template.php'; ?>
