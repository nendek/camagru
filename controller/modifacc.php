<?php

require('./models/model_modifacc.php');

function send_forgot_passwd() {
	if (!(isset($_POST['submit_email']) && $_POST['submit_email'] === "OK")) {
		header("Location: ./views/view_forgot.php?action=send_forgot_passwd");
		return;
	}
	$email = $_POST['email'];
	$token_email = get_token_forgot($email);
	if ($token_email == -1) {
		header("Location: ./views/view_forgot.php?action=send_forgot_passwd");
		return (0);
	}
	mail_reset_passwd($token_email);
	$_SESSION['msg'] = "MAIL SEND, PLEASE CHECK YOUR MAILBOX";
	header("Location: ./views/view_msg.php");
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
	if (isset($_POST['submit_passwd']) && $_POST['submit_passwd'] === "OK") {

		$passwd = $_POST['passwd'];
		$passwd_conf = $_POST['passwd_conf'];

		if ($passwd == "" || $passwd == null || $passwd_conf == "" || $passwd_conf == null) {
			$_SESSION['error'] = "You need to fill all fields";
			header("Location: ./views/view_forgot.php?action=reset_forgot_passwd");
			return;
		}
		if (strcmp($passwd, $passwd_conf) != 0) {
			$_SESSION['error'] = "The two password are different";
			header("Location: ./views/view_forgot.php?action=reset_forgot_passwd");
			return;
		}
		if (strlen($passwd) > 50 || strlen($passwd) < 2) {
			$_SESSION['error'] = "The password must be between 2 and 50 characters";
			header("Location: ./views/view_forgot.php?action=reset_forgot_passwd");
			return;
		}
		push_new_passwd($_SESSION['user_forgot'], $passwd);
		$_SESSION['user_forgot'] = null;
		$_SESSION['msg'] = "Password reset ok, please login";
		header("Location: ./views/view_msg.php");
	} else {
		header("Location: ./views/view_forgot.php?action=reset_forgot_passwd");
		return;
	}
}

function modif_acc() {

	if (!(isset($_SESSION['id']))) {
		$_SESSION['error'] = "ERROR MODIFICATION";
		require('./views/view_error.php');
		return(-1);
	}

	if (isset($_POST['submit_lastname']) && $_POST['submit_lastname'] === "OK") {
		$lastname = $_POST['lastname'];
		if ($lastname == "" || $lastname == null) {
			$_SESSION['error'] = "You need to fill all fields";
			header("Location: ./views/view_modifacc.php?action=modif_acc");
			return;
		}
		if (strlen($lastname) > 50 || strlen($lastname) < 2 || !ctype_alpha($lastname)) {
			$_SESSION['error'] = "The last name must be between 2 and 50 characters and contain only alphabetic characters";
			header("Location: ./views/view_modifacc.php?action=modif_acc");
			return;
		}
		modif_lastname($lastname);

	} elseif (isset($_POST['submit_firstname']) && $_POST['submit_firstname'] === "OK") {
		$firstname = $_POST['firstname'];
		if ($firstname == "" || $firstname == null) {
			$_SESSION['error'] = "You need to fill all fields";
			header("Location: ./views/view_modifacc.php?action=modif_acc");
			return;
		}
		if (strlen($firstname) > 50 || strlen($firstname) < 2 || !ctype_alpha($firstname)) {
			$_SESSION['error'] = "The first name must be between 2 and 50 characters and contain only alphabetic characters";
			header("Location: ./views/view_modifacc.php?action=modif_acc");
			return;
		}
		modif_firstname($firstname);

	} elseif (isset($_POST['submit_email']) && $_POST['submit_email'] === "OK") {
		$email = $_POST['email'];
		if ($email == "" || $email == null) {
			$_SESSION['error'] = "You need to fill all fields";
			header("Location: ./views/view_modifacc.php?action=modif_acc");
			return;
		}
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$_SESSION['error'] = "You need to enter a valid email";
			header("Location: ./views/view_modifacc.php?action=modif_acc");
			return;
		}
		if (check_email($email) == -1) {
			header("Location: ./views/view_modifacc.php?action=modif_acc");
			return;
		}
		modif_email($email);

	} elseif (isset($_POST['submit_username']) && $_POST['submit_username'] === "OK") {
		$username = $_POST['username'];
		if ($username == "" || $username == null) {
			$_SESSION['error'] = "You need to fill all fields";
			header("Location: ./views/view_modifacc.php?action=modif_acc");
			return;
		}
		if (strlen($username) > 50 || strlen($username) < 2 || !ctype_alnum($username)) {
			$_SESSION['error'] = "The user name must be between 2 and 50 characters and contain only alphanumeric characters";
			header("Location: ./views/view_modifacc.php?action=modif_acc");
			return;
		}
		if (check_user($username) == -1) {
			header("Location: ./views/view_modifacc.php?action=modif_acc");
			return;
		}
		modif_username($username);

	} elseif (isset($_POST['submit_passwd']) && $_POST['submit_passwd'] === "OK") {
		$passwd = $_POST['passwd'];
		$passwd_conf = $_POST['passwd_conf'];
		if (strcmp($passwd, $passwd_conf) != 0) {
			$_SESSION['error'] = "The two password are different";
			header("Location: ./views/view_modifacc.php?action=modif_acc");
			return;
		}
		if (strlen($passwd) > 50 || strlen($passwd) < 2) {
			$_SESSION['error'] = "The password must be between 2 and 50 characters";
			header("Location: ./views/view_modifacc.php?action=modif_acc");
			return;
		}
		modif_passwd($passwd);

	} else
		header("Location: ./views/view_modifacc.php?action=modif_acc");
}

?>
