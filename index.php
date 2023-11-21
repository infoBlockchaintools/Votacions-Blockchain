<?php
include "funcions.php";
$pagina="index";
$correcte = 1;

headerr($pagina);
pre();

/*PARAMETRES A CONFIGURAR*/
$entitat = 1;


$pregunta = $_REQUEST["id"];
if ($pregunta==""){
	$sql =" SELECT MAX(id) from preguntes";
	$results = $conn->Select($sql,$link);
	$row = mysqli_fetch_array($results);
	$pregunta = $row[0];
}
$_SESSION["pregunta"]=$pregunta;


if ($pregunta=="") { echo "ERROR"; exit; }	
?>

<div class="container inici" style="color:#523f8d;width:100%;bodrder:10px solid #ff0000;margin-top:0px;">

<?php

$sql = "SELECT iInici,iFinal FROM preguntes WHERE id = " . $pregunta;
$results2 = $conn->Select($sql,$link);			
$row= mysqli_fetch_array($results2);
$temps = time();
$temps = $temps + 3600;
$dif = $temps - $row["iFinal"];

$correcte =1;
if ($row["iInici"] > $temps)
{
	$codiE = "La votació començarà el proper dia 9 de Desembre a les 08:00h";	$correcte = 0;
}
else if ($dif>0)
{
	$codiE = "Votació acabada"; 	$correcte = 0;
}

$correcte = 1;

if (!$correcte)
{
?>
<div class="intro" id="intro" style="z-index:-1"></div>
<div class="introMob formulari1" id="introMob" style="z-index:-1;"></div>
<div style="text-align:center;margin-left:20px;">
  <form class="form-signin" name="form" id="form" method="post">
  <input type="hidden" name="id" id="id" value="<?=$pregunta;?>"/>
	<input type="hidden" name="pas" id="pas" value="1"/>
	<input type="hidden" name="valor" id="valor" value="-1"/>
	<div style="display:block;">
		<div style="display:block;float:left;width:5%">&nbsp;&nbsp;</div>		
		<div class="cartell1" id="cartell1" >
		<?=$codiE;?></div>
	</div>  
  </form>
</div>
<?php
	exit;
}

//0-Pas inicial
if (((!isset($_REQUEST["pas"])) || ($_REQUEST["pas"]==0) || ($_REQUEST["pas"]==5)) && ($correcte))
{
	$sql = "SELECT iInici,iFinal,sP FROM preguntes WHERE id = " . $pregunta;
	$results2 = $conn->Select($sql,$link);			
	$row= mysqli_fetch_array($results2);
	$temps = time();
	$dif = $temps - $row["iFinal"];
	$dif = $row["iFinal"]  - $temps ;

?>
<div class="intro" id="intro" style="z-index:-1"></div>
<div class="introMob formulari1" id="introMob" style="z-index:-1;"></div>
<div style="text-align:center;margin-left:20px;">
  <form class="form-signin" name="form" id="form" method="post">
  <input type="hidden" name="id" id="id" value="<?=$pregunta;?>"/>
	<input type="hidden" name="pas" id="pas" value="1"/>
	<input type="hidden" name="valor" id="valor" value="-1"/>
	<div style="display:block;">
		<div style="display:block;float:left;width:5%">	&nbsp;&nbsp;
		</div>		
		<div class="cartell1" id="cartell1"  >Per a poder votar serà necessari que estiguis registrat, sinó hauràs de passar per l'entitat a registrar-te</div>
		<button class="btn btn-lg btn-primary btn-block endavant" type="button"  onclick="endavant('1');" id="botoComencar">Vota</button>
		<br/>
		<div class="logosHome">
			<img src="css/solucions-ample.jpg" style="max-width:100%">
		</div>
	</div>  
  </form>
</div>
<?php
}
//Pas 1a DNI
else if (($_REQUEST["pas"]=="1") && ($correcte==1))
{
	$pregunta = $_REQUEST["id"];
	$_SESSION["dni"]="";
	$_SESSION["data"]="";
?>
<div class="form inicial" id="formulari1">
	<form class="login-form" name="form" id="form" method="post">
		<input type="hidden" name="id" id="id" value="<?=$pregunta;?>"/>
		<input type="hidden" name="pas" id="pas" value="1a"/>
		<input type="hidden" name="valor" id="valor" value=""/>
		<div class="titol1">Cal identificar-se</div>
			<div class="titol2">Introdueix el teu DNI / NIE / Passaport</div>
			<input type="text" placeholder="DNI/NIE" name="dni" id="dni" required maxlength=9 style="font-size:20px;" autofocus/>
			<div class="clear"></div> 
			<div>
				<div style="float:left;width:25%">
					<button class="btn btn-lg btn-primary btn-block" type="button"  onclick="cancelar('<?=$pregunta;?>','0');" id="botoEndarrera">Enrere</button>
				</div>
				<div style="float:left;width:25%">
					<button class="btn btn-lg btn-primary btn-block endavant" type="button"  onclick="endavant('2');" id="botoEndavant" submit>Continuar</button>
				</div>
			</div>		
	</form>
</div>

<?php	

}
elseif (($_REQUEST["pas"]=="1a")  && ($correcte==1))
{
	$pregunta = $_REQUEST["id"];
	$dni = strtoupper($_REQUEST["dni"]);
	if ($_REQUEST["dni"]=="") $dni = $_SESSION["dni"];
	$_SESSION["dni"] = $dni;
	$_SESSION["data"] = $data;
	?>
<div class="form inicial" id="formulari1">
<form class="login-form" name="form" id="form" method="post">
	<input type="hidden" name="id" id="id" value="<?=$pregunta;?>"/>
	<input type="hidden" name="pas" id="pas" value="1b"/>
	<input type="hidden" name="valor" id="valor" value=""/>
	<input type="hidden" name="cod1" id="cod1" value="<?=$dni;?>"/>
	<div class="titol1">Cal identificar-se</div>
		<div class="titol2">Introdueix la teva data de naixement</div>

		<div class="caixetadeDates">
		<div class="dates"><input type="text" placeholder="DD" name="data1" id="data1" class="caixadata" required maxlength=2 autofocus/></div>
		<div class="dates"><input type="text" placeholder="MM" name="data2" id="data2" class="caixadata" required maxlength=2/></div>
		<div class="dates4"><input type="text" placeholder="AAAAA" name="data3" id="data3" class="caixadata4" required maxlength=4/></div>
		</div>
		</form>
</div>
<div style="width:100%;">
		<div style="float:left;width:25%">
			<button class="btn btn-lg btn-primary btn-block" type="button"  onclick="cancelar('<?=$pregunta;?>','1');" id="botoEndarrera">Enrera</button>
		</div>
		<div style="float:left;width:25%">
			<button class="btn btn-lg btn-primary btn-block endavant" type="submit"  onclick="endavant('2');" id="botoEndavant">Continuar</button>
		</div>
</div>	
<script>
$("form input").on('keypress',function(event) {
  if (event.which === 13) {
    $('button.endavant').trigger('click');
  }
});

 $("#data1").keyup(function () {
        if (this.value.length == this.maxLength) {
          $("#data2").focus(); 
        }
});
$("#data2").keyup(function () {
        if (this.value.length == this.maxLength) {
          $("#data3").focus(); 
        }
});
$("#data3").keyup(function () {
        if (this.value.length == this.maxLength) {
          $(".endavant").focus(); 
        }
});
</script>
<?php
}
else if (($_REQUEST["pas"]=="1b"))
{
	$pregunta = $_REQUEST["id"];
	$dni = $_SESSION["dni"];
	
	$data3 = $_REQUEST["data3"]; if (strlen($data3)<4) $data3 = "20" . $data3;
	$data2 = $_REQUEST["data2"]; if (strlen($data2)<2) $data2 = "0" . $data2;
	$data1 = $_REQUEST["data1"]; if (strlen($data1)<2) $data1 = "0" . $data1;

	$data = $data3 . $data2 . $data1;
	if ($data=="")
		$data = $_SESSION["data"];
	else
		$_SESSION["data"] = $data;

	//Mirar si cal preguntar x contrasenya o no.
	$retorn = verificarSiDataOContrasenya($dni,$data,$pregunta,$entitat);
	
	
	if (($retorn == "NO-TROBAT") || ($retorn == "NO-PER-AQUESTA"))
	{
		$resultat = '
<div class="form inicial" id="formulari1">
	<input type="hidden" name="id" id="id" value="' . $pregunta . '"/>		
		<div class="titol1">Identificació</div>
		<div class="titol2">Les dades introduïdes no sòn correctes</div>
		<div class="clear"></div> 
	
		<form class="login-form" action="index.php" method="post" style="text-align:center" >
			<input type="hidden" id="id" name="id" value="<?=$pregunta;?>"/>
			<input type="hidden" id="pas" name="pas" value="1a"/>
			<button class="boto1 endavant" id="botoEndarreraSol">Enrere</button>
		</form>
	</div>	
		';
		echo $resultat;
	}
	elseif ($retorn == "CONTRASENYA")
	{
		$pregunta = $_SESSION["pregunta"];
?>
<div class="form inicial" id="formulari1">
<form class="login-form" name="form" id="form" method="post">
	<input type="hidden" name="pas" id="pas" value="2"/>
	<input type="hidden" name="valor" id="valor" value=""/>
	<input type="hidden" name="cod1" id="cod1" value="<?=$dni;?>"/>
	<div class="titol1">Cal identificar-se</div>
		<div class="titol2">Introdueix la teva contrasenya</div>
		<input type="password" placeholder="" name="contrasenya" id="contrasenya" classs="caixadata" required maxlength=15 autofocus/>
		<div class="clear"></div> 
		<div>
			<div style="float:left;width:25%">
				<button class="btn btn-lg btn-primary btn-block" type="button"  onclick="cancelar('<?=$pregunta;?>','1a');" id="botoEndarrera">Enrere</button>
			</div>
			<div style="float:left;width:25%">
				<button class="btn btn-lg btn-primary btn-block endavant" type="submit"  onclick="endavant('2');" id="botoEndavant">Continuar</button>
			</div>
		</div>	
	</form>
</div>
<?php	
	}
}
//2-Contrasenya
else if ($_REQUEST["pas"]==2)
{
	?>
	<div class="form inicial formulari1">
	<?php
	//Validar que el usuari pugui votar!
	$dni = $_SESSION["dni"];
	$data = $_SESSION["data"];
	$pass = $_REQUEST["contrasenya"];
	if ($pass!="")
		$_SESSION["pass"] = $pass;
	else
		$pass = $_SESSION["pass"];
	$pregunta = $_SESSION["pregunta"];



	$resposta =  verificarSiPotVotar($dni,$data,$pass,$pregunta,$entitat);
	
	$error = 1;
	if (substr($resposta,0,23)=="CONTRASENYA-INCORRECTA-")
	{
		$passAnterior = "1a";
		$queden = substr($resposta,23,1);
		if ($queden == 0)
		{
			$resultat = '<div class="titol1">Identificació</div>
			<div class="titol2">Contrasenya incorrecta. Usuari bloquejat, contacta amb la teva entitat.</div>';
			$passAnterior = "0";
		}
		elseif ($queden == 1)
		{
			$resultat = '<div class="titol1">Identificació</div>
			<div class="titol2">Contrasenya incorrecta. Queda ' . $queden . ' intent.</div>';
		}
		else
		{
			$resultat = '<div class="titol1">Identificació</div>
			<div class="titol2">Contrasenya incorrecta. Queden ' . $queden . ' intents.</div>';
		}
	}
	elseif (($resposta == "NO-TROBAT") || ($resposta == "NO-PER-AQUESTA") || ($resposta == "CONTRASENYA-INCORRECTA"))
	{
		$passAnterior = "0";
			$resultat = '<div class="titol1">Identificació</div>
			<div class="titol2">Les dades introduïdes no sòn correctes.</div>';		
	}
	elseif (($resposta == "JA-VOTAT"))
	{
		$passAnterior = "0";
			$resultat = '<div class="titol1">Identificació</div>
			<div class="titol2">Aquest usuari ja ha votat.</div>';		
	}	
	else
	{
		$error = 0;
	}
	
	if ($error)
	{
		echo $resultat;
?>
		<form class="login-form" action="index.php" method="post" style="text-align:center" >
			<input type="hidden" id="id" name="id" value="<?=$pregunta;?>"/>
			<input type="hidden" id="pas" name="pas" value="<?=$passAnterior;?>"/>
			<button class="boto1 endavant" id="botoEndarreraSol">Enrere</button>
		</form>
	</div>
	
<?php 
	}
	else
	{
		$sql = "SELECT sP,sR1,sR2,sR3,sR4,sR5,sR6 FROM preguntes WHERE id = " . $pregunta;
		$results2 = $conn->Select($sql,$link);			
		$row= mysqli_fetch_array($results2);

		$dif = $row["iFinal"]  - $temps ;
		$valors = array(1,2,3,4,5,6);
		shuffle($valors);
	?>
<div class="form inicial" id="formulari1">
	<div class="titol2">Selecciona 3 de les 6 propostes</div>
	  <form class="form-signin" name="form" id="form" method="post">
		<input type="hidden" name="id" id="id" value="<?=$pregunta;?>"/>
		<input type="hidden" name="pas" id="pas" value="3"/>
		<input type="hidden" name="cod1" id="cod1" value="<?=$dni;?>"/>
		<input type="hidden" name="cod2" id="cod2" value="<?=$data;?>"/>
		<input type="hidden" name="cod3" id="cod3" value="<?=$pass;?>"/>
		<input type="hidden" id="idVotant" name="idVotant" value="<?=$idVotant;?>"/>		
		<input type="hidden" name="valor" id="valor" value="-1"/>
		<input type="hidden" name="valor1" id="valor1" value="-1"/>
		<input type="hidden" name="valor2" id="valor2" value="-1"/>
		<input type="hidden" name="valor3" id="valor3" value="-1"/>
		<div style="display:block;margin-top:50px;">
			<div style="display:block;float:left;width:5%">
				&nbsp;&nbsp;
			</div>		
			<div class="blockfotos">
			<div>
<?php
$iCont = 0;
while ($iCont < 6)
{
	if ($valors[$iCont]=="1") { $img = "opcio1.png"; $valOp = "1"; }
	elseif ($valors[$iCont]=="2") { $img = "opcio2.png"; $valOp = "2"; }
	elseif ($valors[$iCont]=="3") { $img = "opcio3.png"; $valOp = "3"; }
	elseif ($valors[$iCont]=="4") { $img = "opcio4.png"; $valOp = "4"; }
	elseif ($valors[$iCont]=="5") { $img = "opcio5.png"; $valOp = "5"; }
	elseif ($valors[$iCont]=="6") { $img = "opcio6.png"; $valOp = "6"; }
?>	
			<div class="img" id="<?=$valOp;?>"> <a><img src="/img/<?=$img;?>" width="100%" height="100%"></a></div>
<?php
		$iCont++;
}
?>
			</div>
			</div>
	  </form>
	</div>	
 			
	<div style="background-color:#ff0000">
			<div style="float:left;width:25%">
				<button class="btn btn-lg btn-primary btn-block" type="button"  onclick="cancelar('<?=$pregunta;?>','1a');" id="botoEndarrera">Enrere</button>
			</div>
				
			<div style="display:block;float:left;width:25%">
				<button class="btn btn-lg btn-primary btn-block endavant" type="submit"  onclick="validarOpcions();" id="botoEndavant">Continuar</button>
			</div>			
	</div>		
</div>

 
 <div class="avis3de6" id="avis3de6" style="display:none;">
	<div style="width:100%">Heu de seleccionar 3 opcions</div>
		<button type="button"  onclick="amagarDiv();" id="botoTancarDiv" class="botoTancarDiv">Continuar</button>
</div>
	<script>

	
	$(document).ready(function(){
		$(".img").click(function(){
		 
			if ( $( this).hasClass( "img-selected" ) )
			{
				$(this).removeClass("img-selected");
				return;
			}	 

			if ($('.img-selected').length>2) 
			{
				jQuery('#avis3de6').css('display','block');
					$(".img").each(function(){
						if ( $( this).hasClass( "img-selected" ) ) { $(this).removeClass("img-selected"); }
					});
				return;
			}
			if ( $( this).hasClass( "img-selected" ) ) {
				$(this).removeClass("img-selected");
			}
			else
			{
				$(this).addClass("img-selected");
			}
		});
	});
	</script>
<?php
	}//fi mostrar resultats x triar
}
//3-Confirmació tria
else if ($_REQUEST["pas"]==3)
{
	//echo "DNI" . $_SESSION["dni"] . "- DATA:" . $data;
	//Mostrar resum
	$idVotant = $_REQUEST["idVotant"];
	$valor1 = $_REQUEST["valor1"];
	$valor2 = $_REQUEST["valor2"];
	$valor3 = $_REQUEST["valor3"];
	$cod1 = $_REQUEST["cod1"];
	$cod2 = $_REQUEST["cod2"];
	$cod3 = $_REQUEST["cod3"];
	$valors = array($valor1,$valor2,$valor3);
	$pregunta = $pregunta;
	
	if ($_REQUEST["cod1"]=="") $cod1 = $_SESSION["dni"];
	if ($_REQUEST["cod2"]=="") $cod2 = $_SESSION["data"];

	$_SESSION["dni"] = $cod1;
	$_SESSION["data"] = $cod2;
	$_SESSION["pass"] = $cod3;
	$_SESSION["pregunta"] = $pregunta;

	$opcio1  = "opcio" . $valor1. ".png";
	$opcio2  = "opcio" . $valor2. ".png";
	$opcio3  = "opcio" . $valor3. ".png";
?>	

<div class="form inicial" id="formulari1">
	<div class="titol2">Has triat aquestes 3 respostes<br/><br/>És correcte?</div>	
		<form class="form-signin" name="form" id="form" method="post">
			<input type="hidden" name="id" id="id" value="<?=$pregunta;?>"/>
			<input type="hidden" name="pas" id="pas" value="4"/>
			<input type="hidden" name="cod1" id="cod1" value="<?=$cod1;?>"/>
			<input type="hidden" name="cod2" id="cod2" value="<?=$cod2;?>"/>
			<input type="hidden" name="cod3" id="cod3" value="<?=$cod3;?>"/>
			<input type="hidden" id="idVotant" name="idVotant" value="<?=$idVotant;?>"/>		
			<input type="hidden" name="valor" id="valor" value="-1"/>
			<input type="hidden" name="valor1" id="valor1" value="<?=$valor1;?>"/>
			<input type="hidden" name="valor2" id="valor2" value="<?=$valor2;?>"/>
			<input type="hidden" name="valor3" id="valor3" value="<?=$valor3;?>"/>
			<div style="display:block;margin-top:60px;background:#00ffff;">
				<div class="blockfotos2">			
					<div class="img2" id="<?=$valor1;?>"><img src="/img/<?=$opcio1;?>"  width="100%" height="100%"></div>
					<div class="img2" id="<?=$valor2;?>"><img src="/img/<?=$opcio2;?>"  width="100%" height="100%"></div>
					<div class="img2" id="<?=$valor3;?>"><img src="/img/<?=$opcio3;?>"  width="100%" height="100%"></div>
				</div>
			</div>
			<div class="clear"></div>
		</form>
	</div>
	<div style="background-color:#ff0000" id="confirmacio" name="confirmacio">	
		<div style="float:left;width:25%">
			<button class="btn btn-lg btn-primary btn-block" type="button"  onclick="cancelar('<?=$pregunta;?>','2');" id="botoEndarrera">No</button>
		</div>
			
		<div style="display:block;float:left;width:25%">
			<button class="btn btn-lg btn-primary btn-block endavant" type="button"  onclick="validarVotacio();" id="botoEndavant">Si</button>
		</div>			
	</div>		

	  
<?php	  
}
//4-Passar a votar
else if ($_REQUEST["pas"]==4)
{
	global $conn,$link;
	$constantTaula1 = 1714;
	$constantTaula2 = 789;

	//Mostrar resum
	$idVotant = $_REQUEST["idVotant"];
	$valor1 = $_REQUEST["valor1"];
	$valor2 = $_REQUEST["valor2"];
	$valor3 = $_REQUEST["valor3"];
	$cod1 = $_REQUEST["cod1"];
	$cod2 = $_REQUEST["cod2"];
	$pass = $_REQUEST["cod3"];	
	

	$dni = $_SESSION["dni"];
	if ($dni=="") $dni = $cod1;
	$data = $_SESSION["data"];
	if ($data=="") $data = $cod2;
	$pass = $_SESSION["pass"];
	if ($pass=="") $pass = $cod3;
	$pregunta = $_SESSION["pregunta"];	

	$correcte = 0;
	//Mirar que pugui votar encara...
	$resposta =  verificarSiPotVotar($dni,$data,$pass,$pregunta,$entitat);	
	//echo $resposta;
	if ($resposta=="VOTAR") $correcte = 1;

	$_SESSION["dni"]="";
	$_SESSION["data"]="";
	$_SESSION["pass"]="";
	
	if ($correcte)
	{
		
		
		$hash1 = hash("sha256",$dni);
		$hash2 = hash("sha256",$data);		
		$campATrobar = hash("sha256",$hash1 .  $hash2 . $constantTaula1);
		
		$sql = "SELECT id FROM 1_censLocal WHERE  idControl = '" . $campATrobar. "'";
		$results = $conn->Select($sql,$link);
		$row = mysqli_fetch_array($results);
		if ($row[0] < 10500000) 
		{
			$valor = 10500000;
		}
		$valor = $valor + 23;

		
		
		//recuperar keypublica entitat
		$sql = "SELECT sKeyPublica FROM 0_entitats WHERE id = " . $entitat;
		$results = $conn->Select($sql,$link);
		$row = mysqli_fetch_array($results);
		$keyPublica = $row[0];


		//edat
		$edat = date("Y") - substr($data,0,4);
		$cadenaAEscriure =  "##" . $valor1 . "-"  . $valor2 . "-" . $valor3. "##" . $edat . "##" . time() . "##";
		$retorn = openssl_public_encrypt($cadenaAEscriure, $cadenaEncriptada, $keyPublica);
		
		$sql = "UPDATE 1_censLocal SET iVotat = 1 WHERE idControl = '" . $campATrobar . "'";
		$conn->Select($sql,$link);

		$idSeguretat = hash ("sha256",dechex($valor) . $cadenaAEscriure . $constantTaula2);
		$sql = "INSERT INTO 2_blockchain (idPublica,sInformacio,idSeguretat) VALUES ('" . dechex($valor) . "','" . base64_encode($cadenaEncriptada) . "','" . $idSeguretat . "')";
		$conn->Select($sql,$link);		

		//Crida via API per l'enviament a la cadena Blockchain
		//apiKey="#################";
		//$url = "#################";
		$resultat = file_get_contents($url);
		
		if (substr($resultat,0,2)=="0x")
		{
			//OK
			$sql = "UPDATE 2_blockchain SET iValidat = 1 WHERE idSeguretat = '" . $idSeguretat . "'";
			$conn->Select($sql,$link);
		}
		else
		{
			$correcte = 0;
			$sql = "UPDATE 1_censLocal SET iVotat = 0 WHERE idControl = '" . $campATrobar . "'";
			$conn->Select($sql,$link);
			$sql = "DELETE FROM 2_blockchain WHERE idSeguretat = '" . $idSeguretat . "'";
			$conn->Select($sql,$link);			
		}
		
		if ($correcte)
		{
			
?>	

<div class="form inicial formulari1" style="margin-top:20px">
	<form class="login-form" name="form" id="form" method="post">
		<div class="titol1Final">Aquest és el teu justificant de vot</div>
		<div class="titol1FinalJ" style="color:#f1e434"><strong><a href="https://sepolia.etherscan.io/tx/<?=$resultat;?>" target="_blank" style="color:#f1e434"><?=dechex($valor);?></a></strong></div>
		<div class="titol1Final">Apunta-te'l en algun lloc</div>
		<div class="titol1Final">Gràcies per haver participat</div>
		<div class="logos" style="margin-top:30px">
			<img src="css/solucions-ample.jpg" style="width:90%">
		</div>
		<input type="hidden" name="pas" id="pas" value="5"/>
		<input type="hidden" name="valor" id="valor" value="5"/>
	</form>
</div>	
<?php
		echo "<button class=\"btn btn-lg btn-primary btn-block endavant\" type=\"button\"  onclick=\"endavant('5');\" id=\"botoEndavant\">Continuar</button>";
		}
		else
		{
			$resultat = '<div class="titol1">Error en la votació</div>
		<div class="titol2">Impossible realitzar el vot, torneu a començar.</div>';
			echo $resultat;
			echo "<button class=\"btn btn-lg btn-primary btn-block endavant\" type=\"button\"  onclick=\"cancelar('" . $pregunta . "','0');\" id=\"botoEndavant\">Finalitzar</button>";
		}
	}
	else
	{
			$resultat = '<div class="titol1">Error en la votació</div>
		<div class="titol2">Impossible realitzar el vot, torneu a començar.</div>';
			echo $resultat;
			echo "<button class=\"btn btn-lg btn-primary btn-block endavant\" type=\"button\"  onclick=\"cancelar('" . $pregunta . "','0');\" id=\"botoEndavant\">Finalitzar</button>";
	}
?>

 <?php
}
?>
<div class="ajunt" id="ajunt" style="z-index:-1"></div>	  	
<?php
footer();
?>
