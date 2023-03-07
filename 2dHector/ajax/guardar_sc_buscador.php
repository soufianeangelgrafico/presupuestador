<?php
$mysqli = new mysqli("localhost","admin_rehubik","Rehubic2018","admin_rehubik");	

// Check connection
if ($mysqli -> connect_errno) {
  echo "Fallo al conectar con la base de datos: " . $mysqli -> connect_error;
  exit();
}

$respuesta = new stdClass();
//$sc almacena algo como:
//MOHSDEM01: Picado y desescombro de t...  (23.0044€)
$sc=$mysqli->real_escape_string(trim(htmlentities($_POST["sc"],ENT_QUOTES)));
$id_presupuesto=(int)$_GET["id_presupuesto"];

$sc_explode = explode(":",$sc);
$codigo_sc=$sc_explode[0]; // MOHSDEM01
$respuesta->error=0;
$respuesta->codigo="";

if ($sc == "" || $id_presupuesto == 0)
{
	$respuesta->error=1;
	$respuesta->mensaje="Error - Debes indicar un S/C del buscador";
}
else
{
	$result=$mysqli->query("SELECT id FROM sincodigos WHERE codigo='$codigo_sc' AND id_presupuesto=".$id_presupuesto);

	if ($result->num_rows)
	{
		$respuesta->error=1;
		$respuesta->mensaje="Ya has añadido el código ".$codigo_sc." en este presupuesto";
	}
	else
	{

		$result_insert=$mysqli->query("INSERT sincodigos(codigo,id_presupuesto,existe) VALUES('$codigo_sc',$id_presupuesto,1)");
		if ($result_insert)
		{
			$respuesta->mensaje="Código ".$codigo_sc." Añadido correctamente";
			$respuesta->codigo=$codigo_sc;
		}
		else
		{
			$respuesta->error=1;
			$respuesta->mensaje="Ocurrió un error al añadir el código ".$codigo_sc." al presupuesto. Vuelve a intentarlo";
		}
	}
}

echo json_encode($respuesta);

?>