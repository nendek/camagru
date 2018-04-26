<?php
session_start();

require('./controller/login.php');

try {
	if (isset($_GET['action'])) {
		if ($_GET['action'] == 'login' || $_GET['action'] == 'logout') {
				connexion();
			} else if ($_GET['action'] == 'signup') {
				signup();
			}else if ($_GET['action'] == 'login' || $_GET['action'] == 'logout') {
				connexion();
			}	
		else
			throw new Exception("BAD ACTION");
	}
	else {
		echo 'coucou';
//		home();
	}
}
catch (Exception $e) {
	$_SESSION['error'] = "ERROR: ".$e->getMessage();
	require('./views/view_error.php');
	$_SESSION['error'] = null;
	return(-1);
}
?>

<?php
/*
echo "\n";
echo "username: ".$_SESSION['username']."\n";
echo "id :".$_SESSION['id']."\n";
echo "firstname :".$_SESSION['firstname']."\n";
echo "lastname :".$_SESSION['lastname']."\n";
echo "error :".$_SESSION['error']."\n";
 */
?>
