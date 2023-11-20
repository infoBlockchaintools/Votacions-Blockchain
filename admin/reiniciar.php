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
<h1>REINICIAR VOTACIONS</h1>
<?php

if ($_REQUEST["pas"]=="")
{
	$sql = "SELECT id,sNom FROM 0_entitats ORDER BY ID DESC";
	//echo $sql;
	$results = $conn->Select($sql,$link);
?>
	<form class="login-form" action="reiniciar.php" method="post"  enctype="multipart/form-data">
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
</select>	<br/><br/><br/><br/>


		<button class="boto1" id="boto1">REINICIAR VOTACIONS</button>
	 </form>
<?php
}
else
{
	$entitat = $_REQUEST["entitat"];
	$sql = "UPDATE 1_censLocal SET iVotat = 0 WHERE idEntitat = " . $entitat;
	$conn->Select($sql,$link); 

	$sql = "DELETE FROM 2_blockchain";
	$conn->Select($sql,$link); 

	$sql = "DELETE FROM 4_errors";
	$conn->Select($sql,$link); 
	
	
	echo "<h2>Votacions reiniciades</h2>";
	?>
	<form class="login-form" action="panel.php" method="post">
<button class="boto1" id="boto1">TORNAR AL INICI</button>
</form>
<?php
}
?>