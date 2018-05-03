<?php

session_start();
require 'controller/routeur.php';

$routeur = new Routeur();
$routeur->routeurReq();

?>
