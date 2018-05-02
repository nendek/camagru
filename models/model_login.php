<?php

require_once('./models/model.php');

class Login extends Model {

	public function check_user($username) {
		$req = "SELECT `verified` FROM `users` WHERE `username`=:username";
		$array = array('username' => $username);
		$typeArray = array('username' => PDO::PARAM_STR);
		$req = execReq($req, $array, $typeArray);
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

	public function check_passwd($username, $passwd) {
		$req = "SELECT `passwd` FROM `users` WHERE `username`=:username";
		$array = array('username' => $username);
		$typeArray = array('username' => PDO::PARAM_STR);
		$req = execReq($req, $array, $typeArray);
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

	public function login($username) {
		$req = "SELECT `firstname`,`lastname`,`id` FROM `users` WHERE `username`=:username";
		$array = array('username' => $username);
		$typeArray = array('username' => PDO::PARAM_STR);
		$req = execReq($req, $array, $typeArray);
		$row = $req->fetch();
		$_SESSION['username'] = $username;
		$_SESSION['id'] = $row['id'];
		$_SESSION['firstname'] = $row['firstname'];
		$_SESSION['lastname'] = $row['lastname'];
		return (0);
	}

	public function logout() {
		session_unset ();
		session_destroy ();
	}
}
?>
