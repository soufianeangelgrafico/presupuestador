<?php
session_start();
if (!isset($_SESSION["login"]))
 header("Location:index.php");

include("../conexion.php");
$_SESSION["login"]=(int)$_SESSION["login"];

$result_admin=$mysqli->query("SELECT * FROM administradores WHERE id=".$_SESSION["login"]);


if (!$result_admin->num_rows)
 header("Location:index.php");

$obj_admin = $result_admin->fetch_object();

$id_verificador=(int)$_GET["id_usuario"];
$result_verificador=$mysqli->query("SELECT * FROM administradores WHERE id=".$id_verificador);
$obj_verificador= $result_verificador->fetch_object();

$id_centro=(int)$_GET["id_centro"];
$result_centro=$mysqli->query("SELECT * FROM centros WHERE id_centro=$id_centro");
$obj_centro=$result_centro->fetch_object();

$fecha=date("Y-m-d");

/* Datos paginación */

$cantidad_resultados_por_pagina = 50;

$pagina = $_GET["pagina"];
if (!$pagina) {
 $inicio = 0;
 $pagina=1;
}
else {
  $inicio = ($pagina - 1) * $cantidad_resultados_por_pagina;
} 


?>
<html lang="es">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Rehubik</title>

  <!-- Bootstrap core CSS -->
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Custom styles for this template -->
  <link href="../css/modern-business.css" rel="stylesheet">
  <link href="../css/alertify.min.css" rel="stylesheet">	
  <style>
   @import url('https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,700,700i,900&display=swap');
</style>
	
	<style>
		span.paginador {
    background: #95C11C;
    padding: 1px;
}
		span.paginador > a {color:white;}
		
		span.paginador.paginador-selected {font-weight:bold;}
		span.tipo_P {
    background: #FFC12B;
    padding: 2px;
    border-radius: 2px;
}
		span.tipo_T {
		background: #95c11f;
    padding: 2px;
    border-radius: 2px;	
			
		}		
		.textCenter {text-align:center;width:100%}
		hr.separacion {
    border: 1px solid black;
}
		.container {
    max-width: 100% !important;
}
		body {font-size:14px;}
		
		.table td, .table th {
			border-top: 0;
			border-bottom: 1px solid #dee2e6;
		}
		.table-responsive {padding:10px;}
		.fontweight900 { font-weight:900;}
	</style>
</head>

<body class="page-presupuestador"> 
 
  <!-- Page Content -->
  <div class="container">
 
	<div class="row">
	  
	  <div class="col-md-3" style="height:100vh"> 
       <p class="textCenter"><a href="https://rehubik.com/presupuestador/intranet/main.php"><img src="../img/area_privada.png" width="302" style="max-width:100%" class="marginbottom25 margintop25"></a></p>
		<?php if ($obj_admin->tipo == 0) { ?>
		 <iframe class="centrado" width="330" height="250" style="background-color: transparent;margin:0 auto;" frameborder="0" scrolling="no" src="../calendario/index.php"></iframe>  
		<?php } ?>
	  </div>
		
	  <div class="col-md-9" style="background:white;">
     	
		 <div class="row margintop25 marginbottom25">
			<div class="col-md-6">
				<p><img src="../iconos/icono_verificador.png"> Hola, <b><?php echo $obj_admin->email;?></b></p>
			</div>	
			 <!--
			<div class="col-md-6">
				<div class="codigo_presupuesto">
				  <form name="buscar_presupuesto" id="buscar_presupuesto" method="POST" action="#">	
					<div class="row">
					  <div class="col-md-4">
						  <p class="font18"><b>Código de presupuesto</b></p>
					  </div>
					  <div class="col-md-8">
						<input type="text" name="numero_presupuesto" id="numero_presupuesto" class="transparent form form-control" placeholder="Código presupuesto">
						  <input type="button" style="padding:5px" class="btn btn-success" value="Buscar" id="buscar_presupuesto_ok" id="buscar_presupuesto_ok">
					  </div>
					 </div>
					</form>
				  </div>	
			<span style="position: relative;top: 5px;"><a href="cerrar_sesion.php"><img alt="cerrar sesión" title="Cerrar sesión" src="img/icono_cerrar_sesion.png"></a></span>
		  </div>	
			 -->
		 </div> 
		 <hr class="separacion"/> 
		  
		  <div class="row">
			  <h2 class="textCenter"><span class="fontweight900"><?php echo strtoupper(utf8_encode($obj_verificador->nombre))." ".strtoupper(utf8_encode($obj_verificador->apellidos));?></span><br/> (<?php echo utf8_encode($obj_centro->nombre)." - ".utf8_encode($obj_centro->ciudad).")";?></h2>
		  </div>
		  
		  <hr class="separacion">
		  
		  <div class="row">  
			 <div class="col-md-12"><h5>PRÓXIMAS CITAS</h5></div> 
		 </div>
		  
		<div class="row"> 
		 <div class="col-md-12">
		  <?php
			
			/*$result=$mysqli->query("SELECT presupuestos.*,horarios_calendario.hora as hora, calendario.fecha as fecha FROM presupuestos,horarios_calendario,calendario,presupuestos_citas WHERE horarios_calendario.id_calendario = calendario.id AND presupuestos_citas.id_presupuesto = presupuestos.id_presupuesto AND presupuestos_citas.id_cita = horarios_calendario.id AND calendario.id_centro=".$obj_centro->id_centro." AND calendario.fecha >= ".$fecha." AND presupuestos_citas.asignada=".$obj_verificador->id);
		    */
			  
			$result=$mysqli->query("SELECT DISTINCT presupuestos.*,presupuestos_citas.fecha as fecha_cita FROM presupuestos,presupuestos_citas WHERE presupuestos_citas.id_presupuesto = presupuestos.id_presupuesto AND (presupuestos_citas.asignada = ".$obj_verificador->id." OR presupuestos_citas.asesor = ".$obj_verificador->id.") AND presupuestos_citas.fecha > '".date("Y-m-d H:i:s")."' ORDER BY fecha_cita DESC");

			 //echo "SELECT DISTINCT presupuestos.*,presupuestos_citas.fecha as fecha_cita FROM presupuestos,presupuestos_citas,horarios_calendario,centros WHERE presupuestos_citas.id_presupuesto = presupuestos.id_presupuesto AND horarios_calendario.id_centro = centros.id_centro AND (horarios_calendario.id_centro = ".$obj_centro->id_centro." OR presupuestos_citas.asignada = ".$obj_verificador->id." OR presupuestos_citas.asesor = ".$obj_verificador->id.") AND presupuestos_citas.fecha > '".date("Y-m-d H:i:s")."' ORDER BY fecha_cita DESC";
			 
			if ($result->num_rows)
			{
		   ?>
			 <div class="table-responsive">
			  <table class="table">
		   <?php
			  while ($arr_result = $result->fetch_array())
			  {
			?>
			  
				<tr>
					<td><?php echo date("d-m-Y H:i",strtotime($arr_result["fecha_cita"]));?></td>
					<td>P. <?php echo $arr_result["id_presupuesto"];?></td>
					<td><?php echo $arr_result["nombre_cliente"];?></td>
					<?php
				  /*
					<td><?php echo $arr_result["direccion_cliente"];?> - <?php echo $arr_result["cp_cliente"];?> - <?php echo $arr_result["poblacion_cliente"];?> (<?php echo $arr_result["provincia_cliente"];?>)</td>
					<td><?php echo $arr_result["telefono_cliente"];?></td>
				*/
				  
				    $result_fichero=$mysqli->query("SELECT fichero FROM ficheros WHERE id_fichero=".$arr_result["id_fichero"]);
				  
				    $url_fichero="";
				    if ($result_fichero->num_rows)
					{
						while ($arr_result_fichero = $result_fichero->fetch_array())
						{
							$url_fichero=$arr_result_fichero["fichero"];
						}
				  ?>
					<td><a target="_blank" href="https://rehubik.com/<?php echo $url_fichero;?>">Ver presupuesto</a> 
						<?php
						/*
						<a href="cambiar_cita.php?id=<?php echo $arr_result["id_presupuesto"];?>">Cambiar cita</a> | <span style="cursor:pointer" onclick="eliminarCita(<?php echo $arr_result['id_presupuesto'];?>)">Eliminar Cita</span> 
						*/
						?>
						</td>
				<?php
					}
				?>
				</tr>  
			  
		  <?php
			  }
		  ?>
			 </table>
			  </div>
		  <?php
				
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
		  
		  <div class="row" style="margin-top:25px;">  
			 <div class="col-md-12"><h5>CITAS ANTERIORES</h5></div> 
		 </div>
		  
		<div class="row"> 
		 <div class="col-md-12">
		  <?php
			
			/*$result=$mysqli->query("SELECT presupuestos.*,horarios_calendario.hora as hora, calendario.fecha as fecha FROM presupuestos,horarios_calendario,calendario,presupuestos_citas WHERE horarios_calendario.id_calendario = calendario.id AND presupuestos_citas.id_presupuesto = presupuestos.id_presupuesto AND presupuestos_citas.id_cita = horarios_calendario.id AND calendario.id_centro=".$obj_centro->id_centro." AND calendario.fecha < ".$fecha." AND presupuestos_citas.asignada=".$obj_verificador->id);*/
		    
			 $result=$mysqli->query("SELECT DISTINCT presupuestos.*,presupuestos_citas.fecha as fecha_cita FROM presupuestos,presupuestos_citas WHERE presupuestos_citas.id_presupuesto = presupuestos.id_presupuesto AND (presupuestos_citas.asignada = ".$obj_verificador->id." OR presupuestos_citas.asesor = ".$obj_verificador->id.") AND presupuestos_citas.fecha < '".date("Y-m-d H:i:s")."' ORDER BY fecha_cita DESC");
			if ($result->num_rows)
			{
		   ?>
			 <div class="table-responsive">
			  <table class="table">
		   <?php
			  while ($arr_result = $result->fetch_array())
			  {
			?>
			  
				<tr>
					<td><?php echo date("d-m-Y H:i",strtotime($arr_result["fecha_cita"]));?></td>
					<td>P. <?php echo $arr_result["id_presupuesto"];?></td>
					<td><?php echo $arr_result["nombre_cliente"];?></td>
					<?php
				  /*
					<td><?php echo $arr_result["direccion_cliente"];?> - <?php echo $arr_result["cp_cliente"];?> - <?php echo $arr_result["poblacion_cliente"];?> (<?php echo $arr_result["provincia_cliente"];?>)</td>
					<td><?php echo $arr_result["telefono_cliente"];?></td>
					*/
				  ?>
				  <?php
				  /*
					<td><?php echo $arr_result["direccion_cliente"];?> - <?php echo $arr_result["cp_cliente"];?> - <?php echo $arr_result["poblacion_cliente"];?> (<?php echo $arr_result["provincia_cliente"];?>)</td>
					<td><?php echo $arr_result["telefono_cliente"];?></td>
				*/
				  
				    $result_fichero=$mysqli->query("SELECT fichero FROM ficheros WHERE id_fichero=".$arr_result["id_fichero"]);
				    
				    $url_fichero="";
				    if ($result_fichero->num_rows)
					{
						while ($arr_result_fichero = $result_fichero->fetch_array())
						{
							$url_fichero=$arr_result_fichero["fichero"];
						}
				  ?>
					<td><a target="_blank" href="https://rehubik.com/<?php echo $url_fichero;?>">Ver presupuesto</a></td>
				<?php
					}
				?>
				</tr>  
			  
		  <?php
			  }
		  ?>
			 </table>
			  </div>
		  <?php
				
			}
			else
			{
		  ?>
			 <p>Actualmente no hay ninguna cita antigua para este verificador..</p> 
		  <?php
			}
		  ?>
		 </div>	 
		</div> 		  
		  
		  
		<div class="row" style="margin-top:25px;" id="horarios">  
			 <div class="col-md-12"><h5>HORARIOS <?php echo mb_strtoupper(utf8_encode($obj_centro->nombre));?></h5></div> 
		 </div>	
		  
		
		  <div class="row">
		   <div class="col-md-12">	  
				 <div class="table-responsive">
				  <table class="table">
					<tr> 
						 <th scope="col">Fecha</th> 
						 <th scope="col">Horario</th>
						 <th scope="col">Verificador</th>
						 <th scope="col">Asesor</th>
						 <th scope="col">Tipo</th>
						 <th scope="col">Servicio</th>
						 <th scope="col"><!--<input type="checkbox" id="allcheck">--> Acciones</th>
					</tr>
					 
					<?php
					  $result_fechas=$mysqli->query("SELECT * FROM horarios_calendario WHERE id_centro = $id_centro AND fecha >= '$fecha' ORDER BY fecha,hora,id ASC LIMIT " . $inicio . "," .$cantidad_resultados_por_pagina);
					  
					  $fecha_futura=date('Y-m-d', strtotime('+1 year'));
					  
					  $result_total_fechas=$mysqli->query("SELECT * FROM horarios_calendario WHERE id_centro = $id_centro AND fecha >= '$fecha' AND fecha <= '$fecha_futura' ORDER BY fecha,id ASC");
					  
				 	  $total_paginas = ceil($result_total_fechas->num_rows / $cantidad_resultados_por_pagina);
					  
				  	  $result_verificadores=$mysqli->query("SELECT DISTINCT administradores.* FROM administradores WHERE tipo != 3");
					  
					  /* $result_verificadores=$mysqli->query("SELECT DISTINCT administradores.* FROM administradores,administradores_centros WHERE administradores_centros.id_administrador = administradores.id AND tipo=0 AND id_centro=$id_centro"); */
					  
					  $result_asesores=$mysqli->query("SELECT DISTINCT administradores.* FROM administradores WHERE tipo != 3");
					  
				      while ($arr_result_fechas = $result_fechas->fetch_array())
					  {
					 ?>	  
					  <tr>
						<form name="<?php echo $arr_result_fechas['id'];?>" method="POST">
						 <td><?php echo $arr_result_fechas["fecha"];?></td>
					     <td><?php echo $arr_result_fechas["hora"];?></td>
					     <td>
							 <select name="verificador" class="form form-control">
							  <option value="">Sin asignar</option>
							   <?php
						  	    while ($arr_result_verificadores = $result_verificadores->fetch_array())
							    {
							   ?>
								 <option <?php if ($arr_result_verificadores['id'] == $arr_result_fechas['asignado']) { ?> selected <?php } ?> value="<?php echo $arr_result_verificadores['id'];?>">
									 <?php echo utf8_encode($arr_result_verificadores["nombre"])." ".utf8_encode($arr_result_verificadores["apellidos"]);?>
								 </option>
							   <?php	  
							    }
						  		$result_verificadores->data_seek(0);
						  	   ?>
							</select>	 
							
						
							
							
							</td>
							
							<td>
							 <select name="asesor" class="form form-control">
							  <option value="">Sin asignar</option>
							   <?php
						  	    while ($arr_result_asesores = $result_asesores->fetch_array())
							    {
							   ?>
								 <option <?php if ($arr_result_asesores['id'] == $arr_result_fechas['asesor']) { ?> selected <?php } ?> value="<?php echo $arr_result_asesores['id'];?>">
									 <?php echo utf8_encode($arr_result_asesores["nombre"])." ".utf8_encode($arr_result_asesores["apellidos"]);?>
								 </option>
							   <?php	  
							    }
						  		$result_asesores->data_seek(0);
						  	   ?>
							</select>	 
							
						
							
							
							</td>
							
					     <td class="tipo_<?php echo $arr_result_fechas["tipo"];?>">
							 <input <?php if ($arr_result_fechas["tipo"] == "P") {?> checked <?php } ?> type="radio" name="tipo" value="P"> Presencial <br/>
							 <input <?php if ($arr_result_fechas["tipo"] == "T") {?> checked <?php } ?> type="radio" name="tipo" value="T"> Televisita
							
							</td>
						
						 <td class="servicio_<?php echo $arr_result_fechas["servicio"];?>">
							 <input <?php if ($arr_result_fechas["servicio"] == "C") {?> checked <?php } ?> type="radio" name="servicio" value="C"> Cocina <br/>
							 <input <?php if ($arr_result_fechas["servicio"] == "B") {?> checked <?php } ?> type="radio" name="servicio" value="B"> Baño <br/>
							 <input <?php if ($arr_result_fechas["servicio"] == "I") {?> checked <?php } ?> type="radio" name="servicio" value="I"> Integral <br/>
							 <input <?php if ($arr_result_fechas["servicio"] == "P") {?> checked <?php } ?> type="radio" name="servicio" value="P"> Peq.Ref <br/>
							 <input <?php if ($arr_result_fechas["servicio"] == "M") {?> checked <?php } ?> type="radio" name="servicio" value="M"> Mampara <br/>
							 <input <?php if ($arr_result_fechas["servicio"] == "E") {?> checked <?php } ?> type="radio" name="servicio" value="E"> Electros <br/>
							</td>
							
						 <td><input type="button" value="Guardar" class="guardar btn-success" id="<?php echo $arr_result_fechas['id'];?>"></td>
						</form>	
					  </tr>
					 <?php	  
					  }
				 	 ?>	  
				   </table>
			   </div>  
			
			   
			  
			  </div>	
			  <?php
			   if ($total_paginas > 1){
				   $url_actual="http://".$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI];
				  ?>
					 <div class="col-md-12" style="margin-bottom:50px;text-align:right"><p>
				  <?php
					  
						for ($i=1;$i<=$total_paginas;$i++){
						   if ($pagina == $i)
						   {
						   ?>
						 	  <span class="paginador paginador-selected"><?php echo $pagina;?></span> 
						   <?php
						   }
						   else
						    {
						   ?>
						      <span class="paginador"><a href='<?php echo $url_actual;?>&pagina=<?php echo $i;?>#horarios'><?php echo $i;?></a></span>
						   <?php
						 	}
						}
					?> 
						 </p></div>
					<?php
					}
			  ?>
		  </div>
		 
		  <?php
		  /*
		  <div class="row">
		   <div class="col-md-12">
			   <p><b>Acciones en lote:</b> <br/>
			   <select name="verificador_lote" id="verificador_lote" class="form form-control">
				   <option value=""></option>
				   <option value="0">-- Sin asignar --</option>
				   <?php
				   while ($arr_result_verificadores = $result_verificadores->fetch_array())
				   { 
				   ?>	

					  <option <?php if ($arr_result_verificadores['id'] == $arr_result_calendario_horarios["verificador"]) {?> selected <?php } ?> value="<?php echo $arr_result_verificadores['id'];?>"><?php echo utf8_encode($arr_result_verificadores['nombre'])." ".utf8_encode($arr_result_verificadores['apellidos']);?></option>

				  <?php		
					}
				  ?>
				   </select> </p> 
		   </div>	  
		  </div>
		  
		  
		
		  */ 
		  ?>
		</div>	<!-- col-md-8 -->
		
	</div>
	  

  </div>
  <!-- /.container -->
  <!-- Bootstrap core JavaScript -->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../js/alertify.min.js"></script>	
  <script>
	 $("#buscar_presupuesto_ok").click(function() {
		 var id_presupuesto=document.getElementById("numero_presupuesto").value;
		 
		 $.ajax({
		  type: "POST",
		  dataType: 'json',  
		  url: "ajax/buscar_presupuesto.php",
		  data: {id_presupuesto:id_presupuesto},
		  success:function(respuesta){	
			 if (respuesta.contestacion == 0)
				 window.location.assign("https://rehubik.com/presupuestador/intranet/ver_presupuesto.php?id="+respuesta.id);
			 else
				 alert(respuesta.mensaje);
		  }

		}); // fin $.ajax 
		 
	 })
	  
	 function eliminarCita(id)
	 {
	   var id_presupuesto=id;
	   if (confirm("Vas a eliminar esta cita. Esta acción es irreversible"))
	   {
		   
		   $.ajax({
			  type: "POST",
			  dataType: 'json',  
			  url: "ajax/eliminar_cita.php",
			  data: {id_presupuesto:id_presupuesto},
			  success:function(respuesta){	
				location.reload();
			  }

		  }); // fin $.ajax 

	   }
		  
	 }
	  
	 
	 $(".guardar").click(function() {
		 
		 var id=this.id; //Este valor contiene ID verificador, fecha, hora e id centro separado por +
		 
		 var formulario=$("form[name='"+id+"']").serialize();
		 //alert(formulario);
		 $.ajax({
				  type: "POST",
				  dataType: 'json',  
				  url: "ajax/verificador_asignar_cita.php?id="+id,
				  data: formulario,
				  success:function(respuesta){	
					if (respuesta.contestacion == 0)
					  alertify.success(respuesta.mensaje);
					else
					  alertify.error(respuesta.mensaje);
				  }
		 }); 

		 
		 
		 
	 })
	 
	 $(".checktipo").click(function() {
		 
		 var valor=this.value; //Este valor contiene ID verificador, fecha, hora e id centro separado por +
		 
		 //alert(id_verificador);
		 //alert(id_horarios_calendario);
		 if (confirm("Vas a cambiar la asignación de la cita"))
		 {

			  $.ajax({
				  type: "POST",
				  dataType: 'json',  
				  url: "ajax/verificador_asignar_cita.php",
				  data: {valor:valor},
				  success:function(respuesta){	
					alert(respuesta.mensaje);
				  }

			  }); 

		 }
		 
		 
	 })	  
	  
    
	 $("#verificador_lote").change(function() {
		 var valor="";
		 var id_verificador=this.value;
		 $(".checkhorario").each(function() {
			  
			 if (this.checked)
			 {
				 //Si está marcado
				 valor+=this.value+","; //Este valor contiene ID verificador, fecha, hora e id centro separado por +
			 }
			 
		 });
		 
		 
		 if (valor == "")
		 {
			 alert("Para hacer una acción en lote, debes seleccionar al menos un checkbox");
		 }
		 else
		 {
			 
			 
			 if (confirm("Vas a cambiar la asignación de la cita"))
		 	 {

			    $.ajax({
				  type: "POST",
				  dataType: 'json',  
				  url: "ajax/verificador_asignar_cita_masiva.php",
				  data: {id_verificador:id_verificador,valor:valor},
				  success:function(respuesta){	
					alert(respuesta.mensaje);
					  location.reload();
				  }

			    });

		 	 }
			 
			 
			 
			 
			 
			 
		 }
		 
	 }) 
	  
	  
	  
	 //select all checkboxes
	$("#allcheck").change(function(){  //"select all" change 
		$(".checkhorario").prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status
	});

	//".checkhorario" change 
	$('.checkhorario').change(function(){ 
		//uncheck "select all", if one of the listed checkbox item is unchecked
		if(false == $(this).prop("checked")){ //if this item is unchecked
			$("#allcheck").prop('checked', false); //change "select all" checked status to false
		}
		//check "select all" if all checkbox items are checked
		if ($('.checkhorario:checked').length == $('.checkhorario').length ){
			$("#allcheck").prop('checked', true);
		}
	});
  </script>
</body>

</html>
