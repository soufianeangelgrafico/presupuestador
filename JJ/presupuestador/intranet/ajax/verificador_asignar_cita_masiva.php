<?php
include("../../conexion.php");
$very_bad = array("CONCAT","concat","password","PASSWORD","VERSION","version","VALUES","values","NULL","GROUP BY","group by","HEX","hex","WAITFOR","waitfor","BENCHMARK","benchmark","MD5","SHA1","1=1","1=2","delete","update","insert","drop","select","DELETE","UPDATE","INSERT","DROP","SELECT","(","\x00","\x1a","\'","to:","cc:","bcc:","content-type:","mime-version:","multipart-mixed:","content-transfer-enconding:","\r","\n","%0a","%0d",";","=","$","%","<",">","script","@","*","[","]","{","}","^","html","url","_","lyubovnaya");

$id_verificador=(int)$_POST["id_verificador"]; //0 ====== NULL
$valor=$_POST["valor"];

$valor=substr($valor,0,-1);

//Este valor contiene ID verificador, fecha, hora e ID centro separado por + . Ejemplo : 1+2020-09-24+9:00+2601
$valor=$mysqli->real_escape_string(htmlentities($_POST["valor"],ENT_QUOTES));
$valores = explode(",", $valor);

$respuesta = new stdClass();
$respuesta->contestacion=0;

//cambiar 1 por el ID del usuario

$error=false;
for ($i=0;$i<count($valores);$i++)
{
	
	$valor_calendario = explode("+", $valores[$i]);
	
	$fecha=$valor_calendario[0];
	$hora=$valor_calendario[1];
	$id_centro=$valor_calendario[2];
	
	$result_fecha_creada=$mysqli->query("SELECT id FROM horarios_calendario WHERE id_centro=$id_centro AND fecha='$fecha' AND hora='$hora'");
	 
	if ($result_fecha_creada->num_rows)
    {
	  //Update	

	  if ($id_verificador == 0)
	    $mysqli->query("UPDATE horarios_calendario SET asignado=NULL WHERE horarios_calendario.fecha='$fecha' AND hora='$hora' AND id_centro=$id_centro");
	  else
	    $mysqli->query("UPDATE horarios_calendario SET asignado=$id_verificador WHERE horarios_calendario.fecha='$fecha' AND hora='$hora' AND id_centro=$id_centro");
		
		
	}
	else
	{
		//Insert
		$mysqli->query("INSERT horarios_calendario(id_centro,fecha,hora,ocupado,asignado) VALUES($id_centro,'$fecha','$hora',0,$id_verificador)");
	}
	
	
}

 $respuesta->mensaje="Asignaciones masivas realizadas";

echo json_encode($respuesta);
?>