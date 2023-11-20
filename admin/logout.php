<?php
include "funcions.php";
$pagina="index";
$_SESSION["acces"]="-1";
$_SESSION["missatge"]="<strong>Sesió tancada</strong>";
$_SESSION["usuari"]="";
/*                        setcookie("btcUser", "", time()+1,"/","");
                        setcookie("bctPass", "", time()+1,"/",""); */
$_SESSION["jahaviaentrat"]=1;						
						//exit;
						
echo "<script>javascript:location.href='index.php';</script>";
?>