<?php
$mysqli = new mysqli("localhost","admin_rehubik","Rehubic2018","admin_rehubik");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Fallo al conectar con la base de datos: " . $mysqli -> connect_error;
  exit();
}

$respuesta = new stdClass();

// LISTA NEGRA 
$very_bad = array("CONCAT","concat","password","PASSWORD","VERSION","version","VALUES","values","NULL","GROUP BY","group by","HEX","hex","WAITFOR","waitfor","BENCHMARK","benchmark","MD5","SHA1","1=1","1=2","delete","update","insert","drop","select","DELETE","UPDATE","INSERT","DROP","SELECT","(","\x00","\x1a","\'","to:","cc:","bcc:","content-type:","mime-version:","multipart-mixed:","content-transfer-enconding:","\r","\n","%0a","%0d",";","=","$","%","<",">","script","@","*","[","]","{","}","^","html","url","_","lyubovnaya");

$id=$_POST["id"]; //Todas las instalaciones y equipamiento seleccionados separados por comas , 

//Si ya existen las cookies las eliminamos para volver a guardar los elementos seleccionados y calcular su precio
if (isset($_COOKIE["presupuesto"]))
{
	setcookie('presupuesto', null, -1, '/'); 
}
	
if (isset($_COOKIE["precio_final"]))
{
   setcookie('precio_final', null, -1, '/'); 
}

if ($id != "")
{
	
	$respuesta->contestacion=0;
	
	$elementos_id = explode(",", $id);
	$txt_elementos_seleccionados="";
	$suma_precio=0;
	
	for ($i=0;$i<count($elementos_id);$i++)
	{
	  $id_elemento=$mysqli->real_escape_string(htmlentities($elementos_id[$i],ENT_QUOTES));
		
	  $result=$mysqli->query("SELECT id FROM articulos_compuestos WHERE id_imagen='$id_elemento'");
	
	  while ($arr_result = $result->fetch_array())
	     $id_articulo_compuesto=$arr_result["id"];
		
	
	   $result_articulo_simple=$mysqli->query("SELECT id,codigo,precio,descripcion FROM articulos_simples WHERE id_articulo_compuesto=$id_articulo_compuesto");
	   
	   
	   while ($arr_result_articulo_simple = $result_articulo_simple->fetch_array())
	   {
		   	$codigo=$arr_result_articulo_simple["codigo"];
		    $precio=$arr_result_articulo_simple["precio"];
		    $descripcion=$arr_result_articulo_simple["descripcion"];

		    $suma_precio=$suma_precio+$precio;
		    $txt_elementos_seleccionados=$txt_elementos_seleccionados.$codigo.",".$precio.",".$descripcion.";";
		   
	   }	
		
		
		
	}
	setcookie("presupuesto", $txt_elementos_seleccionados, time()+3600, "/");  /* expira en 1 hora */
	setcookie("precio_final", $suma_precio, time()+3600, "/");  /* expira en 1 hora */
}
else
{
	$respuesta->contestacion=1;
}

	

echo json_encode($respuesta);	
	
?>