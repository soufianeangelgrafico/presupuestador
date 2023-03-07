<?php
$mysqli = new mysqli("localhost","admin_rehubik","Rehubic2018","admin_rehubik");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Fallo al conectar con la base de datos: " . $mysqli -> connect_error;
  exit();
}

$respuesta = new stdClass();
$id_presupuesto=(int)$_GET["id_presupuesto"];

$result_id_usuario=$mysqli->query("SELECT id_usuario FROM clientes ORDER BY id_presupuesto DESC LIMIT 1");

while ($arr_result_id_usuario = $result_id_usuario->fetch_array())
{
  $id_usuario=$arr_result_id_usuario["id_usuario"];
 // $id_nuevo_presupuesto=$arr_result_id_presupuesto["id_presupuesto"]+1;
}



// LISTA NEGRA 
$very_bad = array("CONCAT","concat","password","PASSWORD","VERSION","version","VALUES","values","NULL","GROUP BY","group by","HEX","hex","WAITFOR","waitfor","BENCHMARK","benchmark","MD5","SHA1","1=1","1=2","delete","update","insert","drop","select","DELETE","UPDATE","INSERT","DROP","SELECT","(","\x00","\x1a","\'","to:","cc:","bcc:","content-type:","mime-version:","multipart-mixed:","content-transfer-enconding:","\r","\n","%0a","%0d",";","=","$","%","<",">","script","@","*","[","]","{","}","^","html","url","_","lyubovnaya");


//LIMPIEZA
$limpieza = array("Pared A","Pared B","Pared C","Pared D","m");

$elemento=$_POST["elemento"];
$articulo_simple=$_POST["articulo_simple"];

$result_elemento=$mysqli->query("SELECT id,mostrar FROM articulos_compuestos WHERE id_imagen='$elemento'");

$suma_precios=0;
$precio=0;
if (!$result_elemento->num_rows)
{
	$respuesta->contestacion=1;
	$respuesta->mensaje="Error - No se ha encontrado el articulo compuesto ".$elemento;
}
else
{

	while ($arr_result_elemento = $result_elemento->fetch_array())
	{
		$id_articulo_compuesto=$arr_result_elemento["id"];
		$mostrar=$arr_result_elemento["mostrar"];
	}
	
	//Saco el precio total de ese artículo compuesto (sumando los simples)
	if (isset($_POST["articulo_simple"]))
	{
	  	for ($i=0;$i<count($articulo_simple);$i++)
		{
		  $id_articulo_simple_actual=$articulo_simple[$i];
		  
			$result_precio=$mysqli->query("SELECT ROUND(SUM(precio), 2) as precio FROM articulos_simples WHERE id=$id_articulo_simple_actual");
			
			while ($arr_result_precio = $result_precio->fetch_array())
				$precio=$precio+$arr_result_precio["precio"];
			
		}
	}
	else
    {
	 $result_precio=$mysqli->query("SELECT ROUND(SUM(precio), 2) as precio FROM articulos_simples WHERE id_articulo_compuesto=$id_articulo_compuesto");
	
	  while ($arr_result_precio = $result_precio->fetch_array())
		$precio=$arr_result_precio["precio"];
	}
	if ($mostrar == "muros")
	{
		//Tengo que sacar las paredes que ha seleccionado
		$paredes=$_POST["paredes"]; //Array donde me indica que paredes ha seleccionado
		
		
		for ($i=0;$i<count($paredes);$i++)
		{
			
			//Por cada pared, me quedo solo con los metros para sacar el precio
			$pared_actual=$paredes[$i];
			$metros=str_replace($limpieza,'',$pared_actual); //Ahora tengo los metros: 1.7, 10.5, 8.0 ....
			
			$precio_final=$metros*$precio;
			
			$suma_precios=$suma_precios+$precio_final;
			
			for ($i=0;$i<count($articulo_simple);$i++)
			{
			  
			  $id_articulo_simple_actual=$articulo_simple[$i];
			  $mysqli->query("INSERT clientes(id_usuario,id_articulo_compuesto,id_articulo_simple,paredes,id_presupuesto_modificado) VALUES($id_usuario,$id_articulo_compuesto,$id_articulo_simple_actual,'$pared_actual',$id_presupuesto)");

			}
			
			
			
			
			
		}
		
		
	}
	else
	{
	
	  if ($mostrar == "unidades")
		$unidades=$_POST["unidades"];
	  else
		$unidades=1;
		
	  $precio_final=$unidades*$precio;
	  $suma_precios=$suma_precios+$precio_final;	
		
	  for ($i=0;$i<count($articulo_simple);$i++)
	  {
			  
		 $id_articulo_simple_actual=$articulo_simple[$i];
		 $mysqli->query("INSERT clientes(id_usuario,id_presupuesto,id_articulo_compuesto,id_articulo_simple,unidades,id_presupuesto_modificado) VALUES($id_usuario,$id_nuevo_presupuesto,$id_articulo_compuesto,$id_articulo_simple_actual,'$unidades',$id_presupuesto)");

	  }
	}

	
	
	$precio_cookie=(float)$_COOKIE["precio_final"];
	$precio_cookie=$precio_cookie+$suma_precios;
	//elimino la cookie y la vuelvo a crear con el nuevo precio final
	setcookie('precio_final', null, -1, '/'); 
	setcookie("precio_final",$precio_cookie, time()+3600, "/"); 
	
	$respuesta->mensaje="Precio final del elemento ".$elemento." es: ".$suma_precios." y el precio TOTAL del presupuesto es ".$precio_cookie;
}

if ($mostrar == "")
 $mostrar=0;

$presupuesto=$_COOKIE["presupuesto"].$id_articulo_compuesto.",".$mostrar.",".$precio.",".$suma_precios.";";

setcookie('presupuesto', null, -1, '/'); 
setcookie("presupuesto",$presupuesto, time()+3600, "/"); 


echo json_encode($respuesta);	
	
?>