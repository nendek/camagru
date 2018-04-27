<?php

require('./models/model_activation.php');

function activation($username, $token) {
	if (isset($_SESSION['id'])) {
		header("Location: ./index.php");
		return;
	}
	$_SESSION['error'] = null;

	$row = get_token($username);
	if ($row) {
		$token_db = $row['token'];
		$verified = $row['verified'];
		if ($verified == 1) {
			$_SESSION['error'] = "The account as already activate";
			header("Location: ./views/view_activation.php");
			return;
		}
		if ($token == $token_db) {
			validation($username);
			header("Location: ./views/view_activation.php");
			return;
		} else {
			$_SESSION['error'] = "The account can not be create";
			header("Location: ./views/view_activation.php");
			return;
		}
	} else {
		$_SESSION['error'] = "The user doesn't not exist";
		header("Location: ./views/view_activation.php");
		return;
	}
}

?>
