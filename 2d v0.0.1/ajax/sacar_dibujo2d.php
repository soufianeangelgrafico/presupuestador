<?php
include("../conexion.php");


$id_presupuesto=(int)$_POST["id_presupuesto"];

$result=$mysqli->query("SELECT html_dibujo_reformado FROM planos WHERE id=".$id_presupuesto);
//echo "SELECT dibujo_general_reformado FROM clientes WHERE id_presupuesto=$id_presupuesto AND dibujo_general_reformado != ''";
//echo "SELECT valor FROM clientes WHERE id_presupuesto=$id_presupuesto AND valor != ''";
while ($arr_result = $result->fetch_array())
{
	$mensaje=$arr_result["html_dibujo_reformado"];
}


echo $mensaje;

?>