<?php
include("../../conexion.php");

$very_bad = array("CONCAT","concat","password","PASSWORD","VERSION","version","VALUES","values","NULL","GROUP BY","group by","HEX","hex","WAITFOR","waitfor","BENCHMARK","benchmark","MD5","SHA1","1=1","1=2","delete","update","insert","drop","select","DELETE","UPDATE","INSERT","DROP","SELECT","(","\x00","\x1a","\'","to:","cc:","bcc:","content-type:","mime-version:","multipart-mixed:","content-transfer-enconding:","\r","\n","%0a","%0d",";","=","$","%","<",">","script","@","*","[","]","{","}","^","html","url","_","lyubovnaya");


$verificador=(int)$_POST["verificador"];
$asesor=(int)$_POST["asesor"];
$tipo=$mysqli->real_escape_string(htmlentities($_POST["tipo"],ENT_QUOTES));
$servicio=$mysqli->real_escape_string(htmlentities($_POST["servicio"],ENT_QUOTES));

$id=(int)$_GET["id"];

if ($tipo != "P" && $tipo != "T")
 $tipo="P";

if ($servicio != "C" && $servicio != "B" && $servicio != "I" && $servicio != "M" && $servicio != "P")
 $servicio="M";


$respuesta = new stdClass();
$respuesta->contestacion=0;

//cambiar 1 por el ID del usuario
 
if ($verificador == 0 && $asesor == 0)
{
  $result=$mysqli->query("UPDATE horarios_calendario SET asignado=NULL,asesor=NULL WHERE id=".$id);	
}
else if ($verificador == 0)
{
  $result=$mysqli->query("UPDATE horarios_calendario SET asignado=NULL WHERE id=".$id);	
}
else if ($asesor == 0)
{
 $result=$mysqli->query("UPDATE horarios_calendario SET asesor=NULL WHERE id=".$id);		
}
else
{	
   $result=$mysqli->query("UPDATE horarios_calendario SET asignado=$verificador,asesor=$asesor,tipo='$tipo',servicio='$servicio' WHERE horarios_calendario.id=".$id);
}

if ($result)
 $respuesta->mensaje="Asignación cambiada correctamente";
else
{
 $respuesta->mensaje="No se ha podido cambiar la asignación. Vuelve a intentarlo";
 $respuesta->contestacion=1;
}
echo json_encode($respuesta);
?>
