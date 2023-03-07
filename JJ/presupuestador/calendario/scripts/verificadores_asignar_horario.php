<?php
include("../../conexion.php");
$id_calendario=(int)$_POST["id_calendario"];
$horario=(int)$_POST["horario"]; //0 mañana - 1 tarde - 2 todo el día

$respuesta = new stdClass();
$respuesta->contestacion=0;
 
//cambiar 1 por el ID del usuario
 
if ($horario == 0)
{
 $mysqli->query("UPDATE horarios_calendario SET asignado=1 WHERE id_calendario=$id_calendario AND (hora='10:00-12:00' OR hora='12:00-14:00')");
	//echo "UPDATE horarios_calendario SET asignado=1 WHERE id_calendario=$id_calendario AND (hora='10:00-12:00' OR hora='12:00-14:00')<br/>";
}
else if ($horario == 1)
{
 $mysqli->query("UPDATE horarios_calendario SET asignado=1 WHERE id_calendario=$id_calendario AND hora='16:00-18:00'");	
}
else if ($horario == 2)
{
 $mysqli->query("UPDATE horarios_calendario SET asignado=1 WHERE id_calendario=".$id_calendario);	
}

echo json_encode($respuesta);
?>