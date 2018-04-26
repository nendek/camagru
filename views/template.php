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
			if (isset($_SESSION['username'])) {
			?>
			<a href="../controller/login.php">logout !</a>
			<?php
			} else { 
			?>
			<a href="../controller/signup.php">signup !</a>
				<a href="../controller/login.php">login !</a>
			<?php
			}
			?>
			<p>Welcome to camagru !</p>
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
