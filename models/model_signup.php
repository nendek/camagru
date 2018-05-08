<?php
require_once('./models/model_connect.php');

function check_user($username) {
	$dbh = get_db();
	$req = $dbh->prepare("SELECT `id` FROM `users` WHERE `username`=:username");
	$req->bindValue(':username', $username, PDO::PARAM_STR);
	$req->execute();
	if ($tmp = $req->fetch()) {
		$_SESSION['error'] = "user already exist";
		$req->closeCursor();
		return(-1);
	}
	return (0);
}

function check_email($email) {
	$email = strtolower($email);
	$dbh = get_db();
	$req = $dbh->prepare("SELECT `id` FROM `users` WHERE `email`=:email");
	$req->bindValue(':email', $email, PDO::PARAM_STR);
	$req->execute();
	if ($tmp = $req->fetch()) {
		$_SESSION['error'] = "user or mail already exist"; //voir pour tester si mail ou username qui existe deja
		$req->closeCursor();
		return(-1);
	}
	return (0);
}
 
function add_new_user($lastname, $firstname, $email, $username, $passwd, $verified) {
	require './config/database.php';
	$dbh = get_db();
	//encrypt password
	$passwd = hash("whirlpool", $passwd);
	//generate token
	$token = md5(microtime(TRUE)*100000);
	$req = $dbh->prepare("INSERT INTO users (lastname, firstname, email, username, passwd, token, verified) VALUES (:lastname, :firstname, :email, :username, :passwd, :token, :verified)");
	$req->bindValue(':lastname', $lastname, PDO::PARAM_STR);
	$req->bindValue(':firstname', $firstname, PDO::PARAM_STR);
	$req->bindValue(':email', $email, PDO::PARAM_STR);
	$req->bindValue(':username', $username, PDO::PARAM_STR);
	$req->bindValue(':passwd', $passwd, PDO::PARAM_STR);
	$req->bindValue(':token', $token, PDO::PARAM_STR);
	$req->bindValue(':verified', $verified, PDO::PARAM_INT);
	$req->execute();
	//send mail
	$receiver = $email;
	$subject = "Activate your account";
	$header = "From: registration@camagru.com";
	$message = 'Bienvenue sur Camagru,

		Pour activer votre compte, veuillez cliquer sur le lien ci dessous
		ou copier/coller dans votre navigateur internet.

		http://camagru.com/index.php?action=validation&user='.urlencode($username).'&token='.urlencode($token).'


	---------------
		Ceci est un mail automatique, Merci de ne pas y répondre.';
mail($receiver, $subject, $message, $header);
return (0);
}
?>
