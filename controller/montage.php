<?php

function montage() {
	if (isset($_SESSION['id'])) {
		header("Location: ./views/view_montage.php");
		return ;
	} else {
		throw new Exception("ACCESS DENIED");
	}
}
?>
