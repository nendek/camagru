<?php
session_start();
$title = 'Camagru-modifacc';
ob_start();
?>

	<div class="title">MODIF ACCOUNT</div>
<?php
if (isset($_GET['action'])) {
	if ($_GET['action'] == 'modif_acc') {
?>
	<form method="post" action="../index.php?action=modif_acc">
		<label for="form-lastname">Lastname:</label>
		<input id="form-lastname" name="lastname" placeholder="your lastname" maxlength="50" type="text">
		<input name="submit_lastname" class="form-submit" type="submit" value="OK">
	</form>
	<form method="post" action="../index.php?action=modif_acc">
		<label for="form-firstname">Firstname:</label>
		<input id="form-firstname" name="firstname" placeholder="your firstname" maxlength="50" type="text">
		<input name="submit_firstname" class="form-submit" type="submit" value="OK">
	</form>
	<form method="post" action="../index.php?action=modif_acc">
		<label for="form-email">Email:</label>
		<input id="form-email" name="email" placeholder="your email" maxlength="50" type="mail">
		<input name="submit_email" class="form-submit" type="submit" value="OK">
	</form>
	<form method="post" action="../index.php?action=modif_acc">
		<label for="form-username">Username:</label>
		<input id="form-username" name="username" placeholder="your username" maxlength="50" minlength="2" type="text">
		<input name="submit_username" class="form-submit" type="submit" value="OK">
	</form>
	<form method="post" action="../index.php?action=modif_acc">
		<label for="form-username">Username:</label>
		<label for="form-passwd">Password:</label>
		<input id="form-passwd" name="passwd" placeholder="your password" maxlength="50" minlength="6" type="password">
		<label for="form-passwd-conf">Password:</label>
		<input id="form-passwd-conf" name="passwd_conf" placeholder="confirm your password" maxlength="50" minlength="6" type="password">
		<input name="submit_passwd" class="form-submit" type="submit" value="OK">
	</form>
<?php
	} if ($_GET['action'] == 'send_forgot_passwd') {
?>
	<form method="post" action="../index.php?action=forgot_passwd">
		<label for="form-email">Email:</label>
		<input id="form-email" name="email" placeholder="your email" maxlength="50" type="mail">
		<input name="submit_email" class="form-submit" type="submit" value="OK">
	</form>
<?php
	}
	if ($_GET['action'] == 'mail_send') {
?>
	<p>MAIL SEND PLEASE CHECK MAILBOX</p>
<?php
	}
}
if (isset($_SESSION['error'])) {
	echo $_SESSION['error'];
	$_SESSION['error'] = null;
}
?>
<?php $contents = ob_get_clean(); ?>
<?php require 'template.php'; ?>
