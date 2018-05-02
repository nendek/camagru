<?php
session_start();
require('./models/model_activation.php');
require('./views/view.php');

class ControllerActivation {

	private activation;

	public function __construct() {
		$this->activation = new Activation();
	}

	public function activation($username, $token) {
		if (isset($_SESSION['id'])) {
			header("Location: ./index.php");
			return;
		}
		$_SESSION['error'] = null;
		$row = $this->activation->get_token($username);
		$view = New View("validation");
		if ($row) {
			$token_db = $row['token'];
			$verified = $row['verified'];
			if ($verified == 1) {
				$_SESSION['error'] = "The account as already activate";
				$view->generate();
				return;
			}
			if ($token == $token_db) {
				$this->activation->validation($username);
				$view->generate();
				return;
			} else {
				$_SESSION['error'] = "The account can not be create";
				$view->generate();
				return;
			}
		} else {
			$_SESSION['error'] = "The user doesn't not exist";
			$view->generate();
			return;
		}
	}
}

?>
