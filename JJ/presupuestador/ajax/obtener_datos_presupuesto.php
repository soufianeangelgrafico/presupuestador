<?php
include("../conexion.php");
$email=trim(htmlentities($_POST["email"]));
$id_presupuesto=(int)$_POST["id_presupuesto"];

$respuesta = new stdClass();
$respuesta->contestacion=0;
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
{
	$respuesta->mensaje="El email no es correcto";
    $respuesta->contestacion=1;
}
else
{
	$result_presupuesto=$mysqli->query("SELECT * FROM presupuestos WHERE id_presupuesto=$id_presupuesto AND email_cliente='$email'");
	//echo "SELECT * FROM presupuestos WHERE id_presupuesto=$id_presupuesto AND email_cliente='$email'";
	if ($result_presupuesto->num_rows)
	{

		$obj_presupuesto = $result_presupuesto->fetch_object();
		$respuesta->id_presupuesto=$obj_presupuesto->id_presupuesto;
		$respuesta->nombre=$obj_presupuesto->nombre_cliente;
		$respuesta->apellidos=$obj_presupuesto->apellidos_cliente;
		$respuesta->direccion=$obj_presupuesto->direccion_cliente;
		$respuesta->cp=$obj_presupuesto->cp_cliente;
		$respuesta->telefono=$obj_presupuesto->telefono_cliente;
		$respuesta->email=$obj_presupuesto->email_cliente;
		$respuesta->poblacion=$obj_presupuesto->poblacion_cliente;
		$respuesta->provincia=$obj_presupuesto->provincia_cliente;
		$respuesta->tiporeforma=$obj_presupuesto->tipo_reforma;
		$respuesta->presupuestoikea=$obj_presupuesto->id_presupuesto;
		$respuesta->elementos_instalacion=$obj_presupuesto->elementos_instalacion;
		$respuesta->dibujo2d=$obj_presupuesto->dibujo2d;

	}
	else
	{
		$respuesta->contestacion = 1;
		$respuesta->mensaje="Error - Tus datos no coinciden";
	}
}
echo json_encode($respuesta);
?>