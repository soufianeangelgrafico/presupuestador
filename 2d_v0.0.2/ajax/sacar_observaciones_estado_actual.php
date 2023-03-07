<?php
$mysqli = new mysqli("localhost","admin_rehubik","Rehubic2018","admin_rehubik");	

// Check connection
if ($mysqli -> connect_errno) {
  echo "Fallo al conectar con la base de datos: " . $mysqli -> connect_error;
  exit();
}

$respuesta = new stdClass();
$sesion=$_POST["sesion"];

$result=$mysqli->query("SELECT observaciones_dibujo_actual FROM sesiones_temporales WHERE sesion='$sesion' AND observaciones_dibujo_actual != ''");

while ($arr_result = $result->fetch_array())
{
	$respuesta->mensaje=$arr_result["observaciones_dibujo_actual"];
}


echo json_encode($respuesta);

?>