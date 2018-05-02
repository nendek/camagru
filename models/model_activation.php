<?php

require_once('./models/model.php');

class Activation extends Model {

	public function get_token($username) {
		$req = "SELECT `token`,`verified` FROM `users` WHERE `username`=:username";
		$array = array('username' => $username);
		$typeArray = array('username' => PDO::PARAM_STR);
		$req = execReq($req, $array, $typeArray);
		$row = $req->fetch();
		return ($row);
	}

	public function validation($username) {
		$req = "UPDATE `users` SET `verified` = 1 WHERE `username`=:username";
		$array = array('username' => $username);
		$typeArray = array('username' => PDO::PARAM_STR);
		$req = execReq($req, $array, $typeArray);
		return (0);
	}

}
?>
