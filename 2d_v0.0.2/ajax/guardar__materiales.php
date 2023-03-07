<?php
include ("../conexion.php");

$respuesta = new stdClass();

$id=(int)$_POST["id"];
$dibujo=$_POST["dibujo"];

$mysqli->query("UPDATE planos SET imagen_dibujo_reformad='test' WHERE id=$id");

$respuesta->mensaje="Guardado";

echo json_encode($respuesta);

?>