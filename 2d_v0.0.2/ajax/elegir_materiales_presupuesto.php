<?php
$sesion_temporal=$_COOKIE["random"];
$id=$_POST["id"];

$mysqli = new mysqli("localhost","admin_rehubik","Rehubic2018","admin_rehubik");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Fallo al conectar con la base de datos: " . $mysqli -> connect_error;
  exit();
}

$respuesta = new stdClass();

// LISTA NEGRA 
$very_bad = array("CONCAT","concat","password","PASSWORD","VERSION","version","VALUES","values","NULL","GROUP BY","group by","HEX","hex","WAITFOR","waitfor","BENCHMARK","benchmark","MD5","SHA1","1=1","1=2","delete","update","insert","drop","select","DELETE","UPDATE","INSERT","DROP","SELECT","(","\x00","\x1a","\'","to:","cc:","bcc:","content-type:","mime-version:","multipart-mixed:","content-transfer-enconding:","\r","\n","%0a","%0d",";","=","$","%","<",">","script","@","*","[","]","{","}","^","html","url","_","lyubovnaya");

$id=str_replace($very_bad,'',$id);

$result_material=$mysqli->query("SELECT * FROM materiales WHERE referencia='$id'");	

if ($result_material->num_rows)
{
	while ($arr_result_material = $result_material->fetch_array())
	{
		
		$precio=$arr_result_material["pvp"];
		
		$mysqli->query("INSERT sesiones_temporales(referencia_material,sesion) VALUES('$id','$sesion_temporal')");
		
	}
	
	$respuesta->mensaje="Materiales añadidos al presupuesto";
}
else
{
  $respuesta->mensaje="Referencia $id no encontrada";	
}

$mysqli->query("INSERT sesiones_temporales(id_articulo_compuesto,sesion,paredes) VALUES($id_articulo_compuesto,'$sesion_temporal','$pared_actual')");


echo json_encode($respuesta);	
	
?>