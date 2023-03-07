<?php
$mysqli = new mysqli("localhost","admin_rehubik","Rehubic2018","admin_rehubik");

if (!isset($_COOKIE["random"]))
  setcookie("random",md5(microtime()), time()+3600, "/"); 	

// Check connection
if ($mysqli -> connect_errno) {
  echo "Fallo al conectar con la base de datos: " . $mysqli -> connect_error;
  exit();
}
$id_presupuesto=(int)$_GET["id_presupuesto"];

$result_id_usuario=$mysqli->query("SELECT id_usuario,png_estado_actual FROM clientes WHERE id_presupuesto=$id_presupuesto AND png_estado_actual != '' ORDER BY id DESC LIMIT 1");

while ($arr_result_id_usuario = $result_id_usuario->fetch_array())
{
  $id_usuario=$arr_result_id_usuario["id_usuario"];
  $png_estado_actual=$arr_result_id_usuario["png_estado_actual"];
}

$result_id_presupuesto=$mysqli->query("SELECT id_presupuesto FROM clientes ORDER BY id_presupuesto DESC LIMIT 1");

while ($arr_result_id_presupuesto = $result_id_presupuesto->fetch_array())
 $id_nuevo_presupuesto=$arr_result_id_presupuesto["id_presupuesto"]+1;

$respuesta = new stdClass();

$dibujo2d=$_POST["contenido"];
$elementos_dibujados=$_POST["elementos_dibujados"];
$puertas_ventanas=$_POST["puertas_ventanas"];
$observaciones=$_POST["observaciones"];
$observaciones_texto=$_POST["observaciones_texto"];	

$mysqli->query("UPDATE clientes SET id_presupuesto=$id_nuevo_presupuesto,png_estado_actual='$png_estado_actual', dibujo_general_reformado='$dibujo2d',dibujo_mobiliario_reformado='$elementos_dibujados',dibujo_puertas_ventanas_reformado='$puertas_ventanas',observaciones_dibujo_reformado='$observaciones',observaciones_dibujo_reformado_txt='$observaciones_texto' WHERE id_presupuesto_modificado=$id_presupuesto AND id_presupuesto IS NULL");


$respuesta->mensaje="Guardado";

echo json_encode($respuesta);

?>