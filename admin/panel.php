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
<?php
if ($_SESSION["missatge"]!="")
{
?>
<div class="missatge">
<?php	
echo $_SESSION["missatge"];
$_SESSION["missatge"]="";
?>
</div>
<?php
}

?>	
		<div class="clear"></div>
		<div class="form inicial" style="text-align:left">
		  <h1>OPCIONS PRINCIPALS</h1>
		  <ul>
		  <li><a href="entitats.php">GESTIÓ D'ENTITATS</a></li>
		  </ul>
		  <ul>
			  <li><a href="importador.php">Importador CENS Global</a></li>
			  <li><a href="votacions.php">Importar CENS per Nova votació</a></li>
			  <li><a href="registrarse.php">Registrar-se</a></li>
			  <li><a href="restablir.php">Restablir Usuari</a></li>
		  </ul>
		  <ul>
			<li><a href="escrutini.php">Generar ESCRUTINI</a></li>
			<li><a href="reiniciar.php">Reiniciar Votacions</a></li>
		  </ul> 
		</div>
	</div>
<?php footer(); ?>   