<?php
session_start();
require('./models/model_signup.php');
require('./views/view.php');

class ControllerSignup {

	function signup() {

		private signup;

		public function __construct() {
			$this->signup = new Signup();
		}
		$view = New View("signup");
		if (isset($_SESSION['id'])) {
			$view->generate();
			return;
		}
		if (!(isset($_POST['submit']) && $_POST['submit'] === "OK")) {
			$view->generate();
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
		if ($firstname == "" || $firstname == null || $lastname == "" || $lastname == null || $email == "" || $email == null || $username == "" || $username == null || $passwd == "" || $passwd == null) {
			$_SESSION['error'] = "You need to fill all fields";
			$view->generate();
			return;
		}

		//check the fields
		if (strcmp($passwd, $passwd_conf) != 0) {
			$_SESSION['error'] = "The two password are different";
			$view->generate();
			return;
		}
		if (strlen($lastname) > 50 || strlen($lastname) < 2 || !ctype_alpha($lastname)) {
			$_SESSION['error'] = "The last name must be between 2 and 50 characters and contain only alphabetic characters";
			$view->generate();
			return;
		}
		if (strlen($firstname) > 50 || strlen($firstname) < 2 || !ctype_alpha($firstname)) {
			$_SESSION['error'] = "The first name must be between 2 and 50 characters and contain only alphabetic characters";
			$view->generate();
			return;
		}
		if (strlen($username) > 50 || strlen($username) < 2 || !ctype_alnum($username)) {
			$_SESSION['error'] = "The user name must be between 2 and 50 characters and contain only alphanumeric characters";
			$view->generate();
			return;
		}
		if (strlen($passwd) > 50 || strlen($passwd) < 2) {
			$_SESSION['error'] = "The password must be between 2 and 50 characters";
			$view->generate();
			return;
		}
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$_SESSION['error'] = "You need to enter a valid email";
			$view->generate();
			return;
		}

		//add to db
		if ($this->signup->check_user_mail($username, $email) == -1) {
			$view->generate();
			return;
		}
		if ($this->signup->add_new_user($lastname, $firstname, $email, $username, $passwd, $verified) == -1) {
			$view->generate();
			return;
		}
		else
			$view->generate();
	}

}
?>
