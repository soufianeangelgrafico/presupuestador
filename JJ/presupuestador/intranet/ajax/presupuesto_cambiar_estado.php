<?php
include("../../conexion.php");
$respuesta = new stdClass();
$respuesta->contestacion=1;

$id_presupuesto=(int)$_POST["id_presupuesto"];
$estado=(int)$_POST["estado"];


$result=$mysqli->query("SELECT * FROM presupuestos WHERE id_presupuesto=".$id_presupuesto);
$obj_result = $result->fetch_object();

if ($estado == 0)
{
	$txt_estado="Pendiente";
}
else if ($estado == 1)
{
	$txt_estado="Aprobado";
}
else
{
	$txt_estado="Cancelado";
}

$result_update=$mysqli->query("UPDATE presupuestos SET estado=$estado WHERE id_presupuesto=$id_presupuesto");

if ($result_update)
{
   $respuesta->mensaje="Estado cambiado correctamente";
}
else
{
	$respuesta->mensaje="Ocurrió un error al cambiar el estado. Vuelve a intentarlo";
}

echo json_encode($respuesta);
?>