<?php
include("../conexion.php");

$respuesta = new stdClass();
$id_presupuesto=(int)$_GET["id_presupuesto"];

$result_id_usuario=$mysqli->query("SELECT id_usuario,total_paredes FROM clientes WHERE id_presupuesto=$id_presupuesto AND total_paredes != '' ORDER BY id_presupuesto DESC LIMIT 1");

while ($arr_result_id_usuario = $result_id_usuario->fetch_array())
{
	$id_usuario=$arr_result_id_usuario["id_usuario"];
	$total_paredes=$arr_result_id_usuario["total_paredes"];
	
}


// LISTA NEGRA 
$very_bad = array("CONCAT","concat","password","PASSWORD","VERSION","version","VALUES","values","NULL","GROUP BY","group by","HEX","hex","WAITFOR","waitfor","BENCHMARK","benchmark","MD5","SHA1","1=1","1=2","delete","update","insert","drop","select","DELETE","UPDATE","INSERT","DROP","SELECT","(","\x00","\x1a","\'","to:","cc:","bcc:","content-type:","mime-version:","multipart-mixed:","content-transfer-enconding:","\r","\n","%0a","%0d",";","=","$","%","<",">","script","@","*","[","]","{","}","^","html","url","_","lyubovnaya");


//LIMPIEZA
$limpieza = array("Pared A","Pared B","Pared C","Pared D","m");

$elemento=$_POST["elemento"];
$articulo_simple=$_POST["articulo_simple"];

$result_elemento=$mysqli->query("SELECT id,mostrar FROM articulos_compuestos WHERE id_imagen='$elemento'");
$altura_paredes=$_GET["altura_paredes"];

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

			$mysqli->query("INSERT sesiones_temporales(referencia_material,sesion) VALUES('$elemento','$sesion_temporal')");

		}

		$respuesta->mensaje="Presupuesto modificado. Material con referencia ".$elemento." añadido al presupuesto";
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
	if (isset($_POST["articulo_simple"]))
	{
		for ($x=0;$x<count($articulo_simple);$x++)
		{
			$id_articulo_simple_actual=$articulo_simple[$x];
		
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
			
			$precio_final=$metros*$precio;
			
			$suma_precios=$suma_precios+$precio_final;
			
			if (isset($_POST["articulo_simple"]))
			{
				for ($x=0;$x<count($articulo_simple);$x++)
				{
					$id_articulo_simple_actual=$articulo_simple[$x];
					$mysqli->query("INSERT clientes(id_usuario,id_articulo_compuesto,id_articulo_simple,paredes,longitud_pared,altura_pared,total_paredes,id_presupuesto_modificado) VALUES($id_usuario,$id_articulo_compuesto,$id_articulo_simple_actual,'$pared_actual','$longitud_pared','$altura_paredes','$total_paredes',$id_presupuesto)");
					
				}
			}
			else 
			{
				$mysqli->query("INSERT clientes(id_usuario,id_articulo_compuesto,paredes,longitud_pared,altura_pared,total_paredes,id_presupuesto_modificado) VALUES($id_usuario,$id_articulo_compuesto,'$pared_actual','$longitud_pared','$altura_paredes','$total_paredes',$id_presupuesto)");
			}
		}
	}
	else if ($mostrar == "metros_lineales")
	{
		$metros_lineales=$_POST["metros_lineales"];
		
		//$mysqli->query("INSERT sesiones_temporales(id_articulo_compuesto,sesion,metros_lineales) VALUES($id_articulo_compuesto,'$sesion_temporal','$metros_lineales')");	
		
		$precio_final=$metros_lineales*$precio;
	    $suma_precios=$suma_precios+$precio_final;
		
		for ($x=0;$x<count($articulo_simple);$x++)
		{
		$id_articulo_simple_actual=$articulo_simple[$x];
		$mysqli->query("INSERT clientes(id_usuario,id_articulo_compuesto,id_articulo_simple,metros_lineales,id_presupuesto_modificado) VALUES($id_usuario,$id_articulo_compuesto,$id_articulo_simple_actual,'$metros_lineales',$id_presupuesto)");
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
			
		for ($x=0;$x<count($articulo_simple);$x++)
		{
				
			$id_articulo_simple_actual=$articulo_simple[$x];
			$mysqli->query("INSERT clientes(id_usuario,id_articulo_compuesto,id_articulo_simple,unidades,id_presupuesto_modificado) VALUES($id_usuario,$id_articulo_compuesto,$id_articulo_simple_actual,'$unidades',$id_presupuesto)");
		}
		
	}

	/*$precio_cookie=(float)$_COOKIE["precio_final"];
	$precio_cookie=$precio_cookie+$suma_precios;
	//elimino la cookie y la vuelvo a crear con el nuevo precio final
	setcookie('precio_final', null, -1, '/'); 
	setcookie("precio_final",$precio_cookie, time()+3600, "/"); */
	
	/*$respuesta->mensaje="Precio final del elemento ".$elemento." es: ".$suma_precios." y el precio TOTAL del presupuesto es ".$precio_cookie;*/
	
	$respuesta->mensaje="Presupuesto modificado. Añadido el elemento ".$elemento;
	
	//Saco los SCS
	
	$result_scs=$mysqli->query("SELECT * FROM sincodigos WHERE id_presupuesto=".$id_presupuesto);
	
	if ($result_scs->num_rows)
	{
		while ($arr_result_scs = $result_scs->fetch_array())
		{
			$codigo=$arr_result_scs["codigo"];
			$descripcion=$arr_result_scs["descripcion"];
			$precio=$arr_result_scs["precio"];
			$existe=$arr_result_scs["existe"];
			
			//Si existe, solo la añado a la tabla clientes si no, la doy de alta en artículos simples también
			if ($existe == 1)
			{
				//Existe
				
				$result_id_simple=$mysqli->query("SELECT id FROM articulos_simples WHERE codigo='$codigo'");
				
				while ($arr_result_id_simple = $result_id_simple->fetch_array())
				{
					$id_simple=$arr_result_id_simple["id"];
				}
				
				$mysqli->query("INSERT clientes(id_usuario,id_articulo_compuesto,id_articulo_simple,id_presupuesto_modificado) VALUES($id_usuario,47,$id_simple,$id_presupuesto)");
				
			} 
			else
			{
				//No existe. Lo añado a la tabla articulos_simples y luego lo inserto en clientes
				$result_nuevo_simple=$mysqli->query("INSERT articulos_simples(id_articulo_compuesto,codigo,tienda,descripcion,visible_cliente,precio) VALUES(47,'$codigo',2701,'$descripcion',1,'$precio')");
				
				//echo "INSERT articulos_simples(id_articulo_compuesto,codigo,tienda,descripcion,visible_cliente,precio) VALUES(47,'$codigo',2701,'$descripcion',1,'$precio')";

				if ($result_nuevo_simple)
				{
					
					$id_simple=$mysqli->insert_id;
					//$mysqli->query("INSERT clientes(id_usuario,id_articulo_compuesto,id_articulo_simple,id_presupuesto_modificado) VALUES($id_usuario,47,$id_simple,$id_presupuesto)");
					$mysqli->query("INSERT planos_articulos_compuestos(id_plano,id_articulo_compuesto,id_articulo_simple) VALUES($id_presupuesto,47,$id_simple)");
				}
				
			}
			
		}
		
		$mysqli->query("DELETE sincodigos.* FROM sincodigos WHERE id_presupuesto=$id_presupuesto");
	}
}

if ($mostrar == "")
	$mostrar=0;

/*
$presupuesto=$_COOKIE["presupuesto"].$id_articulo_compuesto.",".$mostrar.",".$precio.",".$suma_precios.";";

setcookie('presupuesto', null, -1, '/'); 
setcookie("presupuesto",$presupuesto, time()+3600, "/"); 
*/

echo json_encode($respuesta);	
	
?>