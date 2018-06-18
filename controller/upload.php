<?php

require('./models/model_uploadImg.php');

function uploadImg() {

	header ("Content-type: image/png");


	$montageDir = "./montage/";

	if (isset($_POST['img']) & isset($_SESSION['id'])) {
		$img = $_POST['img'];
		$filter = "images"; // modifier !!
		$id = $_SESSION['id'];

		$img = str_replace('data:image/png;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$img = base64_decode($img);

		$uiid = uniqid();

		if (!file_exists($montageDir)) {
			mkdir($montageDir);
		}
		file_put_contents($montageDir . $uiid . '.png', $img);
		
		$filter = imagecreatefrompng("./font/".$filter.".png");
		$img = imagecreatefrompng("./montage/".$uiid.".png");

		//resize filtre
		$filter = resizeImg($filter);

		//fusion
		$img = fusionImg($img, $filter);
		file_put_contents($montageDir . $uiid . '.png', $img);





/*
		// On charge d'abord les images
		$source = imagecreatefrompng("./font/images.png");
		$destination = imagecreatefrompng($montageDir.$uiid.'.png');

		// Les fonctions imagesx et imagesy renvoient la largeur et la hauteur d'une image
		$largeur_source = 510;
		$hauteur_source = 510;

		// On met le logo (source) dans l'image de destination (la photo)
		imagecopymerge($destination, $source, 0, 0, 0, 0, $largeur_source, $hauteur_source, 60);

		// On affiche l'image de destination qui a été fusionnée avec le logo
		imagejpeg($destination, "./montage/test.png");
 */



		echo "ok pd";
	} else {
		echo "pas ok pd";
	}
}

?>
