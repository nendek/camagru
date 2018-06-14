<?php

require_once('./models/model_connect.php');

header("Content-Type: image/jpg");

function add_montage($userId, $imgPath) {
	include_once '../setup/database.php';

	$dbh = get_db();
	$req = $dbh->prepare("INSERT INTO gallery (userid, img) VALUES (:userid, :img)");
	$req->bindValue(':userId', $userId, PDO::PARAM_STR);
	$req->bindValue(':imgPath', $imgPath, PDO::PARAM_STR);
	$req->execute();
	return (0);
}

?>
