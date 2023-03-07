<?php
$mysqli = new mysqli("localhost","admin_rehubik","Rehubic2018","admin_rehubik");

if (!isset($_COOKIE["random"]))
  setcookie("random",md5(microtime()), time()+3600, "/"); 	

// Check connection
if ($mysqli -> connect_errno) {
  echo "Fallo al conectar con la base de datos: " . $mysqli -> connect_error;
  exit();
}

$respuesta = new stdClass();

$sesion_temporal=$_COOKIE["random"];
$dibujo2d=$_POST["contenido"];
$elementos_dibujados=$_POST["elementos_dibujados"];
$puertas_ventanas=$_POST["puertas_ventanas"];
$observaciones=$_POST["observaciones"];
$observaciones_texto=$_POST["observaciones_texto"];
	
$mysqli->query("INSERT sesiones_temporales(id_articulo_compuesto,sesion,dibujo_general_actual,dibujo_puertas_ventanas_actual,dibujo_mobiliario_actual,observaciones_dibujo_actual,observaciones_dibujo_actual_txt) VALUES(NULL,'$sesion_temporal','$dibujo2d','$puertas_ventanas','$elementos_dibujados','$observaciones','$observaciones_texto')");

$respuesta->mensaje="Guardado";

echo json_encode($respuesta);

?>