<?php
class BD
{
	function Connectarse($tipus="")
	{
		$db_host="localhost"; // Host al que conectar, habitualmente es el _localhost_
		$db_nombre="NOMBRE"; // Nombre de la Base de Datos que se desea utilizar
		$db_user="USUARIO"; // Nombre del usuario con permisos para acceder
		$db_pass="PASS"; // Contraseña de dicho usuario	

        $link=mysqli_connect($db_host, $db_user, $db_pass);
        mysqli_select_db($link,$db_nombre);
		return $link;
	}
	
	function Select($sql,$link)
	{
		$result = mysqli_query($link,$sql);
		return $result;
	} 
}
?>