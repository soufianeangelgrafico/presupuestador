<?php
include("../../conexion.php");
$email=trim(htmlentities($_POST["email"]));
$id_presupuesto=(int)$_POST["id_presupuesto"];
$dia=$_POST["dia"];
$mes=$_POST["mes"];
$anyo=$_POST["anyo"];
$respuesta = new stdClass();
$respuesta->contestacion=0;


$fecha=$anyo."-".$mes."-".$dia;

$result=$mysqli->query("SELECT id FROM calendario WHERE fecha='$fecha'");

if ($result->num_rows)
{
	while ($arr_result = $result->fetch_array())
		$id=$arr_result["id"];
	
	$respuesta->id=$id;
}
else
{
	$respuesta->contestacion=1;
}




echo json_encode($respuesta);
?>