<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Camagru</title>
</head>
<body>
<a href="./controller/signup.php">signup !</a>
<a href="./controller/login.php">login !</a>
<a href="./controller/login.php">logout !</a>

<?php
echo "\n";
echo "username: ".$_SESSION['username']."\n";
echo "id :".$_SESSION['id']."\n";
echo "firstname :".$_SESSION['firstname']."\n";
echo "lastname :".$_SESSION['lastname']."\n";
echo "error :".$_SESSION['error']."\n";
?>

</body>
</html>
