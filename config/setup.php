#!/usr/bin/php
<?php
include 'database.php';

try {
	$dbh = new PDO($DB_DNS_EMPTY, $DB_USER, $DB_PASSWD);
	$req = "CREATE DATABASE IF NOT EXISTS ".$DB_NAME." CHARACTER SET utf8";
	echo $req;
	$dbh->prepare($req)->execute();
	echo "DB create sucess\n";
} catch (PDOException $e) {
	echo 'Error connexion : '.$e->getMessage();
	exit(-1);
}
try {
	$dbh = new PDO($DB_DNS, $DB_USER, $DB_PASSWD);
	echo "Connec


?>
