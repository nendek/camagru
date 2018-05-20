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
		<input id="form-lastname" name="lastname" placeholder="<?php if (isset($_SESSION['lastname'])) {echo $_SESSION['lastname'];} else {echo "your lastname";}?>" maxlength="50" type="text">
		<input name="submit_lastname" class="form-submit" type="submit" value="OK">
	</form>
	<form method="post" action="../index.php?action=modif_acc">
		<label for="form-firstname">Firstname:</label>
		<input id="form-firstname" name="firstname" placeholder="<?php if (isset($_SESSION['firstname'])) {echo $_SESSION['firstname'];} else {echo "your firstname";}?>" maxlength="50" type="text">
		<input name="submit_firstname" class="form-submit" type="submit" value="OK">
	</form>
	<form method="post" action="../index.php?action=modif_acc">
		<label for="form-email">Email:</label>
		<input id="form-email" name="email" placeholder= "<?php if (isset($_SESSION['email'])) {echo $_SESSION['email'];} else {echo "your email";}?>" maxlength="50" type="mail">
		<input name="submit_email" class="form-submit" type="submit" value="OK">
	</form>
	<form method="post" action="../index.php?action=modif_acc">
		<label for="form-username">Username:</label>
		<input id="form-username" name="username" placeholder= "<?php if (isset($_SESSION['username'])) {echo $_SESSION['username'];} else {echo "your username";}?>" maxlength="50" minlength="2" type="text">
		<input name="submit_username" class="form-submit" type="submit" value="OK">
	</form>
	<form method="post" action="../index.php?action=modif_acc">
		<label for="form-username">Username:</label>
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
<script src="../scripts/script_parse_form.js"></script>
<?php
if (isset($_SESSION['error'])) {
	echo $_SESSION['error'];
	$_SESSION['error'] = null;
}
?>
<?php $contents = ob_get_clean(); ?>
<?php require 'template.php'; ?>
