<?php

require_once('./models/model_connect.php');

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

function fusionImg($image, $imgFont, $x, $y) {
	$destination = $image;
	$widthDestination = imagesx($destination);
	$heightDestination = imagesy($destination);
	$widthFont = imagesx($imgFont);
	$heightFont = imagesy($imgFont);

	if ($widthFont == 510 && $heightFont == 510) {
		imagecopymerge($destination, $imgFont, $x, $y, 0, 0, $widthDestination, $heightDestination, 60);
	} else {
		imagecopy($destination, $imgFont, $x, $y, 0, 0, $widthFont, $heightFont);
	}
	return ($destination);
}

?>
