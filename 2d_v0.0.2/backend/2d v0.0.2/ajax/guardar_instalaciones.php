<?php
include("../conexion.php");

$respuesta = new stdClass();

// LISTA NEGRA Y LIMPIEZA 
$very_bad = array("CONCAT","concat","password","PASSWORD","VERSION","version","VALUES","values","NULL","GROUP BY","group by","HEX","hex","WAITFOR","waitfor","BENCHMARK","benchmark","MD5","SHA1","1=1","1=2","delete","update","insert","drop","select","DELETE","UPDATE","INSERT","DROP","SELECT","(","\x00","\x1a","\'","to:","cc:","bcc:","content-type:","mime-version:","multipart-mixed:","content-transfer-enconding:","\r","\n","%0a","%0d",";","=","$","%","<",">","script","@","*","[","]","{","}","^","html","url","_","lyubovnaya");
$limpieza = array("Pared A","Pared B","Pared C","Pared D","Pared E","Pared F","Pared G","Pared H","Pared I","Pared J","Pared K","Pared L","Pared M","Pared N","Pared O","Pared P","Pared Q","Pared R","Pared S","Pared T","Pared U","Pared V","Pared W","Pared X","Pared Y","Pared Z","m");

$idplano=$_COOKIE["idplano"];
$elemento=$_POST["elemento"];
$total_paredes=$_POST["total_muros"];
$altura_techo=$_POST["altura_techo"];
$metros_cuadrados=$_POST["metros_cuadrados"];


$total_paredes=substr($total_paredes,0,-1); //Quito última coma

$result_elemento=$mysqli->query("SELECT id,mostrar FROM articulos_compuestos WHERE id_imagen='$elemento'");

$suma_precios=0;
$precio=0;

 while ($arr_result_elemento = $result_elemento->fetch_array())
 {
		$id_articulo_compuesto=$arr_result_elemento["id"];
		$mostrar=$arr_result_elemento["mostrar"];
 }
	

	 $result_precio=$mysqli->query("SELECT ROUND(SUM(precio), 2) as precio FROM articulos_simples WHERE id_articulo_compuesto=$id_articulo_compuesto");
	
	  while ($arr_result_precio = $result_precio->fetch_array())
		$precio=$arr_result_precio["precio"];


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
			//Lo que hay después de / es el número de metros que ha elegido en el input range
			
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
			
			
			
			//$mysqli->query("INSERT sesiones_temporales(id_articulo_compuesto,sesion,paredes_reformado,longitud_pared_reformado,altura_techo_reformado,total_paredes_reformado) VALUES($id_articulo_compuesto,'$sesion_temporal','$pared_actual','$longitud_pared','$altura_paredes','$total_paredes')");
			$mysqli->query("INSERT planos_articulos_compuestos(id_plano,id_articulo_compuesto,pared,longitud,total_paredes) VALUES ($idplano,$id_articulo_compuesto,'$pared_actual','$longitud_pared','$total_paredes')");

		}
		
		
	}
	else if ($mostrar == "metros_lineales")
	{
		$metros_lineales=$_POST["metros_lineales"];
		//Añado el total de las paredes porque si no selecciona ningún elemento en el que elija un muro
		//Los muros NO se guardan en la BD y después da error a la hora de que el verificador lo edite.
		
		//$mysqli->query("INSERT sesiones_temporales(id_articulo_compuesto,sesion,total_paredes_reformado,metros_lineales_reformado) VALUES($id_articulo_compuesto,'$sesion_temporal','$total_paredes','$metros_lineales')");	
		$mysqli->query("INSERT planos_articulos_compuestos(id_plano,id_articulo_compuesto,total_paredes,metros_lineales) VALUES ($idplano,$id_articulo_compuesto,'$total_paredes','$metros_lineales')");
		
		
	}
	else
	{
	
	  if ($mostrar == "unidades")
		$unidades=$_POST["unidades"];
	  else
		$unidades=1;
		
	  //$mysqli->query("INSERT sesiones_temporales(id_articulo_compuesto,sesion,total_paredes_reformado,unidades_reformado) VALUES($id_articulo_compuesto,'$sesion_temporal','$total_paredes',$unidades)");	
	  $mysqli->query("INSERT planos_articulos_compuestos(id_plano,id_articulo_compuesto,total_paredes,unidades) VALUES ($idplano,$id_articulo_compuesto,'$total_paredes',$unidades)");

		
	}

 $respuesta->mensaje="Artículo añadido al presupuesto";
	



echo json_encode($respuesta);	

?>