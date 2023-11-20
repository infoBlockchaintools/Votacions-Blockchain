<?php
include "funcions.php";
$pagina="index";
global $link;
global $conn;

$us = $_REQUEST["user"];
$pass = md5($_REQUEST["pass"]);
$sql = "SELECT COUNT(*) AS total, us.sPass, us.sEmail, us.id FROM users us WHERE us.sEmail = '" . $us . "' and us.sPass='" . $pass . "'";
$results = $conn->Select($sql,$link); 
$row = mysqli_fetch_array($results);

if(($row[0]==1) && ($us!=""))	
{
	$_SESSION["acces"]="1";
	$_SESSION["iUsuari"]=$row["sEmail"];
	$_SESSION["iAdmin"]="1";	
	echo "<script>javascript:location.href='panel.php';</script>";
}
else
{
	$_SESSION["missatge"]="<br><strong>Nom i/o contrasenya no vàlid</strong>";
	echo "<script>javascript:location.href='index.php';</script>";
}
?>
