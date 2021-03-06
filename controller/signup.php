<?php

require('./models/model_signup.php');

function signup() {
	if (isset($_SESSION['id']))
		throw new Exception("User already connect");

	if (!(isset($_POST['submit']) && $_POST['submit'] === "OK")) {
		header("Location: ./views/view_signup.php");
		return;
	}
	$lastname = $_POST['lastname'];
	$firstname = $_POST['firstname'];
	$email = $_POST['email'];
	$username = $_POST['username'];
	$passwd = $_POST['passwd'];
	$passwd_conf = $_POST['passwd_conf'];
	$verified = 0;
	$_SESSION['error'] = null;

	//check empty fields
	if ($firstname == "" || $firstname == null || $lastname == "" || $lastname == null || $email == "" || $email == null || $username == "" || $username == null || $passwd == "" || $passwd == null || $passwd_conf == "" || $passwd_conf == null) {
		$_SESSION['error'] = "You need to fill all fields";
		header("Location: ./views/view_signup.php");
		return;
	}

	//check the fields
	if (strcmp($passwd, $passwd_conf) != 0) {
		$_SESSION['error'] = "The two password are different";
		header("Location: ./views/view_signup.php");
		return;
	}
	if (strlen($lastname) > 50 || strlen($lastname) < 2 || !ctype_alpha($lastname)) {
		$_SESSION['error'] = "The last name must be between 2 and 50 characters and contain only alphabetic characters";
		header("Location: ./views/view_signup.php");
		return;
	}
	if (strlen($firstname) > 50 || strlen($firstname) < 2 || !ctype_alpha($firstname)) {
		$_SESSION['error'] = "The first name must be between 2 and 50 characters and contain only alphabetic characters";
		header("Location: ./views/view_signup.php");
		return;
	}
	if (strlen($username) > 50 || strlen($username) < 2 || !ctype_alnum($username)) {
		$_SESSION['error'] = "The user name must be between 2 and 50 characters and contain only alphanumeric characters";
		header("Location: ../views/view_signup.php");
		return;
	}
	if (strlen($passwd) > 50 || strlen($passwd) < 2) {
		$_SESSION['error'] = "The password must be between 2 and 50 characters";
		header("Location: ./views/view_signup.php");
		return;
	}
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$_SESSION['error'] = "You need to enter a valid email";
		header("Location: ./views/view_signup.php");
		return;
	}

	//add to db
	if (check_user($username) == -1) {
		header("Location: ./views/view_signup.php");
		return;
	}
	if (check_email($email) == -1) {
		header("Location: ./views/view_signup.php");
		return;
	}

	if (add_new_user($lastname, $firstname, $email, $username, $passwd, $verified) == -1) {
		header("Location: ./views/view_signup.php");
		return;
	}
	else {
		$_SESSION['msg'] = "Signup success please check your mail box for confirmation your account.";
		header("Location: ./views/view_msg.php");
	}
}
?>
