#!/usr/bin/php
<?php
require_once 'database.php';

try {
	$dbh = new PDO($DB_DNS, $DB_USER, $DB_PASSWD);
	echo "Connect DB camagru Ok\nClean TABLES...\n";
	$req = "DELETE FROM galery";
	$dbh->prepare($req)->execute();
	echo "Table galery clean\n";
	$req = "DELETE FROM comment";
	$dbh->prepare($req)->execute();
	echo "Table galery comment\n";
	$req = "DELETE FROM like";
	$dbh->prepare($req)->execute();
	echo "Table like clean\n";
} catch (PDOException $e) {
	echo 'Error clean tables : '.$e->getMessage();
	exit(-1);
}
