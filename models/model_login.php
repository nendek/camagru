<?php

require('./models/model_connect.php');

function check_user($username) {
	$dbh = get_db();
	$req = $dbh->prepare("SELECT `verified` FROM `users` WHERE `username`=:username");
	$req->bindValue(':username', $username, PDO::PARAM_STR);
	$req->execute();
	if (!$row = $req->fetch()) {
		$_SESSION['error'] = "user doesn't exist";
		$req->closeCursor();
		return (-1);
	}
	if ($row['verified'] == 0) {
		$_SESSION['error'] = "acount doesn't activate";
		$req->closeCursor();
		return (-1);
	}
	return (0);
}

function check_passwd($username, $passwd) {
	$dbh = get_db();
	$req = $dbh->prepare("SELECT `passwd` FROM `users` WHERE `username`=:username");
	$req->bindValue(':username', $username, PDO::PARAM_STR);
	$req->execute();
	$row = $req->fetch();
	$passwd_db = $row['passwd'];
	$passwd = hash("whirlpool", $passwd);
	if ($passwd_db != $passwd) {
		$_SESSION['error'] = "Wrong password";
		$req->closeCursor();
		return (-1);
	}
	return (0);
}

function login($username) {
	$dbh = get_db();
	$req = $dbh->prepare("SELECT `firstname`,`lastname`,`id` FROM `users` WHERE `username`=:username");
	$req->bindValue(':username', $username, PDO::PARAM_STR);
	$req->execute();
	$row = $req->fetch();
	$_SESSION['username'] = $username;
	$_SESSION['id'] = $row['id'];
	$_SESSION['firstname'] = $row['firstname'];
	$_SESSION['lastname'] = $row['lastname'];
	return (0);
}

function logout() {
	session_unset ();
	session_destroy ();
}

?>
