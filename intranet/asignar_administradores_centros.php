<?php
session_start();
if (!isset($_SESSION["login"]))
 header("Location:index.php");

include("../conexion.php");

$result=$mysqli->query("SELECT id FROM administradores");

while ($arr_result = $result->fetch_array())	
{
	
	echo "INSERT administradores_centros(id_centro,id_administrador) VALUES (8119,".$arr_result['id'].");<br/>";
	echo "INSERT administradores_centros(id_centro,id_administrador) VALUES (8120,".$arr_result['id'].");<br/>";
	echo "INSERT administradores_centros(id_centro,id_administrador) VALUES (8121,".$arr_result['id'].");<br/>";
	
}



echo htmlspecialchars_decode($obj_presupuesto->dibujo2d);
?>