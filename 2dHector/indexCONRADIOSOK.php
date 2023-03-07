<?php
session_start();

//Genero una cookie random, para crear una sesión temporal que expira en 1 hora
if (!isset($_COOKIE["random"]))
  setcookie("random",md5(microtime()), time()+3600); 

$mysqli = new mysqli("localhost","admin_rehubik","Rehubic2018","admin_rehubik");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Fallo al conectar con la base de datos: " . $mysqli -> connect_error;
  exit();
}

if (isset($_GET["id_presupuesto"]))
{
	$result_altura_pared=$mysqli->query("SELECT altura_pared FROM clientes WHERE id_presupuesto=".$_GET["id_presupuesto"]." AND altura_pared != 0");
	
	while ($arr_result_pared = $result_altura_pared->fetch_array())
	 $altura_pared=$arr_result_pared["altura_pared"];
	
}
?>

<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Rehubik</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="js/OwlCarousel/dist/assets/owl.carousel.css">
	<link rel="stylesheet" href="js/OwlCarousel/dist/assets/owl.theme.default.css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<style>
	 ul.listado_imagenes.opciones_trabajos_menu {
		display: none;
	 }
		input.paredes {
    display: none;
}
		input[name="metros_parcial"] {
			display: none;
		}
	</style>
</head>

<body style="background:#d6d6d6;margin:0;padding:0; ">
  <div class="modal fade" id="textToLayer" tabindex="-1" role="dialog" aria-labelledby="textToLayerLabel">

    <div class="modal-dialog" role="document">

      <div class="modal-content">

        <div class="modal-header">

          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

          <h4 class="modal-title" id="textToLayerLabel">Observaciones</h4>

        </div>

        <div class="modal-body">

          <p>Tamaño del texto</p>

          <input type="range" list="tickmarks" id="sizePolice" step="0.1" min="10" max="30" value="15" class="range" style="width:200px"/>

          <hr/>

          <p contenteditable="true" id="labelBox" onfocus="this.innerHTML='';" style="font-size:15px;padding:5px;border-radius:5px;color:#333">Escribe aquí tu texto</p>

        </div>

        <div class="modal-footer">

          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>

          <button type="button" class="btn btn-primary" onclick="$('#textToLayer').modal('hide');">Guardar</button>

        </div>

      </div>

    </div>

  </div>	
<?php
 //$_SESSION["login"] se crea cuando el admin entra en la intranet
 if (isset($_SESSION["login"]) || !isset($_GET["id_presupuesto"]))
 {
?>	 
 <div id="parte_superior">
	 <div id="header">
		 <div id="logo"><img src="https://rehubik.com/wp-content/uploads/2020/07/logo_blanco.png" width="95"></div>
		 <?php
		  if (isset($_GET["id_presupuesto"]) && isset($_SESSION["login"]))
		  {
		 ?>
		   <div id="btnFinalizarVerificador"><span>Finalizar</span></div>
		 <?php
		  }
		  else if (!isset($_GET["id_presupuesto"]))
		  {
		 ?>
		 <div id="btnFinalizar"><span>Finalizar</span></div>
		 <?php
		  }
		 ?>
	 </div>

	 
	<div id="menu_planificador_movil">
	 <div class="paso_menu_movil" onclick="window.open('https://rehubik.com/presupuestador/2d/ver_plano_estado_actual.php?sesion=<?php echo $_COOKIE['random'];?>','Estado actual','menubar=1,resizable=1,width=380,height=400')">PASO 1: ESTADO ACTUAL</div>
 	 <div class="paso_menu_movil menu-activo" id="menu_plano_movil">PASO 2: ESTADO REFORMADO</div>
	 <div class="paso_menu_movil" id="menu_mobiliario_movil">PASO 3: MOBILIARIO</div>
	 <div class="paso_menu_movil" id="menu_instalaciones_movil">PASO 4: INSTALACIONES</div>
	 <div class="paso_menu_movil" id="menu_materiales_movil">PASO 5: MATERIALES</div>
	</div> 
	 
	<div id="menu_planificador">
		
		<div class="divmenu" onclick="window.open('https://rehubik.com/presupuestador/2d/ver_plano_estado_actual.php?sesion=<?php echo $_COOKIE['random'];?>','Estado actual','menubar=1,resizable=1,width=1200,height=600')"><h2 class="titular-planificador"><span class="paso-menu">1.</span> <b style="color:black">PASO 1:</b> ESTADO ACTUAL</h2></div>
		<div class="divmenu menu-activo"><h2 class="titular-planificador"><span class="paso-menu">2.</span> <b style="color:black">PASO 2:</b> ESTADO REFORMADO</h2></div>
		
		<div class="divmenu" id="menu_plano"><h5 class="subtitular-planificador">PASO 2.1: TABIQUES, PUERTAS Y VENTANAS <i class="fa fa-info-circle" onclick="instrucciones('paso21')"></i></h5></div>
		
		<div class="divmenu" id="menu_mobiliario"><h5 class="subtitular-planificador">2.2: MOBILIARIO Y ELECTRODOMÉSTICOS <i class="fa fa-info-circle" onclick="instrucciones('paso22')"></i></h5></div>
		
		<div class="divmenu" id="menu_instalaciones">
		  <h5 class="subtitular-planificador">2.3 INSTALACIONES</h5>
		</div>
		
		<div class="divmenu" id="observaciones">
		   <h5 class="subtitular-planificador">2.4 OBSERVACIONES</h5>
		</div>
		
		<div class="divmenu" id="menu_trabajos">
			<h5 class="titular-planificador"><span class="paso-menu">3</span> TRABAJOS A REALIZAR <i class="fa fa-info-circle" onclick="instrucciones('paso23')"></i></h5>
			<ul class="listado_imagenes opciones_instalaciones_menu_escritorio">
				 <li class="submenu_instalaciones menu-demoliciones" onclick="muestraInstalaciones('demoliciones')">DEMOLICIONES</li>
				 <li class="submenu_instalaciones menu-electricidad" onclick="muestraInstalaciones('electricidad')">INSTALACIÓN ELECTRICA</li>
				 <li class="submenu_instalaciones menu-equipamiento" onclick="muestraInstalaciones('equipamiento')">INSTALACIONES EQUIPAMIENTO</li>  
				 <li class="submenu_instalaciones menu-revestimientos_instalaciones" onclick="muestraInstalaciones('revestimientos_instalaciones')">REVESTIMIENTOS</li>
				 <li class="submenu_instalaciones menu-gas" onclick="muestraInstalaciones('gas')">GAS</li>  
				 <li class="submenu_instalaciones menu-carpinteria_interior" onclick="muestraInstalaciones('carpinteria_interior')">CARPINTERÍA INTERIOR</li>
				 <li class="submenu_instalaciones menu-carpinteria_exterior" onclick="muestraInstalaciones('carpinteria_exterior')">CARPINTERÍA EXTERIOR</li>  
				<?php
				 if (isset($_SESSION["login"]) && isset($_GET["id_presupuesto"]))
				 {
				?>
				   <li id ="menu_sc" onclick="muestraInstalaciones('menu-sc')" class="submenu_instalaciones menu-sc">S/C
				
				     <!--<div id="listado_sc"></div>-->
					   
				   </li>
				 
				<?php
				 }
				?>
			   </ul>
			
		
		</div>
		
		
		<div id="menu_materiales">
			<h2 class="titular-planificador"><span class="paso-menu">5.</span> <b style="color:black">PASO 5:</b> MATERIALES</h2></div>  
		
		
		
	</div>

	<div id="panel_informacion">
	 
	 <div id="opciones_observacion" style="display:none;">
		 <button class="btn btn-default fully " id="text_mode" data-toggle="tooltip" data-placement="right" title="Nueva observación" onclick="alertify.alert('Indica las observaciones que consideres necesarias para la reforma de tu cocina y que no hayan sido definidas en los pasos anteriores.<br/><br/> Ej.1: No existe falso techo en mi cocina actual.<br/> Ej.2: Tengo una viga que atraviesa la cocina en horizontal, en ese punto. <br/><br/> Para ello, <b>haz clic en la parte del plano que quieras añadir la observación. Escríbela y pulsa en Guardar</b>')">Añadir observación</button>
	 </div>
		
	 <div style="text-align:center;margin-top:10px;">
		
		
		 
	 </div>
	 <div id="opciones_crear_plano" style="display:none;">
		  <div id="panel">
			<button class="btn btn-default" id="select_mode"><i class="fa fa-2x fa-mouse-pointer" aria-hidden="true"></i> Seleccionar</button>
			<p style="display:none;">
				<button class="btn" id="undo" title="undo"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i></button>
				<button class="btn" id="redo" title="redo"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i></button>
			</p>

			
			 <?php
	 		  if (!isset($_SESSION["login"]))
			  {
				 //El verificador no puede crear nuevos muros, puede modificar los que ya hay
			 ?>
				<button class="btn btn-success" style="height: 47px;" id="line_mode" data-toggle="tooltip" data-placement="right" title="Comenzar">COMENZAR</button>
			 <?php
			  }
	 		 ?>
				
				
				<span id="sizePolice"></span>
			
			  
			  <button class="btn btn-default fully " id="door_mode" onclick="$('.sub').hide();$('#door_list').toggle(200);$('#window_list').hide();">Puertas</button>
				  <div id="door_list"  class="list-unstyled sub" style="display:none;background:#fff;padding:10px;">
					  <button class="btn fully door" id="aperture">Puerta 1</button>
					  <button class="btn fully door" id="simple">Puerta 2</button>
					  <button class="btn fully door" id="double">Puerta 3</button>
					  <button class="btn fully door" id="pocket">Puerta 4</button>
				    </div>
			  <button class="btn btn-default fully " id="window_mode" onclick="$('.sub').hide();$('#window_list').toggle(200);$('#door_list').hide()">Ventanas</button>
			  <div id="window_list"  class="list-unstyled sub" style="display:none;background:#fff; padding:10px;">
				  <button class="btn fully window" id="fix">Ventana 1</button>
				  <button class="btn fully window" id="flap">Ventana 2</button>
				  <button class="btn fully window" id="twin">Ventana 3</button>
				  <button class="btn fully window" id="bay">Ventana 4</button>
        	  </div>
			
		  </div>


			<div id="informacion_pared">
				<label>Altura techo:</label>
				<input type="range" value="2" min="2" max="5" step="0.01" oninput="this.nextElementSibling.value = this.value">
				<output style="display:inline-block">2</output> metros
			</div>
		
		    <div id="informacion_panel">
				<div id="listado_muros"></div>

				  <div id="wallTools" style="display:none;">
					<h2 id="titleWallTools">Modifica la pared</h2>
					<hr/>
					<section id="rangeThick">
					  <p><b>Modificando Pared:</b> <span id="wallWidthScale"></span>  <span id="wallWidthVal"></span></p>
					  <input style="display:none" type="text" id="wallWidth" />
					</section>
					<ul class="list-unstyled">
					<li><button class="btn btn-danger" id="wallTrash"><i class="fa fa-2x fa-trash-o" aria-hidden="true"></i></button>
					<button class="btn btn-info" onclick="fonc_button('select_mode');$('#boxinfo').html('Modo selección');$('#wallTools').hide('300');$('#panel').show('300');"><i class="fa fa-2x fa-backward" aria-hidden="true" ></i></button></li>
					</ul>
					<div id="opcion_tabiqueria">
					  <p>
						  <input type="radio" name="opcion_tabique" value="mantener" checked> Tabique a mantener <br/>
						  <input type="radio" name="opcion_tabique" value="demoler"> Tabique a demoler <br/>
						  <input type="radio" name="opcion_tabique" value="nuevo"> Tabique nuevo <br/>
					  </p>	
					</div>  
					  
				  </div>
			</div>
		
	 </div>
	 <div id="opciones_materiales" style="display:none;">
		<div class="texto-li centrado titulo-material">PAVIMENTOS</div>
	 	<div id="pavimentos">
		  <?php
			$result_materiales=$mysqli->query("SELECT * FROM materiales WHERE rvpv='Pavimento'");
			while ($arr_result_material = $result_materiales->fetch_array())
			{
				$elemento_seleccionado=false;
				if (isset($_GET["id_presupuesto"]))
				{
					//Si existe id usuario, está viendo un mapa ya creado, miro si seleccionó alguno de estos elementos
					$result_seleccion=$mysqli->query("SELECT * FROM clientes WHERE id_presupuesto=".$_GET["id_presupuesto"]." AND referencia_material='".$arr_result_material["referencia"]."'");
					
					if ($result_seleccion->num_rows)
					{
					  $elemento_seleccionado=true;
					
					}
					else
					{ 
					  $elemento_seleccionado=false;
					}
						  
				}
				
		  ?>
			 	<div><img class="elemento_instalacion elemento_material <?php if (isset($_GET["id_presupuesto"]) && $elemento_seleccionado) {?> selected <?php } ?>" id="<?php echo $arr_result_material["referencia"];?>"  width="75" src="<?php echo $arr_result_material["foto"];?>"> <?php echo $arr_result_material["modelo"];?> (<?php echo $arr_result_material["pvp"] * 1.15;?>&euro; / m2)
				<form class="form_generico" name="<?php echo $arr_result_material['referencia'];?>" method="POST" action="#">
				   <input type="text" name="elemento" style="display:none" value="<?php echo $arr_result_material['referencia'];?>">
				</form>
				</div>
		   <?php
			}
			 $result_materiales->free();
		   ?>
			
		</div>
	 
		<div class="texto-li centrado titulo-material">REVESTIMIENTOS</div>
	 	<div id="revestimientos">
		  <?php
			$result_materiales=$mysqli->query("SELECT * FROM materiales WHERE rvpv='Revestimiento'");
			while ($arr_result_material = $result_materiales->fetch_array())
			{
				$elemento_seleccionado=false;
				if (isset($_GET["id_presupuesto"]))
				{
					//Si existe id usuario, está viendo un mapa ya creado, miro si seleccionó alguno de estos elementos
					$result_seleccion=$mysqli->query("SELECT * FROM clientes WHERE id_presupuesto=".$_GET["id_presupuesto"]." AND referencia_material='".$arr_result_material["referencia"]."'");
					
					if ($result_seleccion->num_rows)
					{
					  $elemento_seleccionado=true;
					  $paredes="";
					  while ($arr_result_seleccion = $result_seleccion->fetch_array())
					  {
						  
						  if ($paredes == "")
							 $paredes=$arr_result_seleccion["paredes"];
						  else
						    $paredes=$paredes.",".$arr_result_seleccion["paredes"];
						  
						  $paredes_totales=$arr_result_seleccion["total_paredes"];
						  $unidades=$arr_result_seleccion["unidades"];
						  $metros_lineales=$arr_result_seleccion["metros_lineales"];
					  }
					}
					else
					{ 
					  $elemento_seleccionado=false;
					  $paredes="";
					  //Saco solo las paredes totales	
					  $result_paredes_totales=$mysqli->query("SELECT total_paredes FROM clientes WHERE id_presupuesto=".$_GET["id_presupuesto"]." AND total_paredes != '' LIMIT 1");
					  
					  while ($arr_result_paredes_totales = $result_paredes_totales->fetch_array())
					   	 $paredes_totales=$arr_result_paredes_totales["total_paredes"];	
					}
						  
				}
		  ?>
			 	<div><img class="elemento_instalacion elemento_material <?php if (isset($_GET["id_presupuesto"]) && $elemento_seleccionado) {?> selected <?php } ?>" id="<?php echo $arr_result_material["referencia"];?>"  width="75" src="<?php echo $arr_result_material["foto"];?>"> <?php echo $arr_result_material["modelo"];?> (<?php echo $arr_result_material["pvp"] * 1.15;?>&euro; / m2)
				<!--<form class="form_generico" name="< ?php echo $arr_result_material['referencia'];?>" method="POST" action="#">
				  <input type="text" name="elemento" style="display:none" value="< ?php echo $arr_result_material['referencia'];?>">
				 </form> -->
				<?php
					  if ($arr_result_material["mostrar"] == "muros")
					  {
						  //Le dejo que seleccione el/los muros a los que va esta acción
					?>
						
						  <div class="listado_muros" <?php if (isset($_GET["id_presupuesto"])) {?> style="display:block;" <?php } ?>>
							<form class="form_muros" name="<?php echo $arr_result_material['referencia'];?>" method="POST" action="#">
							 <input type="text" name="elemento" style="display:none" value="<?php echo $arr_result_material['referencia'];?>">
							<?php
						  if (isset($_GET["id_presupuesto"]))
					  	  {
							  
						   //Le muestro muros
						   $paredes_totales_array=explode(",", $paredes_totales);
						   
						   for ($i=0;$i<count($paredes_totales_array);$i++)
						   {
							 if ($paredes_totales_array[$i] != "")
							 {
								 if (strstr($paredes, $paredes_totales_array[$i]))
								 {
									 //Busco si tiene longitud marcada
									 $result_longitud=$mysqli->query("SELECT longitud_pared FROM clientes WHERE id_presupuesto=".$_GET['id_presupuesto']." AND longitud_pared != 0 LIMIT 1");
									 
									 if ($result_longitud->num_rows)
									 {
									   while ($arr_result_longitud = $result_longitud->fetch_array())
										  $longitud=$arr_result_longitud["longitud_pared"];
									   $valor_pared=$paredes_totales_array[$i]."/".$longitud;
									 }
									 else 
									 {
										$longitud="";
									 	$valor_pared=$paredes_totales_array[$i]; 
									 }
									 
									 
								 }
								 else
								 {
									 $longitud="";
									 $valor_pared=$paredes_totales_array[$i];
								 }
						?>	   
							  <span class="checkmuro"><input <?php if (strstr($paredes, $paredes_totales_array[$i])) { ?> checked <?php } ?> type="checkbox" name="paredes[]" class="paredes" value="<?php echo $valor_pared;?>"> <?php echo $paredes_totales_array[$i];?> <?php if ($longitud != "") { ?><div class="metros_seleccionados">(<?php echo $longitud;?>m seleccionados)</div> <?php } ?></span>
						<?php	
							 }
						   }
					  }
					?>
								
							</form>
						  </div>
						  <?php
						   if (isset($_GET["id_presupuesto"]) && $elemento_seleccionado)
						   {
						  ?>
							<div style="color:#95C11F">Muros marcados: <?php echo $paredes;?></div>
						  <?php
						   }
						  
						  ?>
					
					<?php
					  }
					?>
					</div>
			
		   <?php
			}
			 $result_materiales->free();
		   ?>
			
		</div> 
		
		 
		 
		 
		 
		 
	 </div>
	 
	 
	 <div id="opciones_mobiliario" style="display:none">
		 
		 <p style="font-size:12px">* Gire o elimine el mobiliario dando click al elemento una vez lo haya añadido al plano</p>
		 <div class="object tipo_mobiliario">MÓDULOS BAJOS</div>  
		 
		 <!-- class objetos -->
		 <div id="modulos_bajos">
			 
			 <div class="tipo_mobiliario">Profundidad 60cm</div>
			 <ul class="owl-carousel owl-theme" style="display: block;">
			  <li><img src="modulos_bajos/60cm/placa-electrica-80.png" class="modulo btn fully object" id="placa-electrica80" width="83" style="width:83px"></li>
			  <li><img src="modulos_bajos/60cm/placa-electrica-60.png" class="modulo btn fully object" id="placa-electrica60" style="width:83px"></li>
			  <li><img src="modulos_bajos/60cm/placa-electrica-horno-60.png" class="modulo btn fully object" id="placa-electrica-horno60" style="width:83px"></li>
			  <li><img src="modulos_bajos/60cm/placa-electrica-40.png" class="modulo btn fully object" id="placa-electrica40" style="width:83px"></li>
			  <li><img src="modulos_bajos/60cm/placa-gas-80.png" class="modulo btn fully object" id="placa-gas80" width="83" style="width:83px"></li>
			  <li><img src="modulos_bajos/60cm/placa-gas-60.png" class="modulo btn fully object" id="placa-gas60" style="width:83px"></li>
			  <li><img src="modulos_bajos/60cm/placa-gas-horno-60.png" class="modulo btn fully object" id="placa-gas-horno" style="width:83px"></li>
			  <li><img src="modulos_bajos/60cm/placa-gas-40.png" class="modulo btn fully object" id="placa-gas40" style="width:83px"></li>
			  <li><img src="modulos_bajos/60cm/fregadero-80.png" class="modulo btn fully object" id="fregadero80" style="width:83px"></li>
			  <li><img src="modulos_bajos/60cm/fregadero-60.png" class="modulo btn fully object" id="fregadero60" style="width:83px"></li>
			  <li><img src="modulos_bajos/60cm/fregadero-40.png" class="modulo btn fully object" id="fregadero40" style="width:83px"></li>	 
			  <li><img src="modulos_bajos/60cm/mueble-bajo-80.png" class="modulo btn fully object" id="mueble-bajo80" style="width:83px"></li>	 
			  <li><img src="modulos_bajos/60cm/mueble-bajo-60.png" class="modulo btn fully object" id="mueble-bajo60" style="width:83px"></li>	 
			  <li><img src="modulos_bajos/60cm/mueble-bajo-40.png" class="modulo btn fully object" id="mueble-bajo40" style="width:83px"></li>	
			  <li><img src="modulos_bajos/60cm/mueble-bajo-30.png" class="modulo btn fully object" id="mueble-bajo30" style="width:83px"></li>	 
			  <li><img src="modulos_bajos/60cm/mueble-bajo-20.png" class="modulo btn fully object" id="mueble-bajo20" style="width:83px"></li>	 
			 </ul>
			 
			 <div class="tipo_mobiliario">Profundidad reducida 40cm</div>
			 <ul class="owl-carousel owl-theme" style="display: block;">
			  <li><img src="modulos_bajos/40cm/mueble-bajo-reducido-80.png" class="modulo btn fully object" id="reducida80" style="width:83px"></li>	
			  <li><img src="modulos_bajos/40cm/mueble-bajo-reducido-60.png" class="modulo btn fully object" id="reducida60" style="width:83px"></li>	
			  <li><img src="modulos_bajos/40cm/mueble-bajo-reducido-40.png" class="modulo btn fully object" id="reducida40" style="width:83px"></li>	
			  <li><img src="modulos_bajos/40cm/mueble-bajo-reducido-30.png" class="modulo btn fully object" id="reducida30" style="width:83px"></li>	
			 </ul>
			 
			 <div class="tipo_mobiliario">Esquineros</div>
			 <ul class="owl-carousel owl-theme" style="display: block;">
			  <li><img src="modulos_bajos/esquineros/mueble-bajo-88.png" class="modulo btn fully object" id="esquinero88" style="width:83px"></li>	
			  <li><img src="modulos_bajos/esquineros/mueble-bajo-128B.png" class="modulo btn fully object" id="esquinero128b" style="width:83px"></li>
			  <li><img src="modulos_bajos/esquineros/mueble-bajo-128A.png" class="modulo btn fully object" id="esquinero128a" style="width:83px"></li>	 
			 </ul>
			 
			 
			</div>	
		 
		 <div class="object tipo_mobiliario">MÓDULOS ALTOS</div>	
		 <!-- class objetos -->
		 <div id="modulos_altos">
		  <ul class="owl-carousel owl-theme" style="display: block;">	 
			<li><img src="modulos_altos/microondas.png" class="btn fully object" id="mueble-alto-microondas" width="65" style="width:83px"></li>
			<li><img src="modulos_altos/termo-electrico.png" class="btn fully object" id="mueble-alto-termoelectrico" width="65" style="width:83px"></li>
			<li><img src="modulos_altos/calentador-gas.png" class="btn fully object" id="mueble-alto-calentador-gas" width="65" style="width:83px"></li>  
			<li><img src="modulos_altos/campana-60.png" class="btn fully object" id="mueble-alto-campana60" width="65" style="width:83px"></li>
			<li><img src="modulos_altos/campana-80.png" class="btn fully object" id="mueble-alto-campana80" width="65" style="width:83px"></li>
			<li><img src="modulos_altos/campana-90.png" class="btn fully object" id="mueble-alto-campana90" width="65" style="width:83px"></li>  
			<li><img src="modulos_altos/mueble-alto-40.png" class="btn fully object" id="mueble-alto-campana40" width="65" style="width:83px"></li>
			<li><img src="modulos_altos/mueble-alto-30.png" class="btn fully object" id="mueble-alto-campana30" width="65" style="width:83px"></li>  
			<li><img src="modulos_altos/mueble-alto-20.png" class="btn fully object" id="mueble-alto20" width="65" style="width:83px"></li>    
			<li><img src="modulos_altos/mueble-esquina-60.png" class="btn fully object" id="mueble-alto-esquina60" width="65" style="width:83px"></li>   
		   </ul>
		 </div>
		 
		 <div class="object tipo_mobiliario">TORRES</div>  
		 
		 <!-- class objetos -->
		 <div id="torres">
			 
			 <div class="tipo_mobiliario">Profundidad 60cm</div>
			 <ul class="owl-carousel owl-theme" style="display: block;">
			  <li><img src="torres/60cm/horno-micro.png" class="btn fully object" id="torre-horno-micro" width="83" style="width:83px"></li>
			  <li><img src="torres/60cm/horno.png" class="btn fully object" id="torre-horno" width="83" style="width:83px"></li>
			  <li><img src="torres/60cm/frigorifico.png" class="btn fully object" id="torre-frigorifico" width="83" style="width:83px"></li>	 
			  <li><img src="torres/60cm/escobero-80.png" class="btn fully object" id="torre-escobero80" width="83" style="width:83px"></li>	 
			  <li><img src="torres/60cm/escobero-60.png" class="btn fully object" id="torre-escobero60" width="83" style="width:83px"></li>	 
			  <li><img src="torres/60cm/escobero-40.png" class="btn fully object" id="torre-escobero40" width="83" style="width:83px"></li>	 
			  <li><img src="torres/60cm/despensa-80.png" class="btn fully object" id="torre-despensa80" width="83" style="width:83px"></li>	 
			  <li><img src="torres/60cm/despensa-60.png" class="btn fully object" id="torre-despensa60" width="83" style="width:83px"></li>	
			  <li><img src="torres/60cm/despensa-40.png" class="btn fully object" id="torre-despensa40" width="83" style="width:83px"></li>		 
			 </ul>
			 
			 <div class="tipo_mobiliario">Profundidad reducida 40cm</div>
			 <ul class="owl-carousel owl-theme" style="display: block;">
			  <li><img src="torres/40cm/torre-reducida-80.png" class="btn fully object" id="torre-reducida80" width="83" style="width:83px"></li>
			  <li><img src="torres/40cm/torre-reducida-60.png" class="btn fully object" id="torre-reducida60" width="83" style="width:83px"></li>
			  <li><img src="torres/40cm/torre-reducida-40.png" class="btn fully object" id="torre-reducida40" width="83" style="width:83px"></li>	 
			 </ul>
			 
			 
			</div>	
		 
	 </div>
		
	 <div id="opciones_instalaciones" style="display:none;">
		  
		   <div class="tipo_mobiliario">ELECTRICIDAD</div>
		   <ul class="owl-carousel owl-theme" style="display: block;">
			  <li><img src="electricidad/enchufe-servicio.png" class="modulo btn fully object" id="electricidad-enchufeservicio" width="83" style="width:83px">ENCHUFE DE SERVICIO</li>
			  <li><img src="electricidad/toma-25A.png" class="modulo btn fully object" id="electricidad-toma25a" width="83" style="width:83px">TOMA 25A</li> 
			  <li><img src="electricidad/interruptor.png" class="modulo btn fully object" id="electricidad-interruptor" width="83" style="width:83px">INTERRUPTOR</li> 
			  <li><img src="electricidad/cuadro-general.png" class="modulo btn fully object" id="electricidad-cuadrogeneral" width="83" style="width:83px">CUADRO GENERAL</li> 
			  <li><img src="electricidad/lampara-pared.png" class="modulo btn fully object" id="electricidad-lamparapared" width="83" style="width:83px">LÁMPARA PARED</li> 
			  <li><img src="electricidad/caja-electrica.png" class="modulo btn fully object" id="electricidad-cajaelectrica" width="83" style="width:83px">CAJA ELÉCTRICA</li> 
			  <li><img src="electricidad/downlicht-led.png" class="modulo btn fully object" id="electricidad-downlightled" width="83" style="width:83px">DOWNLIGHT LED</li> 
			  <li><img src="electricidad/toma-TV.png" class="modulo btn fully object" id="electricidad-tomatelevision" width="83" style="width:83px">TOMA TELEVISIÓN</li> 
			  <li><img src="electricidad/halogeno-led.png" class="modulo btn fully object" id="electricidad-halogenoled" width="83" style="width:83px">HALÓGENO LED</li> 
			  <li><img src="electricidad/toma-datos.png" class="modulo btn fully object" id="electricidad-tomadatos" width="83" style="width:83px">TOMA DATOS</li> 
			  <li><img src="electricidad/lampara.png" class="modulo btn fully object" id="electricidad-lampara" width="83" style="width:83px">LÁMPARA</li> 
			  <li><img src="electricidad/toma-telf.png" class="modulo btn fully object" id="electricidad-tomatelefono" width="83" style="width:83px">TOMA TELÉFONO</li> 
			  <li><img src="electricidad/tubo-fluor.png" class="modulo btn fully object" id="electricidad-tubofluorescente" width="83" style="width:83px">TUBO FLUORESCENTE</li> 
			  <li><img src="electricidad/telefonillo.png" class="modulo btn fully object" id="electricidad-telefonillo" width="83" style="width:83px">TELEFONILLO</li> 
		   </ul> 
		 
		   <div class="tipo_mobiliario">FONTANERÍA</div>
		   <ul class="owl-carousel owl-theme" style="display: block;">
		     <li><img src="fontaneria_gas/agua-fria-aux.png" class="modulo btn fully object" id="fontaneria-aguafria" width="83" style="width:83px">TOMA AGUA FRÍA <b>AUXILIAR</b></li> 
		     <li><img src="fontaneria_gas/agua-fria-caliente-aux.png" class="modulo btn fully object" id="fontaneria-aguafriacaliente" width="83" style="width:83px">TOMA AGUA FRÍA  Y CALIENTE <b>AUXILIAR</b></li>
			 <li><img src="fontaneria_gas/contador-agua.png" class="modulo btn fully object" id="fontaneria-contadoragua" width="83" style="width:83px">CONTADOR DE AGUA</li>
			 <li><img src="fontaneria_gas/llaves-corte-agua.png" class="modulo btn fully object" id="fontaneria-llaves" width="83" style="width:83px">LLAVES DE CORTE <b>ESTANCIA</b></li>   
		   </ul> 
		 
		   <div class="tipo_mobiliario">GAS</div>
		   <ul class="owl-carousel owl-theme" style="display: block;">
			   
			   <li><img src="fontaneria_gas/contador-gas.png" class="modulo btn fully object" id="gas-contador" width="83" style="width:83px">CONTADOR DE GAS</b></li> 
			   <li><img src="fontaneria_gas/llave-corte-gas.png" class="modulo btn fully object" id="gas-llave" width="83" style="width:83px">LLAVE DE CORTE GAS</b></li> 
			   <li><img src="fontaneria_gas/rejilla-ventilacion-gas.png" class="modulo btn fully object" id="gas-rejilla" width="83" style="width:83px">REJILLA VENTILACIÓN GAS</b></li> 
	
		   </ul>
		 
		 
		   <div class="tipo_mobiliario">CLIMATIZACIÓN</div>

		   <ul class="owl-carousel owl-theme" style="display: block;">
			 <li><img src="climatizacion/radiador-agua.png" class="modulo btn fully object" id="climatizacion-radiadoragua" width="83" style="width:83px">RADIADOR AGUA</b></li> 
			 <li><img src="climatizacion/radiador-electrico.png" class="modulo btn fully object" id="climatizacion-radiadorelectrico" width="83" style="width:83px">RADIADOR ELÉCTRICO</b></li> 
			 <li><img src="climatizacion/aire-acondicionado-conductos.png" class="modulo btn fully object" id="climatizacion-aire" width="83" style="width:83px">APARATO DE AIRE ACONDICIONADO</b></li> 
			 <li><img src="climatizacion/rejilla-aire-conductos.png" class="modulo btn fully object" id="climatizacion-rejilla" width="83" style="width:83px">REJILLA AIRE POR CONDUCTOS</b></li> 
		   </ul>

	 </div>	
		
	 <div id="opciones_trabajos" style="display:none">
	   
	   <ul class="listado_imagenes opciones_trabajos_menu">
		 <li class="submenu_instalaciones menu-demoliciones" onclick="muestraInstalaciones('demoliciones')">DEMOLICIONES</li>
		 <li class="submenu_instalaciones menu-electricidad" onclick="muestraInstalaciones('electricidad')">INSTALACIÓN ELECTRICA</li>
		 <li class="submenu_instalaciones menu-equipamiento" onclick="muestraInstalaciones('equipamiento')">INSTALACIONES EQUIPAMIENTO</li>  
		 <li class="submenu_instalaciones menu-revestimientos" onclick="muestraInstalaciones('revestimientos_instalaciones')">REVESTIMIENTOS</li>
		 <li class="submenu_instalaciones menu-gas" onclick="muestraInstalaciones('gas')">GAS</li>  
		 <li class="submenu_instalaciones menu-carpinteria_interior" onclick="muestraInstalaciones('carpinteria_interior')">CARPINTERÍA INTERIOR</li>
		 <li class="submenu_instalaciones menu-carpinteria_exterior" onclick="muestraInstalaciones('carpinteria_exterior')">CARPINTERÍA EXTERIOR</li>  
	   </ul>	
		
		  
		<ul class="owl-carousel owl-theme listado_instalaciones listado_imagenes" id="demoliciones" style="display:none">
		 <?php
			$result=$mysqli->query("SELECT * FROM articulos_compuestos WHERE tipo=1");
			
			while ($arr_result = $result->fetch_array())
			{
				$id_simple_clientes=$arr_result["id_articulo_simple"];
				if (isset($_GET["id_presupuesto"]))
				{
					//Si existe id usuario, está viendo un mapa ya creado, miro si seleccionó alguno de estos elementos
					$result_seleccion=$mysqli->query("SELECT * FROM clientes WHERE id_presupuesto=".$_GET["id_presupuesto"]." AND id_articulo_compuesto=".$arr_result["id"]);
					//echo "SELECT * FROM clientes WHERE id_presupuesto=".$_GET["id_presupuesto"]." AND id_articulo_compuesto=".$arr_result["id"];
					if ($result_seleccion->num_rows)
					{
					  $elemento_seleccionado=true;
					  $paredes="";
					  while ($arr_result_seleccion = $result_seleccion->fetch_array())
					  {
						  
						  if ($paredes == "")
							 $paredes=$arr_result_seleccion["paredes"];
						  else
						    $paredes=$paredes.",".$arr_result_seleccion["paredes"];
						  
						  $paredes_totales=$arr_result_seleccion["total_paredes"];
						  $unidades=$arr_result_seleccion["unidades"];
						  $metros_lineales=$arr_result_seleccion["metros_lineales"];
					  }
					}
					else
					{
					  $elemento_seleccionado=false;
					  $paredes="";
					  //Saco solo las paredes totales	
					  $result_paredes_totales=$mysqli->query("SELECT total_paredes FROM clientes WHERE id_presupuesto=".$_GET["id_presupuesto"]." AND total_paredes != '' LIMIT 1");
					  
					  while ($arr_result_paredes_totales = $result_paredes_totales->fetch_array())
					   	 $paredes_totales=$arr_result_paredes_totales["total_paredes"];
						
						
					}
						  
				  }
				
		?>		
				<li>
					<?php echo nl2br($arr_result['nombre']);?>
					<br>
					<img src="<?php echo $arr_result['imagen'];?>" class="elemento_instalacion <?php if (isset($_GET["id_presupuesto"]) && $elemento_seleccionado) {?> selected <?php } ?>" id="<?php echo $arr_result['id_imagen'];?>">
					<?php
					  if ($arr_result["mostrar"] == "muros")
					  {
						  //Le dejo que seleccione el/los muros a los que va esta acción
						  
						  
						  
					?>
						
						  <div class="listado_muros" <?php if (isset($_GET["id_presupuesto"])) {?> style="display:block;" <?php } ?>>
							<form class="form_muros" name="<?php echo $arr_result['id_imagen'];?>" method="POST" action="#">
							 <input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen'];?>">
							<?php
						  if (isset($_GET["id_presupuesto"]))
					  	  {
							  
							echo "Paredes es ".$paredes;
						   //Le muestro muros
						   $paredes_totales_array=explode(",", $paredes_totales);
						   
						   for ($i=0;$i<count($paredes_totales_array);$i++)
						   {
							 if ($paredes_totales_array[$i] != "")
							 {
								 if (strstr($paredes, $paredes_totales_array[$i]))
								 {
									 //Busco si tiene longitud marcada
									 $result_longitud=$mysqli->query("SELECT longitud_pared FROM clientes WHERE id_presupuesto=".$_GET['id_presupuesto']." AND id_articulo_compuesto=".$arr_result["id"]." AND paredes='".$paredes_totales_array[$i]."' AND longitud_pared != 0 LIMIT 1");
									 
									 if ($result_longitud->num_rows)
									 {
									   while ($arr_result_longitud = $result_longitud->fetch_array())
										  $longitud=$arr_result_longitud["longitud_pared"];
									   $valor_pared=$paredes_totales_array[$i]."/".$longitud;
									 }
									 else 
									 {
										$longitud="";
									 	$valor_pared=$paredes_totales_array[$i]; 
									 }
									 
									 
								 }
								 else
								 {
									 $longitud="";
									 $valor_pared=$paredes_totales_array[$i];
								 }
						?>	   
							  <span class="checkmuro"><input <?php if (strstr($paredes, $paredes_totales_array[$i])) { ?> checked <?php } ?> type="checkbox" name="paredes[]" class="paredes" value="<?php echo $valor_pared;?>"> <?php echo $paredes_totales_array[$i];?> <?php if ($longitud != "") { ?><div class="metros_seleccionados">(<?php echo $longitud;?>m seleccionados)</div> <?php } ?></span>
						<?php	
							 }
						   }
							  
							  
						  //Le muestro todos los artículos simples
						  $result_simples=$mysqli->query("SELECT * FROM articulos_simples WHERE id_articulo_compuesto=".$arr_result["id"]);
						  
						  while ($arr_result_simples = $result_simples->fetch_array())
						  {
							  $id_articulo_simple=$arr_result_simples["id"];
							  $codigo_articulo_simple=$arr_result_simples["codigo"];
							  $descripcion_articulo_simple=$arr_result_simples["descripcion"];
							  $visible_cliente=$arr_result_simples["visible_cliente"];
							  
							  //Si está marcado porque lo elegió un verificador
							  $result_elegido=$mysqli->query("SELECT id FROM clientes WHERE id_articulo_compuesto=".$arr_result["id"]." AND id_articulo_simple=$id_articulo_simple");
							  
						 ?> 
							<div><input <?php if ((is_null($id_simple_clientes) || $id_simple_clientes == "" || $id_simple_clientes === NULL ) && $visible_cliente == 1) { ?> checked <?php } else if ($id_simple_clientes == $id_articulo_simple || $result_elegido->num_rows) { ?>checked<?php } ?>  type="checkbox" name="articulo_simple[]" value="<?php echo $id_articulo_simple;?>"> <b><?php echo $codigo_articulo_simple;?></b>: <?php echo utf8_encode($descripcion_articulo_simple);?></div>
						 <?php
						  }
						  
					  }
					?>
								
							</form>
						  </div>
						  <?php
						   if (isset($_GET["id_presupuesto"]) && $elemento_seleccionado)
						   {
						  ?>
							<div style="color:#95C11F">Muros marcados: <?php echo $paredes;?></div>
						  <?php
						   }
						  
						  ?>
					
					<?php
					  }
					  else if ($arr_result["mostrar"] == "unidades")
					  {
						  //Le muestro un input para que me indique unidades
					 ?>
						<div class="unidades_elemento" <?php if (isset($_GET["id_presupuesto"])) {?> style="display:block;" <?php } ?>>
						 <form class="form_unidades" name="<?php echo $arr_result['id_imagen'];?>" method="POST" action="#">
						  <input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen'];?>">
						  <select class="form-control <?php echo $arr_result['id_imagen'];?>" name="unidades" <?php if ($arr_result["mostrar"] == "") { ?> style="display:none;"<?php } ?>>
							<?php
						     for ($i=1;$i<=10;$i++)
							 {
							?>	 
							   <option value="<?php echo $i;?>"><?php echo $i;?> <?php if ($i == 1) { ?>unidad <?php } else { ?>unidades<?php } ?></option>
							<?php	 
							 }
						  	?>
						
						  </select>	
						  <?php
						  if (isset($_GET["id_presupuesto"]))
					  	  {
						  //Le muestro todos los artículos simples
						  $result_simples=$mysqli->query("SELECT * FROM articulos_simples WHERE id_articulo_compuesto=".$arr_result["id"]);
						  
						  while ($arr_result_simples = $result_simples->fetch_array())
						  {
							  $id_articulo_simple=$arr_result_simples["id"];
							  $codigo_articulo_simple=$arr_result_simples["codigo"];
							  $descripcion_articulo_simple=$arr_result_simples["descripcion"];
							  $visible_cliente=$arr_result_simples["visible_cliente"];
							  
							  //Si está marcado porque lo elegió un verificador
							  $result_elegido=$mysqli->query("SELECT id FROM clientes WHERE id_articulo_compuesto=".$arr_result["id"]." AND id_articulo_simple=$id_articulo_simple");
						 ?> 
							<div><input <?php if ((is_null($id_simple_clientes) || $id_simple_clientes == "" || $id_simple_clientes === NULL ) && $visible_cliente == 1) { ?> checked <?php } else if ($id_simple_clientes == $id_articulo_simple || $result_elegido->num_rows) { ?>checked<?php } ?>  type="checkbox" name="articulo_simple[]" value="<?php echo $id_articulo_simple;?>"> <b><?php echo $codigo_articulo_simple;?></b>: <?php echo utf8_encode($descripcion_articulo_simple);?></div>
						 <?php
						  }
						  
					  }
					?>
							 
						 </form>	 
						</div>	
					 <?php
					  }
					  else if ($arr_result["mostrar"] == "metros_lineales")
					  {
						  //Le muestro un input para que me indique los metros_lineales
					 ?>
						<div class="metros_lineales" <?php if (isset($_GET["id_presupuesto"])) {?> style="display:block;" <?php } ?>>
						 <form class="form_metros" name="<?php echo $arr_result['id_imagen'];?>" method="POST" action="#">
						  <input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen'];?>">
						  <input type="text" name="metros_lineales" placeholder="Metros lineales" class="form-control" <?php if (isset($_GET["id_presupuesto"])) { ?> value="<?php echo $metros_lineales; } ?>">
						  <?php
						  if (isset($_GET["id_presupuesto"]))
					  	  {
						  //Le muestro todos los artículos simples
						  $result_simples=$mysqli->query("SELECT * FROM articulos_simples WHERE id_articulo_compuesto=".$arr_result["id"]);
						  
						  while ($arr_result_simples = $result_simples->fetch_array())
						  {
							  $id_articulo_simple=$arr_result_simples["id"];
							  $codigo_articulo_simple=$arr_result_simples["codigo"];
							  $descripcion_articulo_simple=$arr_result_simples["descripcion"];
							  $visible_cliente=$arr_result_simples["visible_cliente"];
							  
							  //Si está marcado porque lo elegió un verificador
							  $result_elegido=$mysqli->query("SELECT id FROM clientes WHERE id_articulo_compuesto=".$arr_result["id"]." AND id_articulo_simple=$id_articulo_simple");
						 ?> 
							<div><input <?php if ((is_null($id_simple_clientes) || $id_simple_clientes == "" || $id_simple_clientes === NULL ) && $visible_cliente == 1) { ?> checked <?php } else if ($id_simple_clientes == $id_articulo_simple || $result_elegido->num_rows) { ?>checked<?php } ?>  type="checkbox" name="articulo_simple[]" value="<?php echo $id_articulo_simple;?>"> <b><?php echo $codigo_articulo_simple;?></b>: <?php echo utf8_encode($descripcion_articulo_simple);?></div>
						 <?php
						  }
						  
					  }
					?>
							 
						 </form>	 
						</div>	
					 <?php
					  }
					  else
					  {
					 ?>
					
						<form class="form_generico" name="<?php echo $arr_result['id_imagen'];?>" method="POST" action="#">
						  <input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen'];?>">
					    </form>
					
					<?php
					  }
				
				
				
					 ?>
					  
			
				</li>	
		<?php		
			}
				
		    $result->free();
		 ?>
			
		 </ul>	 
		
		 
		 <ul class="owl-carousel owl-theme listado_instalaciones listado_imagenes" id="electricidad" style="display:none">
		 <?php
			$result=$mysqli->query("SELECT * FROM articulos_compuestos WHERE tipo=2");
			
			while ($arr_result = $result->fetch_array())
			{
				$id_simple_clientes=$arr_result["id_articulo_simple"];
				if (isset($_GET["id_presupuesto"]))
				{
					//Si existe id usuario, está viendo un mapa ya creado, miro si seleccionó alguno de estos elementos
					$result_seleccion=$mysqli->query("SELECT * FROM clientes WHERE id_presupuesto=".$_GET["id_presupuesto"]." AND id_articulo_compuesto=".$arr_result["id"]);
					$unidades=0;
					
					if ($result_seleccion->num_rows)
					{
					  $elemento_seleccionado=true;
					  $paredes="";
					  
					  while ($arr_result_seleccion = $result_seleccion->fetch_array())
					  {
						  if ($paredes == "")
							 $paredes=$arr_result_seleccion["paredes"];
						  else
						    $paredes=$paredes.",".$arr_result_seleccion["paredes"];
						  
						  $paredes_totales=$arr_result_seleccion["total_paredes"];
						  $unidades=$arr_result_seleccion["unidades"];
					  }
					}
					else
					{ 
					  $elemento_seleccionado=false;
					  $paredes="";
					  //Saco solo las paredes totales	
					  $result_paredes_totales=$mysqli->query("SELECT total_paredes FROM clientes WHERE id_presupuesto=".$_GET["id_presupuesto"]." AND total_paredes != '' LIMIT 1");
					  
					  while ($arr_result_paredes_totales = $result_paredes_totales->fetch_array())
					   	 $paredes_totales=$arr_result_paredes_totales["total_paredes"];
					}
						  
				  }
		 ?>		
				<li>
					<?php echo nl2br($arr_result['nombre']);?>
					<br>
					<img src="<?php echo $arr_result['imagen'];?>" class="tipo_electricidad elemento_instalacion <?php if (isset($_GET["id_presupuesto"]) && $elemento_seleccionado) {?> selected <?php } ?>" id="<?php echo $arr_result['id_imagen'];?>">
					<?php
					  if ($arr_result["mostrar"] == "muros")
					  {
						  //Le dejo que seleccione el/los muros a los que va esta acción
					?>
						
						  <div class="listado_muros" <?php if (isset($_GET["id_presupuesto"])) {?> style="display:block;" <?php } ?>>
							<form class="form_muros" name="<?php echo $arr_result['id_imagen'];?>" method="POST" action="#">
							 <input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen'];?>">
							 <?php
						  if (isset($_GET["id_presupuesto"]))
					  	  {
							  
						  //Le muestro muros
						   $paredes_totales_array=explode(",", $paredes_totales);
						   
						   for ($i=0;$i<count($paredes_totales_array);$i++)
						   {
							 if ($paredes_totales_array[$i] != "")
							 {
						?>	   
							  <span class="checkmuro"><input <?php if (strstr($paredes, $paredes_totales_array[$i])) { ?> checked <?php } ?> type="checkbox" name="paredes[]" class="paredes" value="<?php echo $paredes_totales_array[$i];?>"> <?php echo $paredes_totales_array[$i];?></span>
						<?php	
							 }
						   }	  
							  
						  //Le muestro todos los artículos simples
						  $result_simples=$mysqli->query("SELECT * FROM articulos_simples WHERE id_articulo_compuesto=".$arr_result["id"]);
						  
						  while ($arr_result_simples = $result_simples->fetch_array())
						  {
							  $id_articulo_simple=$arr_result_simples["id"];
							  $codigo_articulo_simple=$arr_result_simples["codigo"];
							  $descripcion_articulo_simple=$arr_result_simples["descripcion"];
							  $visible_cliente=$arr_result_simples["visible_cliente"];
							  
							  //Si está marcado porque lo elegió un verificador
							  $result_elegido=$mysqli->query("SELECT id FROM clientes WHERE id_articulo_compuesto=".$arr_result["id"]." AND id_articulo_simple=$id_articulo_simple");
						 ?> 
							<div><input <?php if ((is_null($id_simple_clientes) || $id_simple_clientes == "" || $id_simple_clientes === NULL ) && $visible_cliente == 1) { ?> checked <?php } else if ($id_simple_clientes == $id_articulo_simple || $result_elegido->num_rows) { ?>checked<?php } ?>  type="checkbox" name="articulo_simple[]" value="<?php echo $id_articulo_simple;?>"> <b><?php echo $codigo_articulo_simple;?></b>: <?php echo utf8_encode($descripcion_articulo_simple);?></div>
						 <?php
						  }
						  
					  }
					
					?>
								
							</form>
							  
						  </div>
						  <?php
						   if (isset($_GET["id_presupuesto"]) && $elemento_seleccionado)
						   {
						  ?>
							<div style="color:#95C11F">Muros marcados: <?php echo $paredes;?></div>
						  <?php
						   }
						  
						  ?>
					<?php
					  }
					  else if ($arr_result["mostrar"] == "unidades")
					  {
						  //Le muestro un input para que me indique unidades
						 /* if (isset($_GET["id_presupuesto"]))
						  {
								//Si existe id usuario, está viendo un mapa ya creado, miro si seleccionó alguno de estos elementos
								echo "LAS UNIDADES SON $unidades";
							    
						  }
						  */
					 ?>
						<div class="unidades_elemento" <?php if (isset($_GET["id_presupuesto"])) {?> style="display:block;" <?php } ?>>
						 <form class="form_unidades" name="<?php echo $arr_result['id_imagen'];?>" method="POST" action="#">
						  <input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen'];?>">
						  <input type="range" value="1" min="1" max="30" step="1" oninput="this.nextElementSibling.value = this.value" class="<?php echo $arr_result['id_imagen'];?>" name="unidades" <?php if ($arr_result["mostrar"] == "") { ?> style="display:none;"<?php } ?>>
						  Unidades: <output style="display:inline-block">1</output> 	 
						  
						  <?php
						  if (isset($_GET["id_presupuesto"]))
					  	  {	
						  //Le muestro todos los artículos simples
						  $result_simples=$mysqli->query("SELECT * FROM articulos_simples WHERE id_articulo_compuesto=".$arr_result["id"]);
						  
						  while ($arr_result_simples = $result_simples->fetch_array())
						  {
							  $id_articulo_simple=$arr_result_simples["id"];
							  $codigo_articulo_simple=$arr_result_simples["codigo"];
							  $descripcion_articulo_simple=$arr_result_simples["descripcion"];
							  $visible_cliente=$arr_result_simples["visible_cliente"];
							  
							  //Si está marcado porque lo elegió un verificador
							  $result_elegido=$mysqli->query("SELECT id FROM clientes WHERE id_articulo_compuesto=".$arr_result["id"]." AND id_articulo_simple=$id_articulo_simple");
						 ?> 
							<div><input <?php if ((is_null($id_simple_clientes) || $id_simple_clientes == "" || $id_simple_clientes === NULL ) && $visible_cliente == 1) { ?> checked <?php } else if ($id_simple_clientes == $id_articulo_simple || $result_elegido->num_rows) { ?>checked<?php } ?>  type="checkbox" name="articulo_simple[]" value="<?php echo $id_articulo_simple;?>"> <b><?php echo $codigo_articulo_simple;?></b>: <?php echo utf8_encode($descripcion_articulo_simple);?></div>
						 <?php
						  }
						  
					  }
					
					?>
							 
						 </form>	 
						</div>	
					 <?php
					  }
					 ?>	
					  
			
				</li>		
		<?php		
			}
				
		?>
		 </ul>	
		 
		 
		 <ul class="owl-carousel owl-theme listado_instalaciones listado_imagenes" id="equipamiento" style="display:none">
		  <?php
			$result=$mysqli->query("SELECT * FROM articulos_compuestos WHERE tipo=3");
			
			while ($arr_result = $result->fetch_array())
			{
				$id_simple_clientes=$arr_result["id_articulo_simple"];
				if (isset($_GET["id_presupuesto"]))
				{
					//Si existe id usuario, está viendo un mapa ya creado, miro si seleccionó alguno de estos elementos
					$result_seleccion=$mysqli->query("SELECT * FROM clientes WHERE id_presupuesto=".$_GET["id_presupuesto"]." AND id_articulo_compuesto=".$arr_result["id"]);
					
					if ($result_seleccion->num_rows)
					{
					  $elemento_seleccionado=true;
					  $paredes="";
					  while ($arr_result_seleccion = $result_seleccion->fetch_array())
					  {
						  if ($paredes == "")
							 $paredes=$arr_result_seleccion["paredes"];
						  else
						    $paredes=$paredes.",".$arr_result_seleccion["paredes"];
						  
						  $paredes_totales=$arr_result_seleccion["total_paredes"];
						  $unidades=$arr_result_seleccion["unidades"];
					  }
					}
					else
					{
					  $elemento_seleccionado=false;
					  $paredes="";	
					  $result_paredes_totales=$mysqli->query("SELECT total_paredes FROM clientes WHERE id_presupuesto=".$_GET["id_presupuesto"]." AND total_paredes != '' LIMIT 1");
					  
					  while ($arr_result_paredes_totales = $result_paredes_totales->fetch_array())
					   	 $paredes_totales=$arr_result_paredes_totales["total_paredes"];	
					}
						  
				  }
		?>		
				<li>
					<?php echo nl2br($arr_result['nombre']);?>
					<br>
					<img src="<?php echo $arr_result['imagen'];?>" class="tipo_equipamiento elemento_instalacion <?php if (isset($_GET["id_presupuesto"]) && $elemento_seleccionado) {?> selected <?php } ?>" id="<?php echo $arr_result['id_imagen'];?>">
					<?php
					  if ($arr_result["mostrar"] == "muros")
					  {
						  //Le dejo que seleccione el/los muros a los que va esta acción
					?>
						
						  <div class="listado_muros" <?php if (isset($_GET["id_presupuesto"])) {?> style="display:block;" <?php } ?>>
							<form class="form_muros" name="<?php echo $arr_result['id_imagen'];?>" method="POST" action="#">
							 <input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen'];?>">
							 <?php
						  if (isset($_GET["id_presupuesto"]))
					      {
						   //Le muestro muros
						   $paredes_totales_array=explode(",", $paredes_totales);
						   
						   for ($i=0;$i<count($paredes_totales_array);$i++)
						   {
							 if ($paredes_totales_array[$i] != "")
							 {
						?>	   
							  <span class="checkmuro"><input <?php if (strstr($paredes, $paredes_totales_array[$i])) { ?> checked <?php } ?> type="checkbox" name="paredes[]" class="paredes" value="<?php echo $paredes_totales_array[$i];?>"> <?php echo $paredes_totales_array[$i];?></span>
						<?php	
							 }
						   } 	  
							  
							  //Le muestro todos los artículos simples
							  $result_simples=$mysqli->query("SELECT * FROM articulos_simples WHERE id_articulo_compuesto=".$arr_result["id"]);

							  while ($arr_result_simples = $result_simples->fetch_array())
							  {
								  $id_articulo_simple=$arr_result_simples["id"];
								  $codigo_articulo_simple=$arr_result_simples["codigo"];
								  $descripcion_articulo_simple=$arr_result_simples["descripcion"];
								  $visible_cliente=$arr_result_simples["visible_cliente"];
								  
								  //Si está marcado porque lo elegió un verificador
							  		$result_elegido=$mysqli->query("SELECT id FROM clientes WHERE id_articulo_compuesto=".$arr_result["id"]." AND id_articulo_simple=$id_articulo_simple");
								  
							 ?> 
								<div><input <?php if ((is_null($id_simple_clientes) || $id_simple_clientes == "" || $id_simple_clientes === NULL ) && $visible_cliente == 1) { ?> checked <?php } else if ($id_simple_clientes == $id_articulo_simple || $result_elegido->num_rows) { ?>checked<?php } ?>  type="checkbox" name="articulo_simple[]" value="<?php echo $id_articulo_simple;?>"> <b><?php echo $codigo_articulo_simple;?></b>: <?php echo utf8_encode($descripcion_articulo_simple);?></div>
							 <?php
							  }
						  
					     }
					  ?>	
							</form>
						  </div>
						  <?php
						   if (isset($_GET["id_presupuesto"]) && $elemento_seleccionado)
						   {
						  ?>
							<div style="color:#95C11F">Muros marcados: <?php echo $paredes;?></div>
						  <?php
						   }
						  
						  ?>
					<?php
					  }
					  else if ($arr_result["mostrar"] == "unidades")
					  {
						  //Le muestro un input para que me indique unidades
					 ?>
						<div class="unidades_elemento" <?php if (isset($_GET["id_presupuesto"])) {?> style="display:block;" <?php } ?>>
						 <form class="form_unidades" name="<?php echo $arr_result['id_imagen'];?>" method="POST" action="#">
						  <input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen'];?>">
						  
						  <input type="range" value="1" min="1" max="5" step="1" oninput="this.nextElementSibling.value = this.value" class="<?php echo $arr_result['id_imagen'];?>" name="unidades" <?php if ($arr_result["mostrar"] == "") { ?> style="display:none;"<?php } ?>>
						  Unidades: <output style="display:inline-block">1</output>
							 
						  
							 
						  <?php
						  if (isset($_GET["id_presupuesto"]))
					      {
							  //Le muestro todos los artículos simples
							  $result_simples=$mysqli->query("SELECT * FROM articulos_simples WHERE id_articulo_compuesto=".$arr_result["id"]);

							  while ($arr_result_simples = $result_simples->fetch_array())
							  {
								  $id_articulo_simple=$arr_result_simples["id"];
								  $codigo_articulo_simple=$arr_result_simples["codigo"];
								  $descripcion_articulo_simple=$arr_result_simples["descripcion"];
								  $visible_cliente=$arr_result_simples["visible_cliente"];
								  
								  //Si está marcado porque lo elegió un verificador
							  	  $result_elegido=$mysqli->query("SELECT id FROM clientes WHERE id_articulo_compuesto=".$arr_result["id"]." AND id_articulo_simple=$id_articulo_simple");
							 ?> 
								<div><input <?php if ((is_null($id_simple_clientes) || $id_simple_clientes == "" || $id_simple_clientes === NULL ) && $visible_cliente == 1) { ?> checked <?php } else if ($id_simple_clientes == $id_articulo_simple || $result_elegido->num_rows) { ?>checked<?php } ?>  type="checkbox" name="articulo_simple[]" value="<?php echo $id_articulo_simple;?>"> <b><?php echo $codigo_articulo_simple;?></b>: <?php echo utf8_encode($descripcion_articulo_simple);?></div>
							 <?php
							  }
						  
					     }
					  ?>	 
						 </form>	 
						</div>		
					 <?php
					  }
					  else
					  {
					 ?>
					
						<form class="form_generico" name="<?php echo $arr_result['id_imagen'];?>" method="POST" action="#">
						  <input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen'];?>">
					    </form>
					
					<?php
					  }
				
					?>
			
				</li>		
		<?php		
			}
		?>		
		    
		 </ul>	
		 
		 
		 <ul class="owl-carousel owl-theme listado_instalaciones listado_imagenes" id="revestimientos_instalaciones" style="display:none">
		  <?php
			$result=$mysqli->query("SELECT * FROM articulos_compuestos WHERE tipo=4");
			
			while ($arr_result = $result->fetch_array())
			{
				$id_simple_clientes=$arr_result["id_articulo_simple"];
				if (isset($_GET["id_presupuesto"]))
				{
					//Si existe id usuario, está viendo un mapa ya creado, miro si seleccionó alguno de estos elementos
					$result_seleccion=$mysqli->query("SELECT * FROM clientes WHERE id_presupuesto=".$_GET["id_presupuesto"]." AND id_articulo_compuesto=".$arr_result["id"]);
					
					if ($result_seleccion->num_rows)
					{
					  $elemento_seleccionado=true;
					  $paredes="";
					  while ($arr_result_seleccion = $result_seleccion->fetch_array())
					  {
						  if ($paredes == "")
							 $paredes=$arr_result_seleccion["paredes"];
						  else
						    $paredes=$paredes.",".$arr_result_seleccion["paredes"];
						  
						  $paredes_totales=$arr_result_seleccion["total_paredes"];
						  $unidades=$arr_result_seleccion["unidades"];
					  }
					}
					else
					{
					  $elemento_seleccionado=false;
					  $paredes="";	
					  $result_paredes_totales=$mysqli->query("SELECT total_paredes FROM clientes WHERE id_presupuesto=".$_GET["id_presupuesto"]." AND total_paredes != '' LIMIT 1");
					  
					  while ($arr_result_paredes_totales = $result_paredes_totales->fetch_array())
					   	 $paredes_totales=$arr_result_paredes_totales["total_paredes"];	
					}
						  
				  }
		?>		
				<li>
					<?php echo nl2br($arr_result['nombre']);?>
					<br>
					<img src="<?php echo $arr_result['imagen'];?>" class="elemento_instalacion <?php if (isset($_GET["id_presupuesto"]) && $elemento_seleccionado) {?> selected <?php } ?>" id="<?php echo $arr_result['id_imagen'];?>">
					<?php
					  if ($arr_result["mostrar"] == "muros")
					  {
						  //Le dejo que seleccione el/los muros a los que va esta acción
					?>
						
						  <div class="listado_muros" <?php if (isset($_GET["id_presupuesto"])) {?> style="display:block;" <?php } ?>>
							<form class="form_muros" name="<?php echo $arr_result['id_imagen'];?>" method="POST" action="#">
							 <input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen'];?>">
							 <?php
						  if (isset($_GET["id_presupuesto"]))
					      {
						 //Le muestro muros
						   $paredes_totales_array=explode(",", $paredes_totales);
						   
						   for ($i=0;$i<count($paredes_totales_array);$i++)
						   {
							 if ($paredes_totales_array[$i] != "")
							 {
						?>	   
							  <span class="checkmuro"><input <?php if (strstr($paredes, $paredes_totales_array[$i])) { ?> checked <?php } ?> type="checkbox" name="paredes[]" class="paredes" value="<?php echo $paredes_totales_array[$i];?>"> <?php echo $paredes_totales_array[$i];?></span>
						<?php	
							 }
						   }	  
							  //Le muestro todos los artículos simples
							  $result_simples=$mysqli->query("SELECT * FROM articulos_simples WHERE id_articulo_compuesto=".$arr_result["id"]);

							  while ($arr_result_simples = $result_simples->fetch_array())
							  {
								  $id_articulo_simple=$arr_result_simples["id"];
								  $codigo_articulo_simple=$arr_result_simples["codigo"];
								  $descripcion_articulo_simple=$arr_result_simples["descripcion"];
								  $visible_cliente=$arr_result_simples["visible_cliente"];
								  
								  //Si está marcado porque lo elegió un verificador
							  	  $result_elegido=$mysqli->query("SELECT id FROM clientes WHERE id_articulo_compuesto=".$arr_result["id"]." AND id_articulo_simple=$id_articulo_simple");
							 ?> 
								<div><input <?php if ((is_null($id_simple_clientes) || $id_simple_clientes == "" || $id_simple_clientes === NULL ) && $visible_cliente == 1) { ?> checked <?php } else if ($id_simple_clientes == $id_articulo_simple || $result_elegido->num_rows) { ?>checked<?php } ?>  type="checkbox" name="articulo_simple[]" value="<?php echo $id_articulo_simple;?>"> <b><?php echo $codigo_articulo_simple;?></b>: <?php echo utf8_encode($descripcion_articulo_simple);?></div>
							 <?php
							  }
						  
					     }
					  ?>	
							</form>
						  </div>
						  <?php
						   if (isset($_GET["id_presupuesto"]) && $elemento_seleccionado)
						   {
						  ?>
							<div style="color:#95C11F">Muros marcados: <?php echo $paredes;?></div>
						  <?php
						   }
						  
						  ?>
					<?php
					  }
					  else if ($arr_result["mostrar"] == "unidades")
					  {
						  //Le muestro un input para que me indique unidades
					 ?>
						<div class="unidades_elemento" <?php if (isset($_GET["id_presupuesto"])) {?> style="display:block;" <?php } ?>>
						 <form class="form_unidades" name="<?php echo $arr_result['id_imagen'];?>" method="POST" action="#">
						  <input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen'];?>">
						  <select class="form-control <?php echo $arr_result['id_imagen'];?>" name="unidades" <?php if ($arr_result["mostrar"] == "") { ?> style="display:none;"<?php } ?>>
							<?php
						     for ($i=1;$i<=10;$i++)
							 {
							?>	 
							   <option value="<?php echo $i;?>"><?php echo $i;?> <?php if ($i == 1) { ?>unidad <?php } else { ?>unidades<?php } ?></option>
							<?php	 
							 }
						  	?>
						
						  </select>	
						  <?php
						  if (isset($_GET["id_presupuesto"]))
					      {
							  //Le muestro todos los artículos simples
							  $result_simples=$mysqli->query("SELECT * FROM articulos_simples WHERE id_articulo_compuesto=".$arr_result["id"]);

							  while ($arr_result_simples = $result_simples->fetch_array())
							  {
								  $id_articulo_simple=$arr_result_simples["id"];
								  $codigo_articulo_simple=$arr_result_simples["codigo"];
								  $descripcion_articulo_simple=$arr_result_simples["descripcion"];
								  $visible_cliente=$arr_result_simples["visible_cliente"];
								  
								  //Si está marcado porque lo elegió un verificador
							  	  $result_elegido=$mysqli->query("SELECT id FROM clientes WHERE id_articulo_compuesto=".$arr_result["id"]." AND id_articulo_simple=$id_articulo_simple");
								  
							 ?> 
								<div><input <?php if ((is_null($id_simple_clientes) || $id_simple_clientes == "" || $id_simple_clientes === NULL ) && $visible_cliente == 1) { ?> checked <?php } else if ($id_simple_clientes == $id_articulo_simple || $result_elegido->num_rows) { ?>checked<?php } ?>  type="checkbox" name="articulo_simple[]" value="<?php echo $id_articulo_simple;?>"> <b><?php echo $codigo_articulo_simple;?></b>: <?php echo utf8_encode($descripcion_articulo_simple);?></div>
							 <?php
							  }
						  
					     }
					  ?>	 
						 </form>	 
						</div>	
					 <?php
					  }
					?>
			
				</li>			
		<?php		
			}
		?>		
		    	 
		 </ul>	
		 
		 <ul class="owl-carousel owl-theme listado_instalaciones listado_imagenes" id="gas" style="display:none">
		  <?php
			$result=$mysqli->query("SELECT * FROM articulos_compuestos WHERE tipo=5");
			
			while ($arr_result = $result->fetch_array())
			{
				$id_simple_clientes=$arr_result["id_articulo_simple"];
				if (isset($_GET["id_presupuesto"]))
				{
					//Si existe id usuario, está viendo un mapa ya creado, miro si seleccionó alguno de estos elementos
					$result_seleccion=$mysqli->query("SELECT * FROM clientes WHERE id_presupuesto=".$_GET["id_presupuesto"]." AND id_articulo_compuesto=".$arr_result["id"]);
					
					if ($result_seleccion->num_rows)
					{
					  $elemento_seleccionado=true;
					  $paredes="";
					  while ($arr_result_seleccion = $result_seleccion->fetch_array())
					  {
						  if ($paredes == "")
							 $paredes=$arr_result_seleccion["paredes"];
						  else
						    $paredes=$paredes.",".$arr_result_seleccion["paredes"];
						  
						  $paredes_totales=$arr_result_seleccion["total_paredes"];
						  $unidades=$arr_result_seleccion["unidades"];
					  }
					}
					else
					{
					  $elemento_seleccionado=false;
					  $paredes="";	
					  $result_paredes_totales=$mysqli->query("SELECT total_paredes FROM clientes WHERE id_presupuesto=".$_GET["id_presupuesto"]." AND total_paredes != '' LIMIT 1");
					  
					  while ($arr_result_paredes_totales = $result_paredes_totales->fetch_array())
					   	 $paredes_totales=$arr_result_paredes_totales["total_paredes"];	
					}
						  
				  }
		?>		
				<li>
					<?php echo nl2br($arr_result['nombre']);?>
					<br>
					<img src="<?php echo $arr_result['imagen'];?>" class="elemento_instalacion <?php if (isset($_GET["id_presupuesto"]) && $elemento_seleccionado) {?> selected <?php } ?>" id="<?php echo $arr_result['id_imagen'];?>">
					<?php
					  if ($arr_result["mostrar"] == "muros")
					  {
						  //Le dejo que seleccione el/los muros a los que va esta acción
					?>
						
						  <div class="listado_muros" <?php if (isset($_GET["id_presupuesto"])) {?> style="display:block;" <?php } ?>>
							<form class="form_muros" name="<?php echo $arr_result['id_imagen'];?>" method="POST" action="#">
							 <input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen'];?>">
							 <?php
						  if (isset($_GET["id_presupuesto"]))
					      {
							  
						   //Le muestro muros
						   $paredes_totales_array=explode(",", $paredes_totales);
						   
						   for ($i=0;$i<count($paredes_totales_array);$i++)
						   {
							 if ($paredes_totales_array[$i] != "")
							 {
						?>	   
							  <span class="checkmuro"><input <?php if (strstr($paredes, $paredes_totales_array[$i])) { ?> checked <?php } ?> type="checkbox" name="paredes[]" class="paredes" value="<?php echo $paredes_totales_array[$i];?>"> <?php echo $paredes_totales_array[$i];?></span>
						<?php	
							 }
						   }	  
							  //Le muestro todos los artículos simples
							  $result_simples=$mysqli->query("SELECT * FROM articulos_simples WHERE id_articulo_compuesto=".$arr_result["id"]);

							  while ($arr_result_simples = $result_simples->fetch_array())
							  {
								  $id_articulo_simple=$arr_result_simples["id"];
								  $codigo_articulo_simple=$arr_result_simples["codigo"];
								  $descripcion_articulo_simple=$arr_result_simples["descripcion"];
								  $visible_cliente=$arr_result_simples["visible_cliente"];
								  
								  //Si está marcado porque lo elegió un verificador
							  	  $result_elegido=$mysqli->query("SELECT id FROM clientes WHERE id_articulo_compuesto=".$arr_result["id"]." AND id_articulo_simple=$id_articulo_simple");
								  
							 ?> 
								<div><input <?php if ((is_null($id_simple_clientes) || $id_simple_clientes == "" || $id_simple_clientes === NULL ) && $visible_cliente == 1) { ?> checked <?php } else if ($id_simple_clientes == $id_articulo_simple || $result_elegido->num_rows) { ?>checked<?php } ?>  type="checkbox" name="articulo_simple[]" value="<?php echo $id_articulo_simple;?>"> <b><?php echo $codigo_articulo_simple;?></b>: <?php echo utf8_encode($descripcion_articulo_simple);?></div>
							 <?php
							  }
						  
					     }
					  ?>	
							</form>
						  </div>
						  <?php
						   if (isset($_GET["id_presupuesto"]) && $elemento_seleccionado)
						   {
						  ?>
							<div style="color:#95C11F">Muros marcados: <?php echo $paredes;?></div>
						  <?php
						   }
						  
						  ?>
						
					<?php
					  }
					  else if ($arr_result["mostrar"] == "unidades")
					  {
						  //Le muestro un input para que me indique unidades
					 ?>
						<div class="unidades_elemento" <?php if (isset($_GET["id_presupuesto"])) {?> style="display:block;" <?php } ?>>
						 <form class="form_unidades" name="<?php echo $arr_result['id_imagen'];?>" method="POST" action="#">
						  <input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen'];?>">
						  <select class="form-control <?php echo $arr_result['id_imagen'];?>" name="unidades" <?php if ($arr_result["mostrar"] == "") { ?> style="display:none;"<?php } ?>>
							<?php
						     for ($i=1;$i<=10;$i++)
							 {
							?>	 
							   <option value="<?php echo $i;?>"><?php echo $i;?> <?php if ($i == 1) { ?>unidad <?php } else { ?>unidades<?php } ?></option>
							<?php	 
							 }
						  	?>
						
						  </select>	 
						  <?php
						  if (isset($_GET["id_presupuesto"]))
					      {
							  //Le muestro todos los artículos simples
							  $result_simples=$mysqli->query("SELECT * FROM articulos_simples WHERE id_articulo_compuesto=".$arr_result["id"]);

							  while ($arr_result_simples = $result_simples->fetch_array())
							  {
								  $id_articulo_simple=$arr_result_simples["id"];
								  $codigo_articulo_simple=$arr_result_simples["codigo"];
								  $descripcion_articulo_simple=$arr_result_simples["descripcion"];
								  $visible_cliente=$arr_result_simples["visible_cliente"];
								  
								  //Si está marcado porque lo elegió un verificador
							  	  $result_elegido=$mysqli->query("SELECT id FROM clientes WHERE id_articulo_compuesto=".$arr_result["id"]." AND id_articulo_simple=$id_articulo_simple");
							 ?> 
								<div><input <?php if ((is_null($id_simple_clientes) || $id_simple_clientes == "" || $id_simple_clientes === NULL ) && $visible_cliente == 1) { ?> checked <?php } else if ($id_simple_clientes == $id_articulo_simple || $result_elegido->num_rows) { ?>checked<?php } ?>  type="checkbox" name="articulo_simple[]" value="<?php echo $id_articulo_simple;?>"> <b><?php echo $codigo_articulo_simple;?></b>: <?php echo utf8_encode($descripcion_articulo_simple);?></div>
							 <?php
							  }
						  
					     }
					  ?>
						  
						 </form>	 
						</div>	
					 <?php
					  }
					 ?>
			
				</li>			
		<?php		
			}
		?>		
		    	 
		 </ul>	
		 
		 <ul class="owl-carousel owl-theme listado_instalaciones listado_imagenes" id="carpinteria_interior" style="display:none">
			<?php
			 $result=$mysqli->query("SELECT * FROM articulos_compuestos WHERE tipo=6");
			
			 while ($arr_result = $result->fetch_array())
			 {
				 $id_simple_clientes=$arr_result["id_articulo_simple"];
				if (isset($_GET["id_presupuesto"]))
				{
					//Si existe id usuario, está viendo un mapa ya creado, miro si seleccionó alguno de estos elementos
					$result_seleccion=$mysqli->query("SELECT * FROM clientes WHERE id_presupuesto=".$_GET["id_presupuesto"]." AND id_articulo_compuesto=".$arr_result["id"]);
					
					if ($result_seleccion->num_rows)
					{
					  $elemento_seleccionado=true;
					  $paredes="";
					  while ($arr_result_seleccion = $result_seleccion->fetch_array())
					  {
						  if ($paredes == "")
							 $paredes=$arr_result_seleccion["paredes"];
						  else
						    $paredes=$paredes.",".$arr_result_seleccion["paredes"];
						  
						  $paredes_totales=$arr_result_seleccion["total_paredes"];
						  $unidades=$arr_result_seleccion["unidades"];
					  }
					}
					else
					{
					  $elemento_seleccionado=false;
					  $paredes="";	
					  $result_paredes_totales=$mysqli->query("SELECT total_paredes FROM clientes WHERE id_presupuesto=".$_GET["id_presupuesto"]." AND total_paredes != '' LIMIT 1");
					  
					  while ($arr_result_paredes_totales = $result_paredes_totales->fetch_array())
					   	 $paredes_totales=$arr_result_paredes_totales["total_paredes"];	
					}
						  
				  }
			?>		
				<li>
					<?php echo nl2br($arr_result['nombre']);?>
					<br>
					<img src="<?php echo $arr_result['imagen'];?>" class="door elemento_instalacion <?php if (isset($_GET["id_presupuesto"]) && $elemento_seleccionado) {?> selected <?php } ?>" id="<?php echo $arr_result['id_imagen'];?>">
					<?php
					  if ($arr_result["mostrar"] == "muros")
					  {
						  //Le dejo que seleccione el/los muros a los que va esta acción
					?>
						
						  <div class="listado_muros" <?php if (isset($_GET["id_presupuesto"])) {?> style="display:block;" <?php } ?>>
							<form class="form_muros" name="<?php echo $arr_result['id_imagen'];?>" method="POST" action="#">
							 <input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen'];?>">
							 <?php
						  if (isset($_GET["id_presupuesto"]))
					      {
						  //Le muestro muros
						   $paredes_totales_array=explode(",", $paredes_totales);
						   
						   for ($i=0;$i<count($paredes_totales_array);$i++)
						   {
							 if ($paredes_totales_array[$i] != "")
							 {
						?>	   
							  <span class="checkmuro"><input <?php if (strstr($paredes, $paredes_totales_array[$i])) { ?> checked <?php } ?> type="checkbox" name="paredes[]" class="paredes" value="<?php echo $paredes_totales_array[$i];?>"> <?php echo $paredes_totales_array[$i];?></span>
						<?php	
							 }
						   }	  
							  
							  //Le muestro todos los artículos simples
							  $result_simples=$mysqli->query("SELECT * FROM articulos_simples WHERE id_articulo_compuesto=".$arr_result["id"]);

							  while ($arr_result_simples = $result_simples->fetch_array())
							  {
								  $id_articulo_simple=$arr_result_simples["id"];
								  $codigo_articulo_simple=$arr_result_simples["codigo"];
								  $descripcion_articulo_simple=$arr_result_simples["descripcion"];
								  $visible_cliente=$arr_result_simples["visible_cliente"];
								  
								  //Si está marcado porque lo elegió un verificador
							  	  $result_elegido=$mysqli->query("SELECT id FROM clientes WHERE id_articulo_compuesto=".$arr_result["id"]." AND id_articulo_simple=$id_articulo_simple");
							 ?> 
								<div><input <?php if ((is_null($id_simple_clientes) || $id_simple_clientes == "" || $id_simple_clientes === NULL ) && $visible_cliente == 1) { ?> checked <?php } else if ($id_simple_clientes == $id_articulo_simple || $result_elegido->num_rows) { ?>checked<?php } ?>  type="checkbox" name="articulo_simple[]" value="<?php echo $id_articulo_simple;?>"> <b><?php echo $codigo_articulo_simple;?></b>: <?php echo utf8_encode($descripcion_articulo_simple);?></div>
							 <?php
							  }
						  
					     }
					  ?>	
							</form>
						  </div>
						  <?php
						   if (isset($_GET["id_presupuesto"]) && $elemento_seleccionado)
						   {
						  ?>
							<div style="color:#95C11F">Muros marcados: <?php echo $paredes;?></div>
						  <?php
						   }
						  
						  ?>
					<?php
					  }
					  else if ($arr_result["mostrar"] == "unidades")
					  {
						  //Le muestro un input para que me indique unidades
					 ?>
						<div class="unidades_elemento" <?php if (isset($_GET["id_presupuesto"])) {?> style="display:block;" <?php } ?>>
						 <form class="form_unidades" name="<?php echo $arr_result['id_imagen'];?>" method="POST" action="#">
						  <input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen'];?>">
						  <select class="form-control <?php echo $arr_result['id_imagen'];?>" name="unidades" <?php if ($arr_result["mostrar"] == "") { ?> style="display:none;"<?php } ?>>
							<?php
						     for ($i=1;$i<=10;$i++)
							 {
							?>	 
							   <option value="<?php echo $i;?>"><?php echo $i;?> <?php if ($i == 1) { ?>unidad <?php } else { ?>unidades<?php } ?></option>
							<?php	 
							 }
						  	?>
						
						  </select>
						  <?php
						  if (isset($_GET["id_presupuesto"]))
					      {
							  //Le muestro todos los artículos simples
							  $result_simples=$mysqli->query("SELECT * FROM articulos_simples WHERE id_articulo_compuesto=".$arr_result["id"]);

							  while ($arr_result_simples = $result_simples->fetch_array())
							  {
								  $id_articulo_simple=$arr_result_simples["id"];
								  $codigo_articulo_simple=$arr_result_simples["codigo"];
								  $descripcion_articulo_simple=$arr_result_simples["descripcion"];
								  $visible_cliente=$arr_result_simples["visible_cliente"];
								  
								  //Si está marcado porque lo elegió un verificador
							  	  $result_elegido=$mysqli->query("SELECT id FROM clientes WHERE id_articulo_compuesto=".$arr_result["id"]." AND id_articulo_simple=$id_articulo_simple");
								  
							 ?> 
								<div><input <?php if ((is_null($id_simple_clientes) || $id_simple_clientes == "" || $id_simple_clientes === NULL ) && $visible_cliente == 1) { ?> checked <?php } else if ($id_simple_clientes == $id_articulo_simple || $result_elegido->num_rows) { ?>checked<?php } ?>  type="checkbox" name="articulo_simple[]" value="<?php echo $id_articulo_simple;?>"> <b><?php echo $codigo_articulo_simple;?></b>: <?php echo utf8_encode($descripcion_articulo_simple);?></div>
							 <?php
							  }
						  
					     }
					  ?>
						 </form>	 
						</div>	
					 <?php
					  }
				 	 ?>
			
				</li>			
			<?php		
			 }
			?>		
		     
		 </ul>	
		 
		 <ul class="owl-carousel owl-theme listado_instalaciones listado_imagenes" id="carpinteria_exterior" style="display:none">
			<?php
			$result=$mysqli->query("SELECT * FROM articulos_compuestos WHERE tipo=7");
			
			while ($arr_result = $result->fetch_array())
			{
				$id_simple_clientes=$arr_result["id_articulo_simple"];
				if (isset($_GET["id_presupuesto"]))
				{
					//Si existe id usuario, está viendo un mapa ya creado, miro si seleccionó alguno de estos elementos
					$result_seleccion=$mysqli->query("SELECT * FROM clientes WHERE id_presupuesto=".$_GET["id_presupuesto"]." AND id_articulo_compuesto=".$arr_result["id"]);
					
					if ($result_seleccion->num_rows)
					{
					  $elemento_seleccionado=true;
					  $paredes="";
					  while ($arr_result_seleccion = $result_seleccion->fetch_array())
					  {
						  if ($paredes == "")
							 $paredes=$arr_result_seleccion["paredes"];
						  else
						    $paredes=$paredes.",".$arr_result_seleccion["paredes"];
						  
						  $paredes_totales=$arr_result_seleccion["total_paredes"];
						  $unidades=$arr_result_seleccion["unidades"];
					  }
					}
					else
					{
					  $elemento_seleccionado=false;
					  $paredes="";	
					  $result_paredes_totales=$mysqli->query("SELECT total_paredes FROM clientes WHERE id_presupuesto=".$_GET["id_presupuesto"]." AND total_paredes != '' LIMIT 1");
					  
					  while ($arr_result_paredes_totales = $result_paredes_totales->fetch_array())
					   	 $paredes_totales=$arr_result_paredes_totales["total_paredes"];	
					}
						  
				  }
			?>		
				<li>
					<?php echo nl2br($arr_result['nombre']);?>
					<br>
					<img src="<?php echo $arr_result['imagen'];?>" class="door elemento_instalacion <?php if (isset($_GET["id_presupuesto"]) && $elemento_seleccionado) {?> selected <?php } ?>" id="<?php echo $arr_result['id_imagen'];?>">
					<?php
					  if ($arr_result["mostrar"] == "muros")
					  {
						  //Le dejo que seleccione el/los muros a los que va esta acción
					?>
						
						  <div class="listado_muros" <?php if (isset($_GET["id_presupuesto"])) {?> style="display:block;" <?php } ?>>
							<form class="form_muros" name="<?php echo $arr_result['id_imagen'];?>" method="POST" action="#">
							 <input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen'];?>">
							 <?php
						  if (isset($_GET["id_presupuesto"]))
					      {
						  //Le muestro muros
						   $paredes_totales_array=explode(",", $paredes_totales);
						   
						   for ($i=0;$i<count($paredes_totales_array);$i++)
						   {
							if ($paredes_totales_array[$i] != "")
							 {
						?>	   
							  <span class="checkmuro"><input <?php if (strstr($paredes, $paredes_totales_array[$i])) { ?> checked <?php } ?> type="checkbox" name="paredes[]" class="paredes" value="<?php echo $paredes_totales_array[$i];?>"> <?php echo $paredes_totales_array[$i];?></span>
						<?php	
							}
						   }
							  
							  //Le muestro todos los artículos simples
							  $result_simples=$mysqli->query("SELECT * FROM articulos_simples WHERE id_articulo_compuesto=".$arr_result["id"]);

							  while ($arr_result_simples = $result_simples->fetch_array())
							  {
								  $id_articulo_simple=$arr_result_simples["id"];
								  $codigo_articulo_simple=$arr_result_simples["codigo"];
								  $descripcion_articulo_simple=$arr_result_simples["descripcion"];
								  $visible_cliente=$arr_result_simples["visible_cliente"];
								  
								  //Si está marcado porque lo elegió un verificador
							  	  $result_elegido=$mysqli->query("SELECT id FROM clientes WHERE id_articulo_compuesto=".$arr_result["id"]." AND id_articulo_simple=$id_articulo_simple");
								  
							 ?> 
								<div><input <?php if ((is_null($id_simple_clientes) || $id_simple_clientes == "" || $id_simple_clientes === NULL ) && $visible_cliente == 1) { ?> checked <?php } else if ($id_simple_clientes == $id_articulo_simple || $result_elegido->num_rows) { ?>checked<?php } ?>  type="checkbox" name="articulo_simple[]" value="<?php echo $id_articulo_simple;?>"> <b><?php echo $codigo_articulo_simple;?></b>: <?php echo utf8_encode($descripcion_articulo_simple);?></div>
							 <?php
							  }
						  
					     }
					  ?>
							</form>
						  </div>
						  <?php
						   if (isset($_GET["id_presupuesto"]) && $elemento_seleccionado)
						   {
						  ?>
							<div style="color:#95C11F">Muros marcados: <?php echo $paredes;?></div>
						  <?php
						   }
						  
						  ?>
					<?php
					  }
					  else if ($arr_result["mostrar"] == "unidades")
					  {
						  //Le muestro un input para que me indique unidades
					 ?>
						<div class="unidades_elemento" <?php if (isset($_GET["id_presupuesto"])) {?> style="display:block;" <?php } ?>>
						 <form class="form_unidades" name="<?php echo $arr_result['id_imagen'];?>" method="POST" action="#">
						  <input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen'];?>">
						  <select class="form-control <?php echo $arr_result['id_imagen'];?>" name="unidades" <?php if ($arr_result["mostrar"] == "") { ?> style="display:none;"<?php } ?>>
							<?php
						     for ($i=1;$i<=10;$i++)
							 {
							?>	 
							   <option value="<?php echo $i;?>"><?php echo $i;?> <?php if ($i == 1) { ?>unidad <?php } else { ?>unidades<?php } ?></option>
							<?php	 
							 }
						  	?>
						
						  </select>	 
						  <?php
						  if (isset($_GET["id_presupuesto"]))
					      {
							  //Le muestro todos los artículos simples
							  $result_simples=$mysqli->query("SELECT * FROM articulos_simples WHERE id_articulo_compuesto=".$arr_result["id"]);

							  while ($arr_result_simples = $result_simples->fetch_array())
							  {
								  $id_articulo_simple=$arr_result_simples["id"];
								  $codigo_articulo_simple=$arr_result_simples["codigo"];
								  $descripcion_articulo_simple=$arr_result_simples["descripcion"];
								  $visible_cliente=$arr_result_simples["visible_cliente"];
								  
								  //Si está marcado porque lo elegió un verificador
							  	  $result_elegido=$mysqli->query("SELECT id FROM clientes WHERE id_articulo_compuesto=".$arr_result["id"]." AND id_articulo_simple=$id_articulo_simple");
								  
							 ?> 
								<div><input <?php if ((is_null($id_simple_clientes) || $id_simple_clientes == "" || $id_simple_clientes === NULL ) && $visible_cliente == 1) { ?> checked <?php } else if ($id_simple_clientes == $id_articulo_simple || $result_elegido->num_rows) { ?>checked<?php } ?>  type="checkbox" name="articulo_simple[]" value="<?php echo $id_articulo_simple;?>"> <b><?php echo $codigo_articulo_simple;?></b>: <?php echo utf8_encode($descripcion_articulo_simple);?></div>
							 <?php
							  }
						  
					     }
					  ?>
						 </form>	 
						</div>	
					 <?php
					  }
					  
					?>
			
				</li>		
		   <?php		
			}
		   ?>		
		     
		 </ul>	
		 
	 </div>
		
	 <?php
	 if (isset($_SESSION["login"]) && isset($_GET["id_presupuesto"]))
	 {
	?>
	  
	  <div id="opciones_sc" style="display:none">
		
		<h2>Buscador</h2>
		<form name="form_sc" id="form_sc" method="POST" action="#">
			<p><input type="text" name="sc" id="sc" placeholder="Escribe..." class="form-control"></p>
			<p><input type="button" class="btn btn-success" value="Añadir S/C" id="agregar_sc_buscador"></p>
		</form>
		 
		<h2>Nuevo S/C</h2>  
		<form name="form_nuevo_sc" id="form_nuevo_sc" method="POST" action="#">
			<p><input type="text" name="nuevo_sc" placeholder="Código" class="form-control"></p>
			<p><input type="text" name="descripcion_sc" placeholder="Descripción" class="form-control"></p>
			<p><input type="text" name="precio_sc" placeholder="Precio. Ejemplo: 20.95" class="form-control"></p>
			<p><input type="button" class="btn btn-success" value="Añadir S/C" id="agregar_sc_nuevo"></p>
		</form>
		 
		<div id="listado_sc_guardados"></div>
	  </div>
	<?php
	  }
	 ?>
		
	</div>
	 
 </div>
<!-- fin parte superior -->
 <div id="mensaje_inicio">
	 Lo primero de todo vamos a generar el espacio de nuestra cocina.<br/>
    Introduce las medidas y dibuja el plano de tu cocina en planta haciendo clic en 'COMENZAR'.
  </div>
<?php
 }
 else
 {
	 
?>
	<div id="parte_superior"></div>
<?php
 }
?>

	
  <svg id="lin" viewBox="0 0 1100 700"  preserveAspectRatio="xMidYMin slice" xmlns="http://www.w3.org/2000/svg" style="z-index:2;margin:0;padding:0;width:100vw;height:100vh;position:absolute;top:0;left:0;right:0;bottom:0">

    <defs>
      <linearGradient id="gradientRed" x1="0%" y1="0%" x2="100%" y2="100%" spreadMethod="pad">
        <stop offset="0%"   stop-color="#e65d5e" stop-opacity="1"/>
        <stop offset="100%" stop-color="#e33b3c" stop-opacity="1"/>
      </linearGradient>
      <linearGradient id="gradientYellow" x1="0%" y1="0%" x2="100%" y2="100%" spreadMethod="pad">
        <stop offset="0%"   stop-color="#FDEB71" stop-opacity="1"/>
        <stop offset="100%" stop-color="#F8D800" stop-opacity="1"/>
      </linearGradient>
      <linearGradient id="gradientGreen" x1="0%" y1="0%" x2="100%" y2="100%" spreadMethod="pad">
        <stop offset="0%"   stop-color="#c0f7d9" stop-opacity="1"/>
        <stop offset="100%" stop-color="#6ce8a3" stop-opacity="1"/>
      </linearGradient>
      <linearGradient id="gradientSky" x1="0%" y1="0%" x2="100%" y2="100%" spreadMethod="pad">
        <stop offset="0%"   stop-color="#c4e0f4" stop-opacity="1"/>
        <stop offset="100%" stop-color="#87c8f7" stop-opacity="1"/>
      </linearGradient>
      <linearGradient id="gradientOrange" x1="0%" y1="0%" x2="100%" y2="100%" spreadMethod="pad">
        <stop offset="0%"   stop-color="#f9ad67" stop-opacity="1"/>
        <stop offset="100%" stop-color="#f97f00" stop-opacity="1"/>
      </linearGradient>
      <linearGradient id="gradientWhite" x1="0%" y1="0%" x2="100%" y2="100%" spreadMethod="pad">
        <stop offset="0%"   stop-color="#ffffff" stop-opacity="1"/>
        <stop offset="100%" stop-color="#f0f0f0" stop-opacity="1"/>
      </linearGradient>
      <linearGradient id="gradientGrey" x1="0%" y1="0%" x2="100%" y2="100%" spreadMethod="pad">
        <stop offset="0%"   stop-color="#666" stop-opacity="1"/>
        <stop offset="100%" stop-color="#aaa" stop-opacity="1"/>
      </linearGradient>
      <linearGradient id="gradientBlue" x1="0%" y1="0%" x2="100%" y2="100%" spreadMethod="pad">
        <stop offset="0%"   stop-color="#4f72a6" stop-opacity="1"/>
        <stop offset="100%" stop-color="#365987" stop-opacity="1"/>
      </linearGradient>
      <linearGradient id="gradientPurple" x1="0%" y1="0%" x2="100%" y2="100%" spreadMethod="pad">
        <stop offset="0%"   stop-color="#E2B0FF" stop-opacity="1"/>
        <stop offset="100%" stop-color="#9F44D3" stop-opacity="1"/>
      </linearGradient>
      <linearGradient id="gradientPink" x1="0%" y1="0%" x2="100%" y2="100%" spreadMethod="pad">
        <stop offset="0%"   stop-color="#f6c4dd" stop-opacity="1"/>
        <stop offset="100%" stop-color="#f699c7" stop-opacity="1"/>
      </linearGradient>
      <linearGradient id="gradientBlack" x1="0%" y1="0%" x2="100%" y2="100%" spreadMethod="pad">
        <stop offset="0%"   stop-color="#3c3b3b" stop-opacity="1"/>
        <stop offset="100%" stop-color="#000000" stop-opacity="1"/>
      </linearGradient>
      <linearGradient id="gradientNeutral" x1="0%" y1="0%" x2="100%" y2="100%" spreadMethod="pad">
        <stop offset="0%"   stop-color="#dbc6a0" stop-opacity="1"/>
        <stop offset="100%" stop-color="#c69d56" stop-opacity="1"/>
      </linearGradient>

      <pattern id="grass" patternUnits="userSpaceOnUse" width="256" height="256">
        <image xlink:href="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRWh5nEP_Trwo96CJjev6lnKe0_dRdA63RJFaoc3-msedgxveJd" x="0" y="0" width="256" height="256" />
      </pattern>
      <pattern id="wood" patternUnits="userSpaceOnUse" width="32" height="256">
        <image xlink:href="https://orig00.deviantart.net/e1f2/f/2015/164/8/b/old_oak_planks___seamless_texture_by_rls0812-d8x6htl.jpg" x="0" y="0" width="256" height="256" />
      </pattern>
      <pattern id="tiles" patternUnits="userSpaceOnUse" width="25" height="25">
        <image xlink:href="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQrkoI2Eiw8ya3J_swhfpZdi_ug2sONsI6TxEd1xN5af3DX9J3R" x="0" y="0" width="256" height="256" />
      </pattern>
      <pattern id="granite" patternUnits="userSpaceOnUse" width="256" height="256">
        <image xlink:href="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ9_nEMhnWVV47lxEn5T_HWxvFwkujFTuw6Ff26dRTl4rDaE8AdEQ" x="0" y="0" width="256" height="256" />
      </pattern>
      <pattern id="smallGrid" width="60" height="60" patternUnits="userSpaceOnUse">
        <path d="M 60 0 L 0 0 0 60" fill="none" stroke="#777" stroke-width="0.25"/>
      </pattern>
      <pattern id="grid" width="180" height="180" patternUnits="userSpaceOnUse">
        <rect width="180" height="180" fill="url(#smallGrid)"/>
        <path d="M 200 10 L 200 0 L 190 0 M 0 10 L 0 0 L 10 0 M 0 190 L 0 200 L 10 200 M 190 200 L 200 200 L 200 190" fill="none" stroke="#999" stroke-width="0.8"/>
      </pattern>
      <pattern id="hatch" width="5" height="5" patternTransform="rotate(50 0 0)" patternUnits="userSpaceOnUse" >
        <path d="M 0 0 L 0 5 M 10 0 L 10 10 Z" style="stroke:#666;stroke-width:5;" />
      </pattern>
    </defs>
    <g id="boxgrid">
      <rect width="8000" height="5000" x="-3500" y="-2000" fill="url(#grid)" />
    </g>
    <g id="boxpath"></g>
    <g id="boxSurface"></g>
    <g id="boxRoom"></g>
    <g id="boxwall"></g>
    <g id="boxcarpentry"></g>
    <g id="boxEnergy"></g>
    <g id="boxFurniture"></g>
    <g id="boxbind"></g>
    <g id="boxArea"></g>
    <g id="boxRib"></g>
    <g id="boxScale"></g>
    <g id="boxText"></g>
    <g id="boxDebug"></g>
  </svg>

  <div id="areaValue"></div>

  <div id="reportTools" class="leftBox" style="width:500px;overflow-y: scroll;overflow-x: hidden">
    <h2><i class="fa fa-calculator" aria-hidden="true"></i> Report plan.</h2>
    <br/><br/>
    <h2 class="toHide" id="reportTotalSurface" style="display:none"></h2>
    <h2 class="toHide" id="reportNumberSurface" style="display:none"></h2>
    <hr/>
    <section id="reportRooms" class="toHide" style="display:none">
    </section>
    <button class="btn btn-info fully" style="margin-top:50px" onclick="$('#reportTools').hide('500', function(){$('#panel').show(300);});mode = 'select_mode';"><i class="fa fa-2x fa-backward" aria-hidden="true" ></i></button>
  </div>

  <div id="wallTools" class="leftBox">
    <h2 id="titleWallTools">Modifica la pared</h2>
    <hr/>
    <section id="rangeThick">
      <p>Editando: <span id="wallWidthScale"></span>  <span id="wallWidthVal"></span></span></p>
      <input type="text" id="wallWidth" />
    </section>
    <ul class="list-unstyled">
    <!--<section id="cutWall">
      <p>Cut the wall :<br/><small>A cut will be made at each wall encountered.</small></p>
      <li><button class="btn btn-default fully" onclick="editor.splitWall();"><i class="fa fa-2x fa-cutlery" aria-hidden="true"></i></button></li>
    </section>
    <br/>
    <section id="separate">
      <p>Separation wall :<br/><small>Transform the wall into simple separation line.</small></p>
      <li><button class="btn btn-default fully" onclick="editor.invisibleWall();" id="wallInvisible"><i class="fa fa-2x fa-crop" aria-hidden="true"></i></button></li>
    </section>
    <section id="recombine">
      <p>Transform to wall :<br/><small>The thickness will be identical to the last known.</small></p>
      <li><button class="btn btn-default fully" onclick="editor.visibleWall();" id="wallVisible"><i class="fa fa-2x fa-crop" aria-hidden="true"></i></button></li>
    </section>-->
    <br/>
    <li><button class="btn btn-danger halfy" id="wallTrash"><i class="fa fa-2x fa-trash-o" aria-hidden="true"></i></button>
    <button class="btn btn-info halfy pull-right" onclick="fonc_button('select_mode');$('#boxinfo').html('Modo selección');$('#wallTools').hide('300');$('#panel').show('300');"><i class="fa fa-2x fa-backward" aria-hidden="true" ></i></button></li>
    </ul>
  </div>

  <div id="objBoundingBox" class="leftBox">
    <h2>Modifica el objeto</h2>
    <hr/>
    <section id="objBoundingBoxScale">
      <p>Width [<span id="bboxWidthScale"></span>] : <span id="bboxWidthVal"></span> cm</span></p>
      <input type="range" id="bboxWidth" step="1" class="range" />
      <p>Length [<span id="bboxHeightScale"></span>] : <span id="bboxHeightVal"></span> cm</span></p>
      <input type="range" id="bboxHeight" step="1" class="range" />
    </section>

    <section id="objBoundingBoxRotation">
    <p><i class="fa fa-compass" aria-hidden="true"></i> Rotación : <span id="bboxRotationVal"></span> °</p>
    <input type="range" id="bboxRotation" step="1" class="range" min="-180" max = "180"/>
    </section>

    <div id="stepsCounter" style="display:none;">
      <p><span id="bboxSteps">Nb steps [2-15] : <span id="bboxStepsVal">0</span></span></p>
      <button class="btn btn-info" id="bboxStepsAdd"><i class="fa fa-plus" aria-hidden="true"></i></button>
      <button class="btn btn-info" id="bboxStepsMinus"><i class="fa fa-minus" aria-hidden="true"></i></button>
    </div>

    <div id="objBoundingBoxColor" style="display:none;">
      <div class="color textEditorColor" data-type="gradientRed" style="color:#f55847;background:linear-gradient(30deg, #f55847, #f00);"></div>
      <div class="color textEditorColor" data-type="gradientYellow" style="color:#e4c06e;background:linear-gradient(30deg,#e4c06e, #ffb000);"></div>
      <div class="color textEditorColor" data-type="gradientGreen" style="color:#88cc6c;background:linear-gradient(30deg,#88cc6c, #60c437);"></div>
      <div class="color textEditorColor" data-type="gradientSky" style="color:#77e1f4;background:linear-gradient(30deg,#77e1f4, #00d9ff);"></div>
      <div class="color textEditorColor" data-type="gradientBlue" style="color:#4f72a6;background:linear-gradient(30deg,#4f72a6, #284d7e);"></div>
      <div class="color textEditorColor" data-type="gradientGrey" style="color:#666666;background:linear-gradient(30deg,#666666, #aaaaaa);"></div>
      <div class="color textEditorColor" data-type="gradientWhite" style="color:#fafafa;background:linear-gradient(30deg,#fafafa, #eaeaea);"></div>
      <div class="color textEditorColor" data-type="gradientOrange" style="color:#f9ad67;background:linear-gradient(30deg, #f9ad67, #f97f00);"></div>
      <div class="color textEditorColor" data-type="gradientPurple" style="color:#a784d9;background:linear-gradient(30deg,#a784d9, #8951da);"></div>
      <div class="color textEditorColor" data-type="gradientPink" style="color:#df67bd;background:linear-gradient(30deg,#df67bd, #e22aae);"></div>
      <div class="color textEditorColor" data-type="gradientBlack" style="color:#3c3b3b;background:linear-gradient(30deg,#3c3b3b, #000000);"></div>
      <div class="color textEditorColor" data-type="gradientNeutral" style="color:#e2c695;background:linear-gradient(30deg,#e2c695, #c69d56);"></div>
      <div style="clear:both"></div>
    </div>

    <br/><br/>
    <button class="btn btn-danger fully" id="bboxTrash"><i class="fa fa-2x fa-trash-o" aria-hidden="true"></i></button>
    <button class="btn btn-info" style="margin-top:50px" onclick="fonc_button('select_mode');$('#boxinfo').html('Mode sélection');$('#objBoundingBox').hide(100);$('#panel').show(200);binder.graph.remove();delete binder;"><!--<i class="fa fa-2x fa-backward" aria-hidden="true" ></i>-->GUARDAR MODIFICACIÓN</button>
  </div>

  <div id="objTools" class="leftBox">
    <h2>Modificar puerta/ventana</h2>
    <hr/>
    <ul class="list-unstyled">
      <br/><br/>
      <li style="display:none;"><button class="btn btn-default fully" id="objToolsHinge">REVERTIR</button></li>

      <p>Ancho [<span id="doorWindowWidthScale"></span>] : <span id="doorWindowWidthVal"></span> cm</span></p>
      <input type="range" id="doorWindowWidth" step="1" class="range" />
    <br/>
    <li><button class="btn btn-danger fully objTrash"><i class="fa fa-2x fa-trash-o" aria-hidden="true"></i></button></li>
    <li><button class="btn btn-info" style="margin-top:50px" onclick="fonc_button('select_mode');$('#boxinfo').html('Mode sélection');$('#objTools').hide('100');$('#panel').show('200');binder.graph.remove();delete binder;rib();"><i class="fa fa-2x fa-backward" aria-hidden="true" ></i></button></li>
    </ul>
  </div>

  <div id="roomTools" class="leftBox">
    <span style="color:#08d">Rehubic</span> :<br/><b><span class="size"></span></b>
    <br/><br/>
    <p>Dibuja aquí</p>
    <div class="input-group">
    <input type="text" class="form-control" id="roomSurface"  placeholder="surface réelle" aria-describedby="basic-addon2">
    <span class="input-group-addon" id="basic-addon2">m²</span>
    </div>
    <br/>
    <input type="hidden" id="roomName" value="" />
    Wording :<br/>
    <div class="btn-group">
        <button class="btn dropdown-toggle btn-default" data-toggle="dropdown" id="roomLabel">Wording of the room   <span class="caret"></span></button>
    <ul class="dropdown-menu">
      <li><a href="#">None</a></li>
      <li><a href="#">Lounge</a></li>
      <li><a href="#">Lunchroom</a></li>
      <li><a href="#">Kitchen</a></li>
      <li><a href="#">Toilet</a></li>
      <li><a href="#">Bathroom</a></li>
      <li><a href="#">Bedroom 1</a></li>
      <li><a href="#">Bedroom 2</a></li>
      <li><a href="#">Bedroom 3</a></li>
      <li><a href="#">Locker</a></li>
      <li><a href="#">Office</a></li>
      <li><a href="#">Hall</a></li>
      <li><a href="#">Loggia</a></li>
      <li><a href="#">Bath 2</a></li>
      <li><a href="#">Toilet 2</a></li>
      <li><a href="#">Bedroom 4</a></li>
      <li><a href="#">Bedroom 5</a></li>
      <li class="divider"></li>
      <li><a href="#">Balcony</a></li>
      <li><a href="#">Terrace</a></li>
      <li><a href="#">Corridor</a></li>
      <li><a href="#">Garage</a></li>
      <li><a href="#">clearance</a></li>
    </ul>
    </div>
    <br/>
    <br/>
    Meter :
    <div class="funkyradio">
      <div class="funkyradio-success">
             <input type="checkbox" name="roomShow" value="showSurface" id="seeArea" checked/>
             <label for="seeArea">Show the surface</label>
         </div>
    </div>
    <div class="funkyradio">
            <div class="funkyradio-success">
                <input type="radio" name="roomAction" id="addAction" value="add" checked />
                <label for="addAction">Add the surface</label>
            </div>
            <div class="funkyradio-warning">
                <input type="radio" name="roomAction" id="passAction" value="pass" />
                <label for="passAction">Ignore the surface</label>
            </div>
    </div>
    <hr/>

    <p>Colores</p>
    <div class="roomColor" data-type="gradientRed" style="background:linear-gradient(30deg, #f55847, #f00);"></div>
    <div class="roomColor" data-type="gradientYellow" style="background:linear-gradient(30deg,#e4c06e, #ffb000);"></div>
    <div class="roomColor" data-type="gradientGreen" style="background:linear-gradient(30deg,#88cc6c, #60c437);"></div>
    <div class="roomColor" data-type="gradientSky" style="background:linear-gradient(30deg,#77e1f4, #00d9ff);"></div>
    <div class="roomColor" data-type="gradientBlue" style="background:linear-gradient(30deg,#4f72a6, #284d7e);"></div>
    <div class="roomColor" data-type="gradientGrey" style="background:linear-gradient(30deg,#666666, #aaaaaa);"></div>
    <div class="roomColor" data-type="gradientWhite" style="background:linear-gradient(30deg,#fafafa, #eaeaea);"></div>
    <div class="roomColor" data-type="gradientOrange" style="background:linear-gradient(30deg, #f9ad67, #f97f00);"></div>
    <div class="roomColor" data-type="gradientPurple" style="background:linear-gradient(30deg,#a784d9, #8951da);"></div>
    <div class="roomColor" data-type="gradientPink" style="background:linear-gradient(30deg,#df67bd, #e22aae);"></div>
    <div class="roomColor" data-type="gradientBlack" style="background:linear-gradient(30deg,#3c3b3b, #000000);"></div>
    <div class="roomColor" data-type="gradientNeutral" style="background:linear-gradient(30deg,#e2c695, #c69d56);"></div>
    <br/><br/>
    <p>Materiales</p>
    <div class="roomColor" data-type="wood" style="background: url('https://orig00.deviantart.net/e1f2/f/2015/164/8/b/old_oak_planks___seamless_texture_by_rls0812-d8x6htl.jpg');"></div>
    <div class="roomColor" data-type="tiles" style="background: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQrkoI2Eiw8ya3J_swhfpZdi_ug2sONsI6TxEd1xN5af3DX9J3R');"></div>
    <div class="roomColor" data-type="granite" style="background: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ9_nEMhnWVV47lxEn5T_HWxvFwkujFTuw6Ff26dRTl4rDaE8AdEQ');"></div>
    <div class="roomColor" data-type="grass" style="background: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRWh5nEP_Trwo96CJjev6lnKe0_dRdA63RJFaoc3-msedgxveJd');"></div>
    <div data-type="#ff008a" style="clear:both"></div>
    <br/><br/>
      <input type="hidden" id="roomBackground" value="gradientNeutral" />
      <input type="hidden" id="roomIndex" value="" />
      <button type="button" class="btn btn-primary" id="applySurface">Apply</button>
      <button type="button" class="btn btn-danger" id="resetRoomTools">Cancel</button>

      <br/>
  </div>

  <div style="position:absolute;bottom:10px;left:310px;font-size:1.5em;color:#08d" id="boxinfo">
  </div>

  <div id="moveBox" style="position:absolute;right:-150px;top:10px;color:#08d;background:transparent;z-index:2;text-align:center;transition-duration: 0.2s;transition-timing-function: ease-in;">
    <p style="margin:0px 0 0 0;font-size:11px;display:none"><img src="https://cdn4.iconfinder.com/data/icons/mathematics-doodle-3/48/102-128.png" width="20" /> Rehubic</p>
    <div class="pull-right" style="margin:10px">
    <p style="margin:0"><button class="btn btn-xs btn-info zoom" data-zoom="zoomtop" style="box-shadow:2px 2px 3px #ccc;"><i class="fa fa-arrow-up" aria-hidden="true"></i></button></p>
    <p style="margin:0">
      <button class="btn btn-xs btn-info zoom" data-zoom="zoomleft" style="box-shadow:2px 2px 3px #ccc;"><i class="fa fa-arrow-left" aria-hidden="true"></i></button>
      <button class="btn btn-xs btn-default zoom" data-zoom="zoomreset" style="box-shadow:2px 2px 3px #ccc;"><i class="fa fa-bullseye" aria-hidden="true"></i></button>
      <button class="btn btn-xs btn-info zoom" data-zoom="zoomright" style="box-shadow:2px 2px 3px #ccc;"><i class="fa fa-arrow-right" aria-hidden="true"></i></button>
    </p>
    <p style="margin:0"><button class="btn btn-xs btn-info zoom" data-zoom="zoombottom" style="box-shadow:2px 2px 3px #ccc;"><i class="fa fa-arrow-down" aria-hidden="true"></i></button></p>
    </div>
  </div>

  <div id="zoomBox" style="position:absolute;z-index:100;right:-150px;bottom:20px;text-align:center;background:transparent;padding:0px;color:#fff;transition-duration: 0.2s;transition-timing-function: ease-in;">
    <div class="pull-right" style="margin-right:10px">
      <button class="btn btn btn-default zoom" data-zoom="zoomin" style="box-shadow:2px 2px 3px #ccc;"><i class="fa fa-plus" aria-hidden="true"></i></button>
      <button class="btn btn btn-default zoom" data-zoom="zoomout" style="box-shadow:2px 2px 3px #ccc;"><i class="fa fa-minus" aria-hidden="true"></i></button>
    </div>
    <div style="clear:both"></div>
      <div id="scaleVal"  class="pull-right"  style="box-shadow:2px 2px 3px #ccc;width:60px;height:20px;background:#4b79aa;border-radius:4px;margin-right:10px">
        1m
      </div>

      <div style="clear:both"></div>
  </div>
</body>
  <script src="jquery.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
  <script>
	  
  $("input[name='opcion_tabique']").click(function() { 
	  
	  var muro=$("#wallWidth").attr("class");
	  if ($("input[name='opcion_tabique']:checked").val() == "demoler")
	  {
	    $("#"+muro).attr("fill","#F08675");
	  }
	  else if ($("input[name='opcion_tabique']:checked").val() == "nuevo")
	  {
	    $("#"+muro).attr("fill","green");
	  }
	  else 
	  {
		 $("#"+muro).attr("fill","#666");
	  }
	  
  })	 
	  
	  
  function instrucciones(paso) {
	if (paso == "paso21")
	{
		alertify.alert("<p><b>Si se mantiene la geometría de tu cocina</b> y no vas a modificar ningún tabique, dibuja la tabiquería, igual que en el paso 1.</p><p><b>En el caso de que estés pensando en aumentar o disminuir la superficie de tú cocina</b>, en definitiva, si vas a tirar tabiques o realizar tabiques nuevas, deberás:</p><ol><li>Dibujar el plano del estado actual de la cocina. Ojo! En esta ocasión deberás definir los tabiques nuevos y los tabiques a demoler, para ello, tendrás que dibujar de manera independiente cada tramo de tabique que se mantiene, se demuele o se realiza nuevo. Ej: Si del tabique “A” de 3m de largo, vas a demoler únicamente la mitad, deberás dibujar 1,5m y clicar para dibujar en la misma dirección el siguiente tramo de 1,5m.</li><li>Seleccionar haciendo doble clic encima de cada tabique a demoler o a hacer nuevo y definir la tipología de tabique que corresponda.</li></ol><p><b>Tanto si se modifica la geometría de la cocina como si se mantiene</b>, podrás seleccionar entre los distintos tipos de apertura de ventanas y puertas y ubicarlos en el plano. Haz doble clic en cada una de ellas para definir sus dimensiones.</p><p>Recuerda definir la altura actual de suelo a techo de tu cocina. Si en tu cocina hay dos alturas diferentes, una viga o un falseado a una altura inferior, en este paso indica únicamente la altura mayor de suelo a techo y en el último paso “2.4 Indica observaciones” podrás añadir un cuadro de texto indicando la situación en concreto así como las diferentes alturas. Ej.Tengo una viga que atraviesa la cocina en horizontal, en ese punto la altura de suelo a techo es de 2.22m.</p>");
	}
	else if (paso == "paso22")
	{
		alertify.alert("<p>Define la distribución de mobiliario y electrodomésticos que quieres en tu cocina reformada.</p>");
	}
	else if (paso == "paso23")
	{
		alertify.alert("<p>Añade las instalaciones necesarias para tu cocina reformada</p>");
	}
	  
  }
	  
	  
	  
  /*function eliminaSeleccion()
  {
	//Para que la pared no se quede marcada.
	if ($("#boxbind > g").length )
	{
		$("#boxbind > g").remove();
		
	}
	  $("#boxcarpentry > g > circle").parent().remove();
	  $("#boxScale > path").remove();
  }*/
  function eliminaSC(codigo)
  {
	  codigo_sc=codigo;
	  $.ajax({
			type: "POST",
			data:{codigo_sc:codigo_sc},
			dataType: 'json',
			async:false,
			url: "ajax/eliminar_sc.php?id_presupuesto=<?php echo $_GET['id_presupuesto'];?>",
			success:function(respuesta){
			  if (respuesta.error == 1)
				alertify.error(respuesta.mensaje);
			  else
			  {
				alertify.success(respuesta.mensaje);
				$('#'+codigo_sc).remove();	
			  }
			  
			}

	     });
  }
  $( document ).ready(function() {
	  setInterval(function(){ 
	  
		  if ($("#boxcarpentry > g > circle").length)
			  $("#boxcarpentry > g > circle").parent().remove();
	  
	  }, 3000);
	  $("#agregar_sc_nuevo").click(function() {
		  var formulario=$("#form_nuevo_sc").serialize();
		  //nuevo_sc / descripcion_sc / precio_sc
		  //alert(formulario);
		  $.ajax({
			type: "POST",
			data:formulario,
			dataType: 'json',
			async:false,
			url: "ajax/guardar_sc_nuevo.php?id_presupuesto=<?php echo $_GET['id_presupuesto'];?>",
			success:function(respuesta){
			  if (respuesta.error == 1)
				alertify.error(respuesta.mensaje);
			  else
			  {
				alertify.success(respuesta.mensaje);
				document.getElementById("listado_sc_guardados").innerHTML+="<p id='"+respuesta.codigo+"'>"+respuesta.codigo+" <span style='color:red;font.weight:bold;cursor:pointer;' onclick='eliminaSC(\""+respuesta.codigo+"\")'>ELIMINAR</span></p>";
			  }
			  $('#form_nuevo_sc').trigger("reset");	
			}

	     });
	  })
	  
	  $("#agregar_sc_buscador").click(function() {
		 var sc=document.getElementById("sc").value;
		 $.ajax({
			type: "POST",
			data: {sc:sc},
			dataType: 'json', 
			async:false,
			url: "ajax/guardar_sc_buscador.php?id_presupuesto=<?php echo $_GET['id_presupuesto'];?>",
			success:function(respuesta){
			  if (respuesta.error == 1)
				alertify.error(respuesta.mensaje);
			  else
			  {
				alertify.success(respuesta.mensaje);
				document.getElementById("listado_sc_guardados").innerHTML+="<p id='"+respuesta.codigo+"'>"+respuesta.codigo+" <span style='color:red;font.weight:bold;cursor:pointer;' onclick='eliminaSC(\""+respuesta.codigo+"\")'>ELIMINAR</span></p>";
			  }
			  document.getElementById("sc").value="";
			}

	     });
		  
	  })
	  
	  availableTags=[];
	  $.ajax({
		type: "POST",
		dataType: 'json', 
		async:false,
		url: "ajax/obtener_sc.php",
		success:function(respuesta){
		 
		 availableTags=respuesta;
		 console.log("AVAILABLE TAGS");
		 console.log(availableTags);
		}

	  });
	  
	  $( function() {
		/*var availableTags = [
		  "ActionScript",
		  "AppleScript",
		  "Asp",
		  "BASIC",
		  "C",
		  "C++",
		  "Clojure",
		  "COBOL",
		  "ColdFusion",
		  "Erlang",
		  "Fortran",
		  "Groovy",
		  "Haskell",
		  "Java",
		  "JavaScript",
		  "Lisp",
		  "Perl",
		  "PHP",
		  "Python",
		  "Ruby",
		  "Scala",
		  "Scheme"
		];
		*/
		$( "#sc" ).autocomplete({
		  source: availableTags
		});
	  } );
	  
  });
  </script>

  <script>
	/*!
	 * jQuery UI Touch Punch 0.2.3
	 *
	 * Copyright 2011â€“2014, Dave Furfero
	 * Dual licensed under the MIT or GPL Version 2 licenses.
	 *
	 * Depends:
	 *  jquery.ui.widget.js
	 *  jquery.ui.mouse.js
	 */
	!function(a){function f(a,b){if(!(a.originalEvent.touches.length>1)){a.preventDefault();var c=a.originalEvent.changedTouches[0],d=document.createEvent("MouseEvents");d.initMouseEvent(b,!0,!0,window,1,c.screenX,c.screenY,c.clientX,c.clientY,!1,!1,!1,!1,0,null),a.target.dispatchEvent(d)}}if(a.support.touch="ontouchend"in document,a.support.touch){var e,b=a.ui.mouse.prototype,c=b._mouseInit,d=b._mouseDestroy;b._touchStart=function(a){var b=this;!e&&b._mouseCapture(a.originalEvent.changedTouches[0])&&(e=!0,b._touchMoved=!1,f(a,"mouseover"),f(a,"mousemove"),f(a,"mousedown"))},b._touchMove=function(a){e&&(this._touchMoved=!0,f(a,"mousemove"))},b._touchEnd=function(a){e&&(f(a,"mouseup"),f(a,"mouseout"),this._touchMoved||f(a,"click"),e=!1)},b._mouseInit=function(){var b=this;b.element.bind({touchstart:a.proxy(b,"_touchStart"),touchmove:a.proxy(b,"_touchMove"),touchend:a.proxy(b,"_touchEnd")}),c.call(b)},b._mouseDestroy=function(){var b=this;b.element.unbind({touchstart:a.proxy(b,"_touchStart"),touchmove:a.proxy(b,"_touchMove"),touchend:a.proxy(b,"_touchEnd")}),d.call(b)}}}(jQuery);

  </script>
  <script src="bootstrap.min.js"></script>
  <script src="mousewheel.js"></script>
  <script src="func.js"></script>
  <script src="qSVG.js"></script>
  <script src="editor.js"></script>
  <script src="engine.js"></script>
  <script src="js/OwlCarousel/dist/owl.carousel.min.js"></script>
  <script>
	  
	  $(document).on('input', '[name="metros_parcial"]', function() {
			
			var value=this.value;
			var a = $(this).parent().parent(); /* nombre del formulario */
			var valor_anterior = $("form[name='"+a[0].name+"'] * input[value='"+this.className+"']").val().split('/');
			


			$("form[name='"+a[0].name+"'] * input[value='"+this.className+"']").val(valor_anterior[0]);  


			$("form[name='"+a[0].name+"'] * input[type='checkbox'][value='"+this.className+"']").attr("checked",true);
			$("form[name='"+a[0].name+"'] * input[type='checkbox'][value='"+valor_anterior[0]+"']").val(valor_anterior[0]+"/"+value);
			this.className = valor_anterior[0]+"/"+value;

		});
	  
	  $( document ).on( "click", "input[name='seleccion_metros'][value='parcial']", function() {
		
		  var valor_clase=this.className;
		  var a = $(this).parent().parent(); /* nombre del formulario */
		  
		 
		  
		  $("form[name='"+a[0].name+"'] * input[value*='"+valor_clase+"']").val(valor_clase); 
		  $("form[name='"+a[0].name+"'] *  input[name='seleccion_metros'][class='"+valor_clase+"'] + input[type='range']").removeClass();
		  $("form[name='"+a[0].name+"'] *  input[name='seleccion_metros'][class='"+valor_clase+"'] + input[type='range']").addClass(valor_clase);
		  
		 $("form[name='"+a[0].name+"'] * input[name='seleccion_metros'][class='"+valor_clase+"'] + input[type='range']").show();
 		 $("form[name='"+a[0].name+"'] * input[name='seleccion_metros'][class='"+valor_clase+"'] + input[type='range']").attr("style","display:block !important");

	  })
	  
	  $( document ).on( "click", ".child", function() {
		  
		var value=this.value;
		  
		  
		const replacers_child =   {
					Pared: ' ', 
					A: ' ',
					B: ' ',
					C: ' ',
					D: ' ',
					E: ' ',
					F: ' ',
					G: ' ',
					H: ' ',
					I: ' ',
					J: ' ',
					K: ' ',
					L: ' ',
					M: ' ',
					N: ' ',
					O: ' ',
					P: ' ',
					Q: ' ',
					R: ' ',
					S: ' ',
					T: ' ',
					U: ' ',
					V: ' ',
					W: ' ',
					X: ' ',
					Y: ' ',
					Z: ' ',
					m: ' '
				}
			  const stringArrm = value.split(' ');
			  const result_value = stringArrm.map(word=> replacers_child[word]?replacers_child[word]:word). join(' ').trim();  
		  
		  
		  
		  
		var a = $(this).parent().parent(); /* nombre del formulario */
		  
		//Oculto el input Range (que aparece cuando seleccionas parcial). Porque si seleccionas la completa,
		//No tiene sentido que aparezca este input
		$("form[name='"+a[0].name+"'] * input[type='range'][class*='"+value+"']").hide();
		  
		var valor_anterior = $("form[name='"+a[0].name+"'] * input[type='checkbox'][value*='"+value+"']").val().split('/');  
	
		  
		$("form[name='"+a[0].name+"'] * input[value*='"+value+"']").val(valor_anterior[0]);   
		  

		var valor_input=$("form[name='"+a[0].name+"'] * input[value='"+valor_anterior[0]+"']").val();  
		  
		$("form[name='"+a[0].name+"'] * input[value='"+value+"']").attr("checked",true);
		$("form[name='"+a[0].name+"'] * input[type='checkbox'][value='"+value+"']").val(valor_input+"/"+result_value);
		  
		
	})
	  
	$("#menu_materiales_movil").click(function () {
		
		$("#menu_plano_movil").removeClass("menu-activo");
		$("#menu_instalaciones_movil").removeClass("menu-activo");
		$("#menu_mobiliario_movil").removeClass("menu-activo");
		$("#menu_materiales_movil").addClass("menu-activo");
		
		$("#opciones_crear_plano").hide();
		$("#opciones_instalaciones").hide();
		$("#opciones_sc").hide();
		$("#opciones_mobiliario").hide();
		$("#opciones_materiales").show();
	})  
	  
	$("#menu_instalaciones_movil").click(function() {
		
		$("#menu_plano_movil").removeClass("menu-activo");
		$("#menu_mobiliario_movil").removeClass("menu-activo");
		$("#menu_materiales_movil").removeClass("menu-activo");
		$("#menu_instalaciones_movil").addClass("menu-activo");
		
		$("#opciones_crear_plano").hide();
		$("#opciones_mobiliario").hide();
		$("#opciones_materiales").hide();
		$("#opciones_instalaciones").show();
		
		alertify.success("En el presupuesto no está incluido el mobiliario ni electrodomésticos. Sólo instalación y mano de obra");
		
	})
	  
	$("#menu_mobiliario_movil").click(function() {
	 
		$("#menu_plano_movil").removeClass("menu-activo");
		$("#menu_instalaciones_movil").removeClass("menu-activo");
		$("#menu_materiales_movil").removeClass("menu-activo");
		$("#menu_mobiliario_movil").addClass("menu-activo");
		
		
		$("#opciones_crear_plano").hide();
		$("#opciones_instalaciones").hide();
		$("#opciones_sc").hide();
		$("#opciones_materiales").hide();
		$("#opciones_mobiliario").show();
		
		alertify.success("En el presupuesto no está incluido el mobiliario ni electrodomésticos. Sólo instalación y mano de obra");
		
		fonc_button('select_mode');
		$('#boxinfo').html('Modo selección');
		$('#wallTools').hide('300');
		$('#panel').show('300');
	
	
	
	
	})
	  
	$("#menu_plano_movil").click(function() {
		$("#menu_mobiliario_movil").removeClass("menu-activo");
		$("#menu_instalaciones_movil").removeClass("menu-activo");
		$("menu_materiales_movil").removeClass("menu-activo");
		$("#menu_plano_movil").addClass("menu-activo");
		
		$("#opciones_mobiliario").hide();
		$("#opciones_instalaciones").hide();
		$("#opciones_sc").hide();
		$("#opciones_materiales").hide();
		$("#opciones_crear_plano").show();
	})
	  
	  
    $("#menu_plano").click(function() {
		$("#menu_mobiliario").removeClass("menu-activo");
		$("#menu_instalaciones").removeClass("menu-activo");
		$("menu_materiales").removeClass("menu-activo");
		$("#menu_plano").addClass("menu-activo");
		
		$("#opciones_mobiliario").hide();
		$("#opciones_instalaciones").hide();
		$("#opciones_sc").hide();
		$("#opciones_observacion").hide();
		$("#opciones_materiales").hide();
		$("#opciones_crear_plano").show();
	})

	$("#menu_sc").click(function() {
		$("#menu_mobiliario").removeClass("menu-activo");
		$("#menu_instalaciones").removeClass("menu-activo");
		$("#menu_plano").removeClass("menu-activo");
		$("#menu_materiales").removeClass("menu-activo");
		$("#menu_sc").addClass("menu-activo");
		
		$("#opciones_mobiliario").hide();
		$("#opciones_instalaciones").hide();
		$("#opciones_observacion").hide();
		$("#opciones_crear_plano").hide();
		$("#opciones_materiales").hide();
		$("#opciones_sc").show();
	})  
	  
	  
	$("#menu_materiales").click(function () {
		
		$("#menu_plano").removeClass("menu-activo");
		$("#menu_instalaciones").removeClass("menu-activo");
		$("#menu_mobiliario").removeClass("menu-activo");
		$("#menu_materiales").addClass("menu-activo");
		
		$("#opciones_crear_plano").hide();
		$("#opciones_instalaciones").hide();
		$("#opciones_sc").hide();
		$("#opciones_observacion").hide();
		$("#opciones_mobiliario").hide();
		$("#opciones_materiales").show();
	})  
	  
	$("#menu_mobiliario").click(function() {
	 
		$("#menu_plano").removeClass("menu-activo");
		$("#menu_instalaciones").removeClass("menu-activo");
		$("#menu_materiales").removeClass("menu-activo");
		$("#menu_mobiliario").addClass("menu-activo");
		
		
		
		$("#opciones_crear_plano").hide();
		$("#opciones_instalaciones").hide();
		$("#opciones_sc").hide();
		$("#opciones_materiales").hide();
		$("#opciones_observacion").hide();
		$("#opciones_mobiliario").show();
		$("#armarios_bajos > ul").show();
		$("#armarios_altos > ul").show();
		
		alertify.success("En el presupuesto no está incluido el mobiliario ni electrodomésticos. Sólo instalación y mano de obra");
		
		fonc_button('select_mode');
		$('#boxinfo').html('Modo selección');
		$('#wallTools').hide('300');
		$('#panel').show('300');
	
	
	
	
	})
 
	  
	$("#menu_trabajos").click(function() {
		
		$("#menu_plano").removeClass("menu-activo");
		$("#menu_mobiliario").removeClass("menu-activo");
		$("#menu_materiales").removeClass("menu-activo");
		$("#menu_instalaciones").removeClass("menu-activo");
		$("#menu_trabajos").addClass("menu-activo");
		
		
		$("#opciones_crear_plano").hide();
		$("#opciones_mobiliario").hide();
		$("#opciones_materiales").hide();
		$("#opciones_observacion").hide();
		$("#opciones_instalaciones").hide();
		$("#opciones_trabajos").show();
	
	})  
	  
	$("#menu_instalaciones").click(function() {
		
		$("#menu_plano").removeClass("menu-activo");
		$("#menu_mobiliario").removeClass("menu-activo");
		$("#menu_materiales").removeClass("menu-activo");
		$("#menu_instalaciones").addClass("menu-activo");
		
		$("#opciones_crear_plano").hide();
		$("#opciones_mobiliario").hide();
		$("#opciones_materiales").hide();
		$("#opciones_observacion").hide();
		$("#opciones_instalaciones").show();
		
		alertify.success("En el presupuesto no está incluido el mobiliario ni electrodomésticos. Sólo instalación y mano de obra");
		
	})
  </script>
<!-- alertify -->
<script>
!function(t,k){"use strict";var e,E=t.document;e=function(){var m,s,a,o,r,n={},l={},c=!1,v=27,g=32,f=[];return l=E.location.href.includes("mis_datos.php")?{buttons:{holder:'<nav class="alertify-buttons">{{buttons}}</nav>',submit:'<button type="submit" class="alertify-button alertify-button-ok" id="alertify-ok" />{{ok}}</button>',ok:'<a href="#" class="alertify-button alertify-button-ok" id="alertify-ok">{{ok}}</a>',cancel:'<a href="#" class="alertify-button alertify-button-cancel" id="alertify-cancel">{{cancel}}</a>'},input:'<input type="password" class="alertify-text" id="alertify-text">',message:'<p class="alertify-message">{{message}}</p>',log:'<article class="alertify-log{{class}}">{{message}}</article>'}:{buttons:{holder:'<nav class="alertify-buttons">{{buttons}}</nav>',submit:'<button type="submit" class="alertify-button alertify-button-ok" id="alertify-ok" />{{ok}}</button>',ok:'<a href="#" class="alertify-button alertify-button-ok" id="alertify-ok">{{ok}}</a>',cancel:'<a href="#" class="alertify-button alertify-button-cancel" id="alertify-cancel">{{cancel}}</a>'},input:'<input type="text" class="alertify-text" id="alertify-text">',message:'<p class="alertify-message">{{message}}</p>',log:'<article class="alertify-log{{class}}">{{message}}</article>'},m=function(t){return E.getElementById(t)},{alert:function(t,e){return n.dialog(t,"alert",e),this},confirm:function(t,e){return n.dialog(t,"confirm",e),this},extend:(n={labels:{ok:"Aceptar",cancel:"Cancelar"},delay:8e3,addListeners:function(e){var i,n,a,s,o,r=m("alertify-resetFocus"),l=m("alertify-ok")||k,c=m("alertify-cancel")||k,f=m("alertify-text")||k,u=m("alertify-form")||k,d=void 0!==l,y=void 0!==c,b=void 0!==f,p="",h=this;i=function(t){void 0!==t.preventDefault&&t.preventDefault(),a(t),void 0!==f&&(p=f.value),"function"==typeof e&&e(!0,p)},n=function(t){void 0!==t.preventDefault&&t.preventDefault(),a(t),"function"==typeof e&&e(!1)},a=function(t){h.hide(),h.unbind(E.body,"keyup",s),h.unbind(r,"focus",o),b&&h.unbind(u,"submit",i),d&&h.unbind(l,"click",i),y&&h.unbind(c,"click",n)},s=function(t){var e=t.keyCode;e!==g||b||i(t),e===v&&y&&n(t)},o=function(t){b?f.focus():y?c.focus():l.focus()},this.bind(r,"focus",o),d&&this.bind(l,"click",i),y&&this.bind(c,"click",n),this.bind(E.body,"keyup",s),b&&this.bind(u,"submit",i),t.setTimeout(function(){f?(f.focus(),f.select()):l.focus()},50)},bind:function(t,e,i){"function"==typeof t.addEventListener?t.addEventListener(e,i,!1):t.attachEvent&&t.attachEvent("on"+e,i)},build:function(t){var e="",i=t.type,n=t.message;switch(e+='<div class="alertify-dialog">',"prompt"===i&&(e+='<form id="alertify-form">'),e+='<article class="alertify-inner">',e+=l.message.replace("{{message}}",n),"prompt"===i&&(e+=l.input),e+=l.buttons.holder,e+="</article>","prompt"===i&&(e+="</form>"),e+='<a id="alertify-resetFocus" class="alertify-resetFocus" href="#">Reset Focus</a>',e+="</div>",i){case"confirm":e=(e=e.replace("{{buttons}}",l.buttons.ok+l.buttons.cancel)).replace("{{ok}}",this.labels.ok).replace("{{cancel}}",this.labels.cancel);break;case"prompt":e=(e=e.replace("{{buttons}}",l.buttons.submit+l.buttons.cancel)).replace("{{ok}}",this.labels.ok).replace("{{cancel}}",this.labels.cancel);break;case"alert":e=(e=e.replace("{{buttons}}",l.buttons.ok)).replace("{{ok}}",this.labels.ok)}return o.className="alertify alertify-show alertify-"+i,a.className="alertify-cover",e},close:function(t,e){var i=e&&!isNaN(e)?+e:this.delay;this.bind(t,"click",function(){r.removeChild(t)}),setTimeout(function(){void 0!==t&&t.parentNode===r&&r.removeChild(t)},i)},dialog:function(t,e,i,n){s=E.activeElement;var a=function(){o&&null!==o.scrollTop||a()};if("string"!=typeof t)throw new Error("message must be a string");if("string"!=typeof e)throw new Error("type must be a string");if(void 0!==i&&"function"!=typeof i)throw new Error("fn must be a function");return"function"==typeof this.init&&(this.init(),a()),f.push({type:e,message:t,callback:i,placeholder:n}),c||this.setup(),this},extend:function(i){return function(t,e){this.log(t,i,e)}},hide:function(){f.splice(0,1),0<f.length?this.setup():(c=!1,o.className="alertify alertify-hide alertify-hidden",a.className="alertify-cover alertify-hidden",s.focus())},init:function(){E.createElement("nav"),E.createElement("article"),E.createElement("section"),(a=E.createElement("div")).setAttribute("id","alertify-cover"),a.className="alertify-cover alertify-hidden",E.body.appendChild(a),(o=E.createElement("section")).setAttribute("id","alertify"),o.className="alertify alertify-hidden",E.body.appendChild(o),(r=E.createElement("section")).setAttribute("id","alertify-logs"),r.className="alertify-logs",E.body.appendChild(r),E.body.setAttribute("tabindex","0"),delete this.init},log:function(t,e,i){var n=function(){r&&null!==r.scrollTop||n()};return"function"==typeof this.init&&(this.init(),n()),this.notify(t,e,i),this},notify:function(t,e,i){var n=E.createElement("article");n.className="alertify-log"+("string"==typeof e&&""!==e?" alertify-log-"+e:""),n.innerHTML=t,r.insertBefore(n,r.firstChild),setTimeout(function(){n.className=n.className+" alertify-log-show"},50),this.close(n,i)},set:function(t){var e;if("object"!=typeof t&&t instanceof Array)throw new Error("args must be an object");for(e in t)t.hasOwnProperty(e)&&(this[e]=t[e])},setup:function(){var t=f[0];c=!0,o.innerHTML=this.build(t),"string"==typeof t.placeholder&&(m("alertify-text").value=t.placeholder),this.addListeners(t.callback)},unbind:function(t,e,i){"function"==typeof t.removeEventListener?t.removeEventListener(e,i,!1):t.detachEvent&&t.detachEvent("on"+e,i)}}).extend,init:n.init,log:function(t,e,i){return n.log(t,e,i),this},prompt:function(t,e,i){return n.dialog(t,"prompt",e,i),this},success:function(t,e){return n.log(t,"success",e),this},error:function(t,e){return n.log(t,"error",e),this},set:function(t){n.set(t)},labels:n.labels}},"function"==typeof define?define([],function(){return new e}):void 0===t.alertify&&(t.alertify=new e)}(this);
</script>
<?php
if (!isset($_SESSION["login"]))
{
?>	
  <script>
	   $("#menu_instalaciones_movil").click(function() {
		 //Cojo todos los muros creados y los añado a todos los elementos 
		 //de instalaciones y equipamiento en el que podrán seleccionar los muros a los que van ese elemento
		 var paredes="";
		 var i=0;
		 $(".info_muro").each(function() {
			 //$(this).text();
			 //paredes=paredes+" <span class='checkmuro'><input type='checkbox' name='paredes[]' class='paredes' value='"+$(this).text()+"'> "+$(this).text()+"</span>";
			 
			 //Si no existe se muro, creámelo, y si no, no hagas nada
			 //Esto es así xq si no me reinicia todos los input y lo que hayas marcado se elimina
			 if (!$("input[value='"+$(this).text()+"']").length)
			 {
			   $(".form_muros").append("<span class='checkmuro'><input type='checkbox' name='paredes[]' class='paredes' value='"+$(this).text()+"'> "+$(this).text()+"</span>");
				
			 }
			 
			 
		 })
		 
		 
		   
		  
		   
		 //$(".form_muros > .checkmuro").remove(); 
	 }) 
	  
	  
	   $("#menu_trabajos").click(function() {
		 //Cojo todos los muros creados y los añado a todos los elementos 
		 //de instalaciones y equipamiento en el que podrán seleccionar los muros a los que van ese elemento
		 var paredes="";
		 var i=0;
		 $(".info_muro").each(function() {
			 
			 
			 const replacers =   {
					Pared: ' ', 
					A: ' ',
					B: ' ',
					C: ' ',
					D: ' ',
					E: ' ',
					F: ' ',
					G: ' ',
					H: ' ',
					I: ' ',
					J: ' ',
					K: ' ',
					L: ' ',
					M: ' ',
					N: ' ',
					O: ' ',
					P: ' ',
					Q: ' ',
					R: ' ',
					S: ' ',
					T: ' ',
					U: ' ',
					V: ' ',
					W: ' ',
					X: ' ',
					Y: ' ',
					Z: ' ',
					m: ' '
				}
			  const stringArr = $(this).text().split(' ');
			  const result_metros = stringArr.map(word=> replacers[word]?replacers[word]:word). join(' ')
			  
			 //Si no existe se muro, creámelo, y si no, no hagas nada
			 //Esto es así xq si no me reinicia todos los input y lo que hayas marcado se elimina
			 if (!$("input[value='"+$(this).text()+"']").length)
			 {
			   
			   $(".form_muros").append("<span class='checkmuro'><input type='checkbox' name='paredes[]' class='paredes' value='"+$(this).text()+"'> "+$(this).text()+"<br/><input class='child' name='seleccion_metros' type='radio' value='"+$(this).text()+"'> Completa <br/> <input name='seleccion_metros' class='"+$(this).text()+"' type='radio' value='parcial'> Parcial <input type='range' value='0.1' min='0.1' name='metros_parcial' class='"+$(this).text()+"' max='"+result_metros.trim()+"' step='0.01' oninput='this.nextElementSibling.value = this.value'> <output style='display:inline-block'>0.1</output> metros</span>");
				
			 }
			 
			 
		 })
		 
		 
		   
		  
		   
		 //$(".form_muros > .checkmuro").remove(); 
	 }) 
	  
	  
	   $("#menu_materiales").click(function() {
		 //Cojo todos los muros creados y los añado a todos los elementos 
		 //de instalaciones y equipamiento en el que podrán seleccionar los muros a los que van ese elemento
		 var paredes="";
		 var i=0;
		 $(".info_muro").each(function() {
			 //$(this).text();
			 //paredes=paredes+" <span class='checkmuro'><input type='checkbox' name='paredes[]' class='paredes' value='"+$(this).text()+"'> "+$(this).text()+"</span>";
			 
			 //Si no existe se muro, creámelo, y si no, no hagas nada
			 //Esto es así xq si no me reinicia todos los input y lo que hayas marcado se elimina
			 if (!$("input[value='"+$(this).text()+"']").length)
			 {
			   $(".form_muros").append("<span class='checkmuro'><input type='checkbox' name='paredes[]' class='paredes' value='"+$(this).text()+"'> "+$(this).text()+"</span>");
				
			 }
			 
			 
		 })
		 
		 
		   
		  
		   
		 //$(".form_muros > .checkmuro").remove(); 
	 }) 	  
	   
	  
	  
  </script>
<?php
}
?>
<script>
	
  	$( document ).on( "click", ".paredes", function() {
	
	 /*
	  var i=0;
	  if (this.checked)
	  {
		  do {
			var metros = prompt("Introduce los metros ("+this.value+") en los que quieres aplicar este elemento (por ejemplo: 3.4). Si no quiere seleccionar esta pared, pulse en el botón 'Cancelar'");
			var pared_seleccionada=this.value;
			  
			if (metros != null && metros !== null) {
			  metros=parseFloat(metros);
			  const replacers =   {
					Pared: ' ', 
					A: ' ',
					B: ' ',
					C: ' ',
					D: ' ',
					E: ' ',
					F: ' ',
					G: ' ',
					H: ' ',
					I: ' ',
					J: ' ',
					K: ' ',
					L: ' ',
					M: ' ',
					N: ' ',
					O: ' ',
					P: ' ',
					Q: ' ',
					R: ' ',
					S: ' ',
					T: ' ',
					U: ' ',
					V: ' ',
					W: ' ',
					X: ' ',
					Y: ' ',
					Z: ' ',
					m: ' '
				}
			  const stringArr = pared_seleccionada.split(' ');
			  const result_metros = stringArr.map(word=> replacers[word]?replacers[word]:word). join(' ') 
			  
			  
			  if (Number.isNaN(metros))
			  {
				alert("Debes especificar los metros cuadrados de "+this.value+" en número. Ejemplo: 3.2")
			  }
			  else if (metros > parseFloat(result_metros))
			  {
				alert("Error - Has elegido "+metros+" metros de la "+this.value+". Esta pared mide "+result_metros.trim()+" metros");
			  } 
			  else
			  {
				
				//$(".form_muros").append("<input value="+metros+" name='m2[]' placeholder='Introduce los m2' type='text' class='form-control m2'>");
				this.value=this.value+"/"+metros;
				$(this).parent().append("<div class='metros_seleccionados'>(seleccionado "+metros+" m)</div>");
				i=1;
			  }
			 }
			else
			{
			   i=1; //Si cancela, entiendo que este elemento lo aplica a toda la pared
			   this.checked=false;
			}
		  } while (i == 0); 
	}
	else
	{
		//Lo está deseleccionando
		$("input[value='"+this.value+"'] + div.metros_seleccionados").remove();
		var valor_anterior = this.value.split('/');
		this.value=valor_anterior[0];

	}
		
	*/	
	}) 
	
  $( document ).ready(function() {
	  
	 //Ajusto zoom
	 for (var i=0;i<4;i++)
	 {
	   $("button[data-zoom='zoomin']").trigger("click"); 
	 }
	  
	  $("#observaciones").click(function () {
		
		 $("#opciones_crear_plano").hide();
		 $("#opciones_instalaciones").hide(); 
		 $("#opciones_mobiliario").hide();
		 $("#opciones_observacion").show(); 
	 }) 
	  
	 if ($(window).width() < 1099)
	 {
	 
		  $('.owl-carousel').owlCarousel({
			loop:false,
			margin:50,
			responsiveClass:true,
			responsive:{
				0:{
					items:3
				},
				600:{
					items:4
				},
				1000:{
					items:4
				},
				1099: {
					items:4
				}
			}
		})
	 }
	  
	  
	$(".elemento_instalacion").click(function() {
		
		 var id=this.id;
		 var selected=0;
		 
		 if ($("#"+id).hasClass("selected"))
		 {
		  $("#"+id).removeClass("selected");
		  selected=0;
		  $("#select_mode").trigger("click"); // simulo que le da click a la herramienta de selección, porque si no, al deseleccionar un elemento
			 								  //Me lo pone para añadir una unidad al plano
		 }
		 else
		 {
		  $("#"+id).addClass("selected"); 
		  selected=1;
		 }
		
		 //listado muros
		 if ($("#"+this.id+" + .listado_muros").length)
		 {
			if (selected == 1)
			 $("#"+this.id+" + .listado_muros").show();
			else
			 $("#"+this.id+" + .listado_muros").hide();
			 
			  
			 $("#"+this.id+" + .listado_muros > input[type='checkbox']").each(function() {
				 //alert("checkbox!");
				 if (selected == 1)
					$(this).addClass(id); //La vuelvo a generar
				 else 
				    $(this).removeClass(id); //Primero elimino por si ya tenía esa clase
				 
				 
			 })
			 
			
			 
		 }
		 else if ($("#"+this.id+" + .unidades_elemento").length)
		 {
			if (selected == 1)
			 $("#"+this.id+" + .unidades_elemento").show();
			else
			 $("#"+this.id+" + .unidades_elemento").hide();
			 
		 }
		 else if ($("#"+this.id+" + .metros_lineales").length)
		 {
			if (selected == 1)
			 $("#"+this.id+" + .metros_lineales").show();
			else
			 $("#"+this.id+" + .metros_lineales").hide();
			 
		 }
		 else 
		 {
		  
		  if (selected == 1)
			$("#"+this.id).parent().append( '<img class="marcado" src="iconos/Tick_Mark-256.png" style="width: 32px;display: block;margin: 0px auto;">' ); 
		  else
		  {
			 $("#"+this.id+" + .marcado").remove();
			 $("#"+this.id+" + form + .marcado").remove();
		  }
		 }
		
		
		
	 })
	  
	  
	 $("#btnFinalizar").click(function() {
		 
		 $("#btnFinalizar").attr("style","pointer-events: none;");
		 $("#btnFinalizar > span").html("Guardando...")
		 
		 var id="";
		 var entro=false;
		 var formularios=[];
		 var contador=0;
		 var altura_paredes=document.getElementById("altura_paredes").value;
		 
		 if (altura_paredes != "")
		 {
		   $(".elemento_instalacion.selected").each(function() {
			 entro=true;
			 
			 //Por cada elemento seleccionado, detecto si es muro o unidades y lo añado a la cookie
			 var formulario=$("form[name='"+this.id+"']").serialize();
			 var id=this.id;
			 console.log(formulario);
			 
			 //Me guardo también el total de los muros, aunque no estén seleccionados
			 var total_muros="";
			 $( ".info_muro" ).each(function() {
				  //console.log($(this)[0].outerText);
				  total_muros=$(this)[0].outerText+","+total_muros;
			  });
			 
			 
			 
			 $.ajax({
				 type: "POST",
				 dataType: 'json', 
				 async:false,
				 url: "ajax/finalizar_plano.php?altura_paredes="+altura_paredes+"&total_muros="+total_muros,
				 data: formulario,
				 success:function(respuesta){	
					 alertify.success(respuesta.mensaje);
				 }

			 });
			 contador++;
			 
		 })
		 
		 if (!entro)
		  alertify.error("Debes seleccionar, al menos, un elemento de instalaciones y equipamiento para finalizar el plano")
		 else
		 {
		  console.log("FORMULARIOS!!");
			 //Guardo para que el mapa se guarde en localstorage history para luego guardarlo en la BD
			//Y que el admin lo recupere
			console.log("LOCAL STORAGE ANTES DE SAVE");
			 console.log(localStorage.getItem("history"));

			save();
			 console.log("LOCAL STORAGE DESPUES DE SAVE");
			 console.log(localStorage.getItem("history"));

			 console.log("LOCALS STORAGE stringfy");
			 var numero_muros=$(".muro").length;
			 //console.log(HISTORY[4]);
			//var contenido=localStorage.getItem("history");
			// var contenido=localStorage.getItem("history");
			 var contenido=HISTORY[numero_muros]; //El último muro es el que tiene la info de todo el dibujo
			 var elementos_dibujados=$("#boxEnergy").html();
			 var puertas_ventanas=$("#boxcarpentry").html();
			 console.log("ELEMENTOS DIBUJADOS");
			 console.log(elementos_dibujados);
			 $.ajax({
					 type: "POST",
					 dataType: 'json', 
					 async:false,
					 url: "ajax/guardar_dibujo2d.php",
					 data: {contenido:contenido,elementos_dibujados:elementos_dibujados,puertas_ventanas:puertas_ventanas},
					 success:function(respuesta){	
						 	window.location.assign("https://rehubik.com/presupuestador/2d/registro_cliente.php"); 
					 }

			 });



			
		 }
		
		setTimeout(function(){ $("#btnFinalizar").attr("style","pointer-events: unset;"); $("#btnFinalizar > span").html("Finalizar")  }, 2000);
		
	  }
	  else
	  {
		alertify.error("Debes especificar la altura de las paredes en el PASO 2");
		setTimeout(function(){ $("#btnFinalizar").attr("style","pointer-events: unset;"); $("#btnFinalizar > span").html("Finalizar")  }, 2000);  
	  }
	 }) 

	 $("#btnFinalizarVerificador").click(function() {
		 var id="";
		 var entro=false;
		 var formularios=[];
		 var contador=0;
		 var altura_paredes=document.getElementById("altura_paredes").value;
		 
		 if (altura_paredes != "")
		 {
		   $(".elemento_instalacion.selected").each(function() {
			 entro=true;
			 
			 //Por cada elemento seleccionado, detecto si es muro o unidades y lo añado a la cookie
			 var formulario=$("form[name='"+this.id+"']").serialize();
			 var id=this.id;
			 console.log(formulario);
			 //alert(formulario);
			 $.ajax({
				 type: "POST",
				 dataType: 'json', 
				 async:false,
				 url: "ajax/finalizar_plano_verificador.php?altura_paredes="+altura_paredes+"&id_presupuesto=<?php echo $_GET['id_presupuesto'];?>",
				 data: formulario,
				 success:function(respuesta){	
					 alertify.success(respuesta.mensaje);
					 
				 }

			 });
			 contador++;
			 
		 })
		 
		 if (!entro)
		  alertify.error("Debes seleccionar, al menos, un elemento de instalaciones y equipamiento para finalizar el plano")
		 else
		 {
			save();
			var numero_muros=$(".muro").length;
			var contenido=HISTORY[0]; //El último muro es el que tiene la info de todo el dibujo
			console.log("OJO, el CONTENIDO ES "+contenido);
			var elementos_dibujados=$("#boxEnergy").html();
			var puertas_ventanas=$("#boxcarpentry").html();
			 
			 $.ajax({
					 type: "POST",
					 dataType: 'json', 
					 async:false,
					 url: "ajax/guardar_dibujo2d_verificador.php?id_presupuesto=<?php echo $_GET['id_presupuesto'];?>",
					 data: {contenido:contenido,elementos_dibujados:elementos_dibujados,puertas_ventanas:puertas_ventanas},
					 success:function(respuesta){	

					 }

			 });



			//window.location.assign("https://rehubik.com/presupuestador/2d/registro_cliente.php"); 
		 }
	
	   }
	   else
	   {
		 alertify.error("Debes especificar la altura de las paredes en el PASO 1"); 
	   }
		
	 }) 	  
	  
	  
	  
	
	
	
	 $("#vitro_horno").click(function() {
		
		if (parseInt($("path[stroke-dasharray*='vitro_horno']").parent().length) >= 1)
		{
		    $("path[stroke-dasharray*='vitro_horno']").parent().remove();
		}
		
	 }) 
	
	 $("#gas_horno").click(function() {
		
		if (parseInt($("path[stroke-dasharray*='gas_horno']").parent().length) >= 1)
		{
		    $("path[stroke-dasharray*='gas_horno']").parent().remove();
		}
		
	 }) 
	
	$("#frigo_americano").click(function() {
		
		if (parseInt($("path[stroke-dasharray*='frigo_americano']").parent().length) >= 1)
		{
		    $("path[stroke-dasharray*='frigo_americano']").parent().remove();
		}
		
	}) 
	
	$("#escobero").click(function() {
		
		if (parseInt($("path[stroke-dasharray*='escobero']").parent().length) >= 1)
		{
		    $("path[stroke-dasharray*='escobero']").parent().remove();
		}
		
	}) 
	
	$("#caldera_gas").click(function() {
		
		if (parseInt($("path[stroke-dasharray*='caldera_gas']").parent().length) >= 1)
		{
		    $("path[stroke-dasharray*='caldera_gas']").parent().remove();
		}
		
	}) 
	
	$("#calentador_gas").click(function() {
		
		if (parseInt($("path[stroke-dasharray*='calentador_gas']").parent().length) >= 1)
		{
		    $("path[stroke-dasharray*='calentador_gas']").parent().remove();
		}
		
	}) 
	  
	  
	$("#termo_electrico").click(function() {
		
		if (parseInt($("path[stroke-dasharray*='termo_electrico']").parent().length) >= 1)
		{
		    $("path[stroke-dasharray*='termo_electrico']").parent().remove();
		}
		
	})   
	  
	$("#lavadero").click(function() {
		
		if (parseInt($("path[stroke-dasharray*='lavadero']").parent().length) >= 1)
		{
		    $("path[stroke-dasharray*='lavadero']").parent().remove();
		}
		
	}) 
	  
	$("#fregadero").click(function() {
		
		if (parseInt($("path[stroke-dasharray*='campana']").parent().length) >= 1)
		{
		    $("path[stroke-dasharray*='campana']").parent().remove();
		}
		
	}) 
	  
	$("#campana").click(function() {
		
		if (parseInt($("path[stroke-dasharray*='campana']").parent().length) >= 1)
		{
		    $("path[stroke-dasharray*='campana']").parent().remove();
		}
		
	}) 
	
	$("#secadora").click(function() {
		
		if (parseInt($("path[stroke-dasharray*='secadora']").parent().length) >= 1)
		{
		    $("path[stroke-dasharray*='secadora']").parent().remove();
		}
		
	}) 
	
	$("#lavadora").click(function() {
		
		if (parseInt($("path[stroke-dasharray*='lavadora']").parent().length) >= 1)
		{
		    $("path[stroke-dasharray*='lavadora']").parent().remove();
		}
		
	}) 
	
	$("#lavavajillas").click(function() {
		
		if (parseInt($("path[stroke-dasharray*='lavavajillas']").parent().length) >= 1)
		{
		    $("path[stroke-dasharray*='lavavajillas']").parent().remove();
		}
		
	}) 
	
	$("#frigo").click(function() {
		
		if (parseInt($("path[stroke-dasharray*='frigo']").parent().length) >= 1)
		{
		    $("path[stroke-dasharray*='frigo']").parent().remove();
		}
		
	})  
	 
	$("#micro").click(function() {
		
		if (parseInt($("path[stroke-dasharray*='micro']").parent().length) >= 1)
		{
		    $("path[stroke-dasharray*='micro']").parent().remove();
		}
		
	}) 
	  
	$("#placa_gas").click(function() {
		
		if (parseInt($("path[stroke-dasharray*='placa_gas']").parent().length) >= 1)
		{
		    $("path[stroke-dasharray*='placa_gas']").parent().remove();
		}
		
	}) 
	  
	$("#vitro_induccion").click(function() {
		
		if (parseInt($("path[stroke-dasharray*='vitro_induccion']").parent().length) >= 1)
		{
		    $("path[stroke-dasharray*='vitro_induccion']").parent().remove();
		}
		
	})  
	  
	$("#horno").click(function(){
		
		if (parseInt($("path[stroke-dasharray*='horno']").parent().length) >= 1)
		{
		    $("path[stroke-dasharray*='horno']").parent().remove();
		}
		
	})
	  
	  //Cuando cambie de valor en las unidades
	$("select[name='unidades']").change(function() { 
		var clase=this.className; //Obtengo la clase del select de las unidades
		clase=clase.replace('form-control', '');  //Quito el form-control para quedarme solo con la clase que hace referencia al elemento (ejemplo: puntos_electricos_extras)
		clase=$.trim(clase); //Le hago un trim para quitarle espacios en blanco
		
		if (parseInt($("path[stroke-dasharray*='"+clase+"']").parent().length) > this.value)
		{
		    $("path[stroke-dasharray*='"+clase+"']").parent().remove();
		}
		//Los elementos solo se colocan cuando haces click al elemento. Si cambias de unidades, el elemento ya está seleccionado
		//por lo que no te lleva al mapa los elementos. Por ello simulo que hace click (para desclickear) y click (para volver a clickear el elemento)
		$("#"+clase).trigger("click");
		$("#"+clase).trigger("click");
		
		//esto lo hago porque si seleccionas en el desplegable 5 y añades 5 elementos y luego cambias a 8, te añade otros 8
		
	})
	  
	/*$("select[name='unidades']").change(function() {
		
			$("path[stroke-dasharray='puntos_electricos_extras']").parent().remove();						
	})*/
	
	  
	  
	  
	  
	  
	  
  })
	
function muestraContenido(id)
{

	$(".tipo_mobiliario").removeClass("menu-mobiliario-activo");
	$(this).addClass("menu-mobiliario-activo");
	
	$(".objetos").attr("style","display:none");
	
	$("#"+id).attr("style","display:block");
}
function muestraInstalaciones(id)
{
	
	$(".listado_instalaciones").hide();
	$("#"+id).show();
    $(".submenu_instalaciones").attr("style","font-weight:500;color:gray;");
	$(".menu-"+id).attr("style","font-weight:700;color:black;");

}
	
	
$("#guardar2d").click(function() {
	
	var contenido="<html>";
	 contenido+=$("html").html();
	 contenido+="</html>";
	
	var contador=0;
	$("#boxEnergy > g").each(function(){
        	    contador++;
    
	}); 
	
	var plano=document.getElementById("boxRoom").getBoundingClientRect();
	console.log(plano.top, plano.right, plano.bottom, plano.left);

	var objetos_plano=document.getElementById("boxEnergy").getBoundingClientRect();
	console.log(objetos_plano.top, objetos_plano.right, objetos_plano.bottom, objetos_plano.left);

	
	if (objetos_plano.top != 0 && objetos_plano.right != 0 && objetos_plano.bottom != 0 && objetos_plano.left != 0 && contador > 0)
	{
		if (objetos_plano.top <= plano.bottom && objetos_plano.right <= plano.right && objetos_plano.bottom >= plano.top && objetos_plano.left >= plano.left && objetos_plano.bottom <= plano.bottom && objetos_plano.top >= plano.top)
		{
		 	if (typeof contador_muro !== 'undefined') {
	
			  if (confirm("¿Quieres guardar tu plano?"))
			  {
				 var contenido="<html>";
				 contenido+=$("html").html();
				 contenido+="</html>";

				 //localStorage.setItem('dibujo2d', contenido);
				 //Guardo el dibujo2d en la BD para luego ya recuperarlo. 
				  
				  
				 alertify.success("Plano guardado correctamente. Ahora debes crear las paredes");
			  }
			}
			else
			{
					alertify.error("No puedes guardar un plano vacio");
			}	
		}
		else
		{
			alertify.error("¡ATENCIÓN! Todos los elementos deben estar dentro de los límites del plano. Rectifica tu plano.");

		}	
	}
	

	
	
	
	
	
	//localStorage.setItem('dibujo2d', contenido);
	
	//alert("Plano guardado correctamente. Ahora debes crear las paredes");
	
	
	
	
	
	
	
	
})
</script>

<?php
if (isset($_GET["id_presupuesto"]))
{
?>
  <script>
	//Recupero el mapa de un usuario
	  if (localStorage.getItem('history')) localStorage.removeItem('history');
	  
	  var id_presupuesto=<?php echo $_GET["id_presupuesto"];?>;
	  $.ajax({
				 type: "POST",
				 dataType: 'json', 
				 async:false,
				 url: "ajax/sacar_dibujo2d.php",
				 data: {id_presupuesto:id_presupuesto},
				 success:function(mensaje){	
					 HISTORY.push(mensaje);
					 console.log("RESPUESTA MENSAJE:");
					 console.log(mensaje);
					 HISTORY[0] = JSON.stringify(HISTORY[0]);
					 localStorage.setItem('history', JSON.stringify(HISTORY));
					 load(0);
					 save();
				 }

		 });
	  
	  //Saco elementos dibujados
	  	$.ajax({
				 type: "POST",
				 dataType: 'json', 
				 async:false,
				 url: "ajax/sacar_boxenergy.php",
				 data: {id_presupuesto:id_presupuesto},
				 success:function(respuesta){	
					 console.log("Mensaje!");
					 console.log(respuesta.mensaje);
					 $("#boxEnergy").html(respuesta.mensaje);
				 }

		 });
	  
	  //Saco paredes y puertas
	  $.ajax({
				 type: "POST",
				 dataType: 'json', 
				 async:false,
				 url: "ajax/sacar_boxcarpentry.php",
				 data: {id_presupuesto:id_presupuesto},
				 success:function(respuesta){	
					 console.log("Mensaje!");
					 console.log(respuesta.mensaje);
					 $("#boxcarpentry").html(respuesta.mensaje);
				 }

		 });
	  
	  console.log("HISTORY PUSH ES ");
	  console.log(HISTORY);
	 
	  /*HISTORY.push({"objData":[],"wallData":[{"thick":20,"start":{"x":905,"y":85.21875},"end":{"x":1240.5,"y":85.21875},"type":"normal","parent":7,"child":1,"angle":0,"equations":{"up":{"A":"h","B":84.21875},"down":{"A":"h","B":86.21875},"base":{"A":"h","B":85.21875}},"coords":[{"x":905,"y":84.21875},{"x":905,"y":86.21875},{"x":1240.5,"y":86.21875},{"x":1240.5,"y":84.21875}],"backUp":false,"graph":{"0":{},"context":{},"length":1}},{"thick":20,"start":{"x":1240.5,"y":85.21875},"end":{"x":1240.5,"y":211.03125},"type":"normal","parent":null,"child":2,"angle":1.5707963267948966,"equations":{"up":{"A":"v","B":1241.5},"down":{"A":"v","B":1239.5},"base":{"A":"v","B":1240.5}},"coords":[{"x":1241.5,"y":85.21875},{"x":1239.5,"y":85.21875},{"x":1239.5,"y":211.03125},{"x":1241.5,"y":211.03125}],"backUp":false,"graph":{"0":{},"context":{},"length":1}},{"thick":20,"start":{"x":1240.5,"y":211.03125},"end":{"x":1129.125,"y":211.03125},"type":"normal","parent":null,"child":3,"angle":3.141592653589793,"equations":{"up":{"A":"h","B":210.03125},"down":{"A":"h","B":212.03125},"base":{"A":"h","B":211.03125}},"coords":[{"x":1240.5,"y":210.03125},{"x":1240.5,"y":212.03125},{"x":1129.125,"y":212.03125},{"x":1129.125,"y":210.03125}],"backUp":false,"graph":{"0":{},"context":{},"length":1}},{"thick":20,"start":{"x":1129.125,"y":211.03125},"end":{"x":1129.125,"y":119.59375},"type":"normal","parent":null,"child":4,"angle":-1.5707963267948966,"equations":{"up":{"A":"v","B":1130.125},"down":{"A":"v","B":1128.125},"base":{"A":"v","B":1129.125}},"coords":[{"x":1130.125,"y":211.03125},{"x":1128.125,"y":211.03125},{"x":1128.125,"y":119.59375},{"x":1130.125,"y":119.59375}],"backUp":false,"graph":{"0":{},"context":{},"length":1}},{"thick":20,"start":{"x":1129.125,"y":119.59375},"end":{"x":1022.5625,"y":119.59375},"type":"normal","parent":null,"child":5,"angle":3.141592653589793,"equations":{"up":{"A":"h","B":118.59375},"down":{"A":"h","B":120.59375},"base":{"A":"h","B":119.59375}},"coords":[{"x":1129.125,"y":118.59375},{"x":1129.125,"y":120.59375},{"x":1022.5625,"y":120.59375},{"x":1022.5625,"y":118.59375}],"backUp":false,"graph":{"0":{},"context":{},"length":1}},{"thick":20,"start":{"x":1022.5625,"y":119.59375},"end":{"x":1022.5625,"y":208.96875},"type":"normal","parent":null,"child":6,"angle":1.5707963267948966,"equations":{"up":{"A":"v","B":1023.5625},"down":{"A":"v","B":1021.5625},"base":{"A":"v","B":1022.5625}},"coords":[{"x":1023.5625,"y":119.59375},{"x":1021.5625,"y":119.59375},{"x":1021.5625,"y":208.96875},{"x":1023.5625,"y":208.96875}],"backUp":false,"graph":{"0":{},"context":{},"length":1}},{"thick":20,"start":{"x":1022.5625,"y":208.96875},"end":{"x":905,"y":208.96875},"type":"normal","parent":null,"child":7,"angle":3.141592653589793,"equations":{"up":{"A":"h","B":207.96875},"down":{"A":"h","B":209.96875},"base":{"A":"h","B":208.96875}},"coords":[{"x":1022.5625,"y":207.96875},{"x":1022.5625,"y":209.96875},{"x":905,"y":209.96875},{"x":905,"y":207.96875}],"backUp":false,"graph":{"0":{},"context":{},"length":1}},{"thick":20,"start":{"x":905,"y":208.96875},"end":{"x":905,"y":85.21875},"type":"normal","parent":null,"child":null,"angle":-1.5707963267948966,"equations":{"up":{"A":"v","B":906},"down":{"A":"v","B":904},"base":{"A":"v","B":905}},"coords":[{"x":906,"y":208.96875},{"x":904,"y":208.96875},{"x":904,"y":85.21875},{"x":906,"y":85.21875}],"backUp":false,"graph":{"0":{},"context":{},"length":1}}],"roomData":[{"coords":[{"x":905,"y":209},{"x":1023,"y":209},{"x":1023,"y":120},{"x":1129,"y":120},{"x":1129,"y":211},{"x":1241,"y":211},{"x":1241,"y":85},{"x":905,"y":85},{"x":905,"y":209}],"coordsOutside":[{"x":1033,"y":219},{"x":1033,"y":130},{"x":1119,"y":130},{"x":1119,"y":221},{"x":1251,"y":221},{"x":1251,"y":75},{"x":895,"y":75},{"x":895,"y":219},{"x":1033,"y":219}],"coordsInside":[{"x":1013,"y":199},{"x":1013,"y":110},{"x":1139,"y":110},{"x":1139,"y":201},{"x":1231,"y":201},{"x":1231,"y":95},{"x":915,"y":95},{"x":915,"y":199},{"x":1013,"y":199}],"inside":[],"way":["7","6","5","4","3","2","0","1","7"],"area":21834,"surface":"","name":"","color":"gradientWhite","showSurface":true,"action":"add"}]});*/
	 
	</script>
<?php
}
?>

</html>
