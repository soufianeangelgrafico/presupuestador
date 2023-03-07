<?php
include("../conexion.php");

$respuesta = array();

$result=$mysqli->query("SELECT codigo,descripcion,precio FROM articulos_simples WHERE id_articulo_compuesto=47");
$contador=0;
while ($arr_result = $result->fetch_array())
{
	
	$respuesta[$contador]=$arr_result["codigo"].": ".utf8_encode(substr($arr_result["descripcion"],0,25))."...  (".$arr_result['precio']."€)";
	$contador++;

}

//print_r($respuesta);

echo json_encode($respuesta);

?>