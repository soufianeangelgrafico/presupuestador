<?php
include("../conexion.php");
$idplano="101";
$suma_precio=0;
$limpieza = array("Pared A","Pared B","Pared C","Pared D","m");
			  
$result=$mysqli->query("SELECT * FROM planos_articulos_compuestos WHERE id_plano=$idplano");

$result_plano=$mysqli->query("SELECT * FROM planos WHERE id=$idplano");
			  
			 
while ($arr_result_plano = $result_plano->fetch_array())
{
    $altura_pared=$arr_result_plano["altura_techo_reformado"];
	$metros_cuadrados=$arr_result_plano["m2"];
}
			 
			  
if ($result->num_rows)
{
				  
  $codigoHTML.='<table class="table" style="font-size:12px;">
				  <thead>
					<tr>
					  <th scope="col">Artículo</th>
					  <th scope="col">Tipo</th>
					  <th scope="col">Ubicación</th>
					  <th scope="col">Precio</th>
					</tr>
				  </thead>
				  <tbody>';
	
  while ($arr_result = $result->fetch_array())
  {
						
						
	$id_articulo_compuesto=$arr_result["id_articulo_compuesto"];
	$paredes=$arr_result["pared"];
	$longitud_pared=$arr_result["longitud"];
	$unidades=$arr_result["unidades"];
	$metros_lineales=$arr_result["metros_lineales"];
						
							
	$result_compuesto = $mysqli->query("SELECT * FROM articulos_compuestos WHERE id=$id_articulo_compuesto");
						
	while ($arr_result_compuesto = $result_compuesto->fetch_array())
	{
	
		$nombre_articulo_compuesto = $arr_result_compuesto["nombre"];
		$tipo=$arr_result_compuesto["tipo"];
		$imagen=$arr_result_compuesto["imagen"];
		$id=$arr_result_compuesto["id_imagen"];
								
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
						
					  
  		$codigoHTML.='<tr>
							  <th scope="row">
								'.$nombre_articulo_compuesto.'
							  </th>
							  <td>'.$tipo.'</td>
							  <td>';
							   
							 	if ($paredes != "")
								{
									$codigoHTML.=$paredes;
									
									if ($longitud_pared != 0)
									  $codigoHTML.="<br/> (".$longitud_pared." m seleccionados) ";
									
								}
								else if ($metros_lineales != 0)
								{
									
								  $codigoHTML.=$metros_lineales." m.lineales";	
									
								}
							    else
								{
								  if ($unidades == 1)
									$codigoHTML.=$unidades." unidad";
								  else
									$codigoHTML.=$unidades." unidades";
								}
							  
	  $codigoHTML.='</td>';
	  $codigoHTML.='<td>';
			 
      $result_precio=$mysqli->query("SELECT ROUND(SUM(precio),2) as precio FROM articulos_simples WHERE id_articulo_compuesto=$id_articulo_compuesto AND visible_cliente=1");
								
	  while ($arr_result_precio = $result_precio->fetch_array())
	  {
								  
		if ($id == "picado_desescombro_falso_techo" || $id == "picado_desescombro_solado" || $id == "colocacion_solado" || $id == "falso_techo")
		{
									  
			$precio=$metros_cuadrados * $arr_result_precio["precio"];
		}
		else if ($id == "picado_desescombro_rodapie" || $id == "colocacion_zocalo" || $id == "picado_desescombro_rodapie")
		{
			$precio=$longitud_pared*$arr_result_precio["precio"];  
		}
		else if ($paredes != "")
		{
			  if ($id == "alicatado_paredes" || $id == "colocacion_solado")
			  {
				  //m2 alicatado calculados x 1,15
				  $precio=$metros_cuadrados * $arr_result_precio["precio"];
				  $precio=$precio*1.15;
			  }
			  else if ($id == "colocacion_zocalo")
			  {
				 $precio=($longitud_pared*$arr_result_precio["precio"]);
				 $precio=$precio*1.15; 
			  }
			  else
			    $precio=($longitud_pared*$arr_result_precio["precio"])*$altura_pared;
		}  
		else if ($metros_lineales != 0)
			  $precio=$arr_result_precio["precio"] * $metros_lineales;
		else
			  $precio=$arr_result_precio["precio"] * $unidades;
								
	 }
		
	$suma_precio=$suma_precio+$precio;
	$codigoHTML.=round($precio,2);
							  
	$codigoHTML.='€';
							
	$codigoHTML.='</td>
	</tr>';
						
   }
 }
				  
	$result_material=$mysqli->query("SELECT * FROM planos_materiales WHERE id_plano=$idplano");

	if ($result_material->num_rows)
	{
			while ($arr_result_material = $result_material->fetch_array())
			{
				$referencia_material=$arr_result_material["referencia_material"];
				$paredes=$arr_result_material["paredes_reformado"];
				$longitud_pared=$arr_result_material["longitud_pared_reformado"];
				$unidades=$arr_result_material["unidades_reformado"];
						
				if ($unidades == 0)
					$unidades=1; //unidad minima
							
				$result_precios_material = $mysqli->query("SELECT * FROM materiales WHERE referencia='$referencia_material'");
							
				if ($result_precios_material->num_rows)
				{
					while ($arr_result_precios_material = $result_precios_material->fetch_array())
					{
						$modelo=$arr_result_precios_material["modelo"];
						$precio=$arr_result_precios_material["pvp"];
					}
				}
				else
				{
					$modelo="";
					$precio="";
				}
							
				if(strpos($referencia_material, "IKEA") === false)
				{
						
				  $codigoHTML.='<tr>';
				  $codigoHTML.='<th scope="row">'.str_replace("_"," ",$referencia_material);
				  $codigoHTML.=": ".utf8_encode($modelo);
								
				  $codigoHTML.='</th>';
								
				  $codigoHTML.='<td>Material</td>';
				  $codigoHTML.='<td>';
								
				  if ($referencia_material == "REJUNTE_PARED" || $referencia_material == "REJUNTE_SUELO")
				  {
						//la fórmula sería: m2 alicatado calculados en el Paso 3 x 1,15
						$metros_cuadrados=$longitud_pared*$altura_pared;
								
						$unidades=ceil($metros_cuadrados/10);
									
						$codigoHTML.=$unidades;
								
					    $codigoHTML.='unidades para la '.$paredes;
									
				  }
				  else
				  {
					    $codigoHTML.=$unidades." unidades";
	
				  }
								
								
						$codigoHTML.='</td>';
							
						$codigoHTML.='<td>';
								
						if ($precio != "")
						{
									
							$suma_precio=$suma_precio+$precio;
							$codigoHTML.=$precio."€";
									
						}
							
						 $codigoHTML.='</td>';
					   $codigoHTML.='</tr>';
					
				  }
				}
		}
				   
			   $codigoHTML.='<tr style="text-align:right;font-size:14px;">';
				  $codigoHTML.='<th colspan="4">* PRECIO FINAL: '.round($suma_precio,2).'&euro;</th>';
				$codigoHTML.='</tr>';
			  $codigoHTML.='</tbody>';
			$codigoHTML.='</table>';
		  
	  		$codigoHTML.='<p style="font-size:13px">* En este precio no está incluido el mobiliario ni los electrodomésticos, sólo la instalación y mano de obra.</p>';
		     
}

echo $codigoHTML;

?>
			 
