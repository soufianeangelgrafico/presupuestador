<?php
$mysqli = new mysqli("localhost","admin_rehubik","Rehubic2018","admin_rehubik");	

// Check connection
if ($mysqli -> connect_errno) {
  echo "Fallo al conectar con la base de datos: " . $mysqli -> connect_error;
  exit();
}

$respuesta = new stdClass();
$respuesta->error=0;
$respuesta->codigo="";
$id_presupuesto=(int)$_GET["id_presupuesto"];
$sc=$mysqli->real_escape_string(trim(htmlentities($_POST["nuevo_sc"],ENT_QUOTES)));
$descripcion=$mysqli->real_escape_string(trim(htmlentities($_POST["descripcion_sc"],ENT_QUOTES)));
$precio=$mysqli->real_escape_string(trim(htmlentities($_POST["precio_sc"],ENT_QUOTES)));

$respuesta->codigo=$sc;

if ($sc == "" || $descripcion == "" || $precio == "")
{
	$respuesta->error=1;
	$respuesta->mensaje="Debes especificar el código, descripción y precio de este SC";
}
else
{
	$result_existe=$mysqli->query("SELECT id FROM sincodigos WHERE codigo='$sc' AND id_presupuesto=$id_presupuesto");
	$result_existe_simple=$mysqli->query("SELECT codigo FROM articulos_simples WHERE codigo='$sc'");
	
	if ($result_existe->num_rows || $result_existe_simple->num_rows)
	{
		$respuesta->error=1;
		$respuesta->mensaje="EL S/C ".$sc." ya existe. Debes especificar otro código";
	}
	else
	{
		$result=$mysqli->query("INSERT sincodigos(codigo,descripcion,precio,id_presupuesto) VALUES('$sc','$descripcion','$precio',$id_presupuesto)");

		if ($result)
		 $respuesta->mensaje="S/C ".$sc." guardado correctamente";
		else
		{
		 $respuesta->mensaje="El S/C ".$sc." no se ha podido guardar. Vuelve a intentarlo";
		 $respuesta->error=0;
		}
	}
}

echo json_encode($respuesta);

?>