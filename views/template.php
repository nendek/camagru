<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?=$title?></title>
</head>
<body>
	<div id="global">
		<header>
			<a href="../index.php"><h1 id="titleSite">Camagru</h1></a>
			<?php
			if (isset($_SESSION['id'])) {
			?>
			<a href="../index.php?action=logout">logout !</a>
			<a href="../index.php?action=modif_acc">modif account !</a>
			<p>Welcome <?=$_SESSION['firstname']?> to camagru !</p>
			<?php
			} else { 
			?>
			<a href="../index.php?action=signup">signup !</a>
			<a href="../index.php?action=login">login !</a>	
			<p>Welcome to camagru !</p>
			<?php
			}
			?>
		  </header>
		  <div id="contents">
			<?= $contents ?>
		  </div>
		<footer>
			<hr />
			<p class="cop">© pnardozi 2018</p>
		</footer>
	</div>
</body>
</html>

<?php

echo "\n";
echo "username: ".$_SESSION['username']."\n";
echo "id :".$_SESSION['id']."\n";
echo "firstname :".$_SESSION['firstname']."\n";
echo "lastname :".$_SESSION['lastname']."\n";
echo "error :".$_SESSION['error']."\n";
echo "msg :".$_SESSION['msg']."\n";

?>
