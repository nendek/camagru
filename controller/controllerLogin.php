<?php

session_start();
require('./models/model_login.php');
require('./views/view.php');

class ControllerLogin {

	private $connexion;

	public function __construct() {
		$this->connexion = new Login();
	}

	public function login() {
		if (isset($_SESSION['id'])) {
			//logout
			$this->connexion->logout();
			return;
		}
		$view = new View("login");
		if (!(isset($_POST['submit']) && $_POST['submit'] === "OK")) {
			$view->generate();
			return;
		}
		$username = $_POST['username'];
		$passwd = $_POST['passwd'];
		$_SESSION['error'] = null;

		if ($username == "" || $username == null || $passwd == "" || $passwd == null) {
			$_SESSION['error'] = "You need to fill all fields";
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
		if ($this->connexion->check_user($username) == -1) {
			$view->generate();
			return;
		}
		if ($this->connexion->check_passwd($username, $passwd) == -1) {
			$view->generate();
			return;
		}
		$this->connexion->login($username);
		$view->generate();
	}
}
?>
