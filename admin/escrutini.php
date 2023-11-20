<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
//session_start();
include "funcions.php";
$pagina="panel";
headerr($pagina);
global $link;
global $conn;


?>
		<div class="container">

			<div class="component">
<?php panellUser(); ?>				
			<div class="clear"></div>
  <div class="form inicial">
<h1>ESCRUTINI</h1>
<?php

if ($_REQUEST["pas"]=="")
{
	$sql = "SELECT id,sNom FROM 0_entitats ORDER BY ID DESC";
	$results = $conn->Select($sql,$link);
?>
	<form class="login-form" action="escrutini.php" method="post"  enctype="multipart/form-data">
		<input type="hidden" name="pas" id="pas" value="1"/>

<select id="entitat" name="entitat" style="font-size:20px;width:600px;">	
<?php
	while ($row = mysqli_fetch_array($results))
	{
		?>
		<option value="<?=$row["id"];?>"><?=utf8_decode($row["sNom"]);?></option>
<?php		
		//echo utf8_decode($row["sNom"]);

	}
?>				
</select>	<br/><br/>
        <div class="titolPregunta" style="font-size:20px;float:left;width:20%">CLAU PRIVADA:</div><br>
		Primera<br><textarea id="primera" cols="70" rows="15" name="primera"></textarea><br>
		Segona<br><textarea id="segona" cols="70" rows="15" name="segona"></textarea>
		<br/><br/>
		<button class="boto1" id="boto1">GENERAR ESCRITUNI</button>
	 </form>
<?php
}
else
{
	$constantTaula1 = 1714;
	$constantTaula3 = 55;
	$primera = $_REQUEST["primera"];
	$segona = $_REQUEST["segona"];
	$privatekey = $primera . $segona;
	//echo $privatekey;
	
	$num = 0;
	
	$archivo = fopen('escrutini.csv','w');



	
echo "<div style=\"text-align:left\">";


$sql = "SELECT idPublica, sInformacio FROM 2_blockchain";
$results = $conn->Select($sql,$link); 
while ($row = mysqli_fetch_array($results))
{
	$texte = base64_decode($row["sInformacio"]);
	//echo "|" . $texte . "|";
	$tornada = openssl_private_decrypt($texte, $decrypted, $privatekey);
	echo "<strong>" . $row["idPublica"] . "</strong>   /   " . str_replace("##",";",substr($decrypted,2)) . "</br>";
	$cadena = $row["idPublica"] . ";" . str_replace("##",";",substr($decrypted,2));
	$cadena = str_replace("<br/>","",$cadena);
//	echo "|" . $cadena . "|";
	fputs($archivo,$cadena); 
	
	$num++;
}
echo "</div>";


fclose($archivo); 


	echo "<h2>Total vots: " . $num . "</h2>";
	if ($cadenes!="")
	{
		echo "<hr><h2>ERRORS: " . $cadenes . "</h2>";
	}
	?>
	
<a href="escrutini.csv" target="_blank">BAIXAR ESCRUTINI</a>
<br><br>

	
	<form class="login-form" action="panel.php" method="post">
<button class="boto1" id="boto1">TORNAR AL INICI</button>
</form>
<?php
}
?>