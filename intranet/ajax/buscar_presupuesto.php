<?php
include("../../conexion.php");

$respuesta = new stdClass();
$respuesta->contestacion=1;

$id_presupuesto=(int)$_POST["id_presupuesto"];


if ($id_presupuesto == 0)
{
	$respuesta->mensaje="Debes especificar un número de presupuesto (numérico) para realizar la búsqueda";
}
else
{
	 
	$result=$mysqli->query("SELECT id_presupuesto FROM presupuestos WHERE id_presupuesto=$id_presupuesto");
	
	
	if ($result->num_rows)
	{
		$respuesta->contestacion=0;
		$respuesta->mensaje="Presupuesto encontrado";
		$respuesta->id=$id_presupuesto;
	}
	else
	{
	   $respuesta->contestacion=1;
	   $respuesta->mensaje="No se ha encontrado ningún presupuesto con ID $id_presupuesto";
	}
	
}
echo json_encode($respuesta);	
	
?>