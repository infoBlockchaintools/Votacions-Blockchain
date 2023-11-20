<?php
session_start();
include "bd.php";
global $conn;
$conn=new BD();
global $link;
$link = $conn->Connectarse(""); 

function headerr($pagina)
{
	echo '<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>VOTA I PARTICIPA</title>
	<!-- Bootstrap core CSS -->
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/estils.css" rel="stylesheet">
	<script type="text/javascript" src="js/jquery-3.0.0.min.js"></script>
	<script type="text/javascript" src="js/funcions.js"></script>
</head>
<body>';
echo '<div class="container" style="margin-top:10px">';
}	

function pre()
{
echo "
<script>

</script>";
}
function footer()
{
echo '</body>
</html>';

}

function verificarSiDataOContrasenya($dni,$data,$pregunta,$entitat)
{	
	global $link, $conn;
	//Constants seguretat
	$constantTaula1 = 1714;
	
	//echo "<h4>PAS 1.1 (Mirar a Taula 1 (censGlobal) si existeix ID Control)</h4>";
	$hash1 = hash("sha256",$dni);
	$hash2 = hash("sha256",$data);
	$campATrobar = hash("sha256",$hash1 .  $hash2 . $constantTaula1);
	$idControl = $campATrobar;
	$sql = "SELECT id,idRegistre,sAny,sSexe from 1_censGlobal WHERE idControl = '" . $campATrobar . "' and idEntitat = " . $entitat;
	$results = $conn->Select($sql,$link); 
	$row = mysqli_fetch_array($results);
	if ($row["id"]!="")
	{
		//Votant existent Global
		$sAny = $row["sAny"];
		$sSexe = $row["sSexe"];
		
		//Existeix
		if ($row["idRegistre"]=="")
		{
			//No estava registrat amb contrasenya
			//MIRAR QUE ESTIGUI HABILITAT PER LA VOTACIO AQUESTA!!!
			//echo "<h4>PAS 1.2 (Mirar a Taula 1 (censLocal) si existeix ID Control)</h4>";
			$sql = "SELECT id,idRegistre from 1_censLocal WHERE idControl = '" . $campATrobar . "' and idEntitat = " . $entitat;
			$results = $conn->Select($sql,$link); 
			$row = mysqli_fetch_array($results);
			if ($row["id"]!="")
			{
				return "VOTAR";
			}
			else
			{
				return "NO-PER-AQUESTA";
			}				
		}
		else
		{
			return "CONTRASENYA";
		}
	}
	else
	{
		return "NO-TROBAT";
	}
}





function verificarSiPotVotar($dni,$dataa,$pass,$pregunta,$entitat)
{	
	global $conn,$link;
	
	//Constants seguretat
	$constantTaula1 = 1714;
	$constantTaula2 = 789;
	$constantTaula4 = 1009;

	//echo "<h4>PAS 1.1 (Mirar a Taula 1 (censGlobal) si existeix ID Control)</h4>";
	$hash1 = hash("sha256",$dni);
	$hash2 = hash("sha256",$dataa);
	$campATrobar = hash("sha256",$hash1 .  $hash2 . $constantTaula1);
	$idControl = $campATrobar;
	$sql = "SELECT id,idRegistre,sAny,sSexe from 1_censGlobal WHERE idControl = '" . $campATrobar . "' and idEntitat = " . $entitat;
	$results = $conn->Select($sql,$link); 
	$row = mysqli_fetch_array($results);
	if ($row["id"]!="")
	{
		//Votrant existent
		$sAny = $row["sAny"];
		$sSexe = $row["sSexe"];
	
		//Existeix
		$seguir = 0;
		if ($row["idRegistre"]=="")
		{
			//No estava registrat amb contrasenya
			$seguir = 0;
			
			//MIRAR QUE ESTIGUI HABILITAT PER LA VOTACIO AQUESTA!!!
			//echo "<h4>PAS 1.2 (Mirar a Taula 1 (censLocal) si existeix ID Control)</h4>";
			$sql = "SELECT id from 1_censLocal WHERE idControl = '" . $campATrobar . "' and idEntitat = " . $entitat;
			$results = $conn->Select($sql,$link); 
			$row = mysqli_fetch_array($results);
			if ($row["id"]!="")
			{
				$seguir = 1;
			}
			else
			{
				$seguir = 0;
				$retorna = "NO-PER-AQUESTA";
			}				
		}
		else
		{
			//echo "<h4>PAS 1.2 (Mirar si tenia contrasenya i la entrat)</h4>";
			//Mirar si idRegistre cuadra amb contrasenya
			$hash3 = hash("sha256",$pass);
			$campATrobar = hash("sha256",$hash1 .  $hash3 . $constantTaula1);
			
			if ($row["idRegistre"]==$campATrobar)
			{
				$seguir = 1;
			}
			else
			{
				//echo "<h4>PAS 1.3 (Mirar si tenia contrasenya i quants errors té)</h4>";
				//ENREGISTRAR ERROR++ A TAULA 4
				$hashErrors = hash("sha256",hash("sha256",$dni).$constantTaula4);
				$sql = "SELECT sErrors,id FROM 4_errors WHERE sEquivocat = '" . $hashErrors ."'";
				$results = $conn->Select($sql,$link); 
				$row = mysqli_fetch_array($results);
				if ($row[0]=="")
				{
					$sql = "INSERT INTO 4_errors (sEquivocat,sErrors) VALUES ('" . $hashErrors . "',1)";
					$conn->Select($sql,$link); 
					$dif = 4;
					$retorna = "CONTRASENYA-INCORRECTA-" . $dif;
				}
				else
				{				
					$errors = $row[0];
					$errors = $errors + 1;
					$sql = "UPDATE 4_errors SET sErrors = " . $errors . " WHERE id = " . $row[1];
					$conn->Select($sql,$link); 
					
					if ($errors > 4)
					{
						$retorna = "CONTRASENYA-INCORRECTA-0";
					}
					else
					{
						$dif = 5 - $errors;
						$retorna = "CONTRASENYA-INCORRECTA-" . $dif;
					}
				}
			}
		}
		
		if ($seguir)
		{
			//enregistrar xifrat sexe i any
			
			
			//echo "<h4>PAS 2 (Mirar a Taula 1(Local) si no ha votat JA)</h4>";
			$sql = "SELECT id FROM 1_censLocal WHERE idControl = '" . $idControl . "' and iVotat = 0 and idEntitat = " . $entitat;
			$results = $conn->Select($sql,$link); 
			$row = mysqli_fetch_array($results);			
			$seguir = 0;
			if ($row["id"]!="")
			{
				$seguir = 1;
			}
			else
			{
				$retorna =  "JA-VOTAT";
			}
			
			if ($seguir)
			{
				//echo "<h4>PAS 3 (Mirar a Taula 4 que no estigui bloquejat per errors)</h4>";
				$campATrobar = hash("sha256",$hash1 .  $constantTaula4);
				$sql = "SELECT id FROM 4_errors WHERE sEquivocat = '" . $campATrobar . "' and sErrors >= 5";
				$results = $conn->Select($sql,$link); 
				$row = mysqli_fetch_array($results);
				$seguir = 0;
				if ($row["id"]=="")
				{
					$seguir = 1;
					$retorna = "VOTAR";
				}
				else
				{
					$retorna =  "MASSA-ACCESSOS";
				}				
			}
		}
	}
	else
	{
		$retorna =  "NO-TROBAT";
	}
	
	return $retorna;
}
?> 