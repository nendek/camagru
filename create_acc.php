<?php
session_start();

$lastname = $_POST['lastname'];
$firstname = $_POST['firstname'];
$email = $_POST['email'];
$username = $_POST['username'];
$passwd = $_POST['passwd'];

$_SESSION['error'] = null;

//check empty fields
if ($firstname == "" || $firstname == null || $lastname == "" || $lastname == null || $email == "" || $email == null || $username == "" || $username == null || $passwd == "" || $passwd == null) {
	$_SESSION['error'] = "You need to fill all fields";
	return;
}

//check the fields
if (strlen($lastname) > 50 || strlen($lastnamename) < 2 || !ctype_alpha($lastname) {
	$_SESSION['error'] = "The last name must be between 2 and 50 characters and contain only alphabetic characters";
	return;
}
if (strlen($firstname) > 50 || strlen($firstnamename) < 2 || !ctype_alpha($firstname) {
	$_SESSION['error'] = "The first name must be between 2 and 50 characters and contain only alphabetic characters";
	return;
}
if (strlen($username) > 50 || strlen($username) < 2 || !ctype_alnum($username) {
	$_SESSION['error'] = "The user name must be between 2 and 50 characters and contain only alphanumeric characters";
	return;
}
if(!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
	$_SESSION['error'] = "You need to enter a valid email";
	return;
}

//add to db
require_once './config/database.php';

//check if already exist mail or username
$email = strtolower($email);
try {
	$dbh = new PDO($DB_DNS, $DB_USER, $DB_PASSWD);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$req = $dbh->prepare("SELECT `id` FROM `users` WHERE `username`=:username OR `email`=:email");
	$req->bindValue(':username', $username, PDO::PARAM_STR);
	$req->execute();
	if ($tmp = $req->fetch()) {
		$_SESSION['error'] = "user or mail already exist"; //voir pour tester si mail ou username qui existe deja
		$req->closeCursor();
		return(-1);
	}
	$req->closeCursor();

	//encrypt password
	$passwd = hash("whirlpool", $passwd);

	$req = $dbh->prepare("INSERT INTO users (lastname, firstname, email, username, passwd, token, verified) VALUES (:lastname, :firstname, :email, :username, :passwd, :token, :verified)");
	$token = uniqid(rand(), true);
	$req->bindValue(':lastname', $lastname, PDO::PARAM_STR);
	$req->bindValue(':firstname', $firstname, PDO::PARAM_STR);
	$req->bindValue(':email', $email, PDO::PARAM_STR);
	$req->bindValue(':username', $username, PDO::PARAM_STR);
	$req->bindValue(':passwd', $passwd, PDO::PARAM_STR);
	$req->bindValue(':token', $token, PDO::PARAM_STR);
	$req->bindValue(':verified', $verified, PDO::PARAM_STR);
	$req->execute();
	//faire envoie de mail
	$_SESSION['signup_success'] = true;
	return (0);
} catch (PDOException $e) {
	$_SESSION['error'] = "ERROR: ".$e->getMessage();
}
?>
