<?php
include "funcions.php";
$pagina="index";
headerr($pagina);
//$comisio = 0.96;
/*
if ($_SESSION["acces"]!=2)
{
	echo "<script>javascript:location.href='index.php';</script>";
}*/

global $conn;
global $link;

$cadena="";
//Mirar si grabar
if (isset($_REQUEST["sNom"]))
{
	$res=openssl_pkey_new();
	// Get private key
	openssl_pkey_export($res, $privatekey);

	// Get public key
	$publickey=openssl_pkey_get_details($res);
	$publickey=$publickey["key"];
/*
	echo "Genero clau privada:<BR>$privatekey<br><br>Clau pública:<BR>$publickey<BR><BR>";

$cleartext = '1234 5678 9012 3456';

echo "Text inicial:<br>$cleartext<BR><BR>";

openssl_public_encrypt($cleartext, $crypttext, $publickey);

echo "Text encriptat:<br>$crypttext<BR><BR>";

openssl_private_decrypt($crypttext, $decrypted, $privatekey);
echo "Text desencriptat:<BR>$decrypted<br><br>"; */

$tamany = strlen($privatekey);
//echo "TAMANY:" . $tamany; 

$mig = $tamany / 2;
$sKeyPrivada = substr($privatekey,0,$mig);
$sKeyPrivada2 = substr($privatekey,$mig);

?>
		<div class="container">

			<div class="component">
<?php panellUser(); ?>	
  <div class="form inicial">
<h1>GESTIÓ ENTITATS</h1>

<h2 style="text-align:center">NOVA ENTITAT CREADA</h2>

<div class="clauEntitat">
<h2>Segona part clau privada. A enviar a l'entitat</h2>
<textarea rows=20 cols=70><?=$sKeyPrivada2;?></textarea>
</div>
<br><br>
<a href="clauPrivada.txt" target="_blank">BAIXAR FITXER PER L'ENTITAT</a>
<br><br>
<?php
$archivo = fopen('clauPrivada.txt','w');
fputs($archivo,$sKeyPrivada2); 
fclose($archivo); 

$sNom = $_REQUEST["sNom"];
$sCIF = $_REQUEST["sCIF"];
$sPoblacio = $_REQUEST["sPoblacio"];
$sEmail = $_REQUEST["sEmail"];
$sTelefon = $_REQUEST["sTelefon"];
$sPersona = $_REQUEST["sPersona"];
/*
		$sql =" INSERT 0_entitats (id,sNom,sKeyPublica,sKeyPrivada,sKeyPrivada2) VALUES 
		(NULL,'" .
		$_REQUEST["sNom"] . "','" .
		$publickey  . "','" .
		$sKeyPrivada  . "','" .
		$sKeyPrivada2  . "')";
		*/
		$sql =" INSERT 0_entitats (id,sNom,sCIF,sPoblacio,sEmail,sTelefon,sPersona,sKeyPublica,sKeyPrivada,sKeyPrivada2) VALUES 
		(NULL,'" .
		$sNom . "','" .
		$sCIF . "','" .
		$sPoblacio . "','" .
		$sEmail . "','" .
		$sTelefon . "','" .
		$sPersona . "','" .
		$publickey  . "','" .
		$sKeyPrivada  . "','" .
		$sKeyPrivada2  . "')";		
		//strtotime($_REQUEST["iData"]) . "," . $_REQUEST["iImport"] . ",'" . $_REQUEST["sBanc"] . "')";
		$conn->Select($sql,$link);	
	//
?>
	<form class="login-form" action="panel.php" method="post">
<button class="boto1" id="boto1">TORNAR AL INICI</button>
</form>
<?php	
	//echo "<script>javascript:location.href='panel.php';</script>";		
	

}

