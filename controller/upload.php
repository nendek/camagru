<?php

require('./models/model_uploadImg.php');

function uploadImg() {

	header ("Content-type: image/png");


	$montageDir = "./montage/";

	if (isset($_POST['img']) & isset($_SESSION['id'])) {
		$img = $_POST['img'];
		$filter = "cig"; // modifier !!
		$id = $_SESSION['id'];

		$img = str_replace('data:image/png;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$img = base64_decode($img);

		$uiid = uniqid();

		if (!file_exists($montageDir)) {
			mkdir($montageDir);
		}
		file_put_contents($montageDir . $uiid . '.png', $img);
		
		$imgFont = imagecreatefrompng("./font/".$filter.".png");
		$img = imagecreatefrompng("./montage/".$uiid.".png");

		//resize filtre
		$imgFont = resizeImg($imgFont);
		imagepng($imgFont, $montageDir."filter.png");
		imagepng($img, $montageDir."image.png");

		//fusion
		$img = fusionImg($img, $imgFont);
		
		imagepng($img, $montageDir.$uiid.".png");

		echo "ok pd";
	} else {
		echo "pas ok pd";
	}
}

?>
