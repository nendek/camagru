<?php

require_once('./controller/controllerLogin.php');
require_once('./controller/controllerSignup.php');
require_once('./controller/controllerActivation.php');
require_once('./controller/controllerHome.php');
require_once('./views/view.php');


class Routeur {

	private $ctrlLogin;
	private $ctrlSignup;
	private $ctrlActivation;
	private $ctrlHome;

	public function __construct() {
		$this->ctrlLogin = new ControllerLogin();
		$this->ctrlSignup = new ControllerSignup();
		$this->ctrlActivation = new ControllerActivation();
		$this->ctrlHome = new ControllerHome();
	}

	public function routeurReq() {
		try {
			if (isset($_GET['action'])) {
				if ($_GET['action'] == 'login' || $_GET['action'] == 'logout') {
					$this->ctrlLogin->login();
				} else if ($_GET['action'] == 'signup') {
					$this->ctrlSignup->signup();
				} else if ($_GET['action'] = 'validation') {
					if (isset($_GET['user']) && isset($_GET['token'])) {
						$user = $_GET['user'];
						$token = $_GET['token'];
						$this->ctrlActivation->activation($user, $token);
					} else
						throw new Exception("BAD ACTIVATION");
				}
				else if ($_GET['action'] == 'login' || $_GET['action'] == 'logout') {
					$this->ctrlLogin->login();
				} else
					throw new Exception("BAD ACTION");
			} else {
				echo 'coucou';
				$this->ctrlHome->home();
			}
		}
		catch (Exception $e) {
			$this->error($e->getMessage());
		}
	}

	private function error($msgError) {
		$_SESSION['error'] = "ERROR: ".$e->getMessage();
		$view = new View("error");
		$view->generate(array('msgError' => $msgError));
	}
}


?>
