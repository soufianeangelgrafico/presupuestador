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

$id_presupuesto=(int)$_GET["id"];


$result=$mysqli->query("SELECT * FROM presupuestos WHERE id_presupuesto=$id_presupuesto");
if (!$result->num_rows)
 header("Location:index.php");

$obj_presupuesto = $result->fetch_object();


$instalacion = explode(",", $obj_presupuesto->elementos_instalacion);
$imagenes_instalacion="";
		

?>
<html lang="es">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Modern Business - Start Bootstrap Template</title>

  <!-- Bootstrap core CSS -->
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="../css/modern-business.css" rel="stylesheet">
  <style>
   @import url('https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,700,700i,900&display=swap');
</style>
	
	<style>
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
		.selected {
			border: 3px solid black;
		}
	</style>
</head>

<body class="page-presupuestador"> 
 
  <!-- Page Content -->
  <div class="container">
 
	<div class="row">
	  
	  <div class="col-md-3" style="height:100vh">
       <p class="textCenter"><img src="../img/area_privada.png" width="302" style="max-width:100%" class="marginbottom25 margintop25"></p>
		<iframe class="centrado" width="330" height="250" style="background-color: transparent;margin:0 auto;" frameborder="0" scrolling="no" src="../calendario/index.php"></iframe>  
	  </div>
		
	  <div class="col-md-9" style="background:white;">
     	
		 <div class="row margintop25 marginbottom25">
			<div class="col-md-6">
				<p><img src="../iconos/icono_verificador.png"> Hola, <b><?php echo $obj_admin->email;?></b></p>
			</div>	 
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
		 </div> 
		 <hr class="separacion"/> 
		  
		 <div id="contenedor-presupuesto">
			 
		  <div id="subcontenedor-presupuesto">

			  <div style="width:97%;background:#d6d6d6;margin:0px auto;padding:25px;">
				 <h2>PRESUPUESTO: <?php echo $obj_presupuesto->id_presupuesto;?></h2>

				 <div style="width:95%;background:white;border:2px solid black;padding:15px;">
					 <h3>DATOS CLIENTE</h3>
					 <div style="width:100%">
					  <form name="datos_cliente" id="datos_cliente" method="POST" action="#">
					   <div style="width:32%;padding:5px;display:inline-block;"><b>Nombre:</b><br/><input class="form form-control" type="text" name="nombre_cliente" value="<?php echo $obj_presupuesto->nombre_cliente;?>"></div>
					   <div style="width:32%;padding:5px;display:inline-block;"><b>Apellidos:</b><br/><input class="form form-control" type="text" name="apellidos_cliente" value="<?php echo $obj_presupuesto->apellidos_cliente;?>"></div>
					   <div style="width:32%;padding:5px;display:inline-block;"><b>Dirección:</b><br/><input class="form form-control" type="text" name="direccion_cliente" value="<?php echo $obj_presupuesto->direccion_cliente;?>"></div>
					   <div style="width:32%;padding:5px;display:inline-block;"><b>CP:</b><br/><input class="form form-control" type="text" name="cp_cliente" value="<?php echo $obj_presupuesto->cp_cliente;?>"></div>
					   <div style="width:32%;padding:5px;display:inline-block;"><b>Población:</b><br/><input class="form form-control" type="text" name="poblacion_cliente" value="<?php echo $obj_presupuesto->poblacion_cliente;?>"></div>	 
					   <div style="width:32%;padding:5px;display:inline-block;"><b>Provincia:</b><br/><input class="form form-control" type="text" name="provincia_cliente" value="<?php echo $obj_presupuesto->provincia_cliente;?>"></div>	
					   <div style="width:32%;padding:5px;display:inline-block;"><b>Teléfono:</b><br/><input class="form form-control" type="text" name="telefono_cliente" value="<?php echo $obj_presupuesto->telefono_cliente;?>"></div>	 
					   <div style="width:32%;padding:5px;display:inline-block;"><b>Email:</b><br/><input class="form form-control" type="text" name="email_cliente" value="<?php echo $obj_presupuesto->email_cliente;?>"></div>
					   <div style="width:32%;padding:5px;display:inline-block;"><input style="display:none" type="text" name="id_presupuesto" id="id_presupuesto" value="<?php echo $_GET['id'];?>"><input type="button" class="btn btn-success" style="padding:5px" id="guardar_datos_cliente" name="guardar_datos_cliente" value="GUARDAR"></div>	 
					  </form>
					 </div>
					  
				  </p>
					 
				  </div>

				  <div style="margin-top:25px;width:95%;background:white;border:2px solid black;padding:15px;">
					 <h3>DATOS TÉCNICOS Y ACABADOS</h3>
					   <br/>
					  <h5><a target="_blank" href="ver_plano.php?id=<?php echo $obj_presupuesto->id_presupuesto;?>">PLANO DIBUJADO</a></h5>
				  </div>

				  <div style="margin-top:25px;width:95%;background:white;border:2px solid black;padding:15px;">
					 <h3>INSTALACIÓN Y OBRA</h3>
					  
					  	<div class="row" style="padding-top:50px;">
							<div class="col-md-12">
							  <h2 class="marginbottom25">_PARA COCINAR</h2> 
							  <ul class="listado_imagenes">
								  <li><img <?php if (in_array("placa_gas", $instalacion)) { ?> class="selected elemento_instalacion" <?php } else { ?>class="elemento_instalacion" <?php } ?> src="../iconos/placa_gas.png" id="placa_gas"><br/>PLACA DE GAS</li>
								  <li><img <?php if (in_array("vitro_induccion", $instalacion)) { ?> class="elemento_instalacion selected" <?php } else { ?> class="elemento_instalacion" <?php } ?> src="../iconos/vitro_induccion.png" id="vitro_induccion"><br/>VITRO/INDUCCIÓN</li>
								  <li><img <?php if (in_array("horno", $instalacion)) { ?> class="elemento_instalacion selected" <?php } else { ?>class="elemento_instalacion" <?php } ?>  src="../iconos/horno.png" id="horno"><br/>HORNO</li>
								  <li><img <?php if (in_array("microondas", $instalacion)) { ?> class="elemento_instalacion selected" <?php } else { ?> class="elemento_instalacion" <?php } ?> src="../iconos/microondas.png" id="microondas"><br/>MICROONDAS</li>
								  <li><img <?php if (in_array("extractor", $instalacion)) { ?> class="elemento_instalacion selected" <?php } else { ?>class="elemento_instalacion" <?php } ?> src="../iconos/extractor.png" id="extractor"><br/>EXTRACTOR</li>
								  <li><img <?php if (in_array("frigorifico", $instalacion)) { ?> class="selected elemento_instalacion" <?php } else { ?>class="elemento_instalacion" <?php } ?> src="../iconos/frigorifico.png" id="frigorifico"><br/>FRIGORIFICO</li>

							  </ul>
							</div>	  
						  </div>
					     
					  	  <div class="row paddingtop0">
							<div class="col-md-12">
							  <h2 class="marginbottom25">_PARA LAVAR</h2> 
							  <ul class="listado_imagenes">
								  <li><img <?php if (in_array("fregadero", $instalacion)) { ?> class="elemento_instalacion selected" <?php } else { ?>class="elemento_instalacion" <?php } ?>  src="../iconos/fregadero.png" id="fregadero"><br/>FREGADERO</li>
								  <li><img <?php if (in_array("lavavajillas", $instalacion)) { ?> class="elemento_instalacion selected" <?php } else { ?>class="elemento_instalacion" <?php } ?> src="../iconos/lavavajillas.png" id="lavavajillas"><br/>LAVAVAJILLAS</li>
								  <li><img <?php if (in_array("lavadora", $instalacion)) { ?> class="elemento_instalacion selected" <?php } else { ?>class="elemento_instalacion" <?php } ?> src="../iconos/lavadora.png" id="lavadora"><br/>LAVADORA</li>
								  <li><img <?php if (in_array("secadora", $instalacion)) { ?> class="elemento_instalacion selected" <?php } else { ?>class="elemento_instalacion" <?php } ?> src="../iconos/secadora.png" id="secadora"><br/>SECADORA</li>

							  </ul>
							</div>	  
						  </div>
					  
					  
					  
					  	  <div class="row paddingtop0">
							<div class="col-md-12">
							  <h2 class="marginbottom25">_PARA CALENTAR</h2> 
							  <ul class="listado_imagenes">
								  <li><img <?php if (in_array("calentador", $instalacion)) { ?> class="elemento_instalacion selected" <?php } else { ?> class="elemento_instalacion" <?php } ?> src="../iconos/calentador.png" id="calentador"><br/>CALENTADOR GAS</li>
								  <li><img <?php if (in_array("termo", $instalacion)) { ?> class="elemento_instalacion selected" <?php } else { ?>class="elemento_instalacion" <?php } ?> src="../iconos/termo.png" id="termo"><br/>TERMO</li>
								  <li><img <?php if (in_array("caldera", $instalacion)) { ?> class="elemento_instalacion selected" <?php } else { ?>class="elemento_instalacion" <?php } ?> src="../iconos/caldera.png" id="caldera"><br/>CALDERA</li>
								  <li><img <?php if (in_array("radiador", $instalacion)) { ?> class="elemento_instalacion selected" <?php } else { ?>class="elemento_instalacion" <?php } ?> src="../iconos/radiador.png" id="radiador"><br/>RADIADOR</li>

							  </ul>
							</div>	  
						  </div>
					  
					  
					  	  <div class="row paddingtop0">
							<div class="col-md-12">
							  <h2 class="marginbottom25">_DE ELECTRICIDAD</h2> 
							  <ul class="listado_imagenes">
								  <li><img <?php if (in_array("puntos_extras", $instalacion)) { ?> class="elemento_instalacion selected" <?php } else { ?>class="elemento_instalacion" <?php } ?> src="../iconos/puntos_extras.png" id="puntos_extras"><br/>PUNTOS ELÉCTRICOS<br/> EXTRAS</li>
								  <li><img <?php if (in_array("puntos_luz_techo", $instalacion)) { ?> class="elemento_instalacion selected" <?php } else { ?>class="elemento_instalacion" <?php } ?> src="../iconos/puntos_luz_techo.png" id="puntos_luz_techo"><br/>PUNTOS DE LUZ<br/> EN TECHO</li>
							  </ul>
							</div>	  
						  </div>
					  
					  
					  
					  	  <div class="row paddingtop0">
							<div class="col-md-12">
							  <h2 class="marginbottom25">_DE FONTANERÍA</h2> 
							  <ul class="listado_imagenes">
								  <li><img <?php if (in_array("llave_corte_agua", $instalacion)) { ?> class="elemento_instalacion selected" <?php } else { ?>class="elemento_instalacion" <?php } ?> src="../iconos/llave_corte_agua.png" id="llave_corte_agua"><br/>LLAVE DE CORTE<br/> EN LA VIVIENDA</li>
							  </ul>
							</div>	  
						  </div>
					  
					  
					  	 <div class="row paddingtop0">
							<div class="col-md-12">
							  <h2 class="marginbottom25">_DE GAS</h2> 
							  <ul class="listado_imagenes">
								  <li><img <?php if (in_array("instalacion_gas", $instalacion)) { ?> class="elemento_instalacion selected" <?php } else { ?>class="elemento_instalacion" <?php } ?> src="../iconos/instalacion_gas.png" id="instalacion_gas"><br/>INSTALACIÓN DE GAS</li>
								  <li><img <?php if (in_array("anular_punto_gas", $instalacion)) { ?> class="elemento_instalacion selected" <?php } else { ?>class="elemento_instalacion" <?php } ?> src="../iconos/anular_punto_gas.png" id="anular_punto_gas"><br/>ANULACIÓN PUNTO GAS</li>
							  </ul>
							</div>	  
						  </div> 
					  
					  	<div class="row paddingtop0">
							<div class="col-md-12">
							  <h2 class="marginbottom25">_DE ALBAÑILERÍA</h2> 
							  <ul class="listado_imagenes">
								  <li><img <?php if (in_array("hacer_tabique", $instalacion)) { ?> class="elemento_instalacion selected" <?php } else { ?>class="elemento_instalacion" <?php } ?> src="../iconos/hacer_tabique.png" id="hacer_tabique"><br/>HACER TABIQUE</li>
								  <li><img <?php if (in_array("tirar_tabique", $instalacion)) { ?> class="elemento_instalacion selected" <?php } else { ?> class="elemento_instalacion" <?php } ?> src="../iconos/tirar_tabique.png" id="tirar_tabique"><br/>TIRAR TABIQUE</li>
								  <li><img <?php if (in_array("falso_techo", $instalacion)) { ?> class="elemento_instalacion selected" <?php } else { ?>class="elemento_instalacion" <?php } ?> src="../iconos/falso_techo.png" id="falso_techo"><br/>FALSO TECHO</li>
							  </ul>
							</div>	  
						  </div>
					  	 
					  	 <div class="row">
							 <div class="col-md-12"><input type="button" id="guardar_instalacion" name="guardar_instalacion" class="btn btn-success" value="GUARDAR">
							 </div>
					  </div>
					 <?php
						/*$imagenes_instalacion.="<img src='http://angelgrafico.com/rehubic/iconos/".$instalacion[$i].".png'>";*/

					  
					  ?>
					 <?php /* echo $imagenes_instalacion; */ ?>
				  </div>

			  </div>

			  <hr/>
			  <div id="footer">
				  
			  
			  	  <p style="margin-bottom: 25px; text-align:center;">
					  <input type="button" class="btn btn-success" value="PASARELA DE PAGO">
				  </p>
				  <p style="margin-bottom: 25px; text-align:center;">
					  <input type="button" id="reenviar_email" class="btn btn-success" value="REENVIAR E-MAIL AL CLIENTE">
				  </p>
			  </div>

		  </div>
		 </div>
		
		 
		</div>	<!-- col-md-8 -->
		
	</div>
	  

  </div>
  <!-- /.container -->
  <!-- Bootstrap core JavaScript -->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script>
	 $(".elemento_instalacion").click(function() {
		 var id=this.id;
		 if ($("#"+id).hasClass("selected"))
		  $("#"+id).removeClass("selected");
		 else
		  $("#"+id).addClass("selected"); 
		 
	 })
	  
	 $("#guardar_datos_cliente").click(function() {
		 
		 var formulario=$("#datos_cliente").serialize();
		 //alert(formulario);
		 $.ajax({
		  type: "POST",
		  dataType: 'json', 
		  url: "ajax/actualizar_datos_cliente.php",
		  data: formulario,
		  success:function(respuesta){	
			 alert(respuesta.mensaje);
		  }

		}); // fin $.ajax 
	
	 })
		 
	  $("#guardar_instalacion").click(function() {
		  var ids="";
		  var id_presupuesto=document.getElementById("id_presupuesto").value;
		  $(".selected").each(function( ) {
				 //Recorro en busca de todos los IDS que tienen la clase SELECTED. Que son los servicios que se han seleccionado
				 ids+=this.id+",";
		  
	  	 })	 
		 
		 // alert(ids);
		  
		  $.ajax({
		   type: "POST",
		   dataType: 'json', 
		   url: "ajax/actualizar_instalaciones.php",
		   data: {id_presupuesto:id_presupuesto,elementos_instalacion:ids},
		   success:function(respuesta){	
			 alert(respuesta.mensaje);
		   }

		 }); // fin $.ajax 
		  
	 }) 
	  
	  
	 $("#buscar_presupuesto_ok").click(function() {
		 var id_presupuesto=document.getElementById("numero_presupuesto").value;
		 
		 $.ajax({
		  type: "POST",
		  dataType: 'json',  
		  url: "ajax/buscar_presupuesto.php",
		  data: {id_presupuesto:id_presupuesto},
		  success:function(respuesta){	
			 if (respuesta.contestacion == 0)
				 window.location.assign("https://rehubik.com/presupuestador/ver_presupuesto.php?id="+respuesta.id);
			 else
				 alert(respuesta.mensaje);
		  }

		}); // fin $.ajax 
		 
	 }) 
	  
	 
	 $("#reenviar_email").click(function() {
		 
		 var id_presupuesto=document.getElementById("id_presupuesto").value;
		 
		 if (confirm("¿Reenviar email de presupuesto al cliente?"))
		 {
			 
			 $.ajax({
			  type: "POST",
			  dataType: 'json',  
			  url: "ajax/enviar_email_presupuesto.php",
			  data: {id_presupuesto:id_presupuesto},
			  success:function(respuesta){	
					 alert(respuesta.mensaje);
			  }

			}); // fin $.ajax
			 
		 }
		 
		 
	 })
 </script>
</body>

</html>
