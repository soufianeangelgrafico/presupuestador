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
$codigo_sc=$mysqli->real_escape_string(trim(htmlentities($_POST["codigo_sc"],ENT_QUOTES)));
$id_presupuesto=(int)$_GET["id_presupuesto"];

$respuesta->error=0;
$respuesta->codigo="";


$result=$mysqli->query("DELETE sincodigos.* FROM sincodigos WHERE codigo='$codigo_sc' AND id_presupuesto=".$id_presupuesto);

if ($result)
{
	$respuesta->mensaje="S/C Borrado correctamente";
}
else
{
	$respuesta->mensaje="El S/C NO se ha podido eliminar. Vuelve a intentarlo";
}

echo json_encode($respuesta);

?>