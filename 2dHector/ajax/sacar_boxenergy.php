<?php
$mysqli = new mysqli("localhost","admin_rehubik","Rehubic2018","admin_rehubik");	

// Check connection
if ($mysqli -> connect_errno) {
  echo "Fallo al conectar con la base de datos: " . $mysqli -> connect_error;
  exit();
}

$respuesta = new stdClass();
$id_presupuesto=(int)$_POST["id_presupuesto"];

$result=$mysqli->query("SELECT dibujo_mobiliario_reformado FROM clientes WHERE id_presupuesto=$id_presupuesto AND dibujo_mobiliario_reformado != ''");
//echo "SELECT valor FROM clientes WHERE id_presupuesto=$id_presupuesto AND valor != ''";
while ($arr_result = $result->fetch_array())
{
	$respuesta->mensaje=$arr_result["dibujo_mobiliario_reformado"];
}


echo json_encode($respuesta);

?>