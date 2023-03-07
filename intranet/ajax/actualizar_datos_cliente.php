<?php
include("../../conexion.php");

$respuesta = new stdClass();
$respuesta->contestacion=1;

// LISTA NEGRA 
$very_bad = array("CONCAT","concat","password","PASSWORD","VERSION","version","VALUES","values","NULL","GROUP BY","group by","HEX","hex","WAITFOR","waitfor","BENCHMARK","benchmark","MD5","SHA1","1=1","1=2","delete","update","insert","drop","select","DELETE","UPDATE","INSERT","DROP","SELECT","(","\x00","\x1a","\'","to:","cc:","bcc:","content-type:","mime-version:","multipart-mixed:","content-transfer-enconding:","\r","\n","%0a","%0d",";","=","$","%","<",">","script","@","*","[","]","{","}","^","html","url","_","lyubovnaya");

$nombre_cliente=$mysqli->real_escape_string(htmlentities($_POST["nombre_cliente"],ENT_QUOTES));
$apellidos_cliente=$mysqli->real_escape_string(htmlentities($_POST["apellidos_cliente"],ENT_QUOTES));
$direccion_cliente=$mysqli->real_escape_string(htmlentities($_POST["direccion_cliente"],ENT_QUOTES));
$cp_cliente=(int)$_POST["cp_cliente"];
$poblacion_cliente=$mysqli->real_escape_string(htmlentities($_POST["poblacion_cliente"],ENT_QUOTES));
$provincia_cliente=$mysqli->real_escape_string(htmlentities($_POST["provincia_cliente"],ENT_QUOTES));
$telefono_cliente=$mysqli->real_escape_string(htmlentities($_POST["telefono_cliente"],ENT_QUOTES));
$email_cliente=$mysqli->real_escape_string(htmlentities($_POST["email_cliente"],ENT_QUOTES));
$id_presupuesto=(int)$_POST["id_presupuesto"];

 
//$password=encrypt("".$password."","".$semilla."");

if ($nombre_cliente == "")
{
	$respuesta->mensaje="Introduce el nombre del cliente";
}
else if ($apellidos_cliente == "")
{
	$respuesta->mensaje="Introduce los apellidos del cliente";
}
else if ($direccion_cliente == "")
{
	$respuesta->mensaje="Introduce la dirección del cliente";
}
else if ($cp_cliente == 0)
{
	$respuesta->mensaje="Introduce el CP del cliente";
}
else if ($poblacion_cliente == "")
{
	$respuesta->mensaje="Introduce la población del cliente";
}
else if ($provincia_cliente == "")
{
	$respuesta->mensaje="Introduce la provincia del cliente";
}
else if ($telefono_cliente == "")
{
	$respuesta->mensaje="Introduce el teléfono del cliente";
}
else if (!filter_var($email_cliente, FILTER_VALIDATE_EMAIL)) {
	$respuesta->mensaje="El email no es correcto";
}
else if ($id_presupuesto == 0)
{
	$respuesta->mensaje="No se ha podido obtener el ID de presupuesto. Recarga la página y vuelve a intentarlo";
}
else
{
	 
	$result=$mysqli->query("UPDATE presupuestos SET  nombre_cliente='$nombre_cliente',apellidos_cliente='$apellidos_cliente',direccion_cliente='$direccion_cliente',cp_cliente=$cp_cliente,poblacion_cliente='$poblacion_cliente',provincia_cliente='$provincia_cliente',telefono_cliente='$telefono_cliente',email_cliente='$email_cliente' WHERE id_presupuesto=$id_presupuesto");
	
	
	if ($result)
	{
		$respuesta->mensaje="Actualización correcta de los datos del cliente";
	}
	else
	{
	   $respuesta->mensaje="No se ha podido actualizar los datos del cliente. Comprueba todos los campos y vuelve a intentarlo";
	}
	
}
echo json_encode($respuesta);	
	
?>