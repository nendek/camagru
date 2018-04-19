#!/usr/bin/php
<?php
include 'database.php'

try {
	$dbh = new PDO($DB_DNS_EMPTY, $DB_USER, $DB_PASSWD);
	$req = "CREATE DATABASE IF NOT EXISTS '".$DB_NAME."' CHARACTER SET 'utf8'";
	$dbh->prepare($req)->execute();
} catch (PDOException $e) {
	echo 'Error connexion : ' $e->getMessage();
}
?>
