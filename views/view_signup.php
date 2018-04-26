<?php
session_start();
$title = 'Camagru-signup';
ob_start();
?>
	<div class="title">SIGNUP</div>
	<form method="post" action="../controller/signup.php">
		<label for="form-lastname">Lastname:</label>
		<input id="form-lastname" name="lastname" placeholder="your lastname" maxlength="50" type="text">
		<label for="form-firstname">Firstname:</label>
		<input id="form-firstname" name="firstname" placeholder="your firstname" maxlength="50" type="text">
		<label for="form-email">Email:</label>
		<input id="form-email" name="email" placeholder="your email" maxlength="50" type="mail">
		<label for="form-username">Username:</label>
		<input id="form-username" name="username" placeholder="your username" maxlength="50" minlength="2" type="text">
		<label for="form-passwd">Password:</label>
		<input id="form-passwd" name="passwd" placeholder="your password" maxlength="50" minlength="6" type="password">
		<label for="form-passwd-conf">Password:</label>
		<input id="form-passwd-conf" name="passwd_conf" placeholder="confirm your password" maxlength="50" minlength="6" type="password">
		<input name="submit" id="form-submit" type="submit" value="OK">
	</form>
<?php
if (isset($_SESSION['error'])) {
	echo $_SESSION['error'];
	$_SESSION['error'] = null;
}
?>
<?php $contents = ob_get_clean(); ?>
<?php require 'template.php'; ?>
