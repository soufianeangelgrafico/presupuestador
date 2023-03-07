<?php
require_once 'dompdf-master/lib/html5lib/Parser.php';
require_once 'dompdf-master/src/Autoloader.php';
Dompdf\Autoloader::register();
use Dompdf\Dompdf;

$mysqli = new mysqli("localhost","admin_rehubik","Rehubic2018","admin_rehubik");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Fallo al conectar con la base de datos: " . $mysqli -> connect_error;
  exit();
}

$id_presupuesto=(int)$_GET["id"];
$result = $mysqli->query("SELECT DISTINCT id_articulo_compuesto FROM clientes WHERE id_presupuesto=".$_GET["id"]." AND id_articulo_compuesto IS NOT NULL");

$result_material=$mysqli->query("SELECT clientes.referencia_material as referencia_material, materiales.rvpv as rvpv, materiales.modelo as modelo, materiales.pvp as precio FROM clientes,materiales WHERE materiales.referencia = clientes.referencia_material AND id_presupuesto=".$_GET["id"]." AND referencia_material IS NOT NULL");

/*
$result = $mysqli->query("SELECT clientes.*,rehubik_wp_users.display_name,articulos_compuestos.nombre as articulo_compuesto, articulos_compuestos.tipo as tipo FROM clientes,rehubik_wp_users,articulos_compuestos WHERE articulos_compuestos.id = clientes.id_articulo_compuesto AND rehubik_wp_users.ID = clientes.id_usuario AND id_presupuesto=".$_GET["id"]);
*/
$codigoHTML="";


  
//HTML QUE SE IMPRIMIRÁ EN EL PDF 
$codigoHTML.='<html><head><style>
@import url("https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700;900&display=swap");
</style>
<style>@page { margin-top: 30px;margin-bottom:0px; } body,h1,h2,h3,p,div,span{font-family:"Montserrat", sans-serif; !important;} .page_break { page-break-before: always; }</style></head><body>';

$codigoHTML.='<p><img width="100" src="https://rehubik.com/wp-content/uploads/2020/07/logo-2.png" alt="Rehubik" title="Rehubik"></p>';
$codigoHTML.='<h2>Presupuesto #'.$id_presupuesto.'</h2>';
$codigoHTML .= '<h2>Presupuesto + 2d/ajax</h2>';
$codigoHTML.='<table border="1" width="100%"><tr style="background:rgb(149, 193, 31);color:white;text-transform:uppercase;"><td style="font-size:12px;font-weight:bold;padding:5px;border:0;">Artículo</td><td style="font-size:12px;font-weight:bold;padding:5px;border:0;">Tipo</td><td style="font-size:12px;font-weight:bold;padding:5px;border:0;">Pared/Unidades</td><td style="font-size:12px;font-weight:bold;padding:5px;border:0;">Precio</td></tr>';

$suma_precio=0;
if ($result->num_rows || $result_material->num_rows)
{
  while ($arr_result = $result->fetch_array())
  {
	
	
	
	$id_articulo_compuesto=$arr_result["id_articulo_compuesto"];
	
	//Saco toda la información de ese artículo compuesto
	$result_articulo_compuesto = $mysqli->query("SELECT * FROM articulos_compuestos WHERE id=".$id_articulo_compuesto);
	
	while ($arr_result_articulo_compuesto = $result_articulo_compuesto->fetch_array())
	{
		
	  $nombre_articulo_compuesto=$arr_result_articulo_compuesto["nombre"];
	  $tipo=$arr_result_articulo_compuesto["tipo"];
		
	  if ($tipo == 1)
	  {
		$tipo="Demoliciones";
	  }
	  else if ($tipo == 2)
	  {
		$tipo="Instalación eléctrica";
	  }
	  else if ($tipo == 3)
	  {
		$tipo="Instalaciones Equipamiento";
	  }
	  else if ($tipo == 4)
	  {
		$tipo="Revestimientos";
	  }
	  else if ($tipo == 5)
	  {
		$tipo="Gas";
	  }
	  else if ($tipo == 6)
	  {
		$tipo="Carpinteria Interior";
	  }
	  else if ($tipo == 7)
	  {
		$tipo="Carpinteria Exterior";
	  }
	  else if ($tipo == 8)
	  {
		$tipo="Otros servicios";
	  }
	  else
	  {
		$tipo="SC";
	  }	
		
	}
	
	
	//Saco toda la información de todos los artículos simples. Si id_articulo_simple es NULL, saco todo lo que visible sea 1
	$result_ids_articulos_simples = $mysqli->query("SELECT id_articulo_simple FROM clientes WHERE id_presupuesto=".$id_presupuesto." AND id_articulo_compuesto=".$id_articulo_compuesto." AND id_articulo_simple IS NOT NULL");
	
	if ($result_ids_articulos_simples->num_rows)
	{
		$ids_articulos_simples="";
		
		while ($arr_result_ids_articulos_simples = $result_ids_articulos_simples->fetch_array())
		{
		  $ids_articulos_simples=$ids_articulos_simples."".$arr_result_ids_articulos_simples["id_articulo_simple"].",";
		}
		
		$ids_articulos_simples=substr($ids_articulos_simples,0,-1); //Quito la última coma
		
		$result_articulos_simples=$mysqli->query("SELECT * FROM articulos_simples WHERE id IN (".$ids_articulos_simples.")");
		
		//Precio artículo compuesto
		$result_precio=$mysqli->query("SELECT ROUND(SUM(precio),2) as precio FROM articulos_simples WHERE id IN (".$ids_articulos_simples.")");
	
	}
	else
	{
		//Saco los articulos simples que visible sea 1
		$result_articulos_simples=$mysqli->query("SELECT * FROM articulos_simples WHERE id_articulo_compuesto=".$id_articulo_compuesto." AND visible_cliente=1");
		
		//Precio artículo compuesto
		$result_precio=$mysqli->query("SELECT ROUND(SUM(precio),2) as precio FROM articulos_simples WHERE id_articulo_compuesto='$id_articulo_compuesto'");
	}
	
	
	
	
	while ($arr_result_precio = $result_precio->fetch_array())
	{
		$precio=$arr_result_precio["precio"];
	}
		
	
	$codigoHTML.='<tr><td style="font-size:12px;padding:5px;border:0;border-top:1px solid black">'.$nombre_articulo_compuesto;
	
	
	
	  while ($arr_result_articulos_simples = $result_articulos_simples->fetch_array())
	  {
		 
		  $codigo_articulo_simple=$arr_result_articulos_simples["codigo"];
		  $descripcion_articulo_simple=$arr_result_articulos_simples["descripcion"];
		 
		  $codigoHTML.='<br/> <span style="font-size:10px"> - '.$codigo_articulo_simple.': '.utf8_encode($descripcion_articulo_simple)."</span>";
		  
	  }
	
	
	 $codigoHTML.='</td>';
	
	$codigoHTML.='<td style="font-size:12px;padding:5px;border:0;border-top:1px solid black">'.$tipo.'</td><td style="font-size:12px;padding:5px;border:0;border-top:1px solid black">';
	
	$result_paredes_unidades = $mysqli->query("SELECT DISTINCT paredes,unidades FROM clientes WHERE id_presupuesto=".$id_presupuesto." AND id_articulo_compuesto=".$id_articulo_compuesto);
	
	while ($arr_result_paredes_unidades = $result_paredes_unidades->fetch_array())
	{
		$paredes=$arr_result_paredes_unidades["paredes"];
		$unidades=$arr_result_paredes_unidades["unidades"];
	
	
		if ($paredes != "")
		{
			$codigoHTML.=$paredes."<br>";
		}
		else
		{
		  if ($unidades == 1)
			$codigoHTML.=$unidades." unidad";
		  else
			$codigoHTML.=$unidades." unidades";
		  
		  $codigoHTML.="<br>";
			
		}
		
	}
	$codigoHTML.='</td>';
	
	$codigoHTML.='<td style="font-size:12px;padding:5px;border:0;border-top:1px solid black">'.$precio.'€</td></tr>';
	
	$suma_precio=$suma_precio+$precio;
  }
  while ($arr_result_material = $result_material->fetch_array())
  {
	    $referencia_material=$arr_result_material["referencia_material"];
		$rvpv=$arr_result_material["rvpv"];
		$modelo_material=$arr_result_material["modelo"];
		$precio_material=$arr_result_material["precio"];
		$suma_precio=$suma_precio+$precio_material;
 	
		$codigoHTML.='<tr>
						  <th scope="row" colspan="3">
							MATERIAL '.$referencia_material.': '.$modelo_material.' ('.$rvpv.')
						  </th>
							
						   <td>'.$precio_material.'€</td>
					    </tr>';
				 		
	}	
	
}
$codigoHTML.='<tr style="color:white;background:rgb(149, 193, 31);text-align:right"><td colspan="4" style="font-size:12px;font-weight:bold;padding:5px;border:0;border-top:1px solid black">PRECIO FINAL: '.$suma_precio.'€</td></tr>';

$codigoHTML.='</table>';
$codigoHTML.='<p>Puedes acceder a tu plano desde <a href="https://rehubik.com/presupuestador/2d/?id_presupuesto='.$id_presupuesto.'" target="_blank" rel="noopener">AQUÍ</p>';

$codigoHTML.='</body></html>';
//echo $codigoHTML; 
//GENERO PDF



$dompdf = new Dompdf(array('enable_remote' => true));
$dompdf->loadHtml($codigoHTML);

// (Optional) Setup the paper size and orientation
$dompdf->set_paper('A4', 'portrait');
//Cambiando la fuente
//$dompdf->set_option('defaultFont', 'Helvetica');
$dompdf->render();

$output = $dompdf->output();
 
$microtime=md5(microtime()); 
$file_to_save = 'pdfs/'.$microtime."_".'presupuesto.pdf';
file_put_contents($file_to_save, $output);  

/* ANTES ESTABA ASÍ
header('Pragma: public');  // required
header('Expires: 0');  // no cache
header("Content-disposition: attachment; filename=".basename('https://fswd.es/'.$file_to_save));
header("Content-type: application/pdf");
readfile("https://fswd.es/".$file_to_save);

*/
 
header('Content-type: application/pdf');
header('Content-Disposition: inline; filename="presupuesto.pdf"');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . filesize("https://rehubik.com/".$file_to_save));
header('Accept-Ranges: bytes');
readfile("https://rehubik.com/".$file_to_save);





?>