<?php
$respuesta = new stdClass();
$mysqli = new mysqli("localhost","angelgra_rehubic","Montse2016","angelgra_rehubic");
$fecha=$_POST["fecha"];
$respuesta->mensaje="";

$result_fecha=$mysqli->query("SELECT id FROM calendario WHERE fecha='$fecha'");

if ($result_fecha->num_rows)
{
  while ($arr_result_fecha = $result_fecha->fetch_array())
	 $id_calendario=$arr_result_fecha["id"];
	
  $result=$mysqli->query("SELECT * FROM horarios_calendario WHERE id_calendario=$id_calendario AND ocupado=0");
  
  if ($result->num_rows)
  {
	  $respuesta->mensaje="<h4 style='text-align:center;'>Horas disponibles el ".date("d-m-Y",strtotime($fecha))."</h4><form name='cita_previa' id='cita_previa' method='POST' action='#'>";
	  while ($arr_result = $result->fetch_array())
	  {
		  
		  $respuesta->mensaje.="<label><input name='horario' type='radio' value='".$arr_result['id']."'> ".$arr_result["hora"]."</label>";
		  
	  }
	  
	  $respuesta->mensaje.="<p style='margin-top:10px;'><input id='confirmar_cita' type='button' style='width:100%;background:black;color:white' class='btn btn-reverse' value='Confirmar cita'></p>";
	  $respuesta->mensaje.="</form>";
  }
  else
  {
	  $respuesta->mensaje="No hay ninguna hora disponible para la fecha seleccionada";
  }
	
}
else
  $respuesta->mensaje="Fecha no encontrada";

echo json_encode($respuesta);	
?>