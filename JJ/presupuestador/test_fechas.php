<?php
$mysqli = new mysqli('localhost', 'admin_rehubik', 'Rehubic2018', 'admin_rehubik');

if ($mysqli->connect_error) {
    die('Error de conexión: ' . $mysqli->connect_error);
}

//Saco todas las fechas disponibles de la BD
$result=$mysqli->query("SELECT DISTINCT fecha FROM horarios_calendario WHERE fecha > '".date("Y-m-d")."'");


while ($arr_result = $result->fetch_array())
{
	$fecha=$arr_result["fecha"]; //fecha
	$hora_inicio="9:00"; //Hora inicio
	do
	{
	  //Hago todo este bloque mientras la hora esté comprendida entre las 9:00 y 17:40
		
	  $suma_tiempo = strtotime("+20 minutes", strtotime($hora_inicio)); //Sumo 20 minutos a la hora de inicio
	  $hora_inicio=date("H:i",$suma_tiempo); //Almaceno en $hora_inicio el tiempo sumado
	  $fecha_final=$fecha." ".$hora_inicio; //Fecha completa YYYY-MM-DD HH:II:SS
	  
	  //fecha_explode[0] la fecha y fecha_explode[1] la hora
	  $fecha_explode=explode(" ",$fecha_final);
	  //echo $fecha_explode[0]." ".$fecha_explode[1]."<br>";
	  
	  //Hay que cambiar ID centro: 2601,2700,2701,2707,2708
	  echo "INSERT  horarios_calendario(id_centro,fecha,hora,ocupado,asignado,asesor,tipo,servicio) VALUES (2601,'$fecha_explode[0]','$fecha_explode[1]',0,NULL,NULL,'T','M');<br/>";
		
	} while ($hora_inicio > "09:00" && $hora_inicio < "17:40");
	
}
?>