<?php
include ("../conexion.php");

$respuesta = new stdClass();

$id=(int)$_POST["id"];
$dibujo=$_POST["dibujo"];
$observaciones_texto=$_POST["observaciones_texto"];

$mysqli->query("UPDATE planos SET html_dibujo_actual='$dibujo',altura_techo_actual='$altura_techo',observaciones_estado_actual='$observaciones_texto' WHERE id=$id");

$respuesta->mensaje="Guardado";

echo json_encode($respuesta);

?>