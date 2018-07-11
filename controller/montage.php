<?php

require('./models/model_uploadImg.php');

function montage() {
	if (isset($_SESSION['id'])) {
		header("Location: ./views/view_montage.php");
		return ;
	} else {
		throw new Exception("ACCESS DENIED");
	}
}

function displayMontage() {
	if (isset($_SESSION['id'])) {
		$userId = $_SESSION['id'];
		$tab = get_montageID($userId);
		
		return ;
	} else {
		throw new Exception("ACCESS DENIED");
	}
}

?>
