<?php

require_once('./models/model.php');

class Signup extends Model {

	public function check_user_mail($username, $email) {
		$email = strtolower($email);
		$req = "SELECT `id` FROM `users` WHERE `username`=:username OR `email`=:email";
		$array = array('username' => $username, 'email' => $email);
		$typeArray = array('username' => PDO::PARAM_STR, 'email' => PDO::PARAM_STR);
		$req = execReq($req, $array, $typeArray);
		if ($tmp = $req->fetch()) {
			$_SESSION['error'] = "user or mail already exist"; //voir pour tester si mail ou username qui existe deja
			$req->closeCursor();
			return(-1);
		}
		return (0);
	}

	public function add_new_user($lastname, $firstname, $email, $username, $passwd, $verified) {
		require './config/database.php';
		//encrypt password
		$passwd = hash("whirlpool", $passwd);
		//generate token
		$token = md5(microtime(TRUE)*100000);

		$req = "INSERT INTO users (lastname, firstname, email, username, passwd, token, verified) VALUES (:lastname, :firstname, :email, :username, :passwd, :token, :verified)";
		$array = array('lastname' => $lastname, 'firstname' => $firstname, 'email' => $email, 'username' => $username, 'passwd' => $passwd, 'token' => $token, 'verified' => $verified);
		$typeArray = array('lastname' => PDO::PARAM_STR, 'firstname' => PDO::PARAM_STR, 'email' => PDO::PARAM_STR, 'username' => PDO::PARAM_STR, 'passwd' => PDO::PARAM_STR, 'token' => PDO::PARAM_STR, 'verified' => PDO::PARAM_INT);
		$req = execReq($req, $array, $typeArray);
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
}
?>
