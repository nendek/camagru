<?php

require('./models/model_modifacc.php');

function modifacc() {

}

function send_forgot_passwd() {
	if (!(isset($_POST['submit_email']) && $_POST['submit_email'] === "OK")) {
		header("Location: ./views/view_modifacc.php?action=send_forgot_passwd");
		return;
	}
	$email = $_POST['email'];
	$token_email = get_token_forgot($email);
	if ($token_email == -1) {
		header("Location: ./views/view_modifacc.php?action=forgot_passwd");
		return (0);
	}
	mail_reset_passwd($token_email);
	header("Location: ./views/view_modifacc.php?action=mail_send");
}


?>
