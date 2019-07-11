<?php
session_start();
if(isset($_GET["deconnect"]) && $_GET["deconnect"]){//variable bien déclaré
	unset($_SESSION["connect"]);
}
if (isset($_SESSION["connect"])) {
	$connect = $_SESSION["connect"];
}else{
	$connect = false;
}
if (empty($connect)) {
	header("Location: formconnexion.php");
}
if (isset($_SESSION["prenom"])) {
	$prenom = $_SESSION["prenom"];
}else{
	$prenom = "";
}
//ne pas fermer la balise sinon pb pour require ds autre php