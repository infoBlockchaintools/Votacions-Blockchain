<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php
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
		<h1>Importador CENS VOTACIO ACTUAL</h1>
<?php

if ($_REQUEST["pas"]=="")
{
	$sql = "SELECT id,sNom FROM 0_entitats ORDER BY ID DESC";
	$results = $conn->Select($sql,$link);
echo '<h2 style="text-align:center">Escollir una entitat i pujar un fitxer .csv</h2>';
?>
		<form class="login-form" action="votacions.php" method="post"  enctype="multipart/form-data">
			<input type="hidden" name="pas" id="pas" value="1"/>
			Entitat:
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
			</select>	<br/><br/><br/>
			<div class="titolPregunta" style="font-size:20px;float:left;width:20%">Fitxer:</div>
			<input type="file" placeholder="fitxer" name="fitxer" id="fitxer" requiredd style="font-size:20px;width:77%"/>*<div class="clear"></div>	  
			Format de columnes: DNI - DATA NAIXEMENT - ANY NAIXEMENT - SEXE (H/D)
			<br/><br/>
			<button class="boto1" id="boto1">IMPORTAR PADRÓ VOTACIONS</button>
		 </form>
<?php
}
else
{
	
	$constantTaula1 = 1714;
	$constantTaula3 = 55;
	
	$arxiu = $_FILES [ 'fitxer' ]["tmp_name"];
	$archivo = fopen($arxiu, "r");
	$entitat = $_REQUEST["entitat"];
	$data = fgetcsv ($archivo, 1000, ";");
	$volta = 0;

	$base = 0;
	$iNum = 0;
	$cadenes = "";
	$valids = "";

	$anyActual = date("Y");
	
	//Buscar clau publica
	$sql = "SELECT sKeyPublica FROM 0_entitats WHERE id = " . $entitat;
	$results = $conn->Select($sql,$link); 
	$row = mysqli_fetch_array($results);	
	$publickey = $row["sKeyPublica"];
	
	$sql = "SET NAMES utf8mb4;";
	$conn->Select($sql,$link); 
	
	
	while ($data = fgetcsv ($archivo, 1000, ";")) {
		if ($volta == 0)
		{
			$sql = "DELETE FROM 1_censLocal WHERE idEntitat = " . $entitat;
			$conn->Select($sql,$link);
		}
		$error = 0;

		$dni = $data[0];
		$dataa = $data[1];
		$sAny = $data[2];
		$sSexe = $data[3];

		$dataa = substr($dataa,6,4) . substr($dataa,3,2) . substr($dataa,0,2);
			
		if (strlen($dataa)<8) {
			$error = 1;
			$cadenes .= "<br>- Error Data massa curta: " . $data[1];
		}

		while (strlen($dni)<8) 
		{
			$dni = "0" . $dni;
		}

		if (strlen($dni)<8) {
			$error = 1;
			$cadenes .= "<br>- Error DNI massa curt: " . $data[0];
		}
		$sCodi1 = hash("sha256",$dni);
		$sCodi2 = hash("sha256",$dataa);
	
		$actual = date("Y");
		$anysDif = $actual - $sAny;
		$anysDif = $anysDif/10;
		$anysDif = ceil($anysDif);
		if ($anysDif > 9) $anysDif = 9;
		
		$sAnyF = encrypt($anysDif,$dni);
		$sSexeF = encrypt($sSexe,$dni);
			
		if (!$error)
		{
			$idControl = hash("sha256",$sCodi1 . $sCodi2 . $constantTaula1);
			
			//Buscar SHA a taula 1
			$idRegistre = "";
			$sql = "SELECT id,idRegistre from 1_censGlobal WHERE idControl = '" . $idControl . "'";
			$results = $conn->Select($sql,$link); 
			$row = mysqli_fetch_array($results);
			
			if ($row[0]!="")
			{
				//Existeix: grabar a la 1_censLocal amb el idRegistre del 1_censGlobal
				$idRegistre = $row["idRegistre"];
			}
			else
			{
				$idRegistre = "";
				$sql = "INSERT INTO 1_censGlobal (idControl,idRegistre,sAny,sSexe,idEntitat) VALUES ('" . 
				$idControl. "','" .
				$idRegistre. "','" .
				$sAnyF .  "','" .
				$sSexeF . "','" .
				$entitat . "')";
				$conn->Select($sql,$link);
			}
			
			//Pujar a 1_censLocal
			$sql = "INSERT INTO 1_censLocal (idControl,idRegistre,sAny,sSexe,idEntitat) VALUES ('" . 
			$idControl. "','" .
			$idRegistre. "','" .
			$sAnyF. "','" .
			$sSexeF. "','" .
			$entitat . "')";
			$conn->Select($sql,$link);

			//Crear a taula3
			$nouCamp = hash("sha256",$idControl . $idRegistre . $constantTaula3);
			$sql = "INSERT INTO 3_integritat (sIntegritat) VALUES ('" . 
			$nouCamp . "')";
			$conn->Select($sql,$link);
			$valids .= "<br>-> " . $sCodi1 .  " " . $sCodi2;
			$iNum++;
		}
		$volta++;
	}
	
	echo "<h2>Total importats: " . $iNum . "</h2>";
	if ($cadenes!="")
	{
		echo "<hr><h2>ERRORS: " . $cadenes . "</h2>";
	}
	?>
		<form class="login-form" action="panel.php" method="post">
			<button class="boto1" id="boto1">TORNAR AL INICI</button>
		</form>
<?php
}
?>
		</div>
	</div>
</div>