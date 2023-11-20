<?php
include "funcions.php";
$pagina="index";
headerr($pagina);
global $conn;
global $link;
?>

<div class="container">
	<div class="component">
<?php panellUser(); ?>		
		<div class="form inicial">
		<h1>REGISTRE VOTANTS</h1>
		<style>
		.form input
		{
			font-size:1.2em;
		}
		</style>
<?php 
if ($_REQUEST["pas"]!="1")
{
	?>
		<h2 style="text-align:center">NOU REGISTRE - Insertar dades</h2>
		<div style="display:block;margin-top:20px;min-height:400px" id="panel1" name="panel1">
			<form class="login-form" name="form" id="form" method="post" style="width:95%" action="registrarse.php" style="font-size:12px">
			
				<input type="hidden" id="pas" name="pas" class="form-control" placeholder="" value="1">
				
				<div style="width:22%;float:left;padding:15px;">
					Entitat<br/>
					<select id="entitat" name="entitat" class="form-control" style="font-size:20px">	
					<?php
						$sql = "SELECT id,sNom FROM 0_entitats ORDER BY ID DESC";
						$results = $conn->Select($sql,$link);
						while ($row = mysqli_fetch_array($results))
						{
							?>
							<option value="<?=$row["id"];?>"><?=utf8_decode($row["sNom"]);?></option>
					<?php		
							//echo utf8_decode($row["sNom"]);

						}
					?>				
					</select>	
				</div>
				
				<div style="width:22%;float:left;padding:15px;">
					DNIs
					<input type="text" name="dni" id="dni" value="40000001" required/> 
				</div>
				<div style="width:22%;float:left;padding:15px;">
					Data Naixement
					<input type="date" name="data" id="data" value="" required/> 
				</div>		
				<div style="width:22%;float:left;padding:15px;">				
					Contrasenya
					<input type="password" id="sPass" name="sPass" class="form-control" placeholder="" required autofocus maxlength="150">
				</div>
				<div style="clear:both"></div>
				<br/><br/>	 
				<button  class="boto1" id="boto1">Registrar-se</button>
			</form>			
<?php 
}
else
{
?>
	<h2 style="text-align:center">NOU REGISTRE - Resultat</h2>
	<?php
	
	$constantTaula1 = 1714;
	$entitat = $_REQUEST["entitat"];
	$dni = $_REQUEST["dni"];
	$dataa = $_REQUEST["data"];
	$sPass = $_REQUEST["sPass"];
	
	$dataa = substr($dataa,0,4) . substr($dataa,5,2) . substr($dataa,8,2);
	
	echo "<h4>PAS 1.1 (Mirar a Taula 1 (censGlobal) si existeix ID Control)</h4>";

	$hash1 = hash("sha256",$dni);
	$hash2 = hash("sha256",$dataa);
	
	$campATrobar = hash("sha256",$hash1 .  $hash2 . $constantTaula1);
	$idControl = $campATrobar;
	
	$sql = "SELECT id,idRegistre from 1_censGlobal WHERE idControl = '" . $campATrobar . "' and idRegistre = '' and idEntitat = " . $entitat;
	$results = $conn->Select($sql,$link); 
	$row = mysqli_fetch_array($results);
	if ($row["id"]!="") {
		
		//echo "Es pot registrar";
		$sCodi1 = hash("sha256",$dni);
		$sCodi2 = hash("sha256",$sPass);	
		//echo $dni . "-" . $sPass;exit;
		$idRegistre = hash("sha256",$sCodi1 . $sCodi2 . $constantTaula1);		
		
		$sql = "UPDATE 1_censGlobal SET idRegistre = '"  .$idRegistre . "' WHERE idControl = '" . $campATrobar . "'";
		$conn->Select($sql,$link); 
		$sql = "UPDATE 1_censLocal SET idRegistre = '"  .$idRegistre . "' WHERE idControl = '" . $campATrobar. "'";
		$conn->Select($sql,$link); 		
		echo "<h2>Usuari registrat</h2>";
		//echo $idRegistre;
	}	
	else
	{
		//Mirar si no existeix o ja te una contrasenya...
		$sql = "SELECT id,idRegistre from 1_censGlobal WHERE idControl = '" . $campATrobar . "' and idRegistre <> '' and idEntitat = " . $entitat;
		$results = $conn->Select($sql,$link); 
		$row = mysqli_fetch_array($results);		
		if ($row["id"]!="") {
			echo "<h2>ERROR, usuari ja registrat</h2>";
		}
		else
		{
			echo "<h2>ERROR, usuari NO existeix</h2>";
		}
	}
}
?>
<br/><br/>
	<form class="login-form" action="panel.php" method="post">
<button class="boto1" id="boto1">TORNAR AL INICI</button>
</form>
</div></div></div>
<?php
footer();
?>