#!/usr/bin/php
<?php
require_once 'database.php';

try {
	$dbh = new PDO($DB_DNS_EMPTY, $DB_USER, $DB_PASSWD);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	echo "Connect server OK\nCreate DB...\n";
	$req = "CREATE DATABASE IF NOT EXISTS ".$DB_NAME." CHARACTER SET utf8";
	$dbh->prepare($req)->execute();
	echo "DB create sucess\n";
} catch (PDOException $e) {
	echo 'Error connexion : '.$e->getMessage();
	exit(-1);
}
try {
	$dbh = new PDO($DB_DNS, $DB_USER, $DB_PASSWD);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	echo "\nConnect DB camagru OK\nCreate TABLES...\n";
	$req = "CREATE TABLE IF NOT EXISTS ".$DB_NAME.".`users` (
		id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
		firstname VARCHAR(50),
		lastname VARCHAR(50),
		email VARCHAR(255),
		username VARCHAR(50),
		passwd TEXT,
		token text,
		verified TINYINT
		);";
	$dbh->prepare($req)->execute();
	echo "Table users create\n";
	$req = "CREATE TABLE IF NOT EXISTS ".$DB_NAME.".`gallery` (
		id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
		userId INT NOT NULL,
		img VARCHAR (100),
		FOREIGN KEY (userId) REFERENCES users(id)
		);";
	$dbh->prepare($req)->execute();
	echo "Table gallery create\n";
	$req = "CREATE TABLE IF NOT EXISTS ".$DB_NAME.".`comment` (
		id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
		userId INT NOT NULL,
		galleryId INT NOT NULL,
		comment TEXT,
		FOREIGN KEY (userId) REFERENCES users(id),
		FOREIGN KEY (galleryId) REFERENCES gallery(id)
		);";
	$dbh->prepare($req)->execute();
	echo "Table comment create\n";
	$req = "CREATE TABLE IF NOT EXISTS ".$DB_NAME.".`like` (
		id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
		userId INT NOT NULL,
		galleryId INT NOT NULL,
		yes TINYINT,
		FOREIGN KEY (userId) REFERENCES users(id),
		FOREIGN KEY (galleryId) REFERENCES gallery(id)
		);";
	$dbh->prepare($req)->execute();
	echo "Table like create\n";
} catch (PDOException $e) {
	echo 'Error create tables : '.$e->getMessage();
	exit(-1);
}
?>
