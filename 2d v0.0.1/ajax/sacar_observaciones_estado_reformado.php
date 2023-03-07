<?php
$mysqli = new mysqli("localhost","admin_rehubik","Rehubic2018","admin_rehubik");	

// Check connection
if ($mysqli -> connect_errno) {
  echo "Fallo al conectar con la base de datos: " . $mysqli -> connect_error;
  exit();
}

$id_presupuesto=(int)$_POST["id_presupuesto"];

$respuesta = new stdClass();

$result=$mysqli->query("SELECT observaciones_dibujo_reformado FROM clientes WHERE id_presupuesto='$id_presupuesto' AND observaciones_dibujo_reformado != ''");

while ($arr_result = $result->fetch_array())
{
	$respuesta->mensaje=$arr_result["observaciones_dibujo_reformado"];
}


echo json_encode($respuesta);

?>