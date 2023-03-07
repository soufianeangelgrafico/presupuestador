 <div class="row">  
			 <div class="col-md-12"><h5>LISTADO CITAS</h5></div> 
		 </div>
		  
		<div class="row"> 
		 <div class="col-md-12">
		  <?php
			$fecha=date("Y-m-d");
		    
			$result=$mysqli->query("SELECT ID FROM rehubik_wp_posts WHERE post_status='wc-completed' ORDER BY ID DESC");
			 
			if ($result->num_rows)
			{
				
				while ($arr_result = $result->fetch_array())
				{
				  //Por cada compra, obtengo el ID
				  $id=$arr_result["ID"];	
				
				
					//Saco los datos de la reserva
					$result_reserva=$mysqli->query("SELECT ID FROM rehubik_wp_posts WHERE post_parent=$id");

					if ($result_reserva->num_rows)
					{

						//Saco lo que ha puesto en el meta_key _id_presupuesto
						$result_id_presupuesto=$mysqli->query("SELECT meta_value FROM rehubik_wp_postmeta WHERE post_id=$id AND meta_key='_id_presupuesto'");
						
						while ($arr_result_id_presupuesto = $result_id_presupuesto->fetch_array())
						{
							$id_presupuesto=$arr_result_id_presupuesto["meta_value"];
						}

			   ?>
						
					   <?php
						  $fecha_inicio="";
						  while ($arr_result_reserva = $result_reserva->fetch_array())
						  {

							 $result_detalles_reserva=$mysqli->query("SELECT * FROM rehubik_wp_postmeta WHERE post_id=".$arr_result_reserva["ID"]);

							  while ($arr_result_detalles_reserva = $result_detalles_reserva->fetch_array())
							  {

								  if ($arr_result_detalles_reserva["meta_key"] == "_booking_product_id")
									 $id_centro=$arr_result_detalles_reserva["meta_value"];
								  else if ($arr_result_detalles_reserva["meta_key"] == "_booking_start")
									 $fecha_inicio=$arr_result_detalles_reserva["meta_value"]; //Ejemplo: 20201127153000
							  }

							  if ($fecha_inicio != "")
							  {

								   $fecha_inicio=date("Y-m-d H:i",strtotime($fecha_inicio));
								   $fecha_inicio_array=explode(" ", $fecha_inicio);

								   //Ahora compruebo si la cita de ESA FECHA y ESE CENTRO están asociados a mi o no
								   //Para mostrar sus datos

								   $result_horarios_calendario=$mysqli->query("SELECT * FROM horarios_calendario WHERE id_centro=".$id_centro." AND fecha='".$fecha_inicio_array[0]."' AND hora='".str_replace("09","9",$fecha_inicio_array[1])."' AND asignado=".$_SESSION["login"]." LIMIT 1"); 
									
								  
								   if ($result_horarios_calendario->num_rows)
								   {
									   //Esa cita es mia. Le muestro los datos

									   while ($arr_result_horarios_calendario = $result_horarios_calendario->fetch_array())
									   {
									 ?>
			 							 <div class="table-responsive">
						  				  <table class="table">
									<?php
									?>  
									   <td><?php echo date("d-m-Y",strtotime($arr_result_horarios_calendario["fecha"]));?></td>
									   <td><?php echo $arr_result_horarios_calendario["hora"];?></td>
									   <td>
										<?php
										  if ($arr_result_horarios_calendario["tipo"] == "T")
										  {
										?>
											Telemática
										<?php   
										  }
										  else
										  {
										?>	 
											Presencial 
										<?php	  
										  }
										?>
									   </td>
									   <td>
										<p>Presupuesto original</p>
										<p><a target="_blank" href="https://rehubik.com/generar_pdf.php?id=<?php echo $id_presupuesto;?>">VER PDF</a> | <a href="https://rehubik.com/presupuestador/2d/?id_presupuesto=<?php echo $id_presupuesto;?>" target="_blank">VER PRESUPUESTO</a> <br/><br/> <a href="https://rehubik.com/exportar_xlsx.php?id_presupuesto=<?php echo $id_presupuesto;?>">EXPORTAR UDO</a> | <a href="https://rehubik.com/exportar_materiales_xlsx.php?id_presupuesto=<?php echo $id_presupuesto;?>">EXPORTAR MATERIALES</a> <br><br>
										  <!--<span onclick="enviarEmail(< ?php echo $id_presupuesto;?>,< ?php echo $_SESSION["login"];?>)">ENVIAR EMAIL</span>-->
											<a href="https://rehubik.com/enviar_email_presupuestos.php?id_presupuesto=<?php echo $id_presupuesto;?>">ENVIAR EMAIL</a>
										 </p>

										<?php
										  $result_modificaciones=$mysqli->query("SELECT DISTINCT id_presupuesto FROM clientes WHERE id_presupuesto_modificado=$id_presupuesto");
										   
										  if ($result_modificaciones->num_rows)
										  {
										?>
										   <p>Presupuestos modificados</p>

										   <?php
											 while ($arr_result_modificaciones = $result_modificaciones->fetch_array())
											 {
										   ?>
											  <p>
												<a target="_blank" href="https://rehubik.com/generar_pdf.php?id=<?php echo $arr_result_modificaciones["id_presupuesto"];?>">VER PDF</a> | <a href="https://rehubik.com/presupuestador/2d/?id_presupuesto=<?php echo $arr_result_modificaciones["id_presupuesto"];?>" target="_blank">VER PRESUPUESTO</a><br/><br/> <a href="https://rehubik.com/exportar_xlsx.php?id_presupuesto=<?php echo $arr_result_modificaciones["id_presupuesto"];?>">EXPORTAR UDO</a> | <a href="https://rehubik.com/exportar_materiales_xlsx.php?id_presupuesto=<?php echo $arr_result_modificaciones["id_presupuesto"];?>">EXPORTAR MATERIALES</a><br/><br/>
												<a href="https://rehubik.com/enviar_email_presupuestos.php?id_presupuesto=<?php echo $arr_result_modificaciones["id_presupuesto"];?>">ENVIAR EMAIL</a>
											  </p>
											  <hr/>
										   <?php
												
												$result_modificaciones_modificado=$mysqli->query("SELECT DISTINCT id_presupuesto FROM clientes WHERE id_presupuesto_modificado=".$arr_result_modificaciones["id_presupuesto"]);
												
												while ($arr_result_modificaciones_modificado = $result_modificaciones_modificado->fetch_array())
												{
										   ?>		
												<p>
													<a target="_blank" href="https://rehubik.com/generar_pdf.php?id=<?php echo $arr_result_modificaciones_modificado["id_presupuesto"];?>">VER PDF</a> | <a href="https://rehubik.com/presupuestador/2d/?id_presupuesto=<?php echo $arr_result_modificaciones_modificado["id_presupuesto"];?>" target="_blank">VER PRESUPUESTO</a><br/><br/> <a href="https://rehubik.com/exportar_xlsx.php?id_presupuesto=<?php echo $arr_result_modificaciones_modificado["id_presupuesto"];?>">EXPORTAR UDO</a> | <a href="https://rehubik.com/exportar_materiales_xlsx.php?id_presupuesto=<?php echo $arr_result_modificaciones_modificado["id_presupuesto"];?>">EXPORTAR MATERIALES</a><br/><br/>
													<a href="https://rehubik.com/enviar_email_presupuestos.php?id_presupuesto=<?php echo $arr_result_modificaciones_modificado["id_presupuesto"];?>">ENVIAR EMAIL</a>
											  </p>
											  <hr/>	
													
										   <?php		
												}
												 
											 }
										   ?>

										<?php  
										  }
										?>
									   </td>

									<?php
									   }
									?>
			 						</table></div>
								  <?php
								   }

							  } 


						?>

					  <?php
						  }
					  ?>
						 
			  <?php
				 }
			   }
		   }
			else
			{
		  ?>
			 <p>Actualmente no hay ninguna cita...</p> 
		  <?php
			}
		  ?>
		 </div>	 
		</div> 
		  
		  
		  