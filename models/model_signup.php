<?php
function check_user_mail($username, $email) {
	require '../config/database.php';
	$email = strtolower($email);
	try {
		$dbh = new PDO($DB_DNS, $DB_USER, $DB_PASSWD);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$req = $dbh->prepare("SELECT `id` FROM `users` WHERE `username`=:username OR `email`=:email");
		$req->bindValue(':username', $username, PDO::PARAM_STR);
		$req->bindValue(':email', $email, PDO::PARAM_STR);
		$req->execute();
		if ($tmp = $req->fetch()) {
			$_SESSION['error'] = "user or mail already exist"; //voir pour tester si mail ou username qui existe deja
			$req->closeCursor();
			return(-1);
		}
		return (0);
	} catch (PDOException $e) {
		$_SESSION['error'] = "ERROR: ".$e->getMessage();
		return(-1);
	}
}

function add_new_user($lastname, $firstname, $email, $username, $passwd, $verified) {
	require '../config/database.php';
	try {
		$dbh = new PDO($DB_DNS, $DB_USER, $DB_PASSWD);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
		//faire envoie de mail
		return (0);
	} catch (PDOException $e) {
		$_SESSION['error'] = "ERROR: ".$e->getMessage();
		return(-1);
	}
}
?>
