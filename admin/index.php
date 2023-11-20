<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php
include "funcions.php";
$pagina="index";
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
  <div class="form inicial" style="width:500px">
	<h2 style="font-size:34px">SOLUCIONS BLOCKCHAIN<br/>Votacions</h2>
	<div style="margin-bottom:20px;"><h2 style="font-size:28px">Acces</h2></div>
    <form class="login-form" action="login.php" method="post">
      <input type="text" placeholder="nom" name="user" id="user" value="xavi" style="font-size:20px;"/>
      <input type="password" placeholder="contrasenya" name="pass" id="pass" style="font-size:20px;"/>
	  <br/><br/><br/><br/>
      <button class="boto1" id="boto1">ENTRADA</button>
    </form> 
  </div>
</div>
<?php footer(); ?>