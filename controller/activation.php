<?php
session_start();
require_once('../models/model_activation.php');

try {
	$username = $_GET['user'];
	$token = $_GET['token'];
	$_SESSION['error'] = null;

	$row = get_token($username);
	if ($row) {
		$token_db = $row['token'];
		$verified = $row['verified'];
		if ($verified == 1) {
			$_SESSION['error'] = "The account as already activate";
			header("Location: ../views/view_activation.php");
			return;
		}
		if ($token == $token_db) {
			activation($username);
			header("Location: ../views/view_activation.php");
			return;
		} else {
			$_SESSION['error'] = "The account can not be create";
			header("Location: ../views/view_activation.php");
			return;
		}
	} else {
		$_SESSION['error'] = "The user doesn't not exist";
		header("Location: ../views/view_activation.php");
		return;
	}
} catch (PDOException $e) {
	$_SESSION['error'] = "ERROR: ".$e->getMessage();
	require('../views/view_error.php');
	$_SESSION['error'] = null;
	return(-1);
}

?>
