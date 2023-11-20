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
			<h1>GESTIÓ ENTITATS</h1>
			<style>
			.form input
			{
				font-size:1.2em;
			}
			</style>
			<h2 style="text-align:center">NOVA ENTITAT - Insertar dades</h2>
			<form class="login-form" name="form" id="form" method="post" style="width:95%" action="entitatsNew.php" style="font-size:12px">
				<div style="display:block;margin-top:20px;min-height:600px" id="panel1" name="panel1">
				<input type="hidden" id="idUser" name="idUser" class="form-control" placeholder="" value="<?=$_SESSION["id"];?>" required autofocus maxlength="150">
				<div style="width:48%;float:left;padding:15px;">
					Nom entitat
					<input type="text" id="sNom" name="sNom" class="form-control" placeholder="" required autofocus maxlength="150">
						</div>
				<div style="width:23%;float:left;padding:15px;">				
					CIF
					<input type="text" id="sCIF" name="sCIF" class="form-control" placeholder="" required autofocus maxlength="150">
				</div>
				<div style="width:20%;float:left;padding:15px;">				
					Població
					<input type="text" id="sPoblacio" name="sPoblacio" class="form-control" placeholder="" required autofocus maxlength="150">
				</div>
				<div style="width:48%;float:left;padding:15px;">				
					Persona Contacte
					<input type="text" id="sPersona" name="sPersona" class="form-control" placeholder="" required autofocus maxlength="150">
				</div>			
				<div style="width:23%;float:left;padding:15px;">				
					Correu
					<input type="text" id="sEmail" name="sEmail" class="form-control" placeholder="" required autofocus maxlength="150">
				</div>
				<div style="width:20%;float:left;padding:15px;">				
					Telèfon
					<input type="text" id="sTelefon" name="sTelefon" class="form-control" placeholder="" required autofocus maxlength="150">
				</div>
				<br/><br/>	 
				<button  class="boto1" id="boto1">Afegir entitat</button>
			</form>			
			<br/><br/>
			
			<h2>Llistat entitats</h2>
			<table>
			<tr>
			<td><strong>Entitat</strong></td><td>&nbsp;&nbsp;&nbsp;</td><td><strong>Clau pública</strong></td><td>&nbsp;&nbsp;&nbsp;</td><td><strong>Accions</strong></td>
			</tr>
			<?php
			$sql = "SELECT id, sNom, sKeyPublica, sKeyPrivada, sKeyPrivada2 FROM 0_entitats ORDER BY id";
			$results = $conn->Select($sql,$link); 
			while ($row = mysqli_fetch_array($results))
			{
			?>
			<tr><td colspan="5"><hr></td></tr>
			<tr valign="top">
				<td><br><h3><?=$row["sNom"];?></h3></td>	<td>&nbsp;&nbsp;&nbsp;</td>
				<td>PÚBLICA<br/><textarea cols=70 rows=10><?=$row["sKeyPublica"];?></textarea>
				<span id="veure_<?=$row["id"];?>" name="veure_<?=$row["id"];?>" style="display:none">
				<br>PRIVADA (pròpia)<br/><textarea cols=70 rows=10 readonly><?=$row["sKeyPrivada"];?></textarea>
				<br>PRIVADA (entitat)<br/><textarea cols=70 rows=10 readonly><?=$row["sKeyPrivada2"];?></textarea>
				</span>
				</td>	<td>&nbsp;&nbsp;&nbsp;</td>
				<td><br><a onclick="mostrar('<?=$row["id"];?>');" style="cursor:pointer;text-decoration:underline"><strong>Mostrar Keys Privades</strong></a><br/><span style="font-size:0.7">(això no serà accesible versió final)</span></td>
			</tr>

			<?php
			}
			?>
			</table>
			<script>
			function mostrar(valor)
			{
				jQuery('#veure_' + valor).toggle();
			}
			</script>
		</div>
	</div>
</div>
<?php
footer();
?>