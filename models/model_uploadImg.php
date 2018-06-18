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

function resizeImg($image) {
	$source = $image;
	$widthSource = imagesx($source);
	$heightSource = imagesy($source);

	if ($heightSource > 510 || $widthSource > 510)
	{
		$imageResize = imagecreatetruecolor(510, 510);
		$widthResize = imagesx($imageResize);
		$heightResize = imagesy($imageResize);
		imagecopyresampled($imageResize, $source, 0, 0, 0, 0, $widthResize, $heightResize, $widthSource, $heightSource);
		return ($imageResize);
	} else {
		return ($source);
	}
}

function fusionImg($image, $filter) {
	$destination = $image;
	$widthDestination = imagesx($destination);
	$heightDestination = imagesy($destination);
	$widthFilter = imagesx($filter);
	$heightFilter = imagesy($filter);
	$x = 0;
	$y = 0;

	imagecopymerge($destination, $filter, $x, $y, 0, 0, $widthDestination, $heightDestination, 60);
	return ($destination);
}

?>
