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
$metros_ancho=$_POST["metros_ancho"];
$metros_alto=$_POST["metros_alto"];
$observaciones_texto=$_POST["observaciones_texto"];

$mysqli->query("INSERT sesiones_temporales(id_articulo_compuesto,sesion,dibujo_general_reformado,dibujo_mobiliario_reformado,dibujo_puertas_ventanas_reformado,observaciones_dibujo_reformado,observaciones_dibujo_reformado_txt,metros_ancho_reformado,metros_alto_reformado) VALUES(NULL,'$sesion_temporal','$dibujo2d','$elementos_dibujados','$puertas_ventanas','$observaciones','$observaciones_texto','$metros_ancho','$metros_alto')");

$respuesta->mensaje="Guardado";

echo json_encode($respuesta);

?>