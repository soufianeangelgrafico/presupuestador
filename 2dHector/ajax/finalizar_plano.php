<?php
$sesion_temporal=$_COOKIE["random"];

$mysqli = new mysqli("localhost","admin_rehubik","Rehubic2018","admin_rehubik");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Fallo al conectar con la base de datos: " . $mysqli -> connect_error;
  exit();
}

$respuesta = new stdClass();
$presupuesto="";

// LISTA NEGRA 
$very_bad = array("CONCAT","concat","password","PASSWORD","VERSION","version","VALUES","values","NULL","GROUP BY","group by","HEX","hex","WAITFOR","waitfor","BENCHMARK","benchmark","MD5","SHA1","1=1","1=2","delete","update","insert","drop","select","DELETE","UPDATE","INSERT","DROP","SELECT","(","\x00","\x1a","\'","to:","cc:","bcc:","content-type:","mime-version:","multipart-mixed:","content-transfer-enconding:","\r","\n","%0a","%0d",";","=","$","%","<",">","script","@","*","[","]","{","}","^","html","url","_","lyubovnaya");


//LIMPIEZA
$limpieza = array("Pared A","Pared B","Pared C","Pared D","Pared E","Pared F","Pared G","Pared H","Pared I","Pared J","Pared K","Pared L","Pared M","Pared N","Pared O","Pared P","Pared Q","Pared R","Pared S","Pared T","Pared U","Pared V","Pared W","Pared X","Pared Y","Pared Z","m");

$elemento=$_POST["elemento"];
$total_paredes=$_GET["total_muros"];
$altura_paredes=$_GET["altura_paredes"];

$total_paredes=substr($total_paredes,0,-1); //Quito última coma

//$articulo_simple=$_POST["articulo_simple"];

$result_elemento=$mysqli->query("SELECT id,mostrar FROM articulos_compuestos WHERE id_imagen='$elemento'");

$suma_precios=0;
$precio=0;
if (!$result_elemento->num_rows)
{
	//Es material
	
	$result_material=$mysqli->query("SELECT * FROM materiales WHERE referencia='$elemento'");	

	if ($result_material->num_rows)
	{
		while ($arr_result_material = $result_material->fetch_array())
		{
			$mostrar=$arr_result_material["mostrar"];
			
			//Hay materiales (como el revestimiento) que también debes elegir el muro o muros en el que lo
			// aplicas, otros que serán unidades y otros que serán genéricos (lo seleccionas o no)
			
			if ($mostrar == "muros")
			{
				//Tengo que sacar las paredes que ha seleccionado
				$paredes=$_POST["paredes"]; //Array donde me indica que paredes ha seleccionado


				for ($i=0;$i<count($paredes);$i++)
				{

					//Por cada pared, me quedo solo con los metros para sacar el precio
					$pared_actual=$paredes[$i];
					//Ahora tengo los metros: 1.7, 10.5, 8.0 ....
					//OJO! esto en caso de que haya elegido TODA la pared, si no, quedará algo como 3.63 m/2
					//Lo que hay después de / es el número de metros que ha elegido en el prompt

					$metros=str_replace($limpieza,'',$pared_actual); 
					$longitud_pared=0;

					if (strpos($metros, "/") !== false)
					{
						//Ha escrito unos m2 (no es la pared completa). Hago un explode
						$metros_explode = explode("/", $metros);

						//$metros_explode[0] -> Metros de la pred
						//$metros_expode[1] -> Metros escritos en el prompt

						$metros=$metros_explode[0];
						$longitud_pared=$metros_explode[1];

						$pared_actual_explode=explode("/",$pared_actual);
						$pared_actual=$pared_actual_explode[0]; //Para quitar el /


					}


				
					$mysqli->query("INSERT sesiones_temporales(referencia_material,sesion,paredes_reformado,longitud_pared_reformado,altura_techo_reformado,total_paredes_reformado) VALUES('$elemento','$sesion_temporal','$pared_actual','$longitud_pared','$altura_paredes','$total_paredes')");
					
				}


			}			
			else
			{
				
				$mysqli->query("INSERT sesiones_temporales(referencia_material,sesion,altura_techo_reformado,total_paredes_reformado) VALUES('$elemento','$sesion_temporal','$altura_paredes','$total_paredes')");
				
			}
			
			

		}

		$respuesta->mensaje="Material con referencia ".$elemento." añadido al presupuesto";
	}
	else
	{
	  $respuesta->contestacion=1;
	  $respuesta->mensaje="Error - No se ha encontrado el articulo compuesto ni el material ".$elemento;
	}
	
	
}
else
{

	while ($arr_result_elemento = $result_elemento->fetch_array())
	{
		$id_articulo_compuesto=$arr_result_elemento["id"];
		$mostrar=$arr_result_elemento["mostrar"];
	}
	
	//Saco el precio total de ese artículo compuesto (sumando los simples)
	/*if (isset($_POST["articulo_simple"]))
	{
	  	for ($i=0;$i<count($articulo_simple);$i++)
		{
		  $id_articulo_simple_actual=$articulo_simple[$i];
		  
			$result_precio=$mysqli->query("SELECT ROUND(SUM(precio), 2) as precio FROM articulos_simples WHERE id=$id_articulo_simple_actual");
			
			while ($arr_result_precio = $result_precio->fetch_array())
				$precio=$precio+$arr_result_precio["precio"];
			
		}
	}*/
	/*else
    {*/
	 $result_precio=$mysqli->query("SELECT ROUND(SUM(precio), 2) as precio FROM articulos_simples WHERE id_articulo_compuesto=$id_articulo_compuesto");
	
	  while ($arr_result_precio = $result_precio->fetch_array())
		$precio=$arr_result_precio["precio"];
	//}
	if ($mostrar == "muros")
	{
		//Tengo que sacar las paredes que ha seleccionado
		$paredes=$_POST["paredes"]; //Array donde me indica que paredes ha seleccionado
		
		
		for ($i=0;$i<count($paredes);$i++)
		{

			//Por cada pared, me quedo solo con los metros para sacar el precio
			$pared_actual=$paredes[$i];
			//Ahora tengo los metros: 1.7, 10.5, 8.0 ....
			//OJO! esto en caso de que haya elegido TODA la pared, si no, quedará algo como 3.63 m/2
			//Lo que hay después de / es el número de metros que ha elegido en el prompt
			
			$metros=str_replace($limpieza,'',$pared_actual); 
			$longitud_pared=0;
			
			if (strpos($metros, "/") !== false)
			{
				//Ha escrito unos m2 (no es la pared completa). Hago un explode
				$metros_explode = explode("/", $metros);
				
				//$metros_explode[0] -> Metros de la pred
				//$metros_expode[1] -> Metros escritos en el prompt
				
				$metros=$metros_explode[0];
				$longitud_pared=$metros_explode[1];
				
				$pared_actual_explode=explode("/",$pared_actual);
				$pared_actual=$pared_actual_explode[0]; //Para quitar el /
				
				
			}
			
			
			
			/*$precio_final=($metros*$altura_paredes)*$precio;
			$suma_precios=$suma_precios+$precio_final;
			*/
			$mysqli->query("INSERT sesiones_temporales(id_articulo_compuesto,sesion,paredes_reformado,longitud_pared_reformado,altura_techo_reformado,total_paredes_reformado) VALUES($id_articulo_compuesto,'$sesion_temporal','$pared_actual','$longitud_pared','$altura_paredes','$total_paredes')");
			echo "1.INSERT sesiones_temporales(id_articulo_compuesto,sesion,paredes_reformado,longitud_pared_reformado,altura_techo_reformado,total_paredes_reformado) VALUES($id_articulo_compuesto,'$sesion_temporal','$pared_actual','$longitud_pared','$altura_paredes','$total_paredes')<br>";
		}
		
		
	}
	else if ($mostrar == "metros_lineales")
	{
		$metros_lineales=$_POST["metros_lineales"];
		//Añado el total de las paredes porque si no selecciona ningún elemento en el que elija un muro
		//Los muros NO se guardan en la BD y después da error a la hora de que el verificador lo edite.
		
		$mysqli->query("INSERT sesiones_temporales(id_articulo_compuesto,sesion,total_paredes_reformado,metros_lineales_reformado) VALUES($id_articulo_compuesto,'$sesion_temporal','$total_paredes','$metros_lineales')");	
		
		echo "2. INSERT sesiones_temporales(id_articulo_compuesto,sesion,total_paredes_reformado,metros_lineales_reformado) VALUES($id_articulo_compuesto,'$sesion_temporal','$total_paredes','$metros_lineales')<br/>";
		
	}
	else
	{
	
	  if ($mostrar == "unidades")
		$unidades=$_POST["unidades"];
	  else
		$unidades=1;
		
	 /* $precio_final=$unidades*$precio;
	  $suma_precios=$suma_precios+$precio_final;	
		*/ 
	  $mysqli->query("INSERT sesiones_temporales(id_articulo_compuesto,sesion,total_paredes_reformado,unidades_reformado) VALUES($id_articulo_compuesto,'$sesion_temporal','$total_paredes',$unidades)");	
		
	 echo "3.INSERT sesiones_temporales(id_articulo_compuesto,sesion,total_paredes_reformado,unidades_reformado) VALUES($id_articulo_compuesto,'$sesion_temporal','$total_paredes',$unidades)<br/>";	
		
	}

 $respuesta->mensaje="Artículo añadido al presupuesto";
	
}


echo json_encode($respuesta);	
	
?>