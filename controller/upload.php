<?php

require('./models/model_uploadImg.php');

function uploadImg() {

	$montageDir = "./montage/";

	if (isset($_POST['img']) & isset($_SESSION['id'])) {
		$img = $_POST['img'];
		$id = $_SESSION['id'];

		$uiid = uniqid();

		if (!file_exists($montageDir)) {
			mkdir($montageDir);
		}
		file_put_contents($montageDir . $uiid . '.jpg', $img);




		echo "ok pd";
	} else {
		echo "pas ok pd";
	}
}

?>
