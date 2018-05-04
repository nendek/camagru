<?
require_once('./models/model_connect.php');

function get_token($email) {
	$email = strtolower($email);
	$dbh = get_db();
	$req = $dbh->prepare("SELECT `token` FROM `users` WHERE `email`=:email");
	$req->bindValue(':email', $email, PDO::PARAM_STR);
	$req->execute();
	$row = $req->fetch();
	if (!$row) {
		$_SESSION['error'] = "Mail doesn't exist";
		$req->closeCursor();
		return (-1);
	}
	return ($row['token']);
}

function mail_reset_passwd($token) {
	$dbh = get_db();
	$req = $dbh->prepare("SELECT `email`, `username` FROM `users` WHRE `token`=:token");
	$req->bindValue(':token', $token, PDO::PARAM_STR);
	$req->execute();
	$row = $req->fetch();
	$receiver = $row['email'];
	$subject = "Reset your password";
	$header = "From: reset@camagru.com";
	$message = 'Bienvenue sur Camagru,

		Pour renitialiser votre mdp cliquer sur le lien ci dessous.

		http://camagru.com/index.php?action=forgot_passwdf&user='.urlencode($row['username']).'&token='.urlencode($token).'


	---------------
		Ceci est un mail automatique, Merci de ne pas y répondre.';
mail($receiver, $subject, $message, $header);
return (0);
}

function push_new_passwd($username, $passwd) {
	$dbh = get_db();
	$req = $dbh->prepare("UPDATE `users` SET `passwd`=:passwd WHERE `username`=:username");
	$req->bindValue(':passwd', $passwd, PDO::PARAM_STR);
	$req->bindValue(':username', $username, PDO::PARAM_STR);
	$req->execute();
	return (0);
}
