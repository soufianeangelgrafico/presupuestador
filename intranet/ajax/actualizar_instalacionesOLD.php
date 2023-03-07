<?php
include("../../conexion.php");

$respuesta = new stdClass();
$respuesta->contestacion=1;

$id_presupuesto=(int)$_POST["id_presupuesto"];
$elementos_instalacion=trim(htmlentities($_POST["elementos_instalacion"])); //Elementos de la obra que quiere instalar separados por COMAS
$elementos_instalacion=substr($elementos_instalacion,0,-1);
 
//$password=encrypt("".$password."","".$semilla."");

if ($elementos_instalacion == "")
{
	$respuesta->mensaje="Debes seleccionar al menos un elemento de instalación y obras";
}
else if ($id_presupuesto == 0)
{
	$respuesta->mensaje="No se ha podido obtener el ID de presupuesto. Recarga la página y vuelve a intentarlo";
}
else
{
	 
	$result=$mysqli->query("UPDATE presupuestos SET elementos_instalacion='$elementos_instalacion' WHERE id_presupuesto=$id_presupuesto");
	
	
	if ($result)
	{
		$respuesta->mensaje="Actualización correcta de instalación y obra";
	}
	else
	{
	   $respuesta->mensaje="No se ha podido actualizar los datos de instalación y obra. Comprueba tu selección y vuelve a intentarlo";
	}
	
}
echo json_encode($respuesta);	
	
?>