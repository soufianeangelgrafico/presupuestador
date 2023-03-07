<?php
$mysqli = new mysqli("localhost","admin_rehubik","Rehubic2018","admin_rehubik");	

// Check connection
if ($mysqli -> connect_errno) {
  echo "Fallo al conectar con la base de datos: " . $mysqli -> connect_error;
  exit();
}


$id_presupuesto=(int)$_POST["id_presupuesto"];

$result=$mysqli->query("SELECT dibujo_general_reformado FROM clientes WHERE id_presupuesto=$id_presupuesto AND dibujo_general_reformado != ''");
//echo "SELECT dibujo_general_reformado FROM clientes WHERE id_presupuesto=$id_presupuesto AND dibujo_general_reformado != ''";
//echo "SELECT valor FROM clientes WHERE id_presupuesto=$id_presupuesto AND valor != ''";
while ($arr_result = $result->fetch_array())
{
	$mensaje=$arr_result["dibujo_general_reformado"];
}


echo $mensaje;

?>