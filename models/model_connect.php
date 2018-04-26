<?php
function get_db() {
	require './config/database.php';
	$dbh = new PDO($DB_DNS, $DB_USER, $DB_PASSWD);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return ($dbh);
}
?>
