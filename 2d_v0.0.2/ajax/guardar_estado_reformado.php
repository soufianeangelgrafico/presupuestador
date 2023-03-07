<?php
include ("../conexion.php");

$respuesta = new stdClass();

$id=(int)$_POST["id"];
$dibujo=$_POST["dibujo"];
$observaciones_texto=$_POST["observaciones_texto"];
$altura_techo=$_POST["altura_techo"];

$mysqli->query("UPDATE planos SET imagen_dibujo_reformad='test' WHERE id=$id");

$respuesta->mensaje="Guardado";

echo json_encode($respuesta);

?>