#!/usr/bin/php
<?php
require_once 'database.php';

try {
	$dbh = new PDO($DB_DNS, $DB_USER, $DB_PASSWD);
	echo "Connect server OK\nDrop DB...\n";
	$req = "DROP DATABASE ".$DB_NAME;
	$dbh->prepare($req)->execute();
	echo "DB drop sucess\n";
} catch (PDOException $e) {
	echo 'Error drop DB : '.$e->getMessage();
	exit(-1);
}
?>
