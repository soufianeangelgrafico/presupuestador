<?php
include("../../conexion.php");
include ("../../semilla.php");

$respuesta = new stdClass();
$respuesta->contestacion=1;

// LISTA NEGRA 
$very_bad = array("CONCAT","concat","password","PASSWORD","VERSION","version","VALUES","values","NULL","GROUP BY","group by","HEX","hex","WAITFOR","waitfor","BENCHMARK","benchmark","MD5","SHA1","1=1","1=2","delete","update","insert","drop","select","DELETE","UPDATE","INSERT","DROP","SELECT","(","\x00","\x1a","\'","to:","cc:","bcc:","content-type:","mime-version:","multipart-mixed:","content-transfer-enconding:","\r","\n","%0a","%0d",";","=","$","%","<",">","script","@","*","[","]","{","}","^","html","url","_","lyubovnaya");

$email=$mysqli->real_escape_string(htmlentities($_POST["email"],ENT_QUOTES));
$password=encrypt("".$_POST["password"]."","".$semilla."");
 
//$password=encrypt("".$password."","".$semilla."");

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	$respuesta->mensaje="El email no es correcto";
}
else
{
	
	$result=$mysqli->query("SELECT id,tipo FROM administradores WHERE email='$email' AND password='$password'");
	
	if ($result->num_rows)
	{
		
		while ($arr_result = $result->fetch_array())
		{
			
			session_start();
			$_SESSION["login"]=$arr_result["id"];
			$respuesta->contestacion=0;
			$respuesta->rol=$arr_result["tipo"];
		}
		
	}
	else
	 $respuesta->mensaje="Email y/o contraseña incorrectos";
	
}


echo json_encode($respuesta);	
	
?>