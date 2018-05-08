<?php
require('./models/model_login.php');

function connexion() {
	if (isset($_SESSION['id'])) {
		//logout
		logout();
		header("Location: ./index.php");
		return;
	}
	if (!(isset($_POST['submit']) && $_POST['submit'] === "OK")) {
		header("Location: ./views/view_login.php");
		return;
	}
	$username = $_POST['username'];
	$passwd = $_POST['passwd'];
	$_SESSION['error'] = null;

	if ($username == "" || $username == null || $passwd == "" || $passwd == null) {
		$_SESSION['error'] = "You need to fill all fields";
		header("Location: ./views/view_login.php");
		return;
	}

	if (strlen($username) > 50 || strlen($username) < 2 || !ctype_alnum($username)) {
		$_SESSION['error'] = "The user name must be between 2 and 50 characters and contain only alphanumeric characters";
		header("Location: ./views/view_login.php");
		return;
	}
	if (strlen($passwd) > 50 || strlen($passwd) < 2) {
		$_SESSION['error'] = "The password must be between 2 and 50 characters";
		header("Location: ./views/view_login.php");
		return;
	}
	if (check_user_verif($username) == -1) {
		header("Location: ./views/view_login.php");
		return;
	}
	if (check_passwd($username, $passwd) == -1) {
		header("Location: ./views/view_login.php");
		return;
	}
	login($username);
	header("Location: ./index.php");
}
?>
