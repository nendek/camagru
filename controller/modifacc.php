<?php

require('./models/model_modifacc.php');

function send_forgot_passwd() {
	if (!(isset($_POST['submit_email']) && $_POST['submit_email'] === "OK")) {
		header("Location: ./views/view_modifacc.php?action=send_forgot_passwd");
		return;
	}
	$email = $_POST['email'];
	$token_email = get_token_forgot($email);
	if ($token_email == -1) {
		header("Location: ./views/view_modifacc.php?action=send_forgot_passwd");
		return (0);
	}
	mail_reset_passwd($token_email);
	header("Location: ./views/view_modifacc.php?action=mail_send");
}

function reset_forgot_passwd($user, $token) {
	if (check_user_forgot($user, $token) != 1) {
		header("Location: ./views/view_error.php");
		return (0);
	}
	$_SESSION['user_forgot'] = $user;
	modif_passwd_forgot();
}

function modif_passwd_forgot() {
	if (!(isset($_SESSION['user_forgot']))) {
		$_SESSION['error'] = "ERROR CHANGE FORGOT PASSWORD";
		require('./views/view_error.php');
	}
	if (!(isset($_POST['submit_passwd']) && $_POST['submit_passwd'] === "OK")) {
		header("Location: ./views/view_modifacc.php?action=reset_forgot_passwd");
		return;
	}
	$passwd = $_POST['passwd'];
	$passwd_conf = $_POST['passwd_conf'];

	if ($passwd == "" || $passwd == null || $passwd_conf == "" || $passwd_conf == null) {
		$_SESSION['error'] = "You need to fill all fields";
		header("Location: ./views/view_modifacc.php?action=reset_forgot_passwd");
		return;
	}
	if (strcmp($passwd, $passwd_conf) != 0) {
		$_SESSION['error'] = "The two password are different";
		header("Location: ./views/view_modifacc.php?action=reset_forgot_passwd");
		return;
	}
	if (strlen($passwd) > 50 || strlen($passwd) < 2) {
		$_SESSION['error'] = "The password must be between 2 and 50 characters";
		header("Location: ./views/view_modifacc.php?action=reset_forgot_passwd");
		return;
	}
	push_new_passwd($_SESSION['user_forgot'], $passwd);
	$_SESSION['user_forgot'] = null;
	header("Location: ./index.php");
}

function modif_acc() {
	if (!(isset($_SESSION['id']))) {
		$_SESSION['error'] = "ERROR MODIFICATION";
		require('./views/view_error.php');
	}
	if (isset($_POST['submit_lastname']) && $_POST['submit_lastname'] === "OK") {

	} elseif (isset($_POST['submit_firstname']) && $_POST['submit_firstname'] === "OK") {

	} elseif (isset($_POST['submit_email']) && $_POST['submit_email'] === "OK") {

	} elseif (isset($_POST['submit_username']) && $_POST['submit_username'] === "OK") {

	} elseif (isset($_POST['submit_passwd']) && $_POST['submit_passwd'] === "OK") {

	} else {
		header("Location: ./views/view_modifacc.php?action=modif_acc");
		return;
	}



}

?>
