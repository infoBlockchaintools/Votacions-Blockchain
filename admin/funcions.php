<?php
include "bd.php";
global $conn;
$conn=new BD();
global $link;
$link = $conn->Connectarse();

function encrypt($string, $key='Change this key to something else') {
    $result = '';
    for($i=0; $i<strlen($string); $i++) {
        $char = substr($string, $i, 1);
        $keychar = substr($key, ($i % strlen($key))-1, 1);
        $ordChar = ord($char);
        $ordKeychar = ord($keychar);
        $sum = $ordChar + $ordKeychar;
        $char = chr($sum);
        $result.=$char;
    }
    return base64_encode($result);
}


function decrypt($string, $key='Change this key to something else') {
    $result = '';
    $string = base64_decode($string);
    for($i=0; $i<strlen($string); $i++) {
        $char = substr($string, $i, 1);
        $keychar = substr($key, ($i % strlen($key))-1, 1);
        $ordChar = ord($char);
        $ordKeychar = ord($keychar);
        $sum = $ordChar - $ordKeychar;
        $char = chr($sum);
        $result.=$char;
    }
    return $result;
}

function headerr($pagina)
{
	
echo '<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>BLOCKCHAIN TOOLS - Votacions</title>
';
if ($pagina == "index") echo '	<link rel="stylesheet" href="css/style.css">
';
 else
	echo '
	<style>	
.form {
  position: relative;
  z-index: 1;
  background: #FFFFFF;
  max-width: 660px;
  margin: 0 auto 100px;
  padding: 45px;
  text-align: center;
  
}
.form input {

  font-family: "Raleway", sans-serif;
  outline: 0;
  background: #f2f2f2;
  width: 100%;
  border: 0;
  margin: 0 0 15px;
  padding: 15px;
  box-sizing: border-box;
  font-size: 14px;
}
.form button {
  font-family: "Open Sans", sans-serif;
  text-transform: uppercase;
  outline: 0;
  background: #008dd6;
  width: 100%;
  border: 0;
  padding: 15px;
  color: #FFFFFF;
  font-size: 14px;
  -webkit-transition: all 0.3 ease;
  transition: all 0.3 ease;
  cursor: pointer;
}
.form button:hover,.form button:active,.form button:focus {
  background: #045b88;
}
.form .message {
  margin: 15px 0 0;
  color: #b3b3b3;
  font-size: 12px;
}
.form .message a {
  color: #008dd6;
  text-decoration: none;
}
.form .register-form {
  display: none;
}
</style>		
';    
    echo '<style>
	body {
	font-family: \'Open Sans\', Arial, sans-serif;
	color: #7c8d87;
	

}	

.missatge{
	width:50%;
	
	color:#013550;
	font-size:20px;
	text-align:center;
	
	margin:auto;
	margin-bottom:20px;

}

</style>
  </head> 
 <body>
<!--<div class="capsalera"><a href="panel.php"><img src="/dist/img/efs.png"></a></div> -->
  ';
}	




function panellUser()
{
	echo '<div class="menu-sup">';
	echo '<div class="menu1">' . "<a href=\"panel.php\" title=\"HOME\">HOME</a>" . "</div>";
	echo '<div class="menu2">' . "<a href=\"logout.php\" title=\"Sortir\">Sortir</a>" . "</div>";
	echo '</div>';
}

?> 