<?php
$mysqli = new mysqli("localhost","admin_rehubik","Rehubic2018","admin_rehubik");	

// Check connection
if ($mysqli -> connect_errno) {
  echo "Fallo al conectar con la base de datos: " . $mysqli -> connect_error;
  exit();
}


$sesion=$_POST["sesion"];

$result=$mysqli->query("SELECT dibujo_general_actual FROM sesiones_temporales WHERE sesion='$sesion' AND dibujo_general_actual != ''");
//echo "SELECT valor FROM clientes WHERE id_presupuesto=$id_presupuesto AND valor != ''";
while ($arr_result = $result->fetch_array())
{
	$mensaje=$arr_result["dibujo_general_actual"];
}


echo $mensaje;

?>