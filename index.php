<?php
session_start();

require('./controller/login.php');
require('./controller/signup.php');
require('./controller/activation.php');
require('./controller/home.php');
require('./controller/modifacc.php');

try {
	if (isset($_GET['action'])) {
		if ($_GET['action'] == 'login' || $_GET['action'] == 'logout') {
			connexion();
		} elseif ($_GET['action'] == 'signup') {
			signup();
		} elseif ($_GET['action'] == 'validation') {
			if (isset($_GET['user']) && isset($_GET['token'])) {
				$user = $_GET['user'];
				$token = $_GET['token'];
				activation($user, $token);
			} else {
				throw new Exception("BAD ACTIVATION");
			}
		} elseif ($_GET['action'] == 'recup_passwd') {
			if (isset($_GET['user']) && isset($_GET['token'])) {
				$user = $_GET['user'];
				$token = $_GET['token'];
				modif_passwd($user, $token);
			} else {
				throw new Exception("BAD RECUP PASSWORD");
			}
		} elseif ($_GET['action'] == 'forgot_passwd') {
			send_forgot_passwd();
		} else {
			throw new Exception("BAD ACTION");
		}
	} else {
		echo 'coucou';
		home();
	}
} catch (Exception $e) {
	$_SESSION['error'] = "ERROR: ".$e->getMessage();
	require('./views/view_error.php');
	$_SESSION['error'] = null;
	return(-1);
}
?>
