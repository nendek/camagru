<?php
require_once('./models/model_connect.php');

function get_token($username) {
	$dbh = get_db();
	$req = $dbh->prepare("SELECT `token`,`verified` FROM `users` WHERE `username`=:username");
	$req->bindValue(':username', $username, PDO::PARAM_STR);
	$req->execute();
	$row = $req->fetch();
	return ($row);
}

function validation($username) {
	$dbh = get_db();
	$req = $dbh->prepare("UPDATE `users` SET `verified` = 1 WHERE `username`=:username");
	$req->bindValue(':username', $username, PDO::PARAM_STR);
	$req->execute();
	return (0);
}

?>
