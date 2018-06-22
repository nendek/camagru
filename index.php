<?php
session_start();

require('./controller/login.php');
require('./controller/signup.php');
require('./controller/activation.php');
require('./controller/home.php');
require('./controller/modifacc.php');
require('./controller/montage.php');
require('./controller/upload.php');

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
		} elseif ($_GET['action'] == 'reset_passwd') {
			if (isset($_GET['user']) && isset($_GET['token'])) {
				$user = $_GET['user'];
				$token = $_GET['token'];
				reset_forgot_passwd($user, $token);
			} elseif (isset($_SESSION['user_forgot'])) {
				modif_passwd_forgot();
			} else {
				throw new Exception("BAD RECUP PASSWORD");
			}
		} elseif ($_GET['action'] == 'forgot_passwd') {
			send_forgot_passwd();
		} elseif ($_GET['action'] == 'modif_acc') {
			modif_acc();
		} elseif ($_GET['action'] == 'montage') {
			montage();
		} elseif ($_GET['action'] == 'upload') {
			uploadImg();
		} elseif ($_GET['action'] == 'displayMontage') {
			displayMontage();
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
	return (-1);
}
?>
