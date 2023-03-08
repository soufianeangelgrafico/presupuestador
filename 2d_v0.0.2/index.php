<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include("conexion.php");

if (!isset($_COOKIE["idplano"]) && !isset($_GET["id_presupuesto"])) {
?>
	<script>
		// alert("No hemos detectado el estado actual de tu cocina. Por favor, vuelve al paso anterior");
		// window.location.assign(" https://rehubik.com/presupuestador/2d_v0.0.2/previa.php");
		// document.write("<p>Test 0</p>") 
	</script>
<?php
}
?>
<!-- mov: no permetir recargar la pagina para no perder cambios -->
<script>
	window.onbeforeunload = function() {
		return "¿Desea recargar la página web?";
	};
</script>

<script src="jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
<script src="html2canvas.js"></script>
<script src="FileSaver.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script> -->
<?php

/* 
	Este código comprueba si existen dos variables de sesión: "login" y "id_presupuesto". 
	Si ambas existen, el código ejecuta una serie de instrucciones.

	Primero, se convierte el valor de "id_presupuesto" en un entero. Luego, 
	se realiza una consulta a la base de datos para obtener información de una fila 
	en la tabla "planos" con un id específico (349 en este caso). La consulta devuelve un objeto 
	con información de esa fila, que se almacena en la variable "$obj_estado_actual".

	A partir de ese objeto, se extraen dos valores: "imagen_dibujo_actual" y "observaciones". 
	Además, se obtiene el valor de la columna "altura_techo_actual" del mismo objeto y 
	se almacena en la variable "$altura_pared".
*/
//!no funciona
if (isset($_SESSION["login"]) && isset($_GET["id_presupuesto"])) {

	// echo "Paso 1";
	// $_GET["id_presupuesto"] = (int)$_GET["id_presupuesto"];

	// //Dibujo estado actual para mostrar en la ventana
	// //$result_estado_actual = $mysqli->query("SELECT * FROM planos WHERE id=349");
	// //$obj_estado_actual = $result_estado_actual->fetch_object();

	// if (!$result_dibujo_actual->num_rows)
	// {
	// 	//Si no tiene dibujo actual, saco el dibujo actual del padre
	// 	$result_dibujo_actual=$mysqli->query("SELECT png_estado_actual FROM clientes WHERE id_presupuesto_modificado=".$_GET["id_presupuesto"]." AND png_estado_actual != '' ");
	// }

	// $png_estado_actual = $obj_estado_actual->imagen_dibujo_actual;

	// $observaciones = $obj_estado_actual->observaciones;
	// $altura_pared = $obj_estado_actual->altura_techo_actual;
} else {
	// echo "Paso 2";

	// $result_estado_actual = $mysqli->query("SELECT * FROM planos WHERE id=" . $_COOKIE["idplano"]);
	// $obj_estado_actual = $result_estado_actual->fetch_object();

	// $png_estado_actual = $obj_estado_actual->imagen_dibujo_reformado;

	// $observaciones_estado_actual = $obj_estado_actual->observaciones_dibujo_actual;
	// $altura_pared = $obj_estado_actual->altura_techo_reformado;

	// $_GET["id_presupuesto"] = (int)$_GET["id_presupuesto"];

	// // Dibujo estado actual para mostrar en la ventana
	// $result_estado_actual = $mysqli->query("SELECT * FROM planos WHERE id=" . $_GET["id_presupuesto"]);
	// $obj_estado_actual = $result_estado_actual->fetch_object();

	// if (!$result_dibujo_actual->num_rows)
	// {
	// 	// Si no tiene dibujo actual, saco el dibujo actual del padre
	// 	$result_dibujo_actual=$mysqli->query("SELECT png_estado_actual FROM clientes WHERE id_presupuesto_modificado=".$_GET["id_presupuesto"]." AND png_estado_actual != '' ");
	// 	$png_estado_actual = $obj_estado_actual->imagen_dibujo_reformado;

	// 	$observaciones = $obj_estado_actual->observaciones;
	// 	$altura_pared = $obj_estado_actual->altura_techo_reformado;
	// }
}


if (!isset($_GET["id_presupuesto"]))
{
	// $result_observaciones_actual=$mysqli->query("SELECT observaciones_dibujo_actual_txt FROM sesiones_temporales WHERE sesion='".$_COOKIE["random"]."' AND observaciones_dibujo_actual_txt != '' ");

	// while ($arr_result_observaciones_actual = $result_observaciones_actual->fetch_array())
	// {

	// 	$observaciones_estado_actual=$arr_result_observaciones_actual["observaciones_dibujo_actual_txt"];
	// }
}

if (isset($_GET["id_presupuesto"]))
{
	$result_altura_pared=$mysqli->query("SELECT altura_techo_reformado FROM clientes WHERE id_presupuesto=".$_GET["id_presupuesto"]." AND altura_techo_reformado != 0");
	
	while ($arr_result_pared = $result_altura_pared->fetch_array())
		$altura_pared=$arr_result_pared["altura_techo_reformado"];
	
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
	<style>
		@import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,300;1,400;1,500;1,700;1,900&display=swap');
	</style>
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="js/OwlCarousel/dist/assets/owl.carousel.css">
	<link rel="stylesheet" href="js/OwlCarousel/dist/assets/owl.theme.default.css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="zoomove.css">
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

		span.checkmuro {
			margin-bottom: 15px;
		}

		.zoo-item {
			width: 100% !important;
		}

		div#btnFinalizar>span {
			padding: 10px;
			color: white;
			cursor: pointer;
			display: inline-block;
			text-align: center;
			margin-left: 30%;
			margin-top: 15px;
			color: white;
			background-color: #95C11F;
			font-size: 1.5em;
			font-weight: 800;
		}
	</style>
</head>

<body style="background:#d6d6d6;margin:0;padding:0;" <?php if (isset($_GET["id_presupuesto"])) { ?> id="<?php echo $_GET['id_presupuesto']; ?>" <?php } else { ?>id="0" <?php } ?>>

	<div id="observaciones_plano">
		<div id="titulo_observaciones_plano">OBSERVACIONES DE TU PROYECTO</div>
		<div id="contenido_observaciones_plano" style="padding: 5px;height: 300px;max-width: 100%;">
			Escribe tus anotaciones<br>
			<textarea id="textarea_observaciones" class="form-control" style="resize: none; width: 100%;height: 200px;max-height: 100%;" resize="off">

			&#13;&#10;ESTADO Actual:&#13;&#10;
			<?php
			if (!isset($_GET["id_presupuesto"])) {
				//echo $observaciones_estado_actual;
			?>

			&#13;&#10;ESTADO REFORMADO:&#13;&#10;
			<?php
			} else if (isset($_SESSION["login"]) && isset($_GET["id_presupuesto"])) {
				echo $observaciones;
			}
			?>
			</textarea>
		</div>
	</div>

	<div class="modal fade" id="textToLayer" tabindex="-1" role="dialog" aria-labelledby="textToLayerLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close cancelarObservacion" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="textToLayerLabel">OBSERVACIONES DE TU PROYECTO</h4>
				</div>
				<div class="modal-body">
					<p>Tamaño del texto</p>
					<input type="range" list="tickmarks" id="sizePolice" step="5" min="9" max="19" value="9" class="range" style="width:200px" />
					<hr />
					<p contenteditable="true" id="labelBox" onfocus="this.innerHTML='';" style="font-size:15px;padding:5px;border-radius:5px;color:#333">Escribe aquí tu texto</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn greenBtn cancelarObservacion">Cancelar</button>
					<button type="button" class="btn greenBtn" id="btnGuardarAnotacion">Guardar</button>
				</div>
			</div>
		</div>
	</div>
	<?php
	//$_SESSION["login"] se crea cuando el admin entra en la intranet
	if (isset($_SESSION["login"]) || !isset($_GET["id_presupuesto"])) {
	?>
		<div id="parte_superior">
			<div id="header">
				<div id="logo">
					<img src="https://rehubik.com/wp-content/uploads/2020/07/logo_blanco.png" width="95">
					<h1 style="
					color: white;
					padding: 0 0 0 10px;
					text-align: initial;
					margin-bottom: 0;
					font-size: x-large;
					">
						DISEÑA
						<br>
						TU COCINA
					</h1>
				</div>

				<button class="btn screenshot fully" id="screenshot_paso_1" onclick="">Cambiar al paso 2</button>
				<button class="btn screenshot fully" id="screenshot_paso_2" onclick="" style="display: none;">Cambiar al paso 3</button>
				<button class="btn screenshot fully" id="screenshot_paso_3" onclick="" style="display: none;">Cambiar al paso 4</button>
				<button class="btn screenshot fully" id="screenshot_paso_4" onclick="" style="display: none;">Cambiar al paso 5</button>
				<!-- sfar: boton finalizar -->
				<button class="btn screenshot fully" id="btnFinalizar" style="display: none;">Finalizar</button>

			</div>

			<div id="menu_planificador_movil">
				<!-- onclick="window.open(' https://rehubik.com/presupuestador/2d_v0.0.2/ver_plano_estado_actual.php?sesion=< ?php echo $_COOKIE['random'];?>','Estado actual','menubar=1,resizable=1,width=380,height=400')" -->
				<!-- sfar: paso 1 -->
				<div class="paso_menu_movil divmenu" id="menu_estado_actual_movil">
					<!-- disactiv -->
					<span class="numeropaso">
						PASO 1
					</span>
					<br>
					DIBUJA EL ESTADO ACTUAL
					<br>
					<!-- <i class="fa fa-light fa-check"></i> -->
				</div>

				<div id="submenu_paso1_movil" style="display:none">
					<div class="divmenu_movil" id="menu_plano_movil">
						<h5 class="subtitular-planificador">
							<div class="submenu-header">
								<b>PASO 1.1</b>
							</div>
							<b> TABIQUES, PUERTAS Y VENTANAS </b>
							<!-- <br> 
							<i class="fa fa-info-circle instructionsBtn" onclick="instrucciones('paso11')"></i> -->
						</h5>
					</div>

					<div class="divmenu_movil" id="menu_mobiliario_movil">
						<h5 class="subtitular-planificador">
							<div class="submenu-header">
								<b>PASO 1.2</b>
							</div>
							<b> MOBILIARIO Y ELECTRODOMÉSTICOS</b>
							<!-- <br> 
							<i class="fa fa-info-circle instructionsBtn" onclick="instrucciones('paso22')"></i> -->
						</h5>
					</div>

					<div class="divmenu_movil" id="menu_instalaciones_movil">
						<h5 class="subtitular-planificador">
							<div class="submenu-header">
								<b>PASO 1.3</b>
							</div>
							<b>INSTALACIONES</b>
							<!-- <br>
							<i class="fa fa-info-circle instructionsBtn" onclick="instrucciones('paso23')"></i> -->
						</h5>
					</div>

					<div class="divmenu_movil" id="observaciones_movil">
						<h5 class="subtitular-planificador">
							<div class="submenu-header">
								<b>PASO 1.4</b>
							</div>
							<b>OBSERVACIONES</b>
							<!-- <br>
							<i class="fa fa-info-circle instructionsBtn" onclick="instrucciones('paso24')"></i> -->
						</h5>
					</div>
				</div>

				<!-- sfar: paso 2 -->
				<div id="menu_estado_reformado_movil" class="divmenu">
					<span class="numeropaso">
						PASO 2
					</span>
					<br>
					DIBUJAR ESTADO REFORMADO
					<br>
					<!-- <i class="fa fa-info-circle instructionsBtn" onclick="instrucciones('paso2')"></i> -->
					<!-- <div class="open-close-menu-btn"></div> -->
				</div>

				<div id="submenu_paso2_movil" style="display:none">
					<img src="iconos/comenzarBTn.png" alt="Comenzar" class="startBtn" onclick="instrucciones('paso2')" />
					<div class="divmenu_movil" id="menu_plano_movil_2">
						<h5 class="subtitular-planificador">
							<div class="submenu-header">
								<b>PASO 2.1</b>
							</div>
							<b> TABIQUES, PUERTAS Y VENTANAS </b>
							<!-- <br> 
							<i class="fa fa-info-circle instructionsBtn" onclick="instrucciones('paso21')"></i> -->
						</h5>
					</div>

					<div class="divmenu_movil" id="menu_mobiliario_movil_2">
						<h5 class="subtitular-planificador">
							<div class="submenu-header">
								<b>PASO 2.2</b>
							</div>
							<b> MOBILIARIO Y ELECTRODOMÉSTICOS</b>
							<!-- <br> 
							<i class="fa fa-info-circle instructionsBtn" onclick="instrucciones('paso22')"></i> -->
						</h5>
					</div>

					<div class="divmenu_movil" id="menu_instalaciones_movil_2">
						<h5 class="subtitular-planificador">
							<div class="submenu-header">
								<b>PASO 2.3</b>
							</div>
							<b>INSTALACIONES</b>
							<!-- <br>
							<i class="fa fa-info-circle instructionsBtn" onclick="instrucciones('paso23')"></i> -->
						</h5>
					</div>

					<div class="divmenu_movil" id="observaciones_movil_2">
						<h5 class="subtitular-planificador">
							<div class="submenu-header">
								<b>PASO 2.4</b>
							</div>
							<b>OBSERVACIONES</b>
							<!-- <br>
							<i class="fa fa-info-circle instructionsBtn" onclick="instrucciones('paso24')"></i> -->
						</h5>
					</div>
				</div>

				<!-- sfar: paso 3 -->
				<div class="divmenu" id="menu_trabajos_movil">
					<!-- <div class="paso_menu_movil" id="menu_mobiliario_movil"> -->
					<!-- <span class="numeropaso">PASO 3</span>
					<br>
					MOBILIARIO -->
					<span class="numeropaso">
						PASO 3
					</span>
					<br>
					TRABAJOS A REALIZAR
					<!-- <br>
					<i class="fa fa-info-circle instructionsBtn" onclick="instrucciones('paso3')"></i> -->
					<!-- <div class="open-close-menu-btn"></div> -->
				</div>

				<div id="submenu_paso3_movil" style="display:none">
					<ul class="listado_imagenes opciones_instalaciones_menu_escritorio">
						<li class="submenu_instalaciones menu-demoliciones" onclick="muestraInstalaciones('demoliciones')">DEMOLICIONES</li>
						<li class="submenu_instalaciones menu-electricidad" onclick="muestraInstalaciones('electricidad')">INSTALACIÓN ELECTRICA</li>
						<li class="submenu_instalaciones menu-equipamiento" onclick="muestraInstalaciones('equipamiento')">INSTALACIONES EQUIPAMIENTO</li>
						<li class="submenu_instalaciones menu-revestimientos_instalaciones" onclick="muestraInstalaciones('revestimientos_instalaciones')">REVESTIMIENTOS</li>
						<li class="submenu_instalaciones menu-gas" onclick="muestraInstalaciones('gas')">GAS</li>
						<li class="submenu_instalaciones menu-carpinteria_interior" onclick="muestraInstalaciones('carpinteria_interior')">CARPINTERÍA INTERIOR</li>
						<li class="submenu_instalaciones menu-carpinteria_exterior" onclick="muestraInstalaciones('carpinteria_exterior')">CARPINTERÍA EXTERIOR</li>
						<?php
						if (isset($_SESSION["login"]) && isset($_GET["id_presupuesto"])) {
						?>
							<li id="menu_sc" onclick="muestraInstalaciones('menu-sc')" class="submenu_instalaciones menu-sc">S/C
								<!--<div id="listado_sc"></div>-->
							</li>
						<?php
						}
						?>
					</ul>
				</div>

				<!-- sfar: paso 4 -->
				<!-- <div class="paso_menu_movil" id="menu_instalaciones_movil">
					<span class="numeropaso">PASO 4</span>
					<br>
					INSTALACIONES
				</div> -->

				<div class="divmenu" id="menu_materiales_movil">
					<span class="numeropaso">PASO 4</span>
					<br>
					MATERIALES
					<br>
					<!-- <i class="fa fa-info-circle instructionsBtn" onclick="instrucciones('paso4')"></i> -->
					<!-- <div class="open-close-menu-btn noBefore"></div> -->
				</div>

				<!-- sfar: paso 5 -->
				<!-- <div class="paso_menu_movil" id="menu_materiales_movil">
					<span class="numeropaso">PASO 5</span>
					<br>
					MATERIALES
				</div> -->

				<div class="divmenu" id="menu_equipamiento_movil">
					<span class="numeropaso">PASO 5</span>
					<br>
					EQUIPAMIENTO
					<br>
					<!-- <i class="fa fa-info-circle instructionsBtn" onclick="instrucciones('paso5')"></i> -->
					<!-- <div class="open-close-menu-btn noBefore"></div> -->
				</div>
			</div>

			<!--@7mar //7mar hna -->

			<div id="menu_planificador">
				<!-- sfar: paso 1 -->
				<div class="divmenu" id="menu_estado_actual">
					<h2 class="titular-planificador">
						<div style="color:#95C11F;">
							PASO 1
						</div>
						DIBUJA EL ESTADO ACTUAL
						<br>
						<i class="fa fa-info-circle instructionsBtn" onclick="instrucciones('paso1')"></i>
					</h2>
					<div class="open-close-menu-btn"></div>
				</div>

				<div id="submenu_paso1" style="display:none">
					<img src="iconos/comenzarBTn.png" alt="Comenzar" class="startBtn" onclick="instrucciones('paso1')" />
					<!-- <div id="anotaciones_observacion">
						<div style="margin-bottom:15px;text-align:center">
							<strong>Paso 1: Dibuja el estado actual</strong>
						</div>
					</div> -->
					<div class="divmenu" id="menu_plano_paso1">
						<h5 class="subtitular-planificador">
							<div class="submenu-header">
								<b>PASO 1.1</b>
							</div>
							<b> TABIQUES, PUERTAS Y VENTANAS </b>
							<br>
							<i class="fa fa-info-circle instructionsBtn" onclick="instrucciones('paso11')"></i>
						</h5>
					</div>

					<div class="divmenu" id="menu_mobiliario_paso1">
						<h5 class="subtitular-planificador">
							<div class="submenu-header">
								<b>PASO 1.2</b>
							</div>
							<b> MOBILIARIO Y ELECTRODOMÉSTICOS</b>
							<br>
							<i class="fa fa-info-circle instructionsBtn" onclick="instrucciones('paso12')"></i>
						</h5>
					</div>

					<div class="divmenu" id="menu_instalaciones_paso1">
						<h5 class="subtitular-planificador">
							<div class="submenu-header">
								<b>PASO 1.3</b>
							</div>
							<b>INSTALACIONES</b>
							<br>
							<i class="fa fa-info-circle instructionsBtn" onclick="instrucciones('paso13')"></i>
						</h5>
					</div>

					<div class="divmenu" id="observaciones_paso1">
						<h5 class="subtitular-planificador">
							<div class="submenu-header">
								<b>PASO 1.4</b>
							</div>
							<b>OBSERVACIONES</b>
							<br>
							<i class="fa fa-info-circle instructionsBtn" onclick="instrucciones('paso14')"></i>
						</h5>
					</div>
				</div>

				<!-- sfar: paso 2 -->
				<div id="menu_estado_reformado" class="divmenu">
					<h2 class="titular-planificador">
						<div style="color:#95C11F;">
							PASO 2
						</div>
						DIBUJAR ESTADO REFORMADO
						<br>
						<i class="fa fa-info-circle instructionsBtn" onclick="instrucciones('paso2')"></i>
					</h2>
					<div class="open-close-menu-btn"></div>

				</div>

				<div id="submenu_paso2" style="display:none">
					<div class="divmenu" id="menu_plano">
						<h5 class="subtitular-planificador">
							<div class="submenu-header">
								<b>PASO 2.1</b>
							</div>
							<b> TABIQUES, PUERTAS Y VENTANAS </b>
							<br>
							<i class="fa fa-info-circle instructionsBtn" onclick="instrucciones('paso21')"></i>
						</h5>
					</div>

					<div class="divmenu" id="menu_mobiliario">
						<h5 class="subtitular-planificador">
							<div class="submenu-header">
								<b>PASO 2.2</b>
							</div>
							<b> MOBILIARIO Y ELECTRODOMÉSTICOS</b>
							<br>
							<i class="fa fa-info-circle instructionsBtn" onclick="instrucciones('paso22')"></i>
						</h5>
					</div>

					<div class="divmenu" id="menu_instalaciones">
						<h5 class="subtitular-planificador">
							<div class="submenu-header">
								<b>PASO 2.3</b>
							</div>
							<b>INSTALACIONES</b>
							<br>
							<i class="fa fa-info-circle instructionsBtn" onclick="instrucciones('paso23')"></i>
						</h5>
					</div>

					<div class="divmenu" id="observaciones">
						<h5 class="subtitular-planificador">
							<div class="submenu-header">
								<b>PASO 2.4</b>
							</div>
							<b>OBSERVACIONES</b>
							<br>
							<i class="fa fa-info-circle instructionsBtn" onclick="instrucciones('paso24')"></i>
						</h5>
					</div>
				</div>

				<!-- sfar: paso 3 -->
				<div class="divmenu" id="menu_trabajos">
					<h2 class="titular-planificador">
						<div style="color:#95C11F;">
							PASO 3
						</div>
						TRABAJOS A REALIZAR
						<br>
						<i class="fa fa-info-circle instructionsBtn" onclick="instrucciones('paso3')"></i>
					</h2>
					<div class="open-close-menu-btn"></div>
				</div>

				<div id="submenu_paso3">
					<ul class="listado_imagenes opciones_instalaciones_menu_escritorio">
						<li class="submenu_instalaciones menu-demoliciones" onclick="muestraInstalaciones('demoliciones')">DEMOLICIONES</li>
						<li class="submenu_instalaciones menu-electricidad" onclick="muestraInstalaciones('electricidad')">INSTALACIÓN ELECTRICA</li>
						<li class="submenu_instalaciones menu-equipamiento" onclick="muestraInstalaciones('equipamiento')">INSTALACIONES EQUIPAMIENTO</li>
						<li class="submenu_instalaciones menu-revestimientos_instalaciones" onclick="muestraInstalaciones('revestimientos_instalaciones')">REVESTIMIENTOS</li>
						<li class="submenu_instalaciones menu-gas" onclick="muestraInstalaciones('gas')">GAS</li>
						<li class="submenu_instalaciones menu-carpinteria_interior" onclick="muestraInstalaciones('carpinteria_interior')">CARPINTERÍA INTERIOR</li>
						<li class="submenu_instalaciones menu-carpinteria_exterior" onclick="muestraInstalaciones('carpinteria_exterior')">CARPINTERÍA EXTERIOR</li>
						<?php
						if (isset($_SESSION["login"]) && isset($_GET["id_presupuesto"])) {
						?>
							<li id="menu_sc" onclick="muestraInstalaciones('menu-sc')" class="submenu_instalaciones menu-sc">S/C

								<div id="listado_sc"></div>

							</li>

						<?php
						}
						?>
					</ul>
				</div>

				<!-- sfar: paso 4 -->
				<div class="divmenu" id="menu_materiales">
					<h2 class="titular-planificador">
						<div style="color:#95C11F;">
							PASO 4
						</div>
						MATERIALES
						<br>
						<i class="fa fa-info-circle instructionsBtn" onclick="instrucciones('paso4')"></i>
					</h2>
					<div class="open-close-menu-btn noBefore"></div>
				</div>

				<!-- sfar: paso 5 -->
				<div class="divmenu" id="menu_equipamiento">
					<h2 class="titular-planificador">
						<div style="color:#95C11F;">
							PASO 5
						</div>
						EQUIPAMIENTO
						<br>
						<i class="fa fa-info-circle instructionsBtn" onclick="instrucciones('paso5')"></i>
					</h2>
					<div class="open-close-menu-btn noBefore"></div>
				</div>
			</div>

			<div id="panel_informacion">
				<div id="opciones_observacion" style="display:none;">
					<button class="blackBtn" id="text_mode" data-toggle="tooltip" data-placement="right" title="Nueva observación">Añadir Anotaciones</button>
					<i class="fa fa-info-circle instructionsBtn" onclick="alertify.alert('Indica las observaciones que consideres necesarias para la reforma de tu cocina y que no hayan sido definidas en los pasos anteriores.<br/><br/> Ej.1: No existe falso techo en mi cocina actual.<br/> Ej.2: Tengo una viga que atraviesa la cocina en horizontal, en ese punto. <br/><br/> Para ello, <b>haz clic en la parte del plano que quieras añadir la observación. Escríbela y pulsa en Guardar</b>')"></i>
					<!-- onclick="alertify.alert('Indica las observaciones que consideres necesarias para la reforma de tu cocina y que no hayan sido definidas en los pasos anteriores.<br/><br/> Ej.1: No existe falso techo en mi cocina actual.<br/> Ej.2: Tengo una viga que atraviesa la cocina en horizontal, en ese punto. <br/><br/> Para ello, <b>haz clic en la parte del plano que quieras añadir la observación. Escríbela y pulsa en Guardar</b>')" -->
					<div id="anotaciones_observacion">
						<?php
						// if (!isset($_GET["id_presupuesto"])) {
						// 	echo $observaciones_estado_actual;
						?>
						<!-- <p style="margin-top:10px;text-align:center"><strong>Observaciones Estado reformado</strong></p> -->
						<?php
						// } else if (isset($_SESSION["login"]) && isset($_GET["id_presupuesto"])) {
						/*$result_observaciones=$mysqli->query("SELECT observaciones_dibujo_reformado_txt FROM clientes WHERE id_presupuesto=".$_GET["id_presupuesto"]." AND observaciones_dibujo_reformado_txt != '' LIMIT 1");
							while ($arr_result_observaciones = $result_observaciones->fetch_array())
							{
								echo $arr_result_observaciones["observaciones_dibujo_reformado_txt"]; 
							}
							*/
						// 	echo $observaciones;
						// }
						?>
					</div>
				</div>

				<div id="opciones_crear_plano" style="display: none;">
					<div id="informacion_pared" style="display: grid;">
						<div id="panel">
							<p style="display:none;">
								<button class="btn" id="undo" title="undo"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i></button>
								<button class="btn" id="redo" title="redo"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i></button>
							</p>
							<?php
							/*if (!isset($_SESSION["login"]))
							{*/
							//El verificador no puede crear nuevos muros, puede modificar los que ya hay
							?>
							<button class="btn greenBtn" id="line_mode" data-toggle="tooltip" data-placement="right" title="Comenzar">
								<i class="fa fa-arrow-right" style="" aria-hidden="true"></i>
								COMENZAR PLANO
							</button>
							<?php
							/*}*/
							?>
							<!-- <span id="sizePolice"></span> -->
							<button class="btn greenBtn fully " id="puertas" onclick="$('.sub').hide();$('#door_list').toggle(200);$('#window_list').hide();">Puertas</button>
							<div id="door_list" class="owl-carousel owl-theme owl-loaded owl-drag" style="display:none;background:#fff;padding:10px;">
								<!-- 7mar: start codigo puertas -->
								<?php
								$dir_path_puertas = "./assets/puertas";
								$extensions_array = array('jpg', 'png', 'jpeg');
								//$id_array = array('aperture','double','left-door','left-sliding-door','pocket','right-door','right-door','right-sliding-door');
								$id_array = array('aperture', 'pasaplatos', 'right-door', 'left-door', 'double', 'left-sliding-door', 'right-sliding-door', 'right-sliding-door', 'right-sliding-door');

								function Quitar_Espacios($Frase, $extensions)
								{
									$Frase_Bien = preg_replace(array('/\s{2,}/', '/[-]/'), ' ', preg_replace(array('/\s{2,}/', '/.' . $extensions . '/'), '', $Frase));
									echo $Frase_Bien;
								}

								if (is_dir($dir_path_puertas)) {
									$files = scandir($dir_path_puertas);
									// echo 'puertas';

									for ($i = $j = 0; $i < count($files); $i++) {
										if ($files[$i] != '.' && $files[$i] != '..') {
											// get file extension
											$file = pathinfo($files[$i]);
											$extension = $file['extension'];
											// echo "File Extension-> $extension<br>";

											// check file extension
											if (in_array($extension, $extensions_array)) {
								?>
												<div class="invertedBtn">
													<button class="btn fully door" id="<?php echo $id_array[$j]; ?>">
														<img src="<?php if (in_array($extension, $extensions_array)) {
																		echo $dir_path_puertas . '/' . $files[$i];
																	} ?>" style="width:83px">
													</button>
													<p>
														<?php Quitar_Espacios($files[$i], $extension); ?>
													</p>
												</div>
								<?php

												$j++;
											}
										}
									}
								}
								?>
								<!-- 7mar: End codigo puertas -->
								<!-- <div class="invertedBtn">
									<button class="btn fully door" id="aperture">
										<img src="puertas/ventaja-fija.png" style="width:83px">
									</button>
									<p>Apertura hueco</p>
								</div>

								<div class="invertedBtn">
									<button class="btn fully door" id="double">
										<img src="puertas/puerta-doble.png" style="width:83px">
									</button>
									<p>Puerta abatible doble</p>
								</div>

								<div class="invertedBtn">
									<button class="btn fully door" id="pocket">
										<img src="puertas/puerta-cajon-dcha.png" style="width:83px">
									</button>
									<p> Puerta corredera guía <br /> exterior apertura izquierda</p>
								</div>

								<div class="invertedBtn">
									<button class="btn fully door" id="left-door">
										<img src="puertas/puerta-izq.png" style="width:83px">
									</button>
									<p> Puerta abatible<br> apertura izquierda</p>
								</div>

								<div class="invertedBtn">
									<button class="btn fully door" id="right-door">
										<img src="puertas/puerta-dcha.png" style="width:83px">
									</button>
									<p> Puerta abatible<br> apertura derecha</p>
								</div>

								<div class="invertedBtn">
									<button class="btn fully door" id="right-sliding-door">
										<img src="puertas/puerta-cajon-dcha.png" style="width:83px">
									</button>
									<p> Puerta corredera encastrada apertura derecha</p>
								</div>

								<div class="invertedBtn">
									<button class="btn fully door" id="left-sliding-door">
										<img src="puertas/puerta-cajon-izq.png" style="width:83px">
									</button>
									<p> Puerta corredera encastrada apertura izquierda</p>
								</div> -->

							</div>
							<!-- <div id="door_list" class="list-unstyled sub" style="display:none;background:#fff;padding:10px;">
								<button class="btn fully door invertedBtn" id="aperture">
									<img src="puertas/ventaja-fija.png">
									<p>Apertura</p>
								</button>
								<button class="btn fully door invertedBtn" id="double">
									<img src="puertas/puerta-doble.png">
									<p>Puerta doble</p>
								</button>

								<button class="btn fully door invertedBtn" id="pocket">
									<img src="puertas/puerta-cajon-dcha.png">
									<p>Puerta corrediza</p>
								</button>
								<button class="btn fully door invertedBtn" id="left-door">
									<img src="puertas/puerta-izq.png">
									<p> Puerta simple<br> izquierda</p>
								</button>

								<button class="btn fully door invertedBtn" id="right-door">
									<img src="puertas/puerta-dcha.png">
									<p> Puerta simple<br> derecha</p>
								</button>
								<button class="btn fully door invertedBtn" id="staff-door">
									<img src="puertas/puerta-servicio.png">
									<p> Puerta de servicio</p>
								</button>

								<button class="btn fully door invertedBtn" id="right-sliding-door">
									<img src="puertas/puerta-cajon-dcha.png">
									<p> Puerta corredera<br> derecha</p>
								</button>
								<button class="btn fully door invertedBtn" id="left-sliding-door">
									<img src="puertas/puerta-cajon-izq.png">
									<p>Puerta corredera<br> izquierda</p>
								</button>

							</div> -->
							<button class="btn greenBtn fully " id="window_mode" onclick="$('.sub').hide();$('#window_list').toggle(200);$('#door_list').hide()">Ventanas</button>
							<!-- <button class="btn greenBtn fully " id="">
								<!-- onclick="html2canvas(document.body).then((canvas) => {
																							let a = document.createElement('a');
																							a.download = 'ss.png';
																							a.href = canvas.toDataURL('image/png');
																							a.click();
																							});" -->
							<?php
							// https://netcell.netlify.com/blog/2016/04/image-base64.html
							/*$file = fopen("screenshot.jpeg", "w");
									$data = explode(",", $_POST["screenshot"]);
									$data = base64_decode($data[1]);
									fwrite($file, $data);
									fclose($file);
									echo "OK";*/ ?>
							<!-- <h1>📷</h1>
							</button> -->



							<div id="window_list" class="owl-carousel owl-theme owl-loaded owl-drag" style="display:none;background:#fff; padding:10px;">
								<!-- 7mar: Start codigo ventanas -->
								<?php
								$dir_path_ventanas = "assets/ventanas";
								// $extensions_array = array('jpg', 'png', 'jpeg');
								// $id_array = array('aperture','double','left-door','left-sliding-door','pocket','right-door','right-door','right-sliding-door');
								// $id_array = array('aperture', 'pasaplatos', 'right-door', 'left-door', 'double', 'left-sliding-door', 'right-sliding-door', 'right-sliding-door', 'right-sliding-door');
								$id_array_ventanas = array('afixed-window', 'flap', 'twin', 'left-window', 'double-sliding-window', 'staff-door');

								// function Quitar_Espacios($Frase, $extensions)
								// {
								// 	$Frase_Bien = preg_replace(array('/\s{2,}/', '/[-]/'), ' ', preg_replace(array('/\s{2,}/', '/.' . $extensions . '/'), '', $Frase));
								// 	echo $Frase_Bien;
								// }

								if (is_dir($dir_path_ventanas)) {
									$files = scandir($dir_path_ventanas);

									// echo is_dir($dir_path_ventanas)."test ventanas";

									for ($i = $j = 0; $i < count($files); $i++) {
										if ($files[$i] != '.' && $files[$i] != '..') {
											// get file extension
											$file = pathinfo($files[$i]);
											$extension = $file['extension'];
											$ext = '/.' . $extension . '/i';
											// echo "File Extension-> $extension<br>";

											// check file extension
											if (in_array($extension, $extensions_array)) {
								?>
												<div class="invertedBtn">
													<button class="btn fully window" id="<?php echo preg_replace($ext, '', $files[$i]); ?>">
														<img src="<?php if (in_array($extension, $extensions_array)) {
																		echo $dir_path_ventanas . '/' . $files[$i];
																	} ?>" style="width:83px">
													</button>
													<p>
														<?php
														echo $extension;
														Quitar_Espacios($files[$i], $extension); ?>
													</p>
												</div>
								<?php

												$j++;
											}
										}
									}
								}
								?>
								<!-- 
								<div class="invertedBtn">
									<button class="btn fully window" id="afixed-window">
										<img src="puertas/ventaja-fija.png" style="width:83px">
									</button>
									<p>Ventana 1 hoja</p>
								</div>

								<div class="invertedBtn">
									<button class="btn fully window" id="flap">
										<img src="puertas/ventana-dcha.png" style="width:83px">
									</button>
									<p>Ventana 1 hoja abatible ap.izquierda </p>
								</div>

								<div class="invertedBtn">
									<button class="btn fully window" id="twin">
										<img src="puertas/ventana-doble.png" style="width:83px">
									</button>
									<p>Ventana 2 hojas abatibles</p>
								</div>

								<div class="invertedBtn">
									<button class="btn fully window" id="left-window">
										<img src="puertas/ventana-izq.png" style="width:83px">
									</button>
									<p>Ventana 1 hoja abatible ap.derecha</p>
								</div>

								<div class="invertedBtn">
									<button class="btn fully window" id="double-sliding-window">
										<img src="puertas/ventana-doble-corredera.png" style="width:83px">
									</button>
									<p> Ventana 2 hojas correderas</p>
								</div>

								<div class="invertedBtn">
									<button class="btn fully door" id="staff-door">
										<img src="puertas/puerta-servicio.png" style="width:83px">
									</button>
									<p> Pasaplatos</p>
								</div> 
								-->
								<!-- 7mar: End codigo ventanas -->
							</div>

							<!-- <div id="window_list" class="list-unstyled sub" style="display:none;background:#fff; padding:10px;">
								<button class="btn fully window invertedBtn" id="afixed-window">
									<img src="puertas/ventaja-fija.png">
									<p>Ventana fija</p>
								</button>
								<button class="btn fully window invertedBtn" id="flap">
									<img src="puertas/ventana-dcha.png">
									<p>Ventana derecha</p>
								</button>

								<button class="btn fully window invertedBtn" id="twin">
									<img src="puertas/ventana-doble.png">
									<p>Ventana doble</p>
								</button>
								<button class="btn fully window invertedBtn" id="left-window">
									<img src="puertas/ventana-izq.png">
									<p>Ventana simple<br> izquierda</p>
								</button>

								<button class="btn fully window invertedBtn" id="right-window">
									<img src="puertas/ventana-dcha.png">
									<p> Ventana simple<br> derecha</p>
								</button>
								<button class="btn fully window invertedBtn" id="double-sliding-window">
									<img src="puertas/ventana-doble-corredera.png">
									<p> Ventana doble<br> corredera</p>
								</button>
							</div> -->
						</div>

						<label>Altura techo:</label>
						<input id="altura_paredes" type="range" value="<?php if (isset($_GET["id_presupuesto"])) {
																			echo $altura_pared;
																		} else { ?>2<?php } ?>" min="2" max="5" step="0.01" oninput="this.nextElementSibling.value = this.value">
						<output style="display:inline-block; color:#95C11F; font-size: 1em">
							<?php
							if (isset($_GET["id_presupuesto"])) {
								echo $altura_pared;
							} else { ?> 2 <?php }
											?>
						</output>
						<span> M</span>
						<button class="btn invertedBtn" id="select_mode"> Seleccionar Muros</button>
					</div>

					<div id="informacion_panel">
						<div id="listado_muros"></div>
						<div id="wallTools" style="display:none;">
							<h2 id="titleWallTools">Modifica la pared</h2>
							<hr />
							<section id="rangeThick">
								<p><b>Modificando Pared:</b> <span id="wallWidthScale"></span> <span id="wallWidthVal"></span></p>
								<input style="display:none" type="text" id="wallWidth" />
							</section>
							<ul class="list-unstyled">
								<li><button class="btn btn-danger" id="wallTrash"><i class="fa fa-2x fa-trash-o" aria-hidden="true"></i></button>
									<button class="btn btn-info" onclick="fonc_button('select_mode');$('#boxinfo').html('Modo selección');$('#wallTools').hide('300');$('#panel').show('300');hideAllSize();rib();"><i class="fa fa-2x fa-backward" aria-hidden="true"></i></button>
								</li>
							</ul>
							<div id="opcion_tabiqueria">
								<p>
									<input type="radio" name="opcion_tabique" value="mantener" checked> Tabique a mantener <br />
									<input type="radio" name="opcion_tabique" value="demoler"> Tabique a demoler <br />
									<input type="radio" name="opcion_tabique" value="nuevo"> Tabique nuevo <br />
								</p>
							</div>
						</div>
					</div>
				</div>

				<div id="opciones_estilos" style="display:none;">
					<div id="estilos">
						<div class="texto-li centrado titulo-material">ESCOGE TU ESTILO</div>
						<div class="style-container">
							<div id="nordicoStyleBtn" class="style-options">
								<i class="fa fa-info-circle instructionsBtn styleInfoBtn" style="color:black;"></i>
								<p>NÓRDICO</p>
							</div>
							<div class="style-info">
								Caracterizado por la sencillez y la
								uniformidad de colores claros
								(blancos, grises y beiges). Muebles
								sencillos de diseño
								contemporáneo salpicados con
								toques como plantas, velas,
								cuadros o textiles que contrasten.
							</div>
						</div>
						<div class="style-container">
							<div id="minimalistaStyleBtn" class="style-options">
								<i class="fa fa-info-circle instructionsBtn styleInfoBtn" style="color:black;"></i>
								<p>MINIMALISTA</p>
							</div>
							<div class="style-info">
								Texturas y superficies lisas, colores
								neutros y ausencia de estampados
								o dibujos. La principal virtud pasa
								por contar con los elementos
								justos e imprescindibles en los
								espacios sin que la estancia quede
								excesivamente plana, y siempre
								conservando orden y armonía.
							</div>
						</div>
						<div class="style-container">
							<div id="industrialStyleBtn" class="style-options">
								<i class="fa fa-info-circle instructionsBtn styleInfoBtn" style="color:black;"></i>
								<p>INDUSTRIAL</p>
							</div>
							<div class="style-info">
								Se caracteriza por el empleo de
								objetos y elementos asociados a
								fábricas antiguas y talleres
								mezclado con el gusto por el
								reciclaje y lo vintage. Instalaciones
								desnudas, suelos y revestimientos
								continuos, muebles de líneas
								rectas y acabados en hierro, acero
								y madera tosca.
							</div>
						</div>
						<div class="style-container">
							<div id="rusticoStyleBtn" class="style-options">
								<i class="fa fa-info-circle instructionsBtn styleInfoBtn" style="color:black;"></i>
								<p>RÚSTICO</p>
							</div>
							<div class="style-info">
								Apuesta por la calidez de la madera incluso en elementos como la encimera. Dentro de este estilo encontramos variedad de acabados y tonalidades. Con líneas simples y una posibilidad de combinar la madera con porcelánicos y acero que puede marcar la diferencia.
							</div>
						</div>
						<div class="style-container">
							<div id="clasicoStyleBtn" class="style-options">
								<i class="fa fa-info-circle instructionsBtn styleInfoBtn" style="color:black;"></i>
								<p>CLÁSICO</p>
							</div>
							<div class="style-info">
								Estilo elegante, lujoso y sofisticado. Cromatismo que toma el blanco como base y lo combina con colores más llamativos como el rojo, el azul o el verde. Maderas nobles, molduras en paredes y techos, papel pintado, cristal y lacados
							</div>
						</div>
						<div class="style-container">
							<div id="mediterraneoStyleBtn" class="style-options">
								<i class="fa fa-info-circle instructionsBtn styleInfoBtn" style="color:black;"></i>
								<p>MEDITERRÁNEO</p>
							</div>
							<div class="style-info">
								Maximización de la luz natural, colores alegres y contraste de blancos, azules y verdes y tonos tierra, azulejos hidráulicos típicos de la zona, mezclando la tradición con los elementos más actuales. Porcelánicos, gres, madera, mimbre y plantas.
							</div>
						</div>
						<div class="style-container">
							<div id="libreStyleBtn" class="style-options">
								<i class="fa fa-info-circle instructionsBtn styleInfoBtn" style="color:black;"></i>
								<p>LIBRE</p>
							</div>
							<div class="style-info">
								Combina todos los elementos a tu gusto y crea tu propio estilo de cocina ideal
							</div>
						</div>
					</div>
				</div>
				<div id="opciones_materiales" style="display:none">
					<div id="materiales">
						<div class="texto-li centrado titulo-material buttonTitle" onclick="$('#opciones_materiales').hide();$('#opciones_estilos').show();$('#titulo_estado_actual').show(); $('#bloque_estado_actual').show();$('#bloque_materiales').hide();$('#lin').hide();">
							<i class="fa fa-arrow-left" style="color:black;margin-left: 10px;" aria-hidden="true"></i>
							<div>ESCOGE TU ESTILO</div>
						</div>
						<div class="style-container">
							<div id="selectedStyleBtn" class="style-options">
								<p>INDUSTRIAL</p>
							</div>
						</div>
						<button class="btn greenBtn fully " id="frente_armario" onclick="hideStep4SubMenus(this);">FRENTE ARMARIO</button>
						<div id="frente_armario_list" class="child_list" style="display:none;background:#fff;padding:10px;">
							<button id="IKEA001" class="libre estilo4 estilo5 materials_submenu_btn">
								<div style="display:flex;" onclick="setMaterialsImages(0,'CapasCocina/MOBILIARIO/BODBYN/mob_bodbyn_grisclaro.png');">
									<img id="IKEA001" src="frenteMobiliario/BodbynGris1.png" style="width:35%">
									<img src="frenteMobiliario/BodbynGris2.png" style="width:55%">
								</div>
							</button>
							<button id="IKEA002" class="libre estilo4 estilo5 materials_submenu_btn" onclick="setMaterialsImages(0,'CapasCocina/MOBILIARIO/BODBYN/mob_bodbyn_hueso.png');">
								<div style="display:flex;">
									<img src="frenteMobiliario/BodbynHueso1.png" style="width:35%">
									<img src="frenteMobiliario/BodbynHueso2.png" style="width:55%">
								</div>
							</button>
							<button id="IKEA003" class="libre estilo5 materials_submenu_btn" onclick="setMaterialsImages(0,'CapasCocina/MOBILIARIO/BODBYN/mob_bodbyn_verdeoscuro.png');">
								<div style="display:flex;">
									<img src="frenteMobiliario/BodbynVerde1.png" style="width:35%">
									<img src="frenteMobiliario/BodbynVerde2.png" style="width:55%">
								</div>
							</button>
							<button id="IKEA004" class="libre estilo2 estilo6 materials_submenu_btn" onclick="setMaterialsImages(0,'CapasCocina/MOBILIARIO/Combinados/mob_jarsta_turquesabrillo.png');">
								<div style="display:flex;">
									<img src="frenteMobiliario/JarstaTurquesa1.png" style="width:35%">
									<img src="frenteMobiliario/JarstaTurquesa2.png" style="width:55%">
								</div>
							</button>
							<button id="IKEA005" class="libre estilo5 materials_submenu_btn" onclick="setMaterialsImages(0,'CapasCocina/MOBILIARIO/Combinados/mob_sinarp_hasslarp_maderaoscura.png');">
								<div style="display:flex;">
									<img src="frenteMobiliario/Sinarp+Hasslarp1.png" style="width:35%">
									<img src="frenteMobiliario/Sinarp+Hasslarp2.png" style="width:55%">
								</div>
							</button>
							<button id="IKEA006" class="libre estilo3 materials_submenu_btn" onclick="setMaterialsImages(0,'CapasCocina/MOBILIARIO/Combinados/mob_varsta_aceroinoxidable.png');">
								<div style="display:flex;">
									<img src="frenteMobiliario/VarstaAceroInox1.png" style="width:35%">
									<img src="frenteMobiliario/VarstaAceroInox2.png" style="width:55%">
								</div>
							</button>
							<button id="IKEA007" class="libre estilo3 estilo5 materials_submenu_btn" onclick="setMaterialsImages(0,'CapasCocina/MOBILIARIO/con_marco/mob_lerhyttan_maderanegra.png');">
								<div style="display:flex;">
									<img src="frenteMobiliario/LerhyttanMaderanegra1.png" style="width:35%">
									<img src="frenteMobiliario/LerhyttanMaderanegra2.png" style="width:55%">
								</div>
							</button>
							<button id="IKEA008" class="libre estilo4 materials_submenu_btn" onclick="setMaterialsImages(0,'CapasCocina/MOBILIARIO/con_marco/mob_savedal_blancomate.png');">
								<div style="display:flex;">
									<img src="frenteMobiliario/SavedalBlancoMate1.png" style="width:35%">
									<img src="frenteMobiliario/SavedalBlancoMate2.png" style="width:55%">
								</div>
							</button>
							<button id="IKEA009" class="libre estilo1 estilo4 estilo6 materials_submenu_btn" onclick="setMaterialsImages(0,'CapasCocina/MOBILIARIO/con_marco/mob_torhamn_maderanatural.png');">
								<div style="display:flex;">
									<img src="frenteMobiliario/TorhamnMadera1.png" style="width:35%">
									<img src="frenteMobiliario/TorhamnMadera2.png" style="width:55%">
								</div>
							</button>
							<button id="IKEA010" class="libre estilo1 estilo6 materials_submenu_btn" onclick="setMaterialsImages(0,'CapasCocina/MOBILIARIO/LISO_con_tirador/mob_askersund_madera_fresnoclaro.png');">
								<div style="display:flex;">
									<img src="frenteMobiliario/AskersunMaderoFresnoClaro1.png" style="width:35%">
									<img src="frenteMobiliario/AskersunMaderoFresnoClaro2.png" style="width:55%">
								</div>
							</button>
							<button id="IKEA011" class="libre estilo5 materials_submenu_btn" onclick="setMaterialsImages(0,'CapasCocina/MOBILIARIO/LISO_con_tirador/mob_havstorp_hueso.png');">
								<div style="display:flex;">
									<img src="frenteMobiliario/HavstorpHueso1.png" style="width:35%">
									<img src="frenteMobiliario/HavstorpHueso2.png" style="width:55%">
								</div>
							</button>
							<button id="IKEA012" class="libre materials_submenu_btn" onclick="setMaterialsImages(0,'CapasCocina/MOBILIARIO/LISO_con_tirador/mob_kallarp_granatebrillo.png');">
								<div style="display:flex;">
									<img src="frenteMobiliario/KallarpGranateBrillo1.png" style="width:35%">
									<img src="frenteMobiliario/KallarpGranateBrillo2.png" style="width:55%">
								</div>
							</button>
							<button id="IKEA013" class="libre estilo3 materials_submenu_btn" onclick="setMaterialsImages(0,'CapasCocina/MOBILIARIO/LISO_con_tirador/mob_kungsbaka_negromate.png');">
								<div style="display:flex;">
									<img src="frenteMobiliario/KungsbackaNegroMate1.png" style="width:35%">
									<img src="frenteMobiliario/KungsbackaNegroMate2.png" style="width:55%">
								</div>
							</button>
							<button id="IKEA014" class="libre estilo1 estilo2 materials_submenu_btn" onclick="setMaterialsImages(0,'CapasCocina/MOBILIARIO/LISO_con_tirador/mob_ringhult_blancobrillo.png');">
								<div style="display:flex;">
									<img src="frenteMobiliario/RinghultBlancoBrillo1.png" style="width:35%">
									<img src="frenteMobiliario/RinghultBlancoBrillo2.png" style="width:55%">
								</div>
							</button>
							<button id="IKEA015" class="libre estilo1 materials_submenu_btn" onclick="setMaterialsImages(0,'CapasCocina/MOBILIARIO/LISO_con_tirador/mob_veddinge_blancomate.png');">
								<div style="display:flex;">
									<img src="frenteMobiliario/VeddingeBlancoMate1.png" style="width:35%">
									<img src="frenteMobiliario/VeddingeBlancoMate2.png" style="width:55%">
								</div>
							</button>
							<button id="IKEA016" class="libre estilo1 estilo2 estilo6 materials_submenu_btn" onclick="setMaterialsImages(0,'CapasCocina/MOBILIARIO/Voxtorp/mob_linea_voxtorp_blanco_brillo.png');">
								<div style="display:flex;">
									<img src="frenteMobiliario/VoxtorpBlancoBrillo1.png" style="width:35%">
									<img src="frenteMobiliario/VoxtorpBlancoBrillo2.png" style="width:55%">
								</div>
							</button>
							<button id="IKEA017" class="libre estilo1 estilo2 estilo6 materials_submenu_btn" onclick="setMaterialsImages(0,'CapasCocina/MOBILIARIO/Voxtorp/mob_linea_voxtorp_blanco_mate.png');">
								<div style="display:flex;">
									<img src="frenteMobiliario/VoxtorpBlancoMate1.png" style="width:35%">
									<img src="frenteMobiliario/VoxtorpBlancoMate2.png" style="width:55%">
								</div>
							</button>
							<button id="IKEA018" class="libre estilo2 materials_submenu_btn" onclick="setMaterialsImages(0,'CapasCocina/MOBILIARIO/Voxtorp/mob_linea_voxtorp_grisoscuro_mate.png');">
								<div style="display:flex;">
									<img src="frenteMobiliario/VoxtorpGris1.png" style="width:35%">
									<img src="frenteMobiliario/VoxtorpGris2.png" style="width:55%">
								</div>
							</button>
							<button id="IKEA019" class="libre estilo1 estilo2 estilo4 estilo6 materials_submenu_btn" onclick="setMaterialsImages(0,'CapasCocina/MOBILIARIO/Voxtorp/mob_linea_voxtorp_madera.png');">
								<div style="display:flex;">
									<img src="frenteMobiliario/VoxtorpMadera1.png" style="width:35%">
									<img src="frenteMobiliario/VoxtorpMadera2.png" style="width:55%">
								</div>
							</button>
						</div>
						<button class="btn greenBtn fully " id="encimera" onclick="hideStep4SubMenus(this);">ENCIMERA</button>
						<div id="encimera_list" class="child_list" style="text-align:center;display:none;background:#fff;padding:10px;">
							<button id="IKEA020" class="libre estilo1 estilo3 materials_submenu_btn" onclick="setMaterialsImages(1,'CapasCocina/ENCIMERA/Cemento/enc_ekbacken_cemento_oscuro.png');">
								<div style="display:flex;">
									<img src="encimeras/ekbacken_cemento_oscuro1.png" style="width:35%">
									<img src="encimeras/ekbacken_cemento_oscuro2.png" style="width:55%">
								</div>
							</button>
							<button id="IKEA021" class="libre estilo1 estilo3 materials_submenu_btn" onclick="setMaterialsImages(1,'CapasCocina/ENCIMERA/Cemento/enc_skararp_efectocemento.png');">
								<div style="display:flex;">
									<img src="encimeras/skararp_efecto_cemento1.png" style="width:35%">
									<img src="encimeras/skararp_efecto_cemento2.png" style="width:55%">
								</div>
							</button>
							<button id="IKEA022" class="libre estilo3 materials_submenu_btn" onclick="setMaterialsImages(1,'CapasCocina/ENCIMERA/Lisa/enc_ekbacken_grisclaro_mate.png');">
								<div style="display:flex;">
									<img src="encimeras/ekbacken_gris_claro_mate1.png" style="width:35%">
									<img src="encimeras/ekbacken_gris_claro_mate2.png" style="width:55%">
								</div>
							</button>
							<button id="IKEA023" class="libre estilo1 estilo5 materials_submenu_btn" onclick="setMaterialsImages(1,'CapasCocina/ENCIMERA/Lisa/enc_ekbacken_hueso_mate.png');">
								<div style="display:flex;">
									<img src="encimeras/ekbacken_hueso_mate1.png" style="width:35%">
									<img src="encimeras/ekbacken_hueso_mate2.png" style="width:55%">
								</div>
							</button>
							<button id="IKEA024" class="libre estilo3 materials_submenu_btn" onclick="setMaterialsImages(1,'CapasCocina/ENCIMERA/Lisa/enc_saljan_aluminio.png');">
								<div style="display:flex;">
									<img src="encimeras/saljan_aluminio1.png" style="width:35%">
									<img src="encimeras/saljan_aluminio2.png" style="width:55%">
								</div>
							</button>
							<button id="IKEA025" class="libre estilo1 estilo2 estilo5 estilo6 materials_submenu_btn" onclick="setMaterialsImages(1,'CapasCocina/ENCIMERA/Lisa/enc_saljan_blanco_brillo.png');">
								<div style="display:flex;">
									<img src="encimeras/saljan_blanco_brillo1.png" style="width:35%">
									<img src="encimeras/saljan_blanco_brillo2.png" style="width:55%">
								</div>
							</button>
							<button id="IKEA026" class="libre estilo1 estilo2 estilo5 estilo6 materials_submenu_btn" onclick="setMaterialsImages(1,'CapasCocina/ENCIMERA/Lisa/enc_saljan_blanco_mate.png');">
								<div style="display:flex;">
									<img src="encimeras/saljan_blanco_mate1.png" style="width:35%">
									<img src="encimeras/saljan_blanco_mate2.png" style="width:55%">
								</div>
							</button>
							<button id="IKEA027" class="libre estilo1 estilo4 materials_submenu_btn" onclick="setMaterialsImages(1,'CapasCocina/ENCIMERA/Madera/enc_barkaboda_madera_nogal.png');">
								<div style="display:flex;">
									<img src="encimeras/barkaboda_madera_nogal1.png" style="width:35%">
									<img src="encimeras/barkaboda_madera_nogal2.png" style="width:55%">
								</div>
							</button>
							<button id="IKEA028" class="libre estilo1 estilo4 estilo6 materials_submenu_btn" onclick="setMaterialsImages(1,'CapasCocina/ENCIMERA/Madera/enc_ekbacken_fresno.png');">
								<div style="display:flex;">
									<img src="encimeras/ekbacken_fresno1.png" style="width:35%">
									<img src="encimeras/ekbacken_fresno2.png" style="width:55%">
								</div>
							</button>
							<button id="IKEA029" class="libre estilo1 estilo4 materials_submenu_btn" onclick="setMaterialsImages(1,'CapasCocina/ENCIMERA/Madera/enc_karlby_madera_nogal.png');">
								<div style="display:flex;">
									<img src="encimeras/karlby_nogal1.png" style="width:35%">
									<img src="encimeras/karlby_nogal2.png" style="width:55%">
								</div>
							</button>
							<button id="IKEA030" class="libre estilo4 materials_submenu_btn" onclick="setMaterialsImages(1,'CapasCocina/ENCIMERA/Madera/enc_pinnarp_madera_nogal.png');">
								<div style="display:flex;">
									<img src="encimeras/PinnarpNogal1.png" style="width:35%">
									<img src="encimeras/PinnarpNogal2.png" style="width:55%">
								</div>
							</button>
							<button id="IKEA031" class="libre estilo1 estilo4 estilo6 materials_submenu_btn" onclick="setMaterialsImages(1,'CapasCocina/ENCIMERA/Madera/enc_saljan_madera_roble.png');">
								<div style="display:flex;">
									<img src="encimeras/SaljanRoble1.png" style="width:35%">
									<img src="encimeras/SaljanRoble2.png" style="width:55%">
								</div>
							</button>
							<button id="IKEA032" class="libre estilo4 estilo5 materials_submenu_btn" onclick="setMaterialsImages(1,'CapasCocina/ENCIMERA/Piedra/enc_ekbacken_marmol_grisoscuro.png');">
								<div style="display:flex;">
									<img src="encimeras/EkbackenMarmolGrisOscuro1.png" style="width:35%">
									<img src="encimeras/EkbackenMarmolGrisOscuro2.png" style="width:55%">
								</div>
							</button>
							<button id="IKEA033" class="libre estilo4 estilo5 materials_submenu_btn" onclick="setMaterialsImages(1,'CapasCocina/ENCIMERA/Piedra/enc_kasker_piedra_marrongrisaceo.png');">
								<div style="display:flex;">
									<img src="encimeras/Kasker_piedra_marron_gris1.png" style="width:35%">
									<img src="encimeras/Kasker_piedra_marron_gris2.png" style="width:55%">
								</div>
							</button>
							<button id="IKEA034" class="materials_submenu_btn" onclick="setMaterialsImages(1,'CapasCocina/ENCIMERA/Piedra/enc_kasker_piedra_negropurpurina.png');">
								<div style="display:flex;">
									<img src="encimeras/KaskerPiedraNegroPurpurina1.png" style="width:35%">
									<img src="encimeras/KaskerPiedraNegroPurpurina2.png" style="width:55%">
								</div>
							</button>
							<button id="IKEA035" class="libre estilo5 materials_submenu_btn" onclick="setMaterialsImages(1,'CapasCocina/ENCIMERA/Piedra/enc_saljan_piedra_blanco.png');">
								<div style="display:flex;">
									<img src="encimeras/Saljan_piedra_blanco1.png" style="width:35%">
									<img src="encimeras/Saljan_piedra_blanco2.png" style="width:55%">
								</div>
							</button>
							<button id="IKEA036" class="libre estilo5 materials_submenu_btn" onclick="setMaterialsImages(1,'CapasCocina/ENCIMERA/Piedra/enc_skararp_beigemate_efectopiedra.png');">
								<div style="display:flex;">
									<img src="encimeras/SkararpBeigeMateEfectoPiedra1.png" style="width:35%">
									<img src="encimeras/SkararpBeigeMateEfectoPiedra2.png" style="width:55%">
								</div>
							</button>
							<button id="IKEA037" class="libre estilo5 materials_submenu_btn" onclick="setMaterialsImages(1,'CapasCocina/ENCIMERA/Piedra/enc_skararp_blancomate_efectomarmol.png');">
								<div style="display:flex;">
									<img src="encimeras/SkararpBlancoMateEfectoMarmol1.png" style="width:35%">
									<img src="encimeras/SkararpBlancoMateEfectoMarmol2.png" style="width:55%">
								</div>
							</button>
							<button id="IKEA038" class="libre estilo5 materials_submenu_btn" onclick="setMaterialsImages(1,'CapasCocina/ENCIMERA/Piedra/enc_skararp_negromate_efectomarmol.png');">
								<div style="display:flex;">
									<img src="encimeras/SkararpNegroMateEfectoMarmol1.png" style="width:35%">
									<img src="encimeras/SkararpNegroMateEfectoMarmol2.png" style="width:55%">
								</div>
							</button>
							<button id="IKEA039" class="libre estilo3 estilo5 materials_submenu_btn" onclick="setMaterialsImages(1,'CapasCocina/ENCIMERA/Piedra/enc_skararp_negromate_efectopiedra.png');">
								<div style="display:flex;">
									<img src="encimeras/Skararp_Negro_Mate_efecto_piedra1.png" style="width:35%">
									<img src="encimeras/Skararp_Negro_Mate_efecto_piedra2.png" style="width:55%">
								</div>

							</button>

						</div>
						<button class="btn greenBtn fully" id="paredes" onclick="hideStep4SubMenus(this);">PAREDES</button>
						<div id="paredes_list" class="child_list" style="display:none;background:#fff;padding:10px;">

							<button class="blackBtn" id="pared_lateral_btn" onclick="hideWallsMenus(this);">
								PARED LATERAL PUERTA
							</button>
							<div class="pared_lateral_list">
								<div style="display:flex;">
									<button class="alicatadoBtn wall_options_btn" style="width: 50%;">
										<img src="iconos/alicatado_paredes.jpg">
										<p>ALICATADO</p>
									</button>
									<button class="enlucidoBtn wall_options_btn" style="width: 50%;">
										<img src="iconos/enlucido_paredes.jpg">
										<p>ENLUCIDO</p>
									</button>

								</div>
								<div class="options_alicatado_list">
									<div style="display:flex;">
										<button id="PLA00527628" class="libre estilo1 estilo2 estilo6 wall_options_btn" onclick="setMaterialsImages(2,'CapasCocina/ALICATADO/PARED_PUERTA/rev_blanco_brillo_30x60PARED_PUERTA.png');">
											<img src="ImagenesRevestimientos/ImagenesAlicatado/BlancoBrillo30x60.png" style="width:90%">
											<p>Blanco Brillo</p>
											<p>30x60cm</p>
										</button>
										<button id="PLA00527627" class="libre estilo1 estilo2 estilo6 wall_options_btn" onclick="setMaterialsImages(2,'CapasCocina/ALICATADO/PARED_PUERTA/rev_blanco_mate_30x60PARED_PUERTA.png');">
											<img src="ImagenesRevestimientos/ImagenesAlicatado/BlancoMate30x60.png" style="width:90%">
											<p>Blanco Mate</p>
											<p>30x60cm</p>
										</button>
									</div>
									<div style="display:flex;">
										<button id="IKEA040" class="libre estilo1 estilo2 estilo6 wall_options_btn" onclick="setMaterialsImages(2,'CapasCocina/ALICATADO/PARED_PUERTA/rev_boat_marfil_30x60PARED_PUERTA.png');">
											<img src="ImagenesRevestimientos/ImagenesAlicatado/BoatMarfil30x60.png" style="width:90%">
											<p>Blanco Marfil</p>
											<p>30x60cm</p>
										</button>
										<button id="PLA00406292" class="libre estilo1 estilo2 estilo6 wall_options_btn" onclick="setMaterialsImages(2,'CapasCocina/ALICATADO/PARED_PUERTA/rev_boat_perla_30x60PARED_PUERTA.png');">
											<img src="ImagenesRevestimientos/ImagenesAlicatado/BoatPerla30x60.png" style="width:90%">
											<p>Boat Perla</p>
											<p>30x60cm</p>
										</button>
									</div>

									<div style="display:flex;">
										<button id="PLA00117886" class="libre estilo1 estilo3 estilo4 estilo6 wall_options_btn" onclick="setMaterialsImages(2,'CapasCocina/ALICATADO/PARED_PUERTA/rev_biselado_blanco_mate_10x20PARED_PUERTA.png');">
											<img src="ImagenesRevestimientos/ImagenesAlicatado/BiseladoBlanco10x20.png" style="width:90%">
											<p>Biselado Blanco Mate</p>
											<p>10x20cm</p>
										</button>
										<button id="PLA00338006" class="libre estilo1 estilo3 estilo4 estilo6 wall_options_btn" onclick="setMaterialsImages(2,'CapasCocina/ALICATADO/PARED_PUERTA/rev_biselado_blanco_brillo_10x20PARED_PUERTA.png');">
											<img src="ImagenesRevestimientos/ImagenesAlicatado/BiseladoBlancoBrillo10x20.png" style="width:90%">
											<p>Biselado Blanco Brillo</p>
											<p>10x20cm</p>
										</button>
									</div>
									<div style="display:flex;">
										<button id="IKEA041" class="libre estilo1 estilo4 estilo5 estilo6 wall_options_btn" style="width:50%" onclick="setMaterialsImages(2,'CapasCocina/ALICATADO/PARED_PUERTA/rev_artisan_blanco_brillo_10x20PARED_PUERTA.png');">
											<img src="ImagenesRevestimientos/ImagenesAlicatado/AristanBlancoBrillo10x20.png" style="width:90%">
											<p>Aristan Blanco Brillo</p>
											<p>10x20cm</p>
										</button>
										<button id="PLA00479520" class="libre estilo3 wall_options_btn" style="width:50%" onclick="setMaterialsImages(2,'CapasCocina/ALICATADO/PARED_PUERTA/rev_biselado_negro_mate_10x20PARED_PUERTA.png');">
											<img src="ImagenesRevestimientos/ImagenesAlicatado/BiseladoNegroBrillo10x20.png" style="width:90%">
											<p>Biselado Negro Mate</p>
											<p>10x20cm</p>
										</button>
									</div>
								</div>
								<div class="options_enlucido_list">

									<div style="display:flex;">
										<button class="color_picker_btn" style="background-color:rgb(197, 208, 212);" onclick="setMaterialsImages(2,'CapasCocina/ENLUCIDO/Pared_Puerta/enlucido_gris_azulado_ok_pared_puerta.png');">

										</button>
										<button class="color_picker_btn" style="background-color:rgb(158, 156, 157);" onclick="setMaterialsImages(2,'CapasCocina/ENLUCIDO/Pared_Puerta/enlucido_gris_oscuro_ok_pared_puerta.png');">

										</button>
										<button class="color_picker_btn" style="background-color:rgb(255, 255, 255);" onclick="setMaterialsImages(2,'CapasCocina/ENLUCIDO/Pared_Puerta/enlucido_rodapie_blanco_pared_puerta.png');">

										</button>
									</div>
									<div style="display:flex;">
										<button class="color_picker_btn" style="background-color:rgb(182, 176, 1);" onclick="setMaterialsImages(2,'CapasCocina/ENLUCIDO/Pared_Puerta/enlucido_marron_ok_pared_puerta.png');">

										</button>
										<button class="color_picker_btn" style="background-color:rgb(231, 211, 197);" onclick="setMaterialsImages(2,'CapasCocina/ENLUCIDO/Pared_Puerta/enlucido_beige_ok_pared_puerta.png');">

										</button>
										<button class="color_picker_btn" style="background-color:rgb(242, 234, 225);" onclick="setMaterialsImages(2,'CapasCocina/ENLUCIDO/Pared_Puerta/enlucido_beige_claro_ok_pared_puerta.png');">

										</button>
									</div>
									<div style="display:flex;">
										<button class="color_picker_btn" style="background-color:rgb(103, 137, 126);" onclick="setMaterialsImages(2,'CapasCocina/ENLUCIDO/Pared_Puerta/enlucido_verde_ok_pared_puerta.png');">

										</button>
										<button class="color_picker_btn" style="background-color:rgb(175, 219, 222);" onclick="setMaterialsImages(2,'CapasCocina/ENLUCIDO/Pared_Puerta/enlucido_azul_ok_pared_puerta.png');">

										</button>
										<div style="width:33%;margin:15px;"></div>

									</div>
								</div>


							</div>
							<button class="blackBtn" id="pared_frontal_btn" onclick="hideWallsMenus(this);">
								PARED FRONTAL
							</button>
							<div class="pared_frontal_list">
								<div style="display:flex;align-items:center;justify-content:center; ">
									<button class="alicatadoBtn wall_options_btn" style="width: 50%;">
										<img src="iconos/alicatado_paredes.jpg">
										<p>ALICATADO</p>
									</button>


								</div>
								<div class="options_alicatado_list">

									<div style="display:flex;">
										<button id="PLA00527628" class="libre estilo1 estilo2 estilo6 wall_options_btn" onclick="setMaterialsImages(3,'CapasCocina/ALICATADO/PARED_FRONTAL/rev_blanco_brillo_30x60_pared_frontal.png');">
											<img src="ImagenesRevestimientos/ImagenesAlicatado/BlancoBrillo30x60.png" style="width:90%">
											<p>Blanco Brillo</p>
											<p>30x60cm</p>
										</button>
										<button id="PLA00527627" class="libre estilo1 estilo2 estilo6 wall_options_btn" onclick="setMaterialsImages(3,'CapasCocina/ALICATADO/PARED_FRONTAL/rev_blanco_mate_30x60_pared_frontal.png');">
											<img src="ImagenesRevestimientos/ImagenesAlicatado/BlancoMate30x60.png" style="width:90%">
											<p>Blanco Mate</p>
											<p>30x60cm</p>
										</button>
									</div>
									<div style="display:flex;">
										<button id="IKEA040" class="libre estilo1 estilo2 estilo6 wall_options_btn" onclick="setMaterialsImages(3,'CapasCocina/ALICATADO/PARED_FRONTAL/rev_boat_marfil_30x60_pared_frontal.png');">
											<img src="ImagenesRevestimientos/ImagenesAlicatado/BoatMarfil30x60.png" style="width:90%">
											<p>Blanco Marfil</p>
											<p>30x60cm</p>
										</button>
										<button id="PLA00406292" class="libre estilo1 estilo2 estilo6 wall_options_btn" onclick="setMaterialsImages(3,'CapasCocina/ALICATADO/PARED_FRONTAL/rev_boat_perla_30x60_pared_frontal.png');">
											<img src="ImagenesRevestimientos/ImagenesAlicatado/BoatPerla30x60.png" style="width:90%">
											<p>Boat Perla</p>
											<p>30x60cm</p>
										</button>
									</div>

									<div style="display:flex;">
										<button id="PLA00117886" class="libre estilo1 estilo3 estilo4 estilo6 wall_options_btn" onclick="setMaterialsImages(3,'CapasCocina/ALICATADO/PARED_FRONTAL/rev_biselado_blanco_mate_10x20_pared_frontal.png');">
											<img src="ImagenesRevestimientos/ImagenesAlicatado/BiseladoBlanco10x20.png" style="width:90%">
											<p>Biselado Blanco Mate</p>
											<p>10x20cm</p>
										</button>
										<button id="PLA00338006" class="libre estilo1 estilo3 estilo4 estilo6 wall_options_btn" onclick="setMaterialsImages(3,'CapasCocina/ALICATADO/PARED_FRONTAL/rev_biselado_blanco_brillo_10x20_pared_frontal.png');">
											<img src="ImagenesRevestimientos/ImagenesAlicatado/BiseladoBlancoBrillo10x20.png" style="width:90%">
											<p>Biselado Blanco Brillo</p>
											<p>10x20cm</p>
										</button>
									</div>
									<div style="display:flex;" style="width:50%">
										<button id="IKEA041" class="libre estilo1 estilo4 estilo5 estilo6 wall_options_btn" style="width:50%" onclick="setMaterialsImages(3,'CapasCocina/ALICATADO/PARED_FRONTAL/rev_artisan_blanco_brillo_10x20_pared_frontal.png');">
											<img src="ImagenesRevestimientos/ImagenesAlicatado/AristanBlancoBrillo10x20.png" style="width:90%">
											<p>Aristan Blanco Brillo</p>
											<p>10x20cm</p>
										</button>
										<button id="PLA00479520" class="libre estilo3 wall_options_btn" style="width:50%" onclick="setMaterialsImages(3,'CapasCocina/ALICATADO/PARED_FRONTAL/rev_biselado_negro_mate_10x20_pared_frontal.png');">
											<img src="ImagenesRevestimientos/ImagenesAlicatado/BiseladoNegroBrillo10x20.png" style="width:90%">
											<p>Biselado Negro Mate</p>
											<p>10x20cm</p>
										</button>
									</div>
								</div>


							</div>
							<button class="blackBtn" id="pared_ventana_btn" onclick="hideWallsMenus(this);">
								PARED LATERAL VENTANA
							</button>
							<div class="pared_ventana_list">
								<div style="display:flex;">
									<button class="alicatadoBtn wall_options_btn" style="width: 50%;">
										<img src="iconos/alicatado_paredes.jpg">
										<p>ALICATADO</p>
									</button>
									<button class="enlucidoBtn wall_options_btn" style="width: 50%;">
										<img src="iconos/enlucido_paredes.jpg">
										<p>ENLUCIDO</p>
									</button>

								</div>
								<div class="options_alicatado_list">
									<div style="display:flex;">
										<button id="PLA00527628" class="libre estilo1 estilo2 estilo6 wall_options_btn" onclick="setMaterialsImages(4,'CapasCocina/ALICATADO/PARED_VENTANA/rev_blanco_brillo_30x60PARED_VENTANA.png');">
											<img src="ImagenesRevestimientos/ImagenesAlicatado/BlancoBrillo30x60.png" style="width:90%">
											<p>Blanco Brillo</p>
											<p>30x60cm</p>
										</button>
										<button id="PLA00527627" class="libre estilo1 estilo2 estilo6 wall_options_btn" onclick="setMaterialsImages(4,'CapasCocina/ALICATADO/PARED_VENTANA/rev_blanco_mate_30x60PARED_VENTANA.png');">
											<img src="ImagenesRevestimientos/ImagenesAlicatado/BlancoMate30x60.png" style="width:90%">
											<p>Blanco Mate</p>
											<p>30x60cm</p>
										</button>
									</div>
									<div style="display:flex;">
										<button id="IKEA040" class="libre estilo1 estilo2 estilo6 wall_options_btn" onclick="setMaterialsImages(4,'CapasCocina/ALICATADO/PARED_VENTANA/rev_boat_marfil_30x60PARED_VENTANA.png');">
											<img src="ImagenesRevestimientos/ImagenesAlicatado/BoatMarfil30x60.png" style="width:90%">
											<p>Blanco Marfil</p>
											<p>30x60cm</p>
										</button>
										<button id="PLA00406292" class="libre estilo1 estilo2 estilo6 wall_options_btn" onclick="setMaterialsImages(4,'CapasCocina/ALICATADO/PARED_VENTANA/rev_boat_perla_30x60PARED_VENTANA.png');">
											<img src="ImagenesRevestimientos/ImagenesAlicatado/BoatPerla30x60.png" style="width:90%">
											<p>Boat Perla</p>
											<p>30x60cm</p>
										</button>
									</div>

									<div style="display:flex;">
										<button id="PLA00117886" class="libre estilo1 estilo3 estilo4 estilo6 wall_options_btn" onclick="setMaterialsImages(4,'CapasCocina/ALICATADO/PARED_VENTANA/rev_biselado_blanco_mate_10x20PARED_VENTANA.png');">
											<img src="ImagenesRevestimientos/ImagenesAlicatado/BiseladoBlanco10x20.png" style="width:90%">
											<p>Biselado Blanco Mate</p>
											<p>10x20cm</p>
										</button>
										<button id="PLA00338006" class="libre estilo1 estilo3 estilo4 estilo6 wall_options_btn" onclick="setMaterialsImages(4,'CapasCocina/ALICATADO/PARED_VENTANA/rev_biselado_blanco_brillo_10x20PARED_VENTANA.png');">
											<img src="ImagenesRevestimientos/ImagenesAlicatado/BiseladoBlancoBrillo10x20.png" style="width:90%">
											<p>Biselado Blanco Brillo</p>
											<p>10x20cm</p>
										</button>
									</div>
									<div style="display:flex;">
										<button id="IKEA041" class="libre estilo1 estilo4 estilo5 estilo6 wall_options_btn" style="width:50%" onclick="setMaterialsImages(4,'CapasCocina/ALICATADO/PARED_VENTANA/rev_artisan_blanco_brillo_10x20PARED_VENTANA.png');">
											<img src="ImagenesRevestimientos/ImagenesAlicatado/AristanBlancoBrillo10x20.png" style="width:90%">
											<p>Aristan Blanco Brillo</p>
											<p>10x20cm</p>
										</button>
										<button id="PLA00479520" class="libre estilo3 wall_options_btn" style="width:50%" onclick="setMaterialsImages(4,'CapasCocina/ALICATADO/PARED_VENTANA/rev_biselado_negro_mate_10x20PARED_VENTANA.png');">
											<img src="ImagenesRevestimientos/ImagenesAlicatado/BiseladoNegroBrillo10x20.png" style="width:90%">
											<p>Biselado Negro Mate</p>
											<p>10x20cm</p>
										</button>
									</div>
								</div>
								<div class="options_enlucido_list">
									<div style="display:flex;">
										<button class="color_picker_btn" style="background-color:rgb(197, 208, 212);" onclick="setMaterialsImages(4,'CapasCocina/ENLUCIDO/Pared_Ventana/enlucido_gris_azulado_ok_pared_ventana.png');">

										</button>
										<button class="color_picker_btn" style="background-color:rgb(158, 156, 157);" onclick="setMaterialsImages(4,'CapasCocina/ENLUCIDO/Pared_Ventana/enlucido_gris_oscuro_ok_pared_ventana.png');">

										</button>
										<button class="color_picker_btn" style="background-color:rgb(255, 255, 255);" onclick="setMaterialsImages(4,'CapasCocina/ENLUCIDO/Pared_Ventana/enlucido_rodapie_blanco_pared_ventana.png');">

										</button>
									</div>
									<div style="display:flex;">
										<button class="color_picker_btn" style="background-color:rgb(182, 176, 1);" onclick="setMaterialsImages(4,'CapasCocina/ENLUCIDO/Pared_Ventana/enlucido_marron_ok_pared_ventana.png');">

										</button>
										<button class="color_picker_btn" style="background-color:rgb(231, 211, 197);" onclick="setMaterialsImages(4,'CapasCocina/ENLUCIDO/Pared_Ventana/enlucido_beige_ok_pared_ventana.png');">

										</button>
										<button class="color_picker_btn" style="background-color:rgb(242, 234, 225);" onclick="setMaterialsImages(4,'CapasCocina/ENLUCIDO/Pared_Ventana/enlucido_beige_claro_ok_pared_ventana.png');">

										</button>
									</div>
									<div style="display:flex;">
										<button class="color_picker_btn" style="background-color:rgb(103, 137, 126);" onclick="setMaterialsImages(4,'CapasCocina/ENLUCIDO/Pared_Ventana/enlucido_verde_ok_pared_ventana.png');">

										</button>
										<button class="color_picker_btn" style="background-color:rgb(175, 219, 222);" onclick="setMaterialsImages(4,'CapasCocina/ENLUCIDO/Pared_Ventana/enlucido_azul_ok_pared_ventana.png');">

										</button>
										<div style="width:33%;margin:15px;"></div>

									</div>
								</div>
							</div>
						</div>

						<button class="btn greenBtn fully " id="suelo" onclick="hideStep4SubMenus(this);">SUELO</button>
						<div id="suelo_list" class="child_list" style="display:none;background:#fff;padding:10px;">

							<div style="display:flex;">
								<button id="PLA00408212" class="libre estilo6 wall_options_btn" style="width:30%; margin-left:1.5%;margin-right: 1.5%;" onclick="setMaterialsImages(5,'CapasCocina/PAVIMENTO/pav_berkeley_45x45.png');">
									<img src="ImagenesRevestimientos/ImagenesPavimento/Berkeley45x45.png" style="margin:0px;">
									<p>Berkeley</p>
									<p>45x45cm</p>
								</button>
								<button id="PLA00408213" class="libre estilo5 wall_options_btn" style="width:30%; margin-left:1.5%;margin-right: 1.5%;" onclick="setMaterialsImages(5,'CapasCocina/PAVIMENTO/pav_checker_45x45_corregido.png');">
									<img src="ImagenesRevestimientos/ImagenesPavimento/Checker45x45.png" style="margin:0px;">
									<p>Checker</p>
									<p>45x45cm</p>
								</button>
								<button id="PLA00337901" class="libre estilo1 estilo2 estilo3 wall_options_btn" style="width:30%; margin-left:1.5%;margin-right: 1.5%;" onclick="setMaterialsImages(5,'CapasCocina/PAVIMENTO/pav_fosterlight_60x60.png');">
									<img src="ImagenesRevestimientos/ImagenesPavimento/FosterLight60x60.png" style="margin:0px;">
									<p>Foster Light</p>
									<p>60x60cm</p>
								</button>
							</div>
							<div style="display:flex;">
								<button id="PLA00406302" class="libre estilo4 wall_options_btn" style="width:30%; margin-left:1.5%;margin-right: 1.5%;" onclick="setMaterialsImages(5,'CapasCocina/PAVIMENTO/pav_teja_33x33.png');">
									<img src="ImagenesRevestimientos/ImagenesPavimento/IrtaTeja33.3x33.3.png" style="margin:0px;">
									<p>Irta Teja</p>
									<p>33.33x33.33cm</p>
								</button>
								<button id="PLA00337899" class="libre estilo1 estilo5 wall_options_btn" style="width:30%; margin-left:1.5%;margin-right: 1.5%;" onclick="setMaterialsImages(5,'CapasCocina/PAVIMENTO/pav_meiersand_60x60_corregido.png');">
									<img src="ImagenesRevestimientos/ImagenesPavimento/MeierSand60x60.png" style="margin:0px;">
									<p>Meier Sand</p>
									<p>60x60cm</p>
								</button>
								<button id="PLA00479814" class="libre estilo5 wall_options_btn" style="width:30%; margin-left:1.5%;margin-right: 1.5%;" onclick="setMaterialsImages(5,'CapasCocina/PAVIMENTO/pav_naoscalacatta_60x60.png');">
									<img src="ImagenesRevestimientos/ImagenesPavimento/NaosCalacatta60x60.png" style="margin:0px;">
									<p>Naos Calacatta</p>
									<p>60x60cm</p>
								</button>
							</div>
							<div style="display:flex;">
								<button id="PLA00407262" class="libre estilo6 wall_options_btn" style="width:30%; margin-left:1.5%;margin-right: 1.5%;" onclick="setMaterialsImages(5,'CapasCocina/PAVIMENTO/pav_powder_deco_60x60.png');">
									<img src="ImagenesRevestimientos/ImagenesPavimento/PowderColdDeco60x60.png" style="margin:0px;">
									<p>Powder Cold Deco</p>
									<p>60x60cm</p>
								</button>
								<button id="PLA00407328" class="libre estilo3 wall_options_btn" style="width:30%; margin-left:1.5%;margin-right: 1.5%;" onclick="setMaterialsImages(5,'CapasCocina/PAVIMENTO/pav_powder_plumb_60x60.png');">
									<img src="ImagenesRevestimientos/ImagenesPavimento/PowderPlumb60x60.png" style="margin:0px;">
									<p>Powder Plumb</p>
									<p>60x60cm</p>
								</button>
								<button id="PLA00407149" class="libre estilo1 wall_options_btn" style="width:30%; margin-left:1.5%;margin-right: 1.5%;" onclick="setMaterialsImages(5,'CapasCocina/PAVIMENTO/pav_powder_tortora2_60x60_corregido.png');">
									<img src="ImagenesRevestimientos/ImagenesPavimento/PowderTortora60x60.png" style="margin:0px;">
									<p>Powder Tortora</p>
									<p>60x60cm</p>
								</button>
							</div>
							<div style="display:flex;">
								<button id="PLA00527711" class="libre estilo1 wall_options_btn" style="width:30%; margin-left:1.5%;margin-right: 1.5%;" onclick="setMaterialsImages(5,'CapasCocina/PAVIMENTO/pav_rotterdam_gris_45x45.png');">
									<img src="ImagenesRevestimientos/ImagenesPavimento/RotterdamGris45x45.png" style="margin:0px;">
									<p>Rotterdam Gris</p>
									<p>45x45cm</p>
								</button>

							</div>
							<div style="width:90%;margin: auto;">
								<button id="PLA00338026" class="libre estilo1 estilo2 estilo5 floor_panel_btn wall_options_btn" onclick="setMaterialsImages(5,'CapasCocina/PAVIMENTO/pav_pecan_beige_23x120.png');">
									<img src="ImagenesRevestimientos/ImagenesPavimento/PecanBeige23x120.png">
									<p>Pecan Beige 23,3x120cm</p>
								</button>
							</div>
							<div style="width:90%;margin: auto;">
								<button id="PLA00464970" class="libre estilo1 estilo2 estilo5 floor_panel_btn wall_options_btn" onclick="setMaterialsImages(5,'CapasCocina/PAVIMENTO/pav_pecan_gris_23x120.png');">
									<img src="ImagenesRevestimientos/ImagenesPavimento/PecanGris 23x120.png">
									<p>Pecan Taupe 23,3x120cm</p>
								</button>

							</div>
						</div>

						<button class="btn greenBtn fully " id="rodapie" onclick="hideStep4SubMenus(this);">RODAPIE</button>
						<div id="rodapie_list" class="child_list" style="display:none;background:#fff;padding:10px;">

							<button class="blackBtn" id="pared_ventana_btn" onclick="hideRodapieMenus();$('.rodapie_pared_puerta_list').show();">
								RODAPIE PARED PUERTA
							</button>
							<div class="rodapie_pared_puerta_list">
								<div style="display:flex;">
									<button id="IKEA042" class="libre estilo1 estilo5 floor_panel_btn" onclick="setMaterialsImages(6,'CapasCocina/RODAPIE/PARED_PUERTA/rod_meiersand_8x60PAREDPUERTA.png');">
										<img src="CapasCocina/REJUNTES/RodapieMeierSand.png" />
										<p>Meier Sand 8x60cm</p>
									</button>
									<button id="PLA00409147" class="libre estilo3 floor_panel_btn" onclick="setMaterialsImages(6,'CapasCocina/RODAPIE/PARED_PUERTA/rod_powerplumb_8x60PAREDPUERTA.png');">
										<img src="CapasCocina/REJUNTES/RodapiePowderPlumb.png" />
										<p>Powder Plumb 8x60cm</p>
									</button>

								</div>
							</div>
							<button class="blackBtn" id="pared_ventana_btn" onclick="hideRodapieMenus();$('.rodapie_pared_ventana_list').show();">
								RODAPIE PARED VENTANA
							</button>
							<div class="rodapie_pared_ventana_list">
								<div style="display:flex;">
									<button id="IKEA042_bis" class="libre estilo1 estilo5 floor_panel_btn" onclick="setMaterialsImages(7,'CapasCocina/RODAPIE/PARED_VENTANA/Trod_meiersand_8x60PAREDVENTANA.png');">
										<img src="CapasCocina/REJUNTES/RodapieMeierSand.png" />
										<p>Meier Sand 8x60cm</p>
									</button>
									<button id="PLA00409147_bis" class="libre estilo3 floor_panel_btn" onclick="setMaterialsImages(7,'CapasCocina/RODAPIE/PARED_VENTANA/rod_powerplumb_8x60PAREDVENTANA.png');">
										<img src="CapasCocina/REJUNTES/RodapiePowderPlumb.png" />
										<p>Powder Plumb 8x60cm</p>
									</button>

								</div>

							</div>
						</div>
						<button class="btn greenBtn fully " id="RYL" onclick="hideStep4SubMenus(this);">REJUNTE Y LISTELO</button>
						<div id="RYL_list" class="child_list" style="display:none;background:#fff;padding:10px;margin: 0 auto;">
							<button class="blackBtn" id="pared_ventana_btn" onclick="hideRYLMenus();$('.rejunte_pared_list').show();">
								REJUNTE PARA PARED
							</button>
							<!-- // zra9                                 REJUNTE PARA PARED                                         -->
							<div class="rejunte_pared_list" style="display:none;background:#fff;padding:10px;">
								<div style="display: grid;gap: 15px;grid-template-columns: repeat(3, 1fr);width: 100%;">
									<div class="RYLbuttonContainerPared">
										<button id="PLA00104647" class="color_btn RYLbuttonContainer" style="background-color:rgb(255, 255, 255);" onclick="setMaterialsImages(8,'');">
										</button>
										<p>Blanco</p>
									</div>
									<div class="RYLbuttonContainerPared">
										<button id="PLA00194469" class="color_btn RYLbuttonContainer"" style="background-color:rgb(197, 208, 212);" onclick="setMaterialsImages(8,'');">
										</button>
										<p>Niebla</p>
									</div>
									<div class="RYLbuttonContainerPared">
										<button id="PLA00008970" class="color_btn RYLbuttonContainer"" style="background-color:rgb(213, 213, 213);" onclick="setMaterialsImages(8,'');">
										</button>
										<p>Plata</p>
									</div>
									<div class="RYLbuttonContainerPared">
										<button id="PLA00008968" class="color_btn RYLbuttonContainer"" style="background-color:rgb(204, 203, 198);" onclick="setMaterialsImages(8,'');">
										</button>
										<p>Perla</p>
									</div>
									<div class="RYLbuttonContainerPared">
										<button id="PLA00204048" class="color_btn RYLbuttonContainer" style="background-color:rgb(178, 180, 177);" onclick="setMaterialsImages(8,'');">
										</button>
										<p>Cemento</p>
									</div>
									<div class="RYLbuttonContainerPared">
										<button id="PLA00008962" class="color_btn RYLbuttonContainer" style="background-color:rgb(137, 141, 142);" onclick="setMaterialsImages(8,'');">
										</button>
										<p>Grafito</p>
									</div>
									<div class="RYLbuttonContainerPared">
										<button id="PLA00008966" class="color_btn RYLbuttonContainer" style="background-color:rgb(0, 0, 0);" onclick="setMaterialsImages(8,'');">
										</button>
										<p>Negro</p>
									</div>
									<div class="RYLbuttonContainerPared">
										<button id="PLA00008969" class="color_btn RYLbuttonContainer" style="background-color:rgb(233, 224, 209);" onclick="setMaterialsImages(8,'');">
										</button>
										<p>Piedra</p>
									</div>
									<div class="RYLbuttonContainerPared">
										<button id="PLA00009567" class="color_btn RYLbuttonContainer" style="background-color:rgb(246, 245, 202);" onclick="setMaterialsImages(8,'');">
										</button>
										<p>Marfil</p>
									</div>
									<div class="RYLbuttonContainerPared">
										<button id="PLA00008957" class="color_btn RYLbuttonContainer" style="background-color:rgb(234, 229, 209);" onclick="setMaterialsImages(8,'');">
										</button>
										<p>Beige Cl.</p>
									</div>
									<div class="RYLbuttonContainerPared">
										<button id="PLA00540862" class="color_btn RYLbuttonContainer" style="background-color:rgb(218, 213, 171);" onclick="setMaterialsImages(8,'');">
										</button>
										<p>Beige</p>
									</div>
									<div class="RYLbuttonContainerPared">
										<button id="PLA00200481" class="color_btn RYLbuttonContainer" style="background-color:rgb(202, 199, 166);" onclick="setMaterialsImages(8,'');">
										</button>
										<p>Nuez</p>
									</div>
									<div class="RYLbuttonContainerPared">
										<button id="PLA00009558" class="color_btn RYLbuttonContainer" style="background-color:rgb(212, 191, 148);" onclick="setMaterialsImages(8,'');">
										</button>
										<p>Chocolate</p>
									</div>
									<div class="RYLbuttonContainerPared">
										<button id="PLA00009574" class="color_btn RYLbuttonContainer" style="background-color:rgb(195, 159, 137);" onclick="setMaterialsImages(8,'');">
										</button>
										<p>Tabaco</p>
									</div>
									<div class="RYLbuttonContainerPared">
										<button id="PLA00210719" class="color_btn RYLbuttonContainer" style="background-color:rgb(202, 184, 162);" onclick="setMaterialsImages(8,'');">
										</button>
										<p>Madera</p>
									</div>
									<div class="RYLbuttonContainerPared">
										<button id="PLA00009562" class="color_btn RYLbuttonContainer" style="background-color:rgb(150, 107, 88);" onclick="setMaterialsImages(8,'');">
										</button>
										<p>Cuero</p>
									</div>
									<div class="RYLbuttonContainerPared">
										<button id="PLA00178858" class="color_btn RYLbuttonContainer" style="background-color:rgb(138, 121, 101);" onclick="setMaterialsImages(8,'');">
										</button>
										<p>Wengue</p>
									</div>
									<!-- sfar: no estan los datos -->
									<!-- <div class="RYLbuttonContainer RYLbuttonContainerPared">
										<button id="" class="color_btn" style="background-color:rgb(221, 173, 135);" onclick="setMaterialsImages(8,'');">
										</button>
										<p>Ladrillo</p>
									</div>
									<div class="RYLbuttonContainer RYLbuttonContainerPared">
										<button id="" class="color_btn" style="background-color:rgb(206, 143, 138);" onclick="setMaterialsImages(8,'');">
										</button>
										<p>Terracota</p>
									</div>
									<div class="RYLbuttonContainer RYLbuttonContainerPared">
										<button id="" class="color_btn" style="background-color:rgb(155, 78, 68);" onclick="setMaterialsImages(8,'');">
										</button>
										<p>Cereza</p>
									</div>
									<div class="RYLbuttonContainer RYLbuttonContainerPared">
										<button id="" class="color_btn" style="background-color:rgb(250, 217, 114);" onclick="setMaterialsImages(8,'');">
										</button>
										<p>Girasol</p>
									</div>
									<div class="RYLbuttonContainer RYLbuttonContainerPared">
										<button id="" class="color_btn" style="background-color:rgb(173, 219, 144);" onclick="setMaterialsImages(8,'');">
										</button>
										<p>Menta</p>
									</div>
									<div class="RYLbuttonContainer RYLbuttonContainerPared">
										<button id="" class="color_btn" style="background-color:rgb(126, 154, 193);" onclick="setMaterialsImages(8,'');">
										</button>
										<p>Marino</p>
									</div>
									<div class="RYLbuttonContainer RYLbuttonContainerPared">
										<button id="" class="color_btn" style="background-color:rgb(168, 212, 239);" onclick="setMaterialsImages(8,'');">
										</button>
										<p>Celeste</p>
									</div> -->
								</div>
							</div>
							<!-- // zra9                                  REJUNTE PARA SUELO                                        -->
							<button class="blackBtn" id="pared_ventana_btn" onclick="hideRYLMenus();$('.rejunte_suelo_list').show();">
								REJUNTE PARA SUELO
							</button>
							<div class="rejunte_suelo_list" style="display:none;background:#fff;padding:10px;">
								<div style="display: grid;gap: 15px;grid-template-columns: repeat(3, 1fr);width: 100%;">
									<div class="RYLbuttonContainerSuelo">
										<button id="PLA00104647" class="color_btn RYLbuttonContainer" style="background-color:rgb(255, 255, 255);" onclick="setMaterialsImages(9,'');">
										</button>
										<p>Blanco</p>
									</div>
									<div class="RYLbuttonContainerSuelo">
										<button id="PLA00194469" class="color_btn RYLbuttonContainer" style="background-color:rgb(197, 208, 212);" onclick="setMaterialsImages(9,'');">
										</button>
										<p>Niebla</p>
									</div>
									<div class="RYLbuttonContainerSuelo">
										<button id="PLA00008970" class="color_btn RYLbuttonContainer" style="background-color:rgb(213, 213, 213);" onclick="setMaterialsImages(9,'');">
										</button>
										<p>Plata</p>
									</div>
									<div class="RYLbuttonContainerSuelo">
										<button id="PLA00008968" class="color_btn RYLbuttonContainer" style="background-color:rgb(204, 203, 198);" onclick="setMaterialsImages(9,'');">
										</button>
										<p>Perla</p>
									</div>
									<div class="RYLbuttonContainerSuelo">
										<button id="PLA00204048" class="color_btn RYLbuttonContainer" style="background-color:rgb(178, 180, 177);" onclick="setMaterialsImages(9,'');">
										</button>
										<p>Cemento</p>
									</div>
									<div class="RYLbuttonContainerSuelo">
										<button id="PLA00008962" class="color_btn RYLbuttonContainer" style="background-color:rgb(137, 141, 142);" onclick="setMaterialsImages(9,'');">
										</button>
										<p>Grafito</p>
									</div>
									<div class="RYLbuttonContainerSuelo">
										<button id="PLA00008966" class="color_btn RYLbuttonContainer" style="background-color:rgb(0, 0, 0);" onclick="setMaterialsImages(9,'');">
										</button>
										<p>Negro</p>
									</div>
									<div class="RYLbuttonContainerSuelo">
										<button id="PLA00008969" class="color_btn RYLbuttonContainer" style="background-color:rgb(233, 224, 209);" onclick="setMaterialsImages(9,'');">
										</button>
										<p>Piedra</p>
									</div>
									<div class="RYLbuttonContainerSuelo">
										<button id="PLA00009567" class="color_btn RYLbuttonContainer" style="background-color:rgb(246, 245, 202);" onclick="setMaterialsImages(9,'');">
										</button>
										<p>Marfil</p>
									</div>
									<div class="RYLbuttonContainerSuelo">
										<button id="PLA00008957" class="color_btn RYLbuttonContainer" style="background-color:rgb(234, 229, 209);" onclick="setMaterialsImages(9,'');">
										</button>
										<p>Beige Cl.</p>
									</div>
									<div class="RYLbuttonContainerSuelo">
										<button id="PLA00540862" class="color_btn RYLbuttonContainer" style="background-color:rgb(218, 213, 171);" onclick="setMaterialsImages(9,'');">
										</button>
										<p>Beige</p>
									</div>
									<div class="RYLbuttonContainerSuelo">
										<button id="PLA00200481" class="color_btn RYLbuttonContainer" style="background-color:rgb(202, 199, 166);" onclick="setMaterialsImages(9,'');">
										</button>
										<p>Nuez</p>
									</div>
									<div class="RYLbuttonContainerSuelo">
										<button id="PLA00009558" class="color_btn RYLbuttonContainer" style="background-color:rgb(212, 191, 148);" onclick="setMaterialsImages(9,'');">
										</button>
										<p>Chocolate</p>
									</div>
									<div class="RYLbuttonContainerSuelo">
										<button id="PLA00009574" class="color_btn RYLbuttonContainer" style="background-color:rgb(195, 159, 137);" onclick="setMaterialsImages(9,'');">
										</button>
										<p>Tabaco</p>
									</div>
									<div class="RYLbuttonContainerSuelo">
										<button id="PLA00210719" class="color_btn RYLbuttonContainer" style="background-color:rgb(202, 184, 162);" onclick="setMaterialsImages(9,'');">
										</button>
										<p>Madera</p>
									</div>
									<div class="RYLbuttonContainerSuelo">
										<button id="PLA00009562" class="color_btn RYLbuttonContainer" style="background-color:rgb(150, 107, 88);" onclick="setMaterialsImages(9,'');">
										</button>
										<p>Cuero</p>
									</div>
									<div class="RYLbuttonContainerSuelo">
										<button id="PLA00178858" class="color_btn RYLbuttonContainer" style="background-color:rgb(138, 121, 101);" onclick="setMaterialsImages(9,'');">
										</button>
										<p>Wengue</p>
									</div>
									<!-- sfar: no estan los datos -->
									<!-- <div class="RYLbuttonContainer RYLbuttonContainerSuelo">
										<button id="" class="color_btn" style="background-color:rgb(221, 173, 135);" onclick="setMaterialsImages(9,'');">
										</button>
										<p>Ladrillo</p>
									</div>
									<div class="RYLbuttonContainer RYLbuttonContainerSuelo">
										<button id="" class="color_btn" style="background-color:rgb(206, 143, 138);" onclick="setMaterialsImages(9,'');">
										</button>
										<p>Terracota</p>
									</div>
									<div class="RYLbuttonContainer RYLbuttonContainerSuelo">
										<button id="" class="color_btn" style="background-color:rgb(155, 78, 68);" onclick="setMaterialsImages(9,'');">
										</button>
										<p>Cereza</p>
									</div>
									<div class="RYLbuttonContainer RYLbuttonContainerSuelo">
										<button id="" class="color_btn" style="background-color:rgb(250, 217, 114);" onclick="setMaterialsImages(9,'');">
										</button>
										<p>Girasol</p>
									</div>
									<div class="RYLbuttonContainer RYLbuttonContainerSuelo">
										<button id="" class="color_btn" style="background-color:rgb(173, 219, 144);" onclick="setMaterialsImages(9,'');">
										</button>
										<p>Menta</p>
									</div>
									<div class="RYLbuttonContainer RYLbuttonContainerSuelo">
										<button id="" class="color_btn" style="background-color:rgb(126, 154, 193);" onclick="setMaterialsImages(9,'');">
										</button>
										<p>Marino</p>
									</div>
									<div class="RYLbuttonContainer RYLbuttonContainerSuelo">
										<button id="" class="color_btn" style="background-color:rgb(168, 212, 239);" onclick="setMaterialsImages(9,'');">
										</button>
										<p>Celeste</p>
									</div> -->
								</div>
							</div>
							<!-- // zra9                                      LISTELOS                                              -->
							<button class="blackBtn" id="pared_ventana_btn" onclick="hideRYLMenus();$('.listelos_list').show();">
								LISTELOS
							</button>
							<div class="listelos_list" style="display:none;background:#fff;padding:10px;">
								<button id="PLA00125082" class="flexBtn">
									<img src="CapasCocina/REJUNTES/Listelo_aluminio_plata mate_10x12mm2_6m.png" />
									<div>
										<p>Listelo Al. Plata</p>
										<p>Mate 10x12mm.</p>
									</div>
									<div class="unidades_elemento" style="display: none;">
										<form class="form_unidades" name="listelos" method="POST" action="#">
											<input type="text" name="elemento" style="display:none" value="PLA00125082">
											<input type="range" value="1" min="1" max="30" step="1" oninput="this.nextElementSibling.value = this.value" class="numero_listados" name="unidades">
											Unidades: <output style="display:inline-block"></output>
										</form>
									</div>
								</button>
								<button id="PLA00125084" class="flexBtn">
									<img src="CapasCocina/REJUNTES/Listelo_aluminio_plata_brillo10x12mm2_6m.png" />
									<div>
										<p>Listelo Al. Plata</p>
										<p>Brillo 10x12mm.</p>
									</div>
									<div class="unidades_elemento" style="display: none;">
										<form class="form_unidades" name="listelos" method="POST" action="#">
											<input type="text" name="elemento" style="display:none" value="PLA00125084">
											<input type="range" value="1" min="1" max="30" step="1" oninput="this.nextElementSibling.value = this.value" class="numero_listados" name="unidades">
											Unidades: <output style="display:inline-block"></output>
										</form>
									</div>
								</button>
								<button id="PLA00296790" class="flexBtn">
									<img src="CapasCocina/REJUNTES/Listelo_aluminio_lacado_en_blanco_12x12mm2_6m.png" />
									<div>
										<p>Listelo Al. Lacado</p>
										<p>Blanco 12x12mm.</p>
									</div>
									<div class="unidades_elemento" style="display: none;">
										<form class="form_unidades" name="listelos" method="POST" action="#">
											<input type="text" name="elemento" style="display:none" value="PLA00296790">
											<input type="range" value="1" min="1" max="30" step="1" oninput="this.nextElementSibling.value = this.value" class="numero_listados" name="unidades">
											Unidades: <output style="display:inline-block"></output>
										</form>
									</div>
								</button>
							</div>
						</div>
						<button class="btn greenBtn fully " id="carpinteria_mode" onclick="hideStep4SubMenus(this);">CARPINTERIA</button>
						<div id="carpinteria_list" class="child_list" style="display:none;background:#fff;padding:10px;">
							<button class="blackBtn" id="carpinteria_mode" onclick="hideCarpentryMenus();$('.door_list').show();">PUERTAS</button>
							<div class="door_list">
								<div style="display:flex;">
									<button id="IKEA043" class="libre estilo1 estilo2 estilo3 estilo4 estilo5 estilo6 wall_options_btn" style="width:45%; margin-left:2.5%;margin-right: 2.5%;" onclick="setMaterialsImages(11,'CapasCocina/PUERTA/carp_blanco.png');">
										<img src="CapasCocina/PUERTA/iconos/carp_blanco.png">
										<p>Puerta Blanca</p>
									</button>
									<button id="IKEA044" class="libre estilo1 estilo2 estilo3 estilo4 estilo5 estilo6 wall_options_btn" style="width:45%; margin-left:2.5%;margin-right: 2.5%;" onclick="setMaterialsImages(11,'CapasCocina/PUERTA/carp_roble.png');">
										<img src="CapasCocina/PUERTA/iconos/carp_roble.png">
										<p>Puerta Roble</p>

									</button>
								</div>
								<div style="display:flex;">
									<button id="IKEA045" class="libre estilo1 estilo2 estilo3 estilo4 estilo5 estilo6 wall_options_btn" style="width:45%; margin-left:2.5%;margin-right: 2.5%;" onclick="setMaterialsImages(11,'CapasCocina/PUERTA/carp_roble2.png');">
										<img src="CapasCocina/PUERTA/iconos/carp_roble2.png">
										<p>Puerta Roble</p>

									</button>
									<button id="IKEA046" class="libre estilo1 estilo2 estilo3 estilo4 estilo5 estilo6 wall_options_btn" style="width:45%; margin-left:2.5%;margin-right: 2.5%;" onclick="setMaterialsImages(11,'CapasCocina/PUERTA/carp_haya.png');">
										<img src="CapasCocina/PUERTA/iconos/carp_haya.png">
										<p>Puerta Haya</p>

									</button>

								</div>
							</div>
							<button class="blackBtn " id="carpinteria_mode" onclick="hideCarpentryMenus();$('.window_list').show();">VENTANAS</button>
							<div class="window_list">
								<div style="display:grid;grid-template-columns: auto auto;">
									<button id="IKEA047" class="libre estilo1 estilo2 estilo3 estilo4 estilo5 estilo6 carpentry_options_btn" onclick="setMaterialsImages(12,'CapasCocina/VENTANA/carp_ext_blanco.png');">
										<img src="CapasCocina/VENTANA/iconos/carp_ext_blanco.png" style="width:90%; margin: auto;">
										<p>Ventana Blanca</p>

									</button>
									<button id="IKEA048" class="libre estilo1 estilo2 estilo3 estilo4 estilo5 estilo6 carpentry_options_btn" onclick="setMaterialsImages(12,'CapasCocina/VENTANA/carp_ext_negro.png');">
										<img src="CapasCocina/VENTANA/iconos/carp_ext_negro.png" style="width:90%; margin: auto;">
										<p>Ventana Negra</p>
									</button>
									<button id="IKEA049" class="libre estilo1 estilo2 estilo3 estilo4 estilo5 estilo6 carpentry_options_btn" onclick="setMaterialsImages(12,'CapasCocina/VENTANA/carp_ext_haya.png');">
										<img src="CapasCocina/VENTANA/iconos/carp_ext_haya.png" style="width:90%; margin: auto;">
										<p>Ventana Haya</p>
									</button>
									<div style="width:45%; margin-left:2.5%;margin-right: 2.5%;">
									</div>
								</div>
							</div>

						</div>

					</div>
				</div>

				<div id="opciones_mobiliario" style="display:none">
					<p style="font-size:12px">* Gire o elimine el mobiliario dando click al elemento una vez lo haya añadido al plano</p>

					<!--//? modulos bajos -->
					<div class="object tipo_mobiliario" onclick="hideStep2Menus(this);">MÓDULOS BAJOS</div>
					<!-- class objetos -->
					<div id="modulos_bajos" class="father_list" style="display:none">

						<div class="greenBtn" onclick="hideStep2SubMenus(this);">Profundidad 60cm</div>
						<div class="child_list">
							<ul class="owl-carousel owl-theme" style="display: block;">
								<?php
									$imagenes_modulos_bajos = array(
										array("src" => "modulos_bajos/60cm/lavadora.png", "id" => "lavadora_bajo"),
										array("src" => "modulos_bajos/60cm/secadora.png", "id" => "secadora_bajo"),
										array("src" => "modulos_bajos/60cm/lavavajillas.png", "id" => "lavavajillas_bajo"),
										array("src" => "modulos_bajos/60cm/lavavajillas-45.png", "id" => "lavavajillas_45"),
										array("src" => "modulos_bajos/60cm/placa-electrica-80.png", "id" => "placa-electrica80"),
										array("src" => "modulos_bajos/60cm/placa-electrica-60.png", "id" => "placa-electrica60"),
										array("src" => "modulos_bajos/60cm/placa-electrica-horno-60.png", "id" => "placa-electrica-horno60"),
										array("src" => "modulos_bajos/60cm/placa-electrica-40.png", "id" => "placa-electrica40"),
										array("src" => "modulos_bajos/60cm/placa-gas-80.png", "id" => "placa-gas80"),
										array("src" => "modulos_bajos/60cm/placa-gas-60.png", "id" => "placa-gas60"),
										array("src" => "modulos_bajos/60cm/placa-gas-horno-60.png", "id" => "placa-gas-horno"),
										array("src" => "modulos_bajos/60cm/placa-gas-40.png", "id" => "placa-gas40"),
										array("src" => "modulos_bajos/60cm/fregadero-80.png", "id" => "fregadero80"),
										array("src" => "modulos_bajos/60cm/fregadero-60.png", "id" => "fregadero60"),
										array("src" => "modulos_bajos/60cm/fregadero-40.png", "id" => "fregadero40"),
										array("src" => "modulos_bajos/60cm/mueble-bajo-80.png", "id" => "mueble-bajo80"),
										array("src" => "modulos_bajos/60cm/mueble-bajo-60.png", "id" => "mueble-bajo60"),
										array("src" => "modulos_bajos/60cm/mueble-bajo-40.png", "id" => "mueble-bajo40"),
										array("src" => "modulos_bajos/60cm/mueble-bajo-30.png", "id" => "mueble-bajo30"),
										array("src" => "modulos_bajos/60cm/mueble-bajo-20.png", "id" => "mueble-bajo20")
									);
								
									for ($i = 0; $i < count($imagenes_modulos_bajos); $i++) {
										echo "<li><img src='" . $imagenes_modulos_bajos[$i]["src"] . "' class='modulo btn fully object' id='" . $imagenes_modulos_bajos[$i]["id"] . "'></li>";
									}
								?>
							</ul>
						</div>
						<div class="greenBtn" onclick="hideStep2SubMenus(this);">Profundidad reducida 40cm</div>
						<div class="child_list">
							<ul class="owl-carousel owl-theme" style="display: block;">
								<li><img src="modulos_bajos/40cm/mueble-bajo-reducido-80.png" class="modulo btn fully object" id="reducida80"></li>
								<li><img src="modulos_bajos/40cm/mueble-bajo-reducido-60.png" class="modulo btn fully object" id="reducida60"></li>
								<li><img src="modulos_bajos/40cm/mueble-bajo-reducido-40.png" class="modulo btn fully object" id="reducida40"></li>
								<li><img src="modulos_bajos/40cm/mueble-bajo-reducido-30.png" class="modulo btn fully object" id="reducida30"></li>
							</ul>
						</div>
						<div class="greenBtn" onclick="hideStep2SubMenus(this);">Esquineros</div>
						<div class="child_list">
							<ul class="owl-carousel owl-theme" style="display: block;">
								<li><img src="modulos_bajos/esquineros/mueble-bajo-88.png" class="modulo btn fully object" id="esquinero88"></li>
								<li><img src="modulos_bajos/esquineros/mueble-bajo-128B.png" class="modulo btn fully object" id="esquinero128b"></li>
								<li><img src="modulos_bajos/esquineros/mueble-bajo-128A.png" class="modulo btn fully object" id="esquinero128a"></li>
							</ul>
						</div>

					</div>

					<!--//? modulos altos -->
					<div class="object tipo_mobiliario" onclick="hideStep2Menus(this);">MÓDULOS ALTOS</div>
					<!-- class objetos -->
					<div id="modulos_altos" class="father_list" style="display:none">
						<ul class="owl-carousel owl-theme" style="display: block;">
							<li><img src="modulos_altos/microondas.png" class="btn fully object" id="mueble-alto-microondas"></li>
							<li><img src="modulos_altos/termo-electrico.png" class="btn fully object" id="mueble-alto-termoelectrico"></li>
							<li><img src="modulos_altos/calentador-gas.png" class="btn fully object" id="mueble-alto-calentador-gas"></li>
							<li><img src="modulos_altos/caldera-gas.png" class="btn fully object" id="caldera-gas"></li>
							<li><img src="modulos_altos/campana-60.png" class="btn fully object" id="mueble-alto-campana60"></li>
							<li><img src="modulos_altos/campana-80.png" class="btn fully object" id="mueble-alto-campana80"></li>
							<li><img src="modulos_altos/campana-90.png" class="btn fully object" id="mueble-alto-campana90"></li>
							<li><img src="modulos_altos/campana-2-80.png" class="btn fully object" id="mueble-alto-campana-2-80"></li>
							<li><img src="modulos_altos/campana-2-60.png" class="btn fully object" id="mueble-alto-campana-2-60"></li>
							<li><img src="modulos_altos/mueble-alto-40.png" class="btn fully object" id="mueble-alto-campana40"></li>
							<li><img src="modulos_altos/mueble-alto-30.png" class="btn fully object" id="mueble-alto-campana30"></li>
							<li><img src="modulos_altos/mueble-alto-20.png" class="btn fully object" id="mueble-alto20"></li>
							<li><img src="modulos_altos/mueble-esquina-60.png" class="btn fully object" id="mueble-alto-esquina60"></li>
						</ul>
					</div>

					<!-- //? torres -->
					<div class="object tipo_mobiliario" onclick="hideStep2Menus(this);">TORRES</div>
					<!-- class objetos -->
					<div id="torres" class="father_list" style="display:none">

						<div class="greenBtn" onclick="hideStep2SubMenus(this);">Profundidad 60cm</div>
						<div class="child_list">
							<ul class="owl-carousel owl-theme" style="display: block;">
								<li><img src="torres/60cm/horno-micro.png" class="btn fully object" id="torre-horno-micro"></li>
								<li><img src="torres/60cm/horno.png" class="btn fully object" id="torre-horno"></li>
								<li><img src="torres/60cm/frigorifico.png" class="btn fully object" id="torre-frigorifico"></li>
								<li><img src="torres/60cm/frigo-americano.png" class="btn fully object" id="frigo-americano"></li>
								<li><img src="torres/60cm/escobero-80.png" class="btn fully object" id="torre-escobero80"></li>
								<li><img src="torres/60cm/escobero-60.png" class="btn fully object" id="torre-escobero60"></li>
								<li><img src="torres/60cm/escobero-40.png" class="btn fully object" id="torre-escobero40"></li>
								<li><img src="torres/60cm/despensa-80.png" class="btn fully object" id="torre-despensa80"></li>
								<li><img src="torres/60cm/despensa-60.png" class="btn fully object" id="torre-despensa60"></li>
								<li><img src="torres/60cm/despensa-40.png" class="btn fully object" id="torre-despensa40"></li>
							</ul>
						</div>
						<div class="greenBtn" onclick="hideStep2SubMenus(this);">Profundidad reducida 40cm</div>
						<div class="child_list">
							<ul class="owl-carousel owl-theme" style="display: block;">
								<li><img src="torres/40cm/torre-reducida-80.png" class="btn fully object" id="torre-reducida80"></li>
								<li><img src="torres/40cm/torre-reducida-60.png" class="btn fully object" id="torre-reducida60"></li>
								<li><img src="torres/40cm/torre-reducida-40.png" class="btn fully object" id="torre-reducida40"></li>
							</ul>
						</div>

					</div>
				</div>

				<div id="opciones_instalaciones" style="display:none;">
					<div class="tipo_mobiliario" onclick="hideStep2SubMenus(this);">ELECTRICIDAD</div>
					<div class="child_list">
						<ul class="owl-carousel owl-theme" style="display: block;">
							<li><img src="electricidad/enchufe-servicio.png" class="modulo btn fully object" id="electricidad-enchufeservicio">ENCHUFE DE SERVICIO</li>
							<li><img src="electricidad/toma-25A.png" class="modulo btn fully object" id="electricidad-toma25a">TOMA 25A</li>
							<li><img src="electricidad/interruptor.png" class="modulo btn fully object" id="electricidad-interruptor">INTERRUPTOR</li>
							<li><img src="electricidad/cuadro-general.png" class="modulo btn fully object" id="electricidad-cuadrogeneral">CUADRO GENERAL</li>
							<li><img src="electricidad/lampara-pared.png" class="modulo btn fully object" id="electricidad-lamparapared">LÁMPARA PARED</li>
							<li><img src="electricidad/caja-electrica.png" class="modulo btn fully object" id="electricidad-cajaelectrica">CAJA ELÉCTRICA</li>
							<li><img src="electricidad/downlicht-led.png" class="modulo btn fully object" id="electricidad-downlightled">DOWNLIGHT LED</li>
							<li><img src="electricidad/toma-TV.png" class="modulo btn fully object" id="electricidad-tomatelevision">TOMA TELEVISIÓN</li>
							<li><img src="electricidad/halogeno-led.png" class="modulo btn fully object" id="electricidad-halogenoled">HALÓGENO LED</li>
							<li><img src="electricidad/toma-datos.png" class="modulo btn fully object" id="electricidad-tomadatos">TOMA DATOS</li>
							<li><img src="electricidad/lampara.png" class="modulo btn fully object" id="electricidad-lampara">LÁMPARA</li>
							<li><img src="electricidad/toma-telf.png" class="modulo btn fully object" id="electricidad-tomatelefono">TOMA TELÉFONO</li>
							<li><img src="electricidad/tubo-fluor.png" class="modulo btn fully object" id="electricidad-tubofluorescente">TUBO FLUORESCENTE</li>
							<li><img src="electricidad/telefonillo.png" class="modulo btn fully object" id="electricidad-telefonillo">TELEFONILLO</li>
							<li><img src="electricidad/punto-luz-mueble.png" class="modulo btn fully object" id="electricidad-mueble"><br />PUNTO LUZ MUEBLE</li>
						</ul>
					</div>
					<div class="tipo_mobiliario" onclick="hideStep2SubMenus(this);">FONTANERÍA</div>
					<div class="child_list">
						<ul class="owl-carousel owl-theme" style="display: block;">
							<li><img src="fontaneria_gas/agua-fria-aux.png" class="modulo btn fully object" id="fontaneria-aguafria">TOMA AGUA FRÍA <b>AUXILIAR</b></li>
							<li><img src="fontaneria_gas/agua-fria-caliente-aux.png" class="modulo btn fully object" id="fontaneria-aguafriacaliente">TOMA AGUA FRÍA Y CALIENTE <b>AUXILIAR</b></li>
							<li><img src="fontaneria_gas/contador-agua.png" class="modulo btn fully object" id="fontaneria-contadoragua">CONTADOR DE AGUA</li>
							<li><img src="fontaneria_gas/llaves-corte-agua.png" class="modulo btn fully object" id="fontaneria-llaves">LLAVES DE CORTE <b>ESTANCIA</b></li>
						</ul>
					</div>

					<div class="tipo_mobiliario" onclick="hideStep2SubMenus(this);">GAS</div>
					<div class="child_list">
						<ul class="owl-carousel owl-theme" style="display: block;">

							<li><img src="fontaneria_gas/contador-gas.png" class="modulo btn fully object" id="gas-contador">CONTADOR DE GAS</b></li>
							<li><img src="fontaneria_gas/llave-corte-gas.png" class="modulo btn fully object" id="gas-llave">LLAVE DE CORTE GAS</b></li>
							<li><img src="fontaneria_gas/rejilla-ventilacion-gas.png" class="modulo btn fully object" id="gas-rejilla">REJILLA VENTILACIÓN GAS</b></li>

						</ul>
					</div>

					<div class="tipo_mobiliario" onclick="hideStep2SubMenus(this);">CLIMATIZACIÓN</div>
					<div class="child_list">
						<ul class="owl-carousel owl-theme" style="display: block;">
							<li><img src="climatizacion/radiador-agua.png" class="modulo btn fully object" id="climatizacion-radiadoragua">RADIADOR AGUA</b></li>
							<li><img src="climatizacion/radiador-electrico.png" class="modulo btn fully object" id="climatizacion-radiadorelectrico">RADIADOR ELÉCTRICO</b></li>
							<li><img src="climatizacion/aire-acondicionado-conductos.png" class="modulo btn fully object" id="climatizacion-aire">APARATO DE AIRE ACONDICIONADO</b></li>
							<li><img src="climatizacion/rejilla-aire-conductos.png" class="modulo btn fully object" id="climatizacion-rejilla">REJILLA AIRE POR CONDUCTOS</b></li>
							<li><img src="climatizacion/split-aire-acondicionado.png" class="modulo btn fully object" id="climatizacion-split"><br />SPLIT AIRE ACONDICIONADO</li>
						</ul>
					</div>

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
						$result = $mysqli->query("SELECT * FROM articulos_compuestos WHERE tipo=1");

						while ($arr_result = $result->fetch_array()) {
							//$id_simple_clientes=$arr_result["id_articulo_simple"];
							if (isset($_GET["id_presupuesto"])) {
								//Si existe id usuario, está viendo un mapa ya creado, miro si seleccionó alguno de estos elementos
								$result_seleccion = $mysqli->query("SELECT * FROM planos_articulos_compuestos WHERE id_plano=" . $_GET["id_presupuesto"] . " AND id_articulo_compuesto=" . $arr_result["id"]);

								if ($result_seleccion->num_rows) {
									$elemento_seleccionado = true;
									$paredes = "";
									while ($arr_result_seleccion = $result_seleccion->fetch_array()) {

										if ($paredes == "")
											$paredes = $arr_result_seleccion["pared"];
										else
											$paredes = $paredes . "," . $arr_result_seleccion["pared"];

										$paredes_totales = $arr_result_seleccion["total_paredes"];
										$unidades = $arr_result_seleccion["unidades"];
										$metros_lineales = $arr_result_seleccion["metros_lineales"];
									}
								} else {
									$elemento_seleccionado = false;
									$paredes = "";
									//Saco solo las paredes totales	
									$result_paredes_totales = $mysqli->query("SELECT total_paredes FROM planos_articulos_compuestos WHERE id_plano=" . $_GET["id_presupuesto"] . " LIMIT 1");

									while ($arr_result_paredes_totales = $result_paredes_totales->fetch_array())
										$paredes_totales = $arr_result_paredes_totales["total_paredes"];
								}
							}

						?>
							<li>
								<?php echo nl2br($arr_result['nombre']); ?>
								<i class="fa fa-info-circle" onclick="instrucciones('<?php echo $arr_result["id_imagen"]; ?>')"></i>
								<br>
								<img src="<?php echo $arr_result['imagen']; ?>" class="elemento_instalacion <?php if (isset($_GET["id_presupuesto"]) && $elemento_seleccionado) { ?> selected <?php } ?>" id="<?php echo $arr_result['id_imagen']; ?>">
								<?php
								if ($arr_result["mostrar"] == "muros") {
									//Le dejo que seleccione el/los muros a los que va esta acción
								?>

									<div class="listado_muros" <?php if (isset($_GET["id_presupuesto"])) { ?> style="display:block;" <?php } ?>>
										<form class="form_muros" name="<?php echo $arr_result['id_imagen']; ?>" method="POST" action="#">
											<input type="checkbox" name="todos_muros" value="1"> Todas las paredes<br /><br />
											<input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen']; ?>">
											<?php
											if (isset($_GET["id_presupuesto"])) {

												//echo "Paredes es ".$paredes;

												//Le muestro muros
												$paredes_totales_array = explode(",", $paredes_totales);

												for ($i = 0; $i < count($paredes_totales_array); $i++) {
													if ($paredes_totales_array[$i] != "") {
														if (strstr($paredes, $paredes_totales_array[$i])) {
															//Busco si tiene longitud marcada
															$result_longitud = $mysqli->query("SELECT longitud FROM planos_articulos_compuestos WHERE id_plano=" . $_GET['id_presupuesto'] . " AND id_articulo_compuesto=" . $arr_result["id"] . " AND pared='" . $paredes_totales_array[$i] . "' AND longitud != 0 LIMIT 1");

															if ($result_longitud->num_rows) {
																while ($arr_result_longitud = $result_longitud->fetch_array())
																	$longitud = $arr_result_longitud["longitud"];
																$valor_pared = $paredes_totales_array[$i] . "/" . $longitud;
															} else {
																$longitud = "";
																$valor_pared = $paredes_totales_array[$i];
															}
														} else {
															$longitud = "";
															$valor_pared = $paredes_totales_array[$i];
														}

														$metros_pared = explode(" ", $valor_pared);
											?>
														<span class="checkmuro">
															<input <?php if (strstr($paredes, $paredes_totales_array[$i])) { ?> checked <?php } ?> type="checkbox" name="paredes[]" class="paredes" value="<?php echo $valor_pared; ?>">
															<?php echo $paredes_totales_array[$i]; ?><br />
															<input class='child' name='seleccion_metros' type='checkbox' value='<?php echo $valor_pared; ?>' <?php if ($longitud == $metros_pared[2]) { ?>checked <?php } ?>> Completa <br />
															<input name='seleccion_metros' class='<?php echo $valor_pared; ?>' type='checkbox' value='parcial' <?php if ($longitud != "" && $longitud != $metros_pared[2]) { ?> checked <?php } ?>> Parcial
															<input type='range' value='0.1' min='0.1' name='metros_parcial' class='<?php echo $valor_pared; ?>' max='<?php echo $metros_pared[2]; ?>' step='0.01' oninput='xxc = this.nextElementSibling.value'>
															<output style='display:none'></output>

															<?php if ($longitud != "") { ?>
																<div class="metros_seleccionados">(<?php echo $longitud; ?>m seleccionados)</div>
															<?php } ?>
														</span>
													<?php
													}
												}

												//Le muestro todos los artículos simples
												$result_simples = $mysqli->query("SELECT * FROM articulos_simples WHERE id_articulo_compuesto=" . $arr_result["id"]);

												while ($arr_result_simples = $result_simples->fetch_array()) {
													$id_articulo_simple = $arr_result_simples["id"];
													$codigo_articulo_simple = $arr_result_simples["codigo"];
													$descripcion_articulo_simple = $arr_result_simples["descripcion"];
													$visible_cliente = $arr_result_simples["visible_cliente"];

													//Si está marcado porque lo elegió un verificador
													$result_elegido = $mysqli->query("SELECT id FROM planos_articulos_compuestos WHERE id_articulo_compuesto=" . $arr_result["id"] . " AND id_articulo_simple=$id_articulo_simple");

													?>
													<div><input <?php if ($visible_cliente == 1) { ?> checked <?php } else if ($result_elegido->num_rows) { ?>checked<?php } ?> type="checkbox" name="articulo_simple[]" value="<?php echo $id_articulo_simple; ?>"> <b><?php echo $codigo_articulo_simple; ?></b>: <?php echo utf8_encode($descripcion_articulo_simple); ?></div>
											<?php
												}
											}
											?>

										</form>
									</div>
									<?php
									if (isset($_GET["id_presupuesto"]) && $elemento_seleccionado) {
									?>
										<div style="color:#95C11F">Muros marcados: <?php echo $paredes; ?></div>
									<?php
									}
									?>

								<?php
								} else if ($arr_result["mostrar"] == "unidades") {
									//Le muestro un input para que me indique unidades
								?>
									<div class="unidades_elemento" <?php if (isset($_GET["id_presupuesto"])) { ?> style="display:block;" <?php } ?>>
										<form class="form_unidades" name="<?php echo $arr_result['id_imagen']; ?>" method="POST" action="#">
											<input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen']; ?>">
											<input type="range" value="1" min="1" max="30" step="1" oninput="this.nextElementSibling.value = this.value" class="<?php echo $arr_result['id_imagen']; ?>" name="unidades" <?php if ($arr_result["mostrar"] == "") { ?> style="display:none;" <?php } ?>>
											Unidades: <output style="display:inline-block">1</output>
											<?php
											if (isset($_GET["id_presupuesto"])) {
												//Le muestro todos los artículos simples
												$result_simples = $mysqli->query("SELECT * FROM articulos_simples WHERE id_articulo_compuesto=" . $arr_result["id"]);

												while ($arr_result_simples = $result_simples->fetch_array()) {
													$id_articulo_simple = $arr_result_simples["id"];
													$codigo_articulo_simple = $arr_result_simples["codigo"];
													$descripcion_articulo_simple = $arr_result_simples["descripcion"];
													$visible_cliente = $arr_result_simples["visible_cliente"];

													//Si está marcado porque lo elegió un verificador
													$result_elegido = $mysqli->query("SELECT id FROM planos_articulos_compuestos WHERE id_articulo_compuesto=" . $arr_result["id"] . " AND id_articulo_simple=$id_articulo_simple");
											?>
													<div><input <?php if ((is_null($id_simple_clientes) || $id_simple_clientes == "" || $id_simple_clientes === NULL) && $visible_cliente == 1) { ?> checked <?php } else if ($id_simple_clientes == $id_articulo_simple || $result_elegido->num_rows) { ?>checked<?php } ?> type="checkbox" name="articulo_simple[]" value="<?php echo $id_articulo_simple; ?>"> <b><?php echo $codigo_articulo_simple; ?></b>: <?php echo utf8_encode($descripcion_articulo_simple); ?></div>
											<?php
												}
											}
											?>

										</form>
									</div>
								<?php
								} else if ($arr_result["mostrar"] == "metros_lineales") {
									//Le muestro un input para que me indique los metros_lineales
								?>
									<div class="metros_lineales" <?php if (isset($_GET["id_presupuesto"])) { ?> style="display:block;" <?php } ?>>
										<form class="form_metros" name="<?php echo $arr_result['id_imagen']; ?>" method="POST" action="#">
											<input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen']; ?>">
											<input type="range" value="<?php if (isset($metros_lineales) && $metros_lineales != 0) {
																			echo $metros_lineales;
																		} else { ?> 1 <?php } ?>" min="1" max="30" step="0.1" oninput="this.nextElementSibling.value = this.value" class="form-control" name="metros_lineales">
											Metros lineales: <output style="display:inline-block"><?php if (isset($metros_lineales) && $metros_lineales != 0) {
																										echo $metros_lineales;
																									} else { ?> 1 <?php } ?></output>

											<?php
											if (isset($_GET["id_presupuesto"])) {
												//Le muestro todos los artículos simples
												$result_simples = $mysqli->query("SELECT * FROM articulos_simples WHERE id_articulo_compuesto=" . $arr_result["id"]);

												while ($arr_result_simples = $result_simples->fetch_array()) {
													$id_articulo_simple = $arr_result_simples["id"];
													$codigo_articulo_simple = $arr_result_simples["codigo"];
													$descripcion_articulo_simple = $arr_result_simples["descripcion"];
													$visible_cliente = $arr_result_simples["visible_cliente"];

													//Si está marcado porque lo elegió un verificador
													$result_elegido = $mysqli->query("SELECT id FROM planos_articulos_compuestos WHERE id_articulo_compuesto=" . $arr_result["id"] . " AND id_articulo_simple=$id_articulo_simple");
											?>
													<div><input <?php if ($visible_cliente == 1) { ?> checked <?php } else if ($result_elegido->num_rows) { ?>checked<?php } ?> type="checkbox" name="articulo_simple[]" value="<?php echo $id_articulo_simple; ?>"> <b><?php echo $codigo_articulo_simple; ?></b>: <?php echo utf8_encode($descripcion_articulo_simple); ?></div>
											<?php
												}
											}
											?>

										</form>
									</div>
								<?php
								} else {
								?>
									<form class="form_generico" name="<?php echo $arr_result['id_imagen']; ?>" method="POST" action="#">
										<input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen']; ?>">
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
						$result = $mysqli->query("SELECT * FROM articulos_compuestos WHERE tipo=2");

						while ($arr_result = $result->fetch_array()) {
							//$id_simple_clientes=$arr_result["id_articulo_simple"];
							if (isset($_GET["id_presupuesto"])) {
								//Si existe id usuario, está viendo un mapa ya creado, miro si seleccionó alguno de estos elementos
								$result_seleccion = $mysqli->query("SELECT * FROM planos_articulos_compuestos WHERE id_plano=" . $_GET["id_presupuesto"] . " AND id_articulo_compuesto=" . $arr_result["id"]);
								$unidades = 0;

								if ($result_seleccion->num_rows) {
									$elemento_seleccionado = true;
									$paredes = "";

									while ($arr_result_seleccion = $result_seleccion->fetch_array()) {
										if ($paredes == "")
											$paredes = $arr_result_seleccion["pared"];
										else
											$paredes = $paredes . "," . $arr_result_seleccion["pared"];

										$paredes_totales = $arr_result_seleccion["total_paredes"];
										$unidades = $arr_result_seleccion["unidades"];
									}
								} else {
									$elemento_seleccionado = false;
									$paredes = "";
									//Saco solo las paredes totales	
									$result_paredes_totales = $mysqli->query("SELECT total_paredes FROM planos_articulos_compuestos WHERE id_plano=" . $_GET["id_presupuesto"] . " LIMIT 1");

									while ($arr_result_paredes_totales = $result_paredes_totales->fetch_array())
										$paredes_totales = $arr_result_paredes_totales["total_paredes"];
								}
							}
						?>
							<li>
								<?php echo nl2br($arr_result['nombre']); ?> <i class="fa fa-info-circle" onclick="instrucciones('<?php echo $arr_result["id_imagen"]; ?>')"></i>
								<br>
								<img src="<?php echo $arr_result['imagen']; ?>" class="tipo_electricidad elemento_instalacion <?php if (isset($_GET["id_presupuesto"]) && $elemento_seleccionado) { ?> selected <?php } ?>" id="<?php echo $arr_result['id_imagen']; ?>">
								<?php
								if ($arr_result["mostrar"] == "muros") {
									//Le dejo que seleccione el/los muros a los que va esta acción
								?>

									<div class="listado_muros" <?php if (isset($_GET["id_presupuesto"])) { ?> style="display:block;" <?php } ?>>
										<form class="form_muros" name="<?php echo $arr_result['id_imagen']; ?>" method="POST" action="#">
											<input type="checkbox" name="todos_muros" value="1"> Todas las paredes<br /><br />
											<input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen']; ?>">
											<?php
											if (isset($_GET["id_presupuesto"])) {

												//Le muestro muros
												$paredes_totales_array = explode(",", $paredes_totales);

												for ($i = 0; $i < count($paredes_totales_array); $i++) {
													if ($paredes_totales_array[$i] != "") {
														if (strstr($paredes, $paredes_totales_array[$i])) {
															//Busco si tiene longitud marcada
															$result_longitud = $mysqli->query("SELECT longitud FROM planos_articulos_compuestos WHERE id_plano=" . $_GET['id_presupuesto'] . " AND id_articulo_compuesto=" . $arr_result["id"] . " AND pared='" . $paredes_totales_array[$i] . "' AND longitud != 0 LIMIT 1");

															if ($result_longitud->num_rows) {
																while ($arr_result_longitud = $result_longitud->fetch_array())
																	$longitud = $arr_result_longitud["longitud"];

																$valor_pared = $paredes_totales_array[$i] . "/" . $longitud;
															} else {
																$longitud = "";
																$valor_pared = $paredes_totales_array[$i];
															}
														} else {
															$longitud = "";
															$valor_pared = $paredes_totales_array[$i];
														}

														$metros_pared = explode(" ", $valor_pared);
											?>
														<span class="checkmuro">
															<input <?php if (strstr($paredes, $paredes_totales_array[$i])) { ?> checked <?php } ?> type="checkbox" name="paredes[]" class="paredes" value="<?php echo $valor_pared; ?>">
															<?php echo $paredes_totales_array[$i]; ?><br />
															<input class='child' name='seleccion_metros' type='checkbox' value='<?php echo $valor_pared; ?>' <?php if ($longitud == $metros_pared[2]) { ?>checked <?php } ?>> Completa <br />
															<input name='seleccion_metros' class='<?php echo $valor_pared; ?>' type='checkbox' value='parcial' <?php if ($longitud != "" && $longitud != $metros_pared[2]) { ?> checked <?php } ?>> Parcial
															<input type='range' value='0.1' min='0.1' name='metros_parcial' class='<?php echo $valor_pared; ?>' max='<?php echo $metros_pared[2]; ?>' step='0.01' oninput='this.nextElementSibling.value = this.value'>
															<output style='display:none'></output>

															<?php if ($longitud != "") { ?>
																<div class="metros_seleccionados">(<?php echo $longitud; ?>m seleccionados)</div>
															<?php } ?>
														</span>
													<?php
													}
												}

												//Le muestro todos los artículos simples
												$result_simples = $mysqli->query("SELECT * FROM articulos_simples WHERE id_articulo_compuesto=" . $arr_result["id"]);

												while ($arr_result_simples = $result_simples->fetch_array()) {
													$id_articulo_simple = $arr_result_simples["id"];
													$codigo_articulo_simple = $arr_result_simples["codigo"];
													$descripcion_articulo_simple = $arr_result_simples["descripcion"];
													$visible_cliente = $arr_result_simples["visible_cliente"];

													//Si está marcado porque lo elegió un verificador
													$result_elegido = $mysqli->query("SELECT id FROM planos_articulos_compuestos WHERE id_articulo_compuesto=" . $arr_result["id"] . " AND id_articulo_simple=$id_articulo_simple");
													?>
													<div><input <?php if ($visible_cliente == 1) { ?> checked <?php } else if ($result_elegido->num_rows) { ?>checked<?php } ?> type="checkbox" name="articulo_simple[]" value="<?php echo $id_articulo_simple; ?>"> <b><?php echo $codigo_articulo_simple; ?></b>: <?php echo utf8_encode($descripcion_articulo_simple); ?></div>
											<?php
												}
											}

											?>

										</form>

									</div>
									<?php
									if (isset($_GET["id_presupuesto"]) && $elemento_seleccionado) {
									?>
										<div style="color:#95C11F">Muros marcados: <?php echo $paredes; ?></div>
									<?php
									}

									?>
								<?php
								} else if ($arr_result["mostrar"] == "unidades") {
									//Le muestro un input para que me indique unidades
									/* if (isset($_GET["id_presupuesto"]))
						  {
								//Si existe id usuario, está viendo un mapa ya creado, miro si seleccionó alguno de estos elementos
								echo "LAS UNIDADES SON $unidades";
							    
						  }
						  */
								?>
									<div class="unidades_elemento" <?php if (isset($_GET["id_presupuesto"])) { ?> style="display:block;" <?php } ?>>
										<form class="form_unidades" name="<?php echo $arr_result['id_imagen']; ?>" method="POST" action="#">
											<input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen']; ?>">
											<input type="range" value="<?php echo $unidades; ?>" min="1" max="30" step="1" oninput="this.nextElementSibling.value = this.value" class="<?php echo $arr_result['id_imagen']; ?>" name="unidades" <?php if ($arr_result["mostrar"] == "") { ?> style="display:none;" <?php } ?>>
											Unidades: <output style="display:inline-block"><?php echo $unidades; ?></output>

											<?php
											if (isset($_GET["id_presupuesto"])) {
												//Le muestro todos los artículos simples
												$result_simples = $mysqli->query("SELECT * FROM articulos_simples WHERE id_articulo_compuesto=" . $arr_result["id"]);

												while ($arr_result_simples = $result_simples->fetch_array()) {
													$id_articulo_simple = $arr_result_simples["id"];
													$codigo_articulo_simple = $arr_result_simples["codigo"];
													$descripcion_articulo_simple = $arr_result_simples["descripcion"];
													$visible_cliente = $arr_result_simples["visible_cliente"];

													//Si está marcado porque lo elegió un verificador
													$result_elegido = $mysqli->query("SELECT id FROM planos_articulos_compuestos WHERE id_articulo_compuesto=" . $arr_result["id"] . " AND id_articulo_simple=$id_articulo_simple");
											?>
													<div><input <?php if ($visible_cliente == 1) { ?> checked <?php } else if ($result_elegido->num_rows) { ?>checked<?php } ?> type="checkbox" name="articulo_simple[]" value="<?php echo $id_articulo_simple; ?>"> <b><?php echo $codigo_articulo_simple; ?></b>: <?php echo utf8_encode($descripcion_articulo_simple); ?></div>
											<?php
												}
											}

											?>

										</form>
									</div>
								<?php
								} else if ($arr_result["mostrar"] == "metros_lineales") {
									//Le muestro un input para que me indique los metros_lineales
								?>
									<div class="metros_lineales" <?php if (isset($_GET["id_presupuesto"])) { ?> style="display:block;" <?php } ?>>
										<form class="form_metros" name="<?php echo $arr_result['id_imagen']; ?>" method="POST" action="#">
											<input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen']; ?>">
											<input type="range" value="<?php if (isset($metros_lineales) && $metros_lineales != 0) {
																			echo $metros_lineales;
																		} else { ?> 1 <?php } ?>" min="1" max="30" step="0.1" oninput="this.nextElementSibling.value = this.value" class="form-control" name="metros_lineales">
											Metros lineales: <output style="display:inline-block"><?php if (isset($metros_lineales) && $metros_lineales != 0) {
																										echo $metros_lineales;
																									} else { ?> 1 <?php } ?></output>
											<?php
											if (isset($_GET["id_presupuesto"])) {
												//Le muestro todos los artículos simples
												$result_simples = $mysqli->query("SELECT * FROM articulos_simples WHERE id_articulo_compuesto=" . $arr_result["id"]);

												while ($arr_result_simples = $result_simples->fetch_array()) {
													$id_articulo_simple = $arr_result_simples["id"];
													$codigo_articulo_simple = $arr_result_simples["codigo"];
													$descripcion_articulo_simple = $arr_result_simples["descripcion"];
													$visible_cliente = $arr_result_simples["visible_cliente"];

													//Si está marcado porque lo elegió un verificador
													$result_elegido = $mysqli->query("SELECT id FROM planos_articulos_compuestos WHERE id_articulo_compuesto=" . $arr_result["id"] . " AND id_articulo_simple=$id_articulo_simple");
											?>
													<div><input <?php if ($visible_cliente == 1) { ?> checked <?php } else if ($result_elegido->num_rows) { ?>checked<?php } ?> type="checkbox" name="articulo_simple[]" value="<?php echo $id_articulo_simple; ?>"> <b><?php echo $codigo_articulo_simple; ?></b>: <?php echo utf8_encode($descripcion_articulo_simple); ?></div>
											<?php
												}
											}
											?>

										</form>
									</div>
								<?php
								} else {
								?>

									<form class="form_generico" name="<?php echo $arr_result['id_imagen']; ?>" method="POST" action="#">
										<input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen']; ?>">
										<?php
										if (isset($_GET["id_presupuesto"])) {
											//Le muestro todos los artículos simples
											$result_simples = $mysqli->query("SELECT * FROM articulos_simples WHERE id_articulo_compuesto=" . $arr_result["id"]);

											while ($arr_result_simples = $result_simples->fetch_array()) {
												$id_articulo_simple = $arr_result_simples["id"];
												$codigo_articulo_simple = $arr_result_simples["codigo"];
												$descripcion_articulo_simple = $arr_result_simples["descripcion"];
												$visible_cliente = $arr_result_simples["visible_cliente"];

												//Si está marcado porque lo elegió un verificador
												$result_elegido = $mysqli->query("SELECT id FROM planos_articulos_compuestos WHERE id_articulo_compuesto=" . $arr_result["id"] . " AND id_articulo_simple=$id_articulo_simple");
										?>
												<div><input <?php if ($visible_cliente == 1) { ?> checked <?php } else if ($result_elegido->num_rows) { ?>checked<?php } ?> type="checkbox" name="articulo_simple[]" value="<?php echo $id_articulo_simple; ?>"> <b><?php echo $codigo_articulo_simple; ?></b>: <?php echo utf8_encode($descripcion_articulo_simple); ?></div>
										<?php
											}
										}
										?>
									</form>

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
						$result = $mysqli->query("SELECT * FROM articulos_compuestos WHERE tipo=3");

						while ($arr_result = $result->fetch_array()) {
							//$id_simple_clientes=$arr_result["id_articulo_simple"];
							if (isset($_GET["id_presupuesto"])) {
								//Si existe id usuario, está viendo un mapa ya creado, miro si seleccionó alguno de estos elementos
								$result_seleccion = $mysqli->query("SELECT * FROM planos_articulos_compuestos WHERE id_plano=" . $_GET["id_presupuesto"] . " AND id_articulo_compuesto=" . $arr_result["id"]);

								if ($result_seleccion->num_rows) {
									$elemento_seleccionado = true;
									$paredes = "";
									while ($arr_result_seleccion = $result_seleccion->fetch_array()) {
										if ($paredes == "")
											$paredes = $arr_result_seleccion["pared"];
										else
											$paredes = $paredes . "," . $arr_result_seleccion["pared"];

										$paredes_totales = $arr_result_seleccion["total_paredes"];
										$unidades = $arr_result_seleccion["unidades"];
									}
								} else {
									$elemento_seleccionado = false;
									$paredes = "";
									$result_paredes_totales = $mysqli->query("SELECT total_paredes FROM planos_articulos_compuestos WHERE id_plano=" . $_GET["id_presupuesto"] . " LIMIT 1");

									while ($arr_result_paredes_totales = $result_paredes_totales->fetch_array())
										$paredes_totales = $arr_result_paredes_totales["total_paredes"];
								}
							}
						?>
							<li>
								<?php echo nl2br($arr_result['nombre']); ?> <i class="fa fa-info-circle" onclick="instrucciones('<?php echo $arr_result['id_imagen']; ?>')"></i>
								<br>
								<img src="<?php echo $arr_result['imagen']; ?>" class="tipo_equipamiento elemento_instalacion <?php if (isset($_GET["id_presupuesto"]) && $elemento_seleccionado) { ?> selected <?php } ?>" id="<?php echo $arr_result['id_imagen']; ?>">
								<?php
								if ($arr_result["mostrar"] == "muros") {
									//Le dejo que seleccione el/los muros a los que va esta acción
								?>

									<div class="listado_muros" <?php if (isset($_GET["id_presupuesto"])) { ?> style="display:block;" <?php } ?>>
										<form class="form_muros" name="<?php echo $arr_result['id_imagen']; ?>" method="POST" action="#">
											<input type="checkbox" name="todos_muros" value="1"> Todas las paredes<br /><br />
											<input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen']; ?>">
											<?php
											if (isset($_GET["id_presupuesto"])) {
												//Le muestro muros
												$paredes_totales_array = explode(",", $paredes_totales);

												for ($i = 0; $i < count($paredes_totales_array); $i++) {
													if ($paredes_totales_array[$i] != "") {
														if (strstr($paredes, $paredes_totales_array[$i])) {
															//Busco si tiene longitud marcada
															$result_longitud = $mysqli->query("SELECT longitud FROM planos_articulos_compuestos WHERE id_plano=" . $_GET['id_presupuesto'] . " AND id_articulo_compuesto=" . $arr_result["id"] . " AND pared='" . $paredes_totales_array[$i] . "' AND longitud != 0 LIMIT 1");

															if ($result_longitud->num_rows) {
																while ($arr_result_longitud = $result_longitud->fetch_array())
																	$longitud = $arr_result_longitud["longitud"];
																$valor_pared = $paredes_totales_array[$i] . "/" . $longitud;
															} else {
																$longitud = "";
																$valor_pared = $paredes_totales_array[$i];
															}
														} else {
															$longitud = "";
															$valor_pared = $paredes_totales_array[$i];
														}

														$metros_pared = explode(" ", $valor_pared);
											?>
														<span class="checkmuro">
															<input <?php if (strstr($paredes, $paredes_totales_array[$i])) { ?> checked <?php } ?> type="checkbox" name="paredes[]" class="paredes" value="<?php echo $valor_pared; ?>">
															<?php echo $paredes_totales_array[$i]; ?><br />
															<input class='child' name='seleccion_metros' type='checkbox' value='<?php echo $valor_pared; ?>' <?php if ($longitud == $metros_pared[2]) { ?>checked <?php } ?>> Completa <br />
															<input name='seleccion_metros' class='<?php echo $valor_pared; ?>' type='checkbox' value='parcial' <?php if ($longitud != "" && $longitud != $metros_pared[2]) { ?> checked <?php } ?>> Parcial
															<input type='range' value='0.1' min='0.1' name='metros_parcial' class='<?php echo $valor_pared; ?>' max='<?php echo $metros_pared[2]; ?>' step='0.01' oninput='this.nextElementSibling.value = this.value'>
															<output style='display:none'></output>

															<?php if ($longitud != "") { ?>
																<div class="metros_seleccionados">(<?php echo $longitud; ?>m seleccionados)</div>
															<?php } ?>
														</span>
													<?php
													}
												}

												//Le muestro todos los artículos simples
												$result_simples = $mysqli->query("SELECT * FROM articulos_simples WHERE id_articulo_compuesto=" . $arr_result["id"]);

												while ($arr_result_simples = $result_simples->fetch_array()) {
													$id_articulo_simple = $arr_result_simples["id"];
													$codigo_articulo_simple = $arr_result_simples["codigo"];
													$descripcion_articulo_simple = $arr_result_simples["descripcion"];
													$visible_cliente = $arr_result_simples["visible_cliente"];

													//Si está marcado porque lo elegió un verificador
													$result_elegido = $mysqli->query("SELECT id FROM planos_articulos_compuestos WHERE id_articulo_compuesto=" . $arr_result["id"] . " AND id_articulo_simple=$id_articulo_simple");

													?>
													<div><input <?php if ($visible_cliente == 1) { ?> checked <?php } else if ($result_elegido->num_rows) { ?>checked<?php } ?> type="checkbox" name="articulo_simple[]" value="<?php echo $id_articulo_simple; ?>"> <b><?php echo $codigo_articulo_simple; ?></b>: <?php echo utf8_encode($descripcion_articulo_simple); ?></div>
											<?php
												}
											}
											?>
										</form>
									</div>
									<?php
									if (isset($_GET["id_presupuesto"]) && $elemento_seleccionado) {
									?>
										<div style="color:#95C11F">Muros marcados: <?php echo $paredes; ?></div>
									<?php
									}

									?>
								<?php
								} else if ($arr_result["mostrar"] == "unidades") {
									//Le muestro un input para que me indique unidades
								?>
									<div class="unidades_elemento" <?php if (isset($_GET["id_presupuesto"])) { ?> style="display:block;" <?php } ?>>
										<form class="form_unidades" name="<?php echo $arr_result['id_imagen']; ?>" method="POST" action="#">
											<input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen']; ?>">

											<input type="range" value="1" min="1" max="5" step="1" oninput="this.nextElementSibling.value = this.value" class="<?php echo $arr_result['id_imagen']; ?>" name="unidades" <?php if ($arr_result["mostrar"] == "") { ?> style="display:none;" <?php } ?>>
											Unidades: <output style="display:inline-block">1</output>

											<?php
											if (isset($_GET["id_presupuesto"])) {
												//Le muestro todos los artículos simples
												$result_simples = $mysqli->query("SELECT * FROM articulos_simples WHERE id_articulo_compuesto=" . $arr_result["id"]);

												while ($arr_result_simples = $result_simples->fetch_array()) {
													$id_articulo_simple = $arr_result_simples["id"];
													$codigo_articulo_simple = $arr_result_simples["codigo"];
													$descripcion_articulo_simple = $arr_result_simples["descripcion"];
													$visible_cliente = $arr_result_simples["visible_cliente"];

													//Si está marcado porque lo elegió un verificador
													$result_elegido = $mysqli->query("SELECT id FROM planos_articulos_compuestos WHERE id_articulo_compuesto=" . $arr_result["id"] . " AND id_articulo_simple=$id_articulo_simple");
											?>
													<div><input <?php if ($visible_cliente == 1) { ?> checked <?php } else if ($result_elegido->num_rows) { ?>checked<?php } ?> type="checkbox" name="articulo_simple[]" value="<?php echo $id_articulo_simple; ?>"> <b><?php echo $codigo_articulo_simple; ?></b>: <?php echo utf8_encode($descripcion_articulo_simple); ?></div>
											<?php
												}
											}
											?>
										</form>
									</div>
								<?php
								} else if ($arr_result["mostrar"] == "metros_lineales") {
									//Le muestro un input para que me indique los metros_lineales
								?>
									<div class="metros_lineales" <?php if (isset($_GET["id_presupuesto"])) { ?> style="display:block;" <?php } ?>>
										<form class="form_metros" name="<?php echo $arr_result['id_imagen']; ?>" method="POST" action="#">
											<input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen']; ?>">
											<input type="range" value="<?php if (isset($metros_lineales) && $metros_lineales != 0) {
																			echo $metros_lineales;
																		} else { ?> 1 <?php } ?>" min="1" max="30" step="0.1" oninput="this.nextElementSibling.value = this.value" class="form-control" name="metros_lineales">
											Metros lineales: <output style="display:inline-block"><?php if (isset($metros_lineales) && $metros_lineales != 0) {
																										echo $metros_lineales;
																									} else { ?> 1 <?php } ?></output>
											<?php
											if (isset($_GET["id_presupuesto"])) {
												//Le muestro todos los artículos simples
												$result_simples = $mysqli->query("SELECT * FROM articulos_simples WHERE id_articulo_compuesto=" . $arr_result["id"]);

												while ($arr_result_simples = $result_simples->fetch_array()) {
													$id_articulo_simple = $arr_result_simples["id"];
													$codigo_articulo_simple = $arr_result_simples["codigo"];
													$descripcion_articulo_simple = $arr_result_simples["descripcion"];
													$visible_cliente = $arr_result_simples["visible_cliente"];

													//Si está marcado porque lo elegió un verificador
													$result_elegido = $mysqli->query("SELECT id FROM planos_articulos_compuestos WHERE id_articulo_compuesto=" . $arr_result["id"] . " AND id_articulo_simple=$id_articulo_simple");
											?>
													<div><input <?php if ((is_null($id_simple_clientes) || $id_simple_clientes == "" || $id_simple_clientes === NULL) && $visible_cliente == 1) { ?> checked <?php } else if ($id_simple_clientes == $id_articulo_simple || $result_elegido->num_rows) { ?>checked<?php } ?> type="checkbox" name="articulo_simple[]" value="<?php echo $id_articulo_simple; ?>"> <b><?php echo $codigo_articulo_simple; ?></b>: <?php echo utf8_encode($descripcion_articulo_simple); ?></div>
											<?php
												}
											}
											?>

										</form>
									</div>
								<?php
								} else {
								?>

									<form class="form_generico" name="<?php echo $arr_result['id_imagen']; ?>" method="POST" action="#">
										<input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen']; ?>">
										<?php
										if (isset($_GET["id_presupuesto"])) {
											//Le muestro todos los artículos simples
											$result_simples = $mysqli->query("SELECT * FROM articulos_simples WHERE id_articulo_compuesto=" . $arr_result["id"]);

											while ($arr_result_simples = $result_simples->fetch_array()) {
												$id_articulo_simple = $arr_result_simples["id"];
												$codigo_articulo_simple = $arr_result_simples["codigo"];
												$descripcion_articulo_simple = $arr_result_simples["descripcion"];
												$visible_cliente = $arr_result_simples["visible_cliente"];

												//Si está marcado porque lo elegió un verificador
												$result_elegido = $mysqli->query("SELECT id FROM planos_articulos_compuestos WHERE id_articulo_compuesto=" . $arr_result["id"] . " AND id_articulo_simple=$id_articulo_simple");
										?>
												<div><input <?php if ($visible_cliente == 1) { ?> checked <?php } else if ($result_elegido->num_rows) { ?>checked<?php } ?> type="checkbox" name="articulo_simple[]" value="<?php echo $id_articulo_simple; ?>"> <b><?php echo $codigo_articulo_simple; ?></b>: <?php echo utf8_encode($descripcion_articulo_simple); ?></div>
										<?php
											}
										}
										?>
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
						$result = $mysqli->query("SELECT * FROM articulos_compuestos WHERE tipo=4");

						while ($arr_result = $result->fetch_array()) {
							//$id_simple_clientes=$arr_result["id_articulo_simple"];
							if (isset($_GET["id_presupuesto"])) {
								//Si existe id usuario, está viendo un mapa ya creado, miro si seleccionó alguno de estos elementos
								$result_seleccion = $mysqli->query("SELECT * FROM planos_articulos_compuestos WHERE id_plano=" . $_GET["id_presupuesto"] . " AND id_articulo_compuesto=" . $arr_result["id"]);

								if ($result_seleccion->num_rows) {
									$elemento_seleccionado = true;
									$paredes = "";
									while ($arr_result_seleccion = $result_seleccion->fetch_array()) {
										if ($paredes == "")
											$paredes = $arr_result_seleccion["pared"];
										else
											$paredes = $paredes . "," . $arr_result_seleccion["pared"];

										$paredes_totales = $arr_result_seleccion["total_paredes"];
										$unidades = $arr_result_seleccion["unidades"];
									}
								} else {
									$elemento_seleccionado = false;
									$paredes = "";
									$result_paredes_totales = $mysqli->query("SELECT total_paredes FROM planos_articulos_compuestos WHERE id_plano=" . $_GET["id_presupuesto"] . " LIMIT 1");

									while ($arr_result_paredes_totales = $result_paredes_totales->fetch_array())
										$paredes_totales = $arr_result_paredes_totales["total_paredes"];
								}
							}
						?>
							<li>
								<?php echo nl2br($arr_result['nombre']); ?>
								<i class="fa fa-info-circle" onclick="instrucciones('<?php echo $arr_result["id_imagen"]; ?>')"></i>
								<br>
								<img src="<?php echo $arr_result['imagen']; ?>" class="elemento_instalacion <?php if (isset($_GET["id_presupuesto"]) && $elemento_seleccionado) { ?> selected <?php } ?>" id="<?php echo $arr_result['id_imagen']; ?>">
								<?php
								if ($arr_result["mostrar"] == "muros") {
									//Le dejo que seleccione el/los muros a los que va esta acción
								?>

									<div class="listado_muros" <?php if (isset($_GET["id_presupuesto"])) { ?> style="display:block;" <?php } ?>>
										<form class="form_muros" name="<?php echo $arr_result['id_imagen']; ?>" method="POST" action="#">
											<input type="checkbox" name="todos_muros" value="1"> Todas las paredes<br /><br />
											<input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen']; ?>">
											<?php
											if (isset($_GET["id_presupuesto"])) {
												//Le muestro muros
												$paredes_totales_array = explode(",", $paredes_totales);

												for ($i = 0; $i < count($paredes_totales_array); $i++) {
													if ($paredes_totales_array[$i] != "") {
														if (strstr($paredes, $paredes_totales_array[$i])) {
															//Busco si tiene longitud marcada
															$result_longitud = $mysqli->query("SELECT longitud FROM planos_articulos_compuestos WHERE id_plano=" . $_GET['id_presupuesto'] . " AND id_articulo_compuesto=" . $arr_result["id"] . " AND pared='" . $paredes_totales_array[$i] . "' AND longitud != 0 LIMIT 1");

															if ($result_longitud->num_rows) {
																while ($arr_result_longitud = $result_longitud->fetch_array())
																	$longitud = $arr_result_longitud["longitud"];
																$valor_pared = $paredes_totales_array[$i] . "/" . $longitud;
															} else {
																$longitud = "";
																$valor_pared = $paredes_totales_array[$i];
															}
														} else {
															$longitud = "";
															$valor_pared = $paredes_totales_array[$i];
														}

														$metros_pared = explode(" ", $valor_pared);
											?>
														<span class="checkmuro">
															<input <?php if (strstr($paredes, $paredes_totales_array[$i])) { ?> checked <?php } ?> type="checkbox" name="paredes[]" class="paredes" value="<?php echo $valor_pared; ?>">
															<?php echo $paredes_totales_array[$i]; ?><br />
															<input class='child' name='seleccion_metros' type='checkbox' value='<?php echo $valor_pared; ?>' <?php if ($longitud == $metros_pared[2]) { ?>checked <?php } ?>> Completa <br />
															<input name='seleccion_metros' class='<?php echo $valor_pared; ?>' type='checkbox' value='parcial' <?php if ($longitud != "" && $longitud != $metros_pared[2]) { ?> checked <?php } ?>> Parcial
															<input type='range' value='0.1' min='0.1' name='metros_parcial' class='<?php echo $valor_pared; ?>' max='<?php echo $metros_pared[2]; ?>' step='0.01' oninput='this.nextElementSibling.value = this.value'>
															<output style='display:none'></output>

															<?php if ($longitud != "") { ?>
																<div class="metros_seleccionados">(<?php echo $longitud; ?>m seleccionados)</div>
															<?php } ?>
														</span>
													<?php
													}
												}
												//Le muestro todos los artículos simples
												$result_simples = $mysqli->query("SELECT * FROM articulos_simples WHERE id_articulo_compuesto=" . $arr_result["id"]);

												while ($arr_result_simples = $result_simples->fetch_array()) {
													$id_articulo_simple = $arr_result_simples["id"];
													$codigo_articulo_simple = $arr_result_simples["codigo"];
													$descripcion_articulo_simple = $arr_result_simples["descripcion"];
													$visible_cliente = $arr_result_simples["visible_cliente"];

													//Si está marcado porque lo elegió un verificador
													$result_elegido = $mysqli->query("SELECT id FROM planos_articulos_compuestos WHERE id_articulo_compuesto=" . $arr_result["id"] . " AND id_articulo_simple=$id_articulo_simple");
													?>
													<div><input <?php if ($visible_cliente == 1) { ?> checked <?php } else if ($result_elegido->num_rows) { ?>checked<?php } ?> type="checkbox" name="articulo_simple[]" value="<?php echo $id_articulo_simple; ?>"> <b><?php echo $codigo_articulo_simple; ?></b>: <?php echo utf8_encode($descripcion_articulo_simple); ?></div>
											<?php
												}
											}
											?>
										</form>
									</div>
									<?php
									if (isset($_GET["id_presupuesto"]) && $elemento_seleccionado) {
									?>
										<div style="color:#95C11F">Muros marcados: <?php echo $paredes; ?></div>
									<?php
									}

									?>
								<?php
								} else if ($arr_result["mostrar"] == "unidades") {
									//Le muestro un input para que me indique unidades
								?>
									<div class="unidades_elemento" <?php if (isset($_GET["id_presupuesto"])) { ?> style="display:block;" <?php } ?>>
										<form class="form_unidades" name="<?php echo $arr_result['id_imagen']; ?>" method="POST" action="#">
											<input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen']; ?>">
											<input type="range" value="1" min="1" max="30" step="1" oninput="this.nextElementSibling.value = this.value" class="<?php echo $arr_result['id_imagen']; ?>" name="unidades" <?php if ($arr_result["mostrar"] == "") { ?> style="display:none;" <?php } ?>>
											Unidades: <output style="display:inline-block">1</output>
											<?php
											if (isset($_GET["id_presupuesto"])) {
												//Le muestro todos los artículos simples
												$result_simples = $mysqli->query("SELECT * FROM articulos_simples WHERE id_articulo_compuesto=" . $arr_result["id"]);

												while ($arr_result_simples = $result_simples->fetch_array()) {
													$id_articulo_simple = $arr_result_simples["id"];
													$codigo_articulo_simple = $arr_result_simples["codigo"];
													$descripcion_articulo_simple = $arr_result_simples["descripcion"];
													$visible_cliente = $arr_result_simples["visible_cliente"];

													//Si está marcado porque lo elegió un verificador
													$result_elegido = $mysqli->query("SELECT id FROM planos_articulos_compuestos WHERE id_articulo_compuesto=" . $arr_result["id"] . " AND id_articulo_simple=$id_articulo_simple");

											?>
													<div><input <?php if ($visible_cliente == 1) { ?> checked <?php } else if ($result_elegido->num_rows) { ?>checked<?php } ?> type="checkbox" name="articulo_simple[]" value="<?php echo $id_articulo_simple; ?>"> <b><?php echo $codigo_articulo_simple; ?></b>: <?php echo utf8_encode($descripcion_articulo_simple); ?></div>
											<?php
												}
											}
											?>
										</form>
									</div>
								<?php
								} else if ($arr_result["mostrar"] == "metros_lineales") {
									//Le muestro un input para que me indique los metros_lineales
								?>
									<div class="metros_lineales" <?php if (isset($_GET["id_presupuesto"])) { ?> style="display:block;" <?php } ?>>
										<form class="form_metros" name="<?php echo $arr_result['id_imagen']; ?>" method="POST" action="#">
											<input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen']; ?>">
											<input type="range" value="<?php if (isset($metros_lineales) && $metros_lineales != 0) {
																			echo $metros_lineales;
																		} else { ?> 1 <?php } ?>" min="1" max="30" step="0.1" oninput="this.nextElementSibling.value = this.value" class="form-control" name="metros_lineales">
											Metros lineales: <output style="display:inline-block"><?php if (isset($metros_lineales) && $metros_lineales != 0) {
																										echo $metros_lineales;
																									} else { ?> 1 <?php } ?></output>
											<?php
											if (isset($_GET["id_presupuesto"])) {
												//Le muestro todos los artículos simples
												$result_simples = $mysqli->query("SELECT * FROM articulos_simples WHERE id_articulo_compuesto=" . $arr_result["id"]);

												while ($arr_result_simples = $result_simples->fetch_array()) {
													$id_articulo_simple = $arr_result_simples["id"];
													$codigo_articulo_simple = $arr_result_simples["codigo"];
													$descripcion_articulo_simple = $arr_result_simples["descripcion"];
													$visible_cliente = $arr_result_simples["visible_cliente"];

													//Si está marcado porque lo elegió un verificador
													$result_elegido = $mysqli->query("SELECT id FROM planos_articulos_compuestos WHERE id_articulo_compuesto=" . $arr_result["id"] . " AND id_articulo_simple=$id_articulo_simple");
											?>
													<div><input <?php if ($visible_cliente == 1) { ?> checked <?php } else if ($result_elegido->num_rows) { ?>checked<?php } ?> type="checkbox" name="articulo_simple[]" value="<?php echo $id_articulo_simple; ?>"> <b><?php echo $codigo_articulo_simple; ?></b>: <?php echo utf8_encode($descripcion_articulo_simple); ?></div>
											<?php
												}
											}
											?>

										</form>
									</div>
								<?php
								} else {
								?>

									<form class="form_generico" name="<?php echo $arr_result['id_imagen']; ?>" method="POST" action="#">
										<input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen']; ?>">
									</form>

								<?php
								}

								?>

							</li>
						<?php
						}
						?>

					</ul>
					<!-- aquí me he quedado corrigiendo -->
					<ul class="owl-carousel owl-theme listado_instalaciones listado_imagenes" id="gas" style="display:none">
						<?php
						$result = $mysqli->query("SELECT * FROM articulos_compuestos WHERE tipo=5");

						while ($arr_result = $result->fetch_array()) {
							//$id_simple_clientes=$arr_result["id_articulo_simple"];
							if (isset($_GET["id_presupuesto"])) {
								//Si existe id usuario, está viendo un mapa ya creado, miro si seleccionó alguno de estos elementos
								$result_seleccion = $mysqli->query("SELECT * FROM planos_articulos_compuestos WHERE id_plano=" . $_GET["id_presupuesto"] . " AND id_articulo_compuesto=" . $arr_result["id"]);

								if ($result_seleccion->num_rows) {
									$elemento_seleccionado = true;
									$paredes = "";
									while ($arr_result_seleccion = $result_seleccion->fetch_array()) {
										if ($paredes == "")
											$paredes = $arr_result_seleccion["pared"];
										else
											$paredes = $paredes . "," . $arr_result_seleccion["pared"];

										$paredes_totales = $arr_result_seleccion["total_paredes"];
										$unidades = $arr_result_seleccion["unidades"];
									}
								} else {
									$elemento_seleccionado = false;
									$paredes = "";
									$result_paredes_totales = $mysqli->query("SELECT total_paredes FROM planos_articulos_compuestos WHERE id_plano=" . $_GET["id_presupuesto"] . " LIMIT 1");

									while ($arr_result_paredes_totales = $result_paredes_totales->fetch_array())
										$paredes_totales = $arr_result_paredes_totales["total_paredes"];
								}
							}
						?>
							<li>
								<?php echo nl2br($arr_result['nombre']); ?>
								<i class="fa fa-info-circle" onclick="instrucciones('<?php echo $arr_result["id_imagen"]; ?>')"></i>
								<br>
								<img src="<?php echo $arr_result['imagen']; ?>" class="elemento_instalacion <?php if (isset($_GET["id_presupuesto"]) && $elemento_seleccionado) { ?> selected <?php } ?>" id="<?php echo $arr_result['id_imagen']; ?>">
								<?php
								if ($arr_result["mostrar"] == "muros") {
									//Le dejo que seleccione el/los muros a los que va esta acción
								?>

									<div class="listado_muros" <?php if (isset($_GET["id_presupuesto"])) { ?> style="display:block;" <?php } ?>>
										<form class="form_muros" name="<?php echo $arr_result['id_imagen']; ?>" method="POST" action="#">
											<input type="checkbox" name="todos_muros" value="1"> Todas las paredes<br /><br />
											<input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen']; ?>">
											<?php
											if (isset($_GET["id_presupuesto"])) {

												//Le muestro muros
												$paredes_totales_array = explode(",", $paredes_totales);

												for ($i = 0; $i < count($paredes_totales_array); $i++) {
													if ($paredes_totales_array[$i] != "") {
														if (strstr($paredes, $paredes_totales_array[$i])) {
															//Busco si tiene longitud marcada
															$result_longitud = $mysqli->query("SELECT longitud FROM planos_articulos_compuestos WHERE id_plano=" . $_GET['id_presupuesto'] . " AND id_articulo_compuesto=" . $arr_result["id"] . " AND pared='" . $paredes_totales_array[$i] . "' AND longitud != 0 LIMIT 1");

															if ($result_longitud->num_rows) {
																while ($arr_result_longitud = $result_longitud->fetch_array())
																	$longitud = $arr_result_longitud["longitud"];
																$valor_pared = $paredes_totales_array[$i] . "/" . $longitud;
															} else {
																$longitud = "";
																$valor_pared = $paredes_totales_array[$i];
															}
														} else {
															$longitud = "";
															$valor_pared = $paredes_totales_array[$i];
														}

														$metros_pared = explode(" ", $valor_pared);
											?>
														<span class="checkmuro">
															<input <?php if (strstr($paredes, $paredes_totales_array[$i])) { ?> checked <?php } ?> type="checkbox" name="paredes[]" class="paredes" value="<?php echo $valor_pared; ?>">
															<?php echo $paredes_totales_array[$i]; ?><br />
															<input class='child' name='seleccion_metros' type='checkbox' value='<?php echo $valor_pared; ?>' <?php if ($longitud == $metros_pared[2]) { ?>checked <?php } ?>> Completa <br />
															<input name='seleccion_metros' class='<?php echo $valor_pared; ?>' type='checkbox' value='parcial' <?php if ($longitud != "" && $longitud != $metros_pared[2]) { ?> checked <?php } ?>> Parcial
															<input type='range' value='0.1' min='0.1' name='metros_parcial' class='<?php echo $valor_pared; ?>' max='<?php echo $metros_pared[2]; ?>' step='0.01' oninput='this.nextElementSibling.value = this.value'>
															<output style='display:none'></output>

															<?php if ($longitud != "") { ?>
																<div class="metros_seleccionados">(<?php echo $longitud; ?>m seleccionados)</div>
															<?php } ?>
														</span>
													<?php
													}
												}
												//Le muestro todos los artículos simples
												$result_simples = $mysqli->query("SELECT * FROM articulos_simples WHERE id_articulo_compuesto=" . $arr_result["id"]);

												while ($arr_result_simples = $result_simples->fetch_array()) {
													$id_articulo_simple = $arr_result_simples["id"];
													$codigo_articulo_simple = $arr_result_simples["codigo"];
													$descripcion_articulo_simple = $arr_result_simples["descripcion"];
													$visible_cliente = $arr_result_simples["visible_cliente"];

													//Si está marcado porque lo elegió un verificador
													$result_elegido = $mysqli->query("SELECT id FROM planos_articulos_compuestos WHERE id_articulo_compuesto=" . $arr_result["id"] . " AND id_articulo_simple=$id_articulo_simple");

													?>
													<div><input <?php if ($visible_cliente == 1) { ?> checked <?php } else if ($result_elegido->num_rows) { ?>checked<?php } ?> type="checkbox" name="articulo_simple[]" value="<?php echo $id_articulo_simple; ?>"> <b><?php echo $codigo_articulo_simple; ?></b>: <?php echo utf8_encode($descripcion_articulo_simple); ?></div>
											<?php
												}
											}
											?>
										</form>
									</div>
									<?php
									if (isset($_GET["id_presupuesto"]) && $elemento_seleccionado) {
									?>
										<div style="color:#95C11F">Muros marcados: <?php echo $paredes; ?></div>
									<?php
									}

									?>

								<?php
								} else if ($arr_result["mostrar"] == "unidades") {
									//Le muestro un input para que me indique unidades
								?>
									<div class="unidades_elemento" <?php if (isset($_GET["id_presupuesto"])) { ?> style="display:block;" <?php } ?>>
										<form class="form_unidades" name="<?php echo $arr_result['id_imagen']; ?>" method="POST" action="#">
											<input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen']; ?>">
											<input type="range" value="1" min="1" max="30" step="1" oninput="this.nextElementSibling.value = this.value" class="<?php echo $arr_result['id_imagen']; ?>" name="unidades" <?php if ($arr_result["mostrar"] == "") { ?> style="display:none;" <?php } ?>>
											Unidades: <output style="display:inline-block">1</output>
											<?php
											if (isset($_GET["id_presupuesto"])) {
												//Le muestro todos los artículos simples
												$result_simples = $mysqli->query("SELECT * FROM articulos_simples WHERE id_articulo_compuesto=" . $arr_result["id"]);

												while ($arr_result_simples = $result_simples->fetch_array()) {
													$id_articulo_simple = $arr_result_simples["id"];
													$codigo_articulo_simple = $arr_result_simples["codigo"];
													$descripcion_articulo_simple = $arr_result_simples["descripcion"];
													$visible_cliente = $arr_result_simples["visible_cliente"];

													//Si está marcado porque lo elegió un verificador
													$result_elegido = $mysqli->query("SELECT id FROM planos_articulos_compuestos WHERE id_articulo_compuesto=" . $arr_result["id"] . " AND id_articulo_simple=$id_articulo_simple");
											?>
													<div><input <?php if ($visible_cliente == 1) { ?> checked <?php } else if ($result_elegido->num_rows) { ?>checked<?php } ?> type="checkbox" name="articulo_simple[]" value="<?php echo $id_articulo_simple; ?>"> <b><?php echo $codigo_articulo_simple; ?></b>: <?php echo utf8_encode($descripcion_articulo_simple); ?></div>
											<?php
												}
											}
											?>

										</form>
									</div>
								<?php
								} else if ($arr_result["mostrar"] == "metros_lineales") {
									//Le muestro un input para que me indique los metros_lineales
								?>
									<div class="metros_lineales" <?php if (isset($_GET["id_presupuesto"])) { ?> style="display:block;" <?php } ?>>
										<form class="form_metros" name="<?php echo $arr_result['id_imagen']; ?>" method="POST" action="#">
											<input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen']; ?>">
											<input type="range" value="<?php if (isset($metros_lineales) && $metros_lineales != 0) {
																			echo $metros_lineales;
																		} else { ?> 1 <?php } ?>" min="1" max="30" step="0.1" oninput="this.nextElementSibling.value = this.value" class="form-control" name="metros_lineales">
											Metros lineales: <output style="display:inline-block"><?php if (isset($metros_lineales) && $metros_lineales != 0) {
																										echo $metros_lineales;
																									} else { ?> 1 <?php } ?></output>
											<?php
											if (isset($_GET["id_presupuesto"])) {
												//Le muestro todos los artículos simples
												$result_simples = $mysqli->query("SELECT * FROM articulos_simples WHERE id_articulo_compuesto=" . $arr_result["id"]);

												while ($arr_result_simples = $result_simples->fetch_array()) {
													$id_articulo_simple = $arr_result_simples["id"];
													$codigo_articulo_simple = $arr_result_simples["codigo"];
													$descripcion_articulo_simple = $arr_result_simples["descripcion"];
													$visible_cliente = $arr_result_simples["visible_cliente"];

													//Si está marcado porque lo elegió un verificador
													$result_elegido = $mysqli->query("SELECT id FROM planos_articulos_compuestos WHERE id_articulo_compuesto=" . $arr_result["id"] . " AND id_articulo_simple=$id_articulo_simple");
											?>
													<div><input <?php if ($visible_cliente == 1) { ?> checked <?php } else if ($result_elegido->num_rows) { ?>checked<?php } ?> type="checkbox" name="articulo_simple[]" value="<?php echo $id_articulo_simple; ?>"> <b><?php echo $codigo_articulo_simple; ?></b>: <?php echo utf8_encode($descripcion_articulo_simple); ?></div>
											<?php
												}
											}
											?>

										</form>
									</div>
								<?php
								} else {
								?>

									<form class="form_generico" name="<?php echo $arr_result['id_imagen']; ?>" method="POST" action="#">
										<input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen']; ?>">
									</form>

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
						$result = $mysqli->query("SELECT * FROM articulos_compuestos WHERE tipo=6");

						while ($arr_result = $result->fetch_array()) {
							//$id_simple_clientes=$arr_result["id_articulo_simple"];
							if (isset($_GET["id_presupuesto"])) {
								//Si existe id usuario, está viendo un mapa ya creado, miro si seleccionó alguno de estos elementos
								$result_seleccion = $mysqli->query("SELECT * FROM planos_articulos_compuestos WHERE id_plano=" . $_GET["id_presupuesto"] . " AND id_articulo_compuesto=" . $arr_result["id"]);

								if ($result_seleccion->num_rows) {
									$elemento_seleccionado = true;
									$paredes = "";
									while ($arr_result_seleccion = $result_seleccion->fetch_array()) {
										if ($paredes == "")
											$paredes = $arr_result_seleccion["pared"];
										else
											$paredes = $paredes . "," . $arr_result_seleccion["pared"];

										$paredes_totales = $arr_result_seleccion["total_paredes"];
										$unidades = $arr_result_seleccion["unidades"];
									}
								} else {
									$elemento_seleccionado = false;
									$paredes = "";
									$result_paredes_totales = $mysqli->query("SELECT total_paredes FROM planos_articulos_compuestos WHERE id_plano=" . $_GET["id_presupuesto"] . " LIMIT 1");

									while ($arr_result_paredes_totales = $result_paredes_totales->fetch_array())
										$paredes_totales = $arr_result_paredes_totales["total_paredes"];
								}
							}
						?>
							<li>
								<?php echo nl2br($arr_result['nombre']); ?>
								<i class="fa fa-info-circle" onclick="instrucciones('<?php echo $arr_result["id_imagen"]; ?>')"></i>
								<br>
								<img src="<?php echo $arr_result['imagen']; ?>" class="elemento_instalacion <?php if (isset($_GET["id_presupuesto"]) && $elemento_seleccionado) { ?> selected <?php } ?>" id="<?php echo $arr_result['id_imagen']; ?>">
								<?php
								if ($arr_result["mostrar"] == "muros") {
									//Le dejo que seleccione el/los muros a los que va esta acción
								?>

									<div class="listado_muros" <?php if (isset($_GET["id_presupuesto"])) { ?> style="display:block;" <?php } ?>>
										<form class="form_muros" name="<?php echo $arr_result['id_imagen']; ?>" method="POST" action="#">
											<input type="checkbox" name="todos_muros" value="1"> Todas las paredes<br /><br />
											<input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen']; ?>">
											<?php
											if (isset($_GET["id_presupuesto"])) {
												//Le muestro muros
												$paredes_totales_array = explode(",", $paredes_totales);

												for ($i = 0; $i < count($paredes_totales_array); $i++) {
													if ($paredes_totales_array[$i] != "") {
														if (strstr($paredes, $paredes_totales_array[$i])) {
															//Busco si tiene longitud marcada
															$result_longitud = $mysqli->query("SELECT longitud FROM planos_articulos_compuestos WHERE id_plano=" . $_GET['id_presupuesto'] . " AND id_articulo_compuesto=" . $arr_result["id"] . " AND pared='" . $paredes_totales_array[$i] . "' AND longitud != 0 LIMIT 1");

															if ($result_longitud->num_rows) {
																while ($arr_result_longitud = $result_longitud->fetch_array())
																	$longitud = $arr_result_longitud["longitud"];
																$valor_pared = $paredes_totales_array[$i] . "/" . $longitud;
															} else {
																$longitud = "";
																$valor_pared = $paredes_totales_array[$i];
															}
														} else {
															$longitud = "";
															$valor_pared = $paredes_totales_array[$i];
														}

														$metros_pared = explode(" ", $valor_pared);
											?>
														<span class="checkmuro">
															<input <?php if (strstr($paredes, $paredes_totales_array[$i])) { ?> checked <?php } ?> type="checkbox" name="paredes[]" class="paredes" value="<?php echo $valor_pared; ?>">
															<?php echo $paredes_totales_array[$i]; ?><br />
															<input class='child' name='seleccion_metros' type='checkbox' value='<?php echo $valor_pared; ?>' <?php if ($longitud == $metros_pared[2]) { ?>checked <?php } ?>> Completa <br />
															<input name='seleccion_metros' class='<?php echo $valor_pared; ?>' type='checkbox' value='parcial' <?php if ($longitud != "" && $longitud != $metros_pared[2]) { ?> checked <?php } ?>> Parcial
															<input type='range' value='0.1' min='0.1' name='metros_parcial' class='<?php echo $valor_pared; ?>' max='<?php echo $metros_pared[2]; ?>' step='0.01' oninput='this.nextElementSibling.value = this.value'>
															<output style='display:none'></output>

															<?php if ($longitud != "") { ?>
																<div class="metros_seleccionados">(<?php echo $longitud; ?>m seleccionados)</div>
															<?php } ?>
														</span>
													<?php
													}
												}

												//Le muestro todos los artículos simples
												$result_simples = $mysqli->query("SELECT * FROM articulos_simples WHERE id_articulo_compuesto=" . $arr_result["id"]);

												while ($arr_result_simples = $result_simples->fetch_array()) {
													$id_articulo_simple = $arr_result_simples["id"];
													$codigo_articulo_simple = $arr_result_simples["codigo"];
													$descripcion_articulo_simple = $arr_result_simples["descripcion"];
													$visible_cliente = $arr_result_simples["visible_cliente"];

													//Si está marcado porque lo elegió un verificador
													$result_elegido = $mysqli->query("SELECT id FROM planos_articulos_compuestos WHERE id_articulo_compuesto=" . $arr_result["id"] . " AND id_articulo_simple=$id_articulo_simple");
													?>
													<div><input <?php if ($visible_cliente == 1) { ?> checked <?php } else if ($result_elegido->num_rows) { ?>checked<?php } ?> type="checkbox" name="articulo_simple[]" value="<?php echo $id_articulo_simple; ?>"> <b><?php echo $codigo_articulo_simple; ?></b>: <?php echo utf8_encode($descripcion_articulo_simple); ?></div>
											<?php
												}
											}
											?>
										</form>
									</div>
									<?php
									if (isset($_GET["id_presupuesto"]) && $elemento_seleccionado) {
									?>
										<div style="color:#95C11F">Muros marcados: <?php echo $paredes; ?></div>
									<?php
									}

									?>
								<?php
								} else if ($arr_result["mostrar"] == "unidades") {
									//Le muestro un input para que me indique unidades
								?>
									<div class="unidades_elemento" <?php if (isset($_GET["id_presupuesto"])) { ?> style="display:block;" <?php } ?>>
										<form class="form_unidades" name="<?php echo $arr_result['id_imagen']; ?>" method="POST" action="#">
											<input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen']; ?>">
											<input type="range" value="1" min="1" max="30" step="1" oninput="this.nextElementSibling.value = this.value" class="<?php echo $arr_result['id_imagen']; ?>" name="unidades" <?php if ($arr_result["mostrar"] == "") { ?> style="display:none;" <?php } ?>>
											Unidades: <output style="display:inline-block">1</output>
											<?php
											if (isset($_GET["id_presupuesto"])) {
												//Le muestro todos los artículos simples
												$result_simples = $mysqli->query("SELECT * FROM articulos_simples WHERE id_articulo_compuesto=" . $arr_result["id"]);

												while ($arr_result_simples = $result_simples->fetch_array()) {
													$id_articulo_simple = $arr_result_simples["id"];
													$codigo_articulo_simple = $arr_result_simples["codigo"];
													$descripcion_articulo_simple = $arr_result_simples["descripcion"];
													$visible_cliente = $arr_result_simples["visible_cliente"];

													//Si está marcado porque lo elegió un verificador
													$result_elegido = $mysqli->query("SELECT id FROM planos_articulos_compuestos WHERE id_articulo_compuesto=" . $arr_result["id"] . " AND id_articulo_simple=$id_articulo_simple");

											?>
													<div><input <?php if ($visible_cliente == 1) { ?> checked <?php } else if ($result_elegido->num_rows) { ?>checked<?php } ?> type="checkbox" name="articulo_simple[]" value="<?php echo $id_articulo_simple; ?>"> <b><?php echo $codigo_articulo_simple; ?></b>: <?php echo utf8_encode($descripcion_articulo_simple); ?></div>
											<?php
												}
											}
											?>
										</form>
									</div>
								<?php
								} else if ($arr_result["mostrar"] == "metros_lineales") {
									//Le muestro un input para que me indique los metros_lineales
								?>
									<div class="metros_lineales" <?php if (isset($_GET["id_presupuesto"])) { ?> style="display:block;" <?php } ?>>
										<form class="form_metros" name="<?php echo $arr_result['id_imagen']; ?>" method="POST" action="#">
											<input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen']; ?>">
											<input type="range" value="<?php if (isset($metros_lineales) && $metros_lineales != 0) {
																			echo $metros_lineales;
																		} else { ?> 1 <?php } ?>" min="1" max="30" step="0.1" oninput="this.nextElementSibling.value = this.value" class="form-control" name="metros_lineales">
											Metros lineales: <output style="display:inline-block"><?php if (isset($metros_lineales) && $metros_lineales != 0) {
																										echo $metros_lineales;
																									} else { ?> 1 <?php } ?></output>
											<?php
											if (isset($_GET["id_presupuesto"])) {
												//Le muestro todos los artículos simples
												$result_simples = $mysqli->query("SELECT * FROM articulos_simples WHERE id_articulo_compuesto=" . $arr_result["id"]);

												while ($arr_result_simples = $result_simples->fetch_array()) {
													$id_articulo_simple = $arr_result_simples["id"];
													$codigo_articulo_simple = $arr_result_simples["codigo"];
													$descripcion_articulo_simple = $arr_result_simples["descripcion"];
													$visible_cliente = $arr_result_simples["visible_cliente"];

													//Si está marcado porque lo elegió un verificador
													$result_elegido = $mysqli->query("SELECT id FROM planos_articulos_compuestos WHERE id_articulo_compuesto=" . $arr_result["id"] . " AND id_articulo_simple=$id_articulo_simple");
											?>
													<div><input <?php if ($visible_cliente == 1) { ?> checked <?php } else if ($result_elegido->num_rows) { ?>checked<?php } ?> type="checkbox" name="articulo_simple[]" value="<?php echo $id_articulo_simple; ?>"> <b><?php echo $codigo_articulo_simple; ?></b>: <?php echo utf8_encode($descripcion_articulo_simple); ?></div>
											<?php
												}
											}
											?>

										</form>
									</div>
								<?php
								} else {
								?>

									<form class="form_generico" name="<?php echo $arr_result['id_imagen']; ?>" method="POST" action="#">
										<input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen']; ?>">
									</form>

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
						$result = $mysqli->query("SELECT * FROM articulos_compuestos WHERE tipo=7");

						while ($arr_result = $result->fetch_array()) {
							//$id_simple_clientes=$arr_result["id_articulo_simple"];
							if (isset($_GET["id_presupuesto"])) {
								//Si existe id usuario, está viendo un mapa ya creado, miro si seleccionó alguno de estos elementos
								$result_seleccion = $mysqli->query("SELECT * FROM planos_articulos_compuestos WHERE id_plano=" . $_GET["id_presupuesto"] . " AND id_articulo_compuesto=" . $arr_result["id"]);

								if ($result_seleccion->num_rows) {
									$elemento_seleccionado = true;
									$paredes = "";
									while ($arr_result_seleccion = $result_seleccion->fetch_array()) {
										if ($paredes == "")
											$paredes = $arr_result_seleccion["paredes"];
										else
											$paredes = $paredes . "," . $arr_result_seleccion["paredes"];

										$paredes_totales = $arr_result_seleccion["total_paredes"];
										$unidades = $arr_result_seleccion["unidades"];
									}
								} else {
									$elemento_seleccionado = false;
									$paredes = "";
									$result_paredes_totales = $mysqli->query("SELECT total_paredes FROM planos_articulos_compuestos WHERE id_plano=" . $_GET["id_presupuesto"] . " LIMIT 1");

									while ($arr_result_paredes_totales = $result_paredes_totales->fetch_array())
										$paredes_totales = $arr_result_paredes_totales["total_paredes"];
								}
							}
						?>
							<li>
								<?php echo nl2br($arr_result['nombre']); ?>
								<i class="fa fa-info-circle" onclick="instrucciones('<?php echo $arr_result["id_imagen"]; ?>')"></i>
								<br>
								<img src="<?php echo $arr_result['imagen']; ?>" class="elemento_instalacion <?php if (isset($_GET["id_presupuesto"]) && $elemento_seleccionado) { ?> selected <?php } ?>" id="<?php echo $arr_result['id_imagen']; ?>">
								<?php
								if ($arr_result["mostrar"] == "muros") {
									//Le dejo que seleccione el/los muros a los que va esta acción
								?>

									<div class="listado_muros" <?php if (isset($_GET["id_presupuesto"])) { ?> style="display:block;" <?php } ?>>
										<form class="form_muros" name="<?php echo $arr_result['id_imagen']; ?>" method="POST" action="#">
											<input type="checkbox" name="todos_muros" value="1"> Todas las paredes<br /><br />
											<input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen']; ?>">
											<?php
											if (isset($_GET["id_presupuesto"])) {
												//Le muestro muros
												$paredes_totales_array = explode(",", $paredes_totales);

												for ($i = 0; $i < count($paredes_totales_array); $i++) {
													if ($paredes_totales_array[$i] != "") {
														if (strstr($paredes, $paredes_totales_array[$i])) {
															//Busco si tiene longitud marcada
															$result_longitud = $mysqli->query("SELECT longitud FROM planos_articulos_compuestos WHERE id_plano=" . $_GET['id_presupuesto'] . " AND id_articulo_compuesto=" . $arr_result["id"] . " AND pared='" . $paredes_totales_array[$i] . "' AND longitud != 0 LIMIT 1");

															if ($result_longitud->num_rows) {
																while ($arr_result_longitud = $result_longitud->fetch_array())
																	$longitud = $arr_result_longitud["longitud"];
																$valor_pared = $paredes_totales_array[$i] . "/" . $longitud;
															} else {
																$longitud = "";
																$valor_pared = $paredes_totales_array[$i];
															}
														} else {
															$longitud = "";
															$valor_pared = $paredes_totales_array[$i];
														}

														$metros_pared = explode(" ", $valor_pared);
											?>
														<span class="checkmuro">
															<input <?php if (strstr($paredes, $paredes_totales_array[$i])) { ?> checked <?php } ?> type="checkbox" name="paredes[]" class="paredes" value="<?php echo $valor_pared; ?>">
															<?php echo $paredes_totales_array[$i]; ?><br />
															<input class='child' name='seleccion_metros' type='checkbox' value='<?php echo $valor_pared; ?>' <?php if ($longitud == $metros_pared[2]) { ?>checked <?php } ?>> Completa <br />
															<input name='seleccion_metros' class='<?php echo $valor_pared; ?>' type='checkbox' value='parcial' <?php if ($longitud != "" && $longitud != $metros_pared[2]) { ?> checked <?php } ?>> Parcial
															<input type='range' value='0.1' min='0.1' name='metros_parcial' class='<?php echo $valor_pared; ?>' max='<?php echo $metros_pared[2]; ?>' step='0.01' oninput='this.nextElementSibling.value = this.value'>
															<output style='display:none'></output>

															<?php if ($longitud != "") { ?>
																<div class="metros_seleccionados">(<?php echo $longitud; ?>m seleccionados)</div>
															<?php } ?>
														</span>
													<?php
													}
												}

												//Le muestro todos los artículos simples
												$result_simples = $mysqli->query("SELECT * FROM articulos_simples WHERE id_articulo_compuesto=" . $arr_result["id"]);

												while ($arr_result_simples = $result_simples->fetch_array()) {
													$id_articulo_simple = $arr_result_simples["id"];
													$codigo_articulo_simple = $arr_result_simples["codigo"];
													$descripcion_articulo_simple = $arr_result_simples["descripcion"];
													$visible_cliente = $arr_result_simples["visible_cliente"];

													//Si está marcado porque lo elegió un verificador
													$result_elegido = $mysqli->query("SELECT id FROM planos_articulos_compuestos WHERE id_articulo_compuesto=" . $arr_result["id"] . " AND id_articulo_simple=$id_articulo_simple");

													?>
													<div><input <?php if ($visible_cliente == 1) { ?> checked <?php } else if ($result_elegido->num_rows) { ?>checked<?php } ?> type="checkbox" name="articulo_simple[]" value="<?php echo $id_articulo_simple; ?>"> <b><?php echo $codigo_articulo_simple; ?></b>: <?php echo utf8_encode($descripcion_articulo_simple); ?></div>
											<?php
												}
											}
											?>
										</form>
									</div>
									<?php
									if (isset($_GET["id_presupuesto"]) && $elemento_seleccionado) {
									?>
										<div style="color:#95C11F">Muros marcados: <?php echo $paredes; ?></div>
									<?php
									}

									?>
								<?php
								} else if ($arr_result["mostrar"] == "unidades") {
									//Le muestro un input para que me indique unidades
								?>
									<div class="unidades_elemento" <?php if (isset($_GET["id_presupuesto"])) { ?> style="display:block;" <?php } ?>>
										<form class="form_unidades" name="<?php echo $arr_result['id_imagen']; ?>" method="POST" action="#">
											<input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen']; ?>">
											<input type="range" value="1" min="1" max="30" step="1" oninput="this.nextElementSibling.value = this.value" class="<?php echo $arr_result['id_imagen']; ?>" name="unidades" <?php if ($arr_result["mostrar"] == "") { ?> style="display:none;" <?php } ?>>
											Unidades: <output style="display:inline-block">1</output>
											<?php
											if (isset($_GET["id_presupuesto"])) {
												//Le muestro todos los artículos simples
												$result_simples = $mysqli->query("SELECT * FROM articulos_simples WHERE id_articulo_compuesto=" . $arr_result["id"]);

												while ($arr_result_simples = $result_simples->fetch_array()) {
													$id_articulo_simple = $arr_result_simples["id"];
													$codigo_articulo_simple = $arr_result_simples["codigo"];
													$descripcion_articulo_simple = $arr_result_simples["descripcion"];
													$visible_cliente = $arr_result_simples["visible_cliente"];

													//Si está marcado porque lo elegió un verificador
													$result_elegido = $mysqli->query("SELECT id FROM planos_articulos_compuestos WHERE id_articulo_compuesto=" . $arr_result["id"] . " AND id_articulo_simple=$id_articulo_simple");

											?>
													<div><input <?php if ($visible_cliente == 1) { ?> checked <?php } else if ($result_elegido->num_rows) { ?>checked<?php } ?> type="checkbox" name="articulo_simple[]" value="<?php echo $id_articulo_simple; ?>"> <b><?php echo $codigo_articulo_simple; ?></b>: <?php echo utf8_encode($descripcion_articulo_simple); ?></div>
											<?php
												}
											}
											?>
										</form>
									</div>
								<?php
								} else if ($arr_result["mostrar"] == "metros_lineales") {
									//Le muestro un input para que me indique los metros_lineales
								?>
									<div class="metros_lineales" <?php if (isset($_GET["id_presupuesto"])) { ?> style="display:block;" <?php } ?>>
										<form class="form_metros" name="<?php echo $arr_result['id_imagen']; ?>" method="POST" action="#">
											<input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen']; ?>">
											<input type="range" value="<?php if (isset($metros_lineales) && $metros_lineales != 0) {
																			echo $metros_lineales;
																		} else { ?> 1 <?php } ?>" min="1" max="30" step="0.1" oninput="this.nextElementSibling.value = this.value" class="form-control" name="metros_lineales">
											Metros lineales: <output style="display:inline-block"><?php if (isset($metros_lineales) && $metros_lineales != 0) {
																										echo $metros_lineales;
																									} else { ?> 1 <?php } ?></output>
											<?php
											if (isset($_GET["id_presupuesto"])) {
												//Le muestro todos los artículos simples
												$result_simples = $mysqli->query("SELECT * FROM articulos_simples WHERE id_articulo_compuesto=" . $arr_result["id"]);

												while ($arr_result_simples = $result_simples->fetch_array()) {
													$id_articulo_simple = $arr_result_simples["id"];
													$codigo_articulo_simple = $arr_result_simples["codigo"];
													$descripcion_articulo_simple = $arr_result_simples["descripcion"];
													$visible_cliente = $arr_result_simples["visible_cliente"];

													//Si está marcado porque lo elegió un verificador
													$result_elegido = $mysqli->query("SELECT id FROM planos_articulos_compuestos WHERE id_articulo_compuesto=" . $arr_result["id"] . " AND id_articulo_simple=$id_articulo_simple");
											?>
													<div><input <?php if ($visible_cliente == 1) { ?> checked <?php } else if ($result_elegido->num_rows) { ?>checked<?php } ?> type="checkbox" name="articulo_simple[]" value="<?php echo $id_articulo_simple; ?>"> <b><?php echo $codigo_articulo_simple; ?></b>: <?php echo utf8_encode($descripcion_articulo_simple); ?></div>
											<?php
												}
											}
											?>

										</form>
									</div>
								<?php
								} else {
								?>

									<form class="form_generico" name="<?php echo $arr_result['id_imagen']; ?>" method="POST" action="#">
										<input type="text" name="elemento" style="display:none" value="<?php echo $arr_result['id_imagen']; ?>">
									</form>

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

				if (isset($_GET["id_presupuesto"]) && isset($_SESSION["login"])) {

					$result_materiales = $mysqli->query("SELECT referencia_material FROM planos_materiales WHERE id_plano=" . $_GET["id_presupuesto"]);
					$referencias_material = "";

					if ($result_materiales->num_rows) {
						while ($arr_result_materiales = $result_materiales->fetch_array()) {
							$referencias_material .= $arr_result_materiales["referencia_material"] . ",";
						}

						$referencias_material = substr($referencias_material, 0, -1);
					}

					$referencia_material = explode(",", $referencias_material);
				} else {
					//Inicializo referencia_material como un array vacio
					//Para evitar errores de undefined variable
					$referencia_material = array();
				}

				?>
				<div id="opciones_equipamiento">
					<button class="blackBtn" onclick="hideStep5SubMenus(this);">TERMOS ELECTRICOS</button>
					<div class="child_list">
						<div class="thermusList" style="display:grid; grid-template-columns: auto;">
							<div class="dropdown_thermus">
								<img src="CapasCocina/EQUIPAMIENTO/TermoFleckDuo-5EU.png" <?php if (in_array("PLA00106438", $referencia_material) || in_array("PLA00107800", $referencia_material)) { ?> class="active" <?php } ?> />
								<div style="width:97.5%; margin-left:2.5%">
									<p>Termo Eléctrico Fleck Duo-5</p>
									<div class="dropdown-content">
										<p>Selecciona capacidad</p>

										<button id="PLA00106438" class="equipamiento <?php if (in_array("PLA00106438", $referencia_material)) { ?>active <?php } ?>" onclick="manageStep5Submenu(this,0);">80 Litros</button>
										<button id="PLA00107800" class="equipamiento <?php if (in_array("PLA00107800", $referencia_material)) { ?>active <?php } ?>" onclick="manageStep5Submenu(this,0);">100 Litros</button>

									</div>

								</div>
							</div>
							<div class="dropdown_thermus">
								<img src="CapasCocina/EQUIPAMIENTO/ThermorConcept.png" <?php if (in_array("PLA00146116", $referencia_material) || in_array("PLA00146114", $referencia_material) || in_array("PLA00146111", $referencia_material) || in_array("PLA00146112", $referencia_material)) { ?> class="active" <?php } ?> />
								<div style="width:90%; margin-left:10%">
									<p>Termo Eléctrico Thermor Concept</p>
									<div class="dropdown-content">
										<p>Selecciona capacidad</p>
										<button id="PLA00146116" class="equipamiento <?php if (in_array("PLA00146116", $referencia_material)) { ?>active <?php } ?>" onclick="manageStep5Submenu(this,0);">30 Litros</button>
										<button id="PLA00146114" class="equipamiento <?php if (in_array("PLA00146114", $referencia_material)) { ?>active <?php } ?>" onclick="manageStep5Submenu(this,0);">50 Litros</button>
										<button id="PLA00146111" class="equipamiento <?php if (in_array("PLA00146111", $referencia_material)) { ?>active <?php } ?>" onclick="manageStep5Submenu(this,0);">80 Litros</button>
										<button id="PLA00146112" class="equipamiento <?php if (in_array("PLA00146112", $referencia_material)) { ?>active <?php } ?>" onclick="manageStep5Submenu(this,0);">100 Litros</button>
									</div>

								</div>
							</div>
							<div class="dropdown_thermus">
								<img src="CapasCocina/EQUIPAMIENTO/CeresAltech.png" <?php if (in_array("PLA00405804", $referencia_material) || in_array("PLA00405805", $referencia_material) || in_array("PLA00405807", $referencia_material)) { ?> class="active" <?php } ?> />
								<div style="width:97.5%; margin-left:2.5%">
									<p>Termo Eléctrico Ceres-Altech</p>
									<div class="dropdown-content">
										<p>Selecciona capacidad</p>

										<button id="PLA00405804" class="equipamiento <?php if (in_array("PLA00405804", $referencia_material)) { ?>active <?php } ?>" onclick="manageStep5Submenu(this,0);">50 Litros</button>
										<button id="PLA00405805" class="equipamiento <?php if (in_array("PLA00405805", $referencia_material)) { ?>active <?php } ?>" onclick="manageStep5Submenu(this,0);">80 Litros</button>
										<button id="PLA00405807" class="equipamiento <?php if (in_array("PLA00405807", $referencia_material)) { ?>active <?php } ?>" onclick="manageStep5Submenu(this,0);">100 Litros</button>
									</div>

								</div>
							</div>
						</div>
					</div>
					<button class="blackBtn" onclick="hideStep5SubMenus(this);">CALENTADORES DE GAS NATURAL</button>
					<div class="child_list">
						<div class="calentadoresList" style="/* display:grid; grid-template-columns: auto auto; */width: 80%;margin: 0px auto;">

							<button id="PLA00370460" class="equipamiento" onclick="manageStep5Submenu(this,1);" class="equipment_options_btn <?php if (in_array("PLA00370460", $referencia_material)) { ?>active <?php } ?>">
								<img src="CapasCocina/EQUIPAMIENTO/CalentadorHydronext.png" style="width:80%" />
								<p>Calentador Gas Natural Hydronext 5600S WTD 12-3 AME23</p>
							</button>

							<button id="PLA00370462" class="equipamiento" onclick="manageStep5Submenu(this,1);" class="equipment_options_btn <?php if (in_array("PLA00370462", $referencia_material)) { ?>active <?php } ?>">
								<img src="CapasCocina/EQUIPAMIENTO/CalentadorHydronext.png" style="width:80%" />
								<p>Calentador Gas Natural Hydronext 5600S WTD 15-3 AME23</p>


							</button>
							<button id="PLA00370463" class="equipamiento" onclick="manageStep5Submenu(this,1);" class="equipment_options_btn <?php if (in_array("PLA00370463", $referencia_material)) { ?>active <?php } ?>">
								<img src="CapasCocina/EQUIPAMIENTO/CalentadorHydronext.png" style="width:80%" />
								<p>Calentador Gas Butano Hydronext 5600S WTD 15-3 AME31</p>

							</button>
						</div>
					</div>
					<button class="blackBtn" onclick="hideStep5SubMenus(this);">Calderas</button>
					<div class="child_list">
						<div class="calderasList" style="/*display:grid; grid-template-columns: auto auto; width:calc( 100% - 20px ); margin: 10px;*/ width:80%;margin:0px auto;">
							<button id="PLA00162142" class="equipamiento" onclick="manageStep5Submenu(this,1);" class="equipment_options_btn <?php if (in_array("PLA00162142", $referencia_material)) { ?>active <?php } ?>">
								<img src="CapasCocina/EQUIPAMIENTO/CalderaJunkersCondensacionCerapurZwbc24-2CGn.png" style="width:80%" />
								<p>Caldera Junkers Condensación Cerapur Zwbc 24-2C Gn</p>
							</button>
							<button id="PLA00390526" class="equipamiento" onclick="manageStep5Submenu(this,1);" class="equipment_options_btn <?php if (in_array("PLA00390526", $referencia_material)) { ?>active <?php } ?>">
								<img src="CapasCocina/EQUIPAMIENTO/CalderaBerettaCiaoGreenErp25CsiMtnTermostato.png" style="width:80%" />
								<p>Caldera Beretta Ciao Green Erp 25 Csi Mtn + Termostat</p>
							</button>
							<button id="PLA01914858" class="equipamiento" onclick="manageStep5Submenu(this,1);" class="equipment_options_btn <?php if (in_array("PLA01914858", $referencia_material)) { ?>active <?php } ?>">
								<img src="CapasCocina/EQUIPAMIENTO/CalderacondVaillantEcoTecPureVWM236-7-223KwNAT.png" style="width:80%" />
								<p>Caldera cond.Vaillant EcoTec Pure VWM236/7-2 23KwNAT</p>
							</button>
						</div>
					</div>
					<button class="blackBtn" onclick="hideStep5SubMenus(this);">Radiadores</button>
					<div class="child_list" style="grid-template-columns: auto; width:calc( 100% - 20px ); margin: 10px;">

						<div class="dropdown_radiator">
							<img src="CapasCocina/EQUIPAMIENTO/Radiador.png" />
							<div style="width:100%; text-align: center; margin-bottom:10px;">Radiador Europa</div>
							<div class="dropdown-content">
								<p>Selecciona un Modelo</p>
								<button class="equipamiento <?php if (in_array("PLA00113104", $referencia_material)) { ?>active <?php } ?>" id="PLA00113104" onclick="selectRadiator(this,0);">450 N</button>
								<button class="equipamiento <?php if (in_array("PLA00113106", $referencia_material)) { ?>active <?php } ?>" id="PLA00113106" onclick="selectRadiator(this,1);">600 N</button>
								<!--<button onclick="selectRadiator(this,2);">700 N</button>-->
								<button class="equipamiento <?php if (in_array("PLA00113120", $referencia_material)) { ?>active <?php } ?>" id="PLA00113120" onclick="selectRadiator(this,2);">800 N</button>

							</div>

							<div class="elements-content">
								<p>Selecciona el numero de elementos</p>
							</div>


						</div>
						<button id="addRadiatorBtn" class="greenBtn">Añadir un radiador</button>
					</div>
				</div>
				<?php
				if (isset($_SESSION["login"]) && isset($_GET["id_presupuesto"])) {
				?>

					<div id="opciones_sc" class="listado_instalaciones" style="display:none">

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

	<?php
	} else {

	?>
		<div id="parte_superior"></div>
	<?php
	}
	?>

	<div id="titulo_estado_actual" style="display: none">
		<h1 style="text-align:center">ESTADO ACTUAL <img src="iconos/eye_icon_open.png" width="33" id="visualizar_estado_actual"></h1>
		<div id="botones-zoom">
			<button id="zoom-in">+</button>
			<button id="zoom-out">-</button>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.2.1.js"></script>

	<script>
		$(document).ready(function() {
			$(".upload").on('click', function() {
				var formData = new FormData();
				var files = $('#image')[0].files[0];
				formData.append('file', files);
				$.ajax({
					url: 'upload.php',
					type: 'post',
					data: formData,
					contentType: false,
					processData: false,
					success: function(response) {
						if (response != 0) {
							$(".card-img-top").attr("src", response);
						} else {
							alert('Formato de imagen incorrecto.');
						}
					}
				});
				return false;
			});
		});
	</script>
	<div id="bloque_estado_actual" style="background: #95C11F; display: none;">
		<div id="imagen_bloque_estado_actual">
			<?php
			// $query = "SELECT * FROM planos WHERE id=" . $_GET["id_presupuesto"]; 
			// $exe = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));
			// $fila = mysqli_fetch_array($exe); 
			?>
			<!-- <img src="https://picsum.photos/200/300" width="100%" height=""> -->
			<?php
			// if (isset($_SESSION["login"]) && isset($_GET["id_presupuesto"])) {

			// 	echo "Paso 1";
			// 	$_GET["id_presupuesto"] = (int)$_GET["id_presupuesto"];

			// 	//Dibujo estado actual para mostrar en la ventana
			// 	$result_estado_actual = $mysqli->query("SELECT * FROM planos WHERE id=349");
			// 	$obj_estado_actual = $result_estado_actual->fetch_object();

			// 	if (!$result_dibujo_actual->num_rows)
			// 	{
			// 		//Si no tiene dibujo actual, saco el dibujo actual del padre
			// 		$result_dibujo_actual=$mysqli->query("SELECT png_estado_actual FROM clientes WHERE id_presupuesto_modificado=".$_GET["id_presupuesto"]." AND png_estado_actual != '' ");
			// 	}

			// 	$png_estado_actual = $obj_estado_actual->imagen_dibujo_actual;

			// 	$observaciones = $obj_estado_actual->observaciones;
			// 	$altura_pared = $obj_estado_actual->altura_techo_reformado;
			// } 
			?>
			<!-- <img src="<?php //echo $png_estado_actual; 
							?>" width="100%" height=""> -->
		</div>
	</div>

	<div id="bloque_materiales">
		<div id="imagen_frente_armario"></div>
		<div id="imagen_encimera"></div>
		<div id="imagen_pared_lateral_puerta"></div>
		<div id="imagen_pared_frontal"></div>
		<div id="imagen_pared_lateral_ventana"></div>
		<div id="imagen_suelo"></div>
		<div id="imagen_rodapie_puerta"></div>
		<div id="imagen_rodapie_ventana"></div>
		<div id="imagen_RYL_pared"></div>
		<div id="imagen_RYL_suelo"></div>
		<div id="imagen_RYL_listelos"></div>
		<div id="imagen_puertas"></div>
		<div id="imagen_ventanas"></div>
	</div>
	<svg id="lin" viewBox="0 0 1100 700" preserveAspectRatio="xMidYMin slice" xmlns="http://www.w3.org/2000/svg" style="z-index:2;margin:0;padding:0;width:100vw;height:100vh;position:absolute;top:0;left:0;right:0;bottom:0">
		<defs>
			<linearGradient id="gradientRed" x1="0%" y1="0%" x2="100%" y2="100%" spreadMethod="pad">
				<stop offset="0%" stop-color="#ed5e" stop-opacity="1" />
				<stop offset="100%" stop-color="#e33b3c" stop-opacity="1" />
			</linearGradient>
			<linearGradient id="gradientYellow" x1="0%" y1="0%" x2="100%" y2="100%" spreadMethod="pad">
				<stop offset="0%" stop-color="#FDEB71" stop-opacity="1" />
				<stop offset="100%" stop-color="#F8D800" stop-opacity="1" />
			</linearGradient>
			<linearGradient id="gradientGreen" x1="0%" y1="0%" x2="100%" y2="100%" spreadMethod="pad">
				<stop offset="0%" stop-color="#c0f7d9" stop-opacity="1" />
				<stop offset="100%" stop-color="#6ce8a3" stop-opacity="1" />
			</linearGradient>
			<linearGradient id="gradientSky" x1="0%" y1="0%" x2="100%" y2="100%" spreadMethod="pad">
				<stop offset="0%" stop-color="#c4e0f4" stop-opacity="1" />
				<stop offset="100%" stop-color="#87c8f7" stop-opacity="1" />
			</linearGradient>
			<linearGradient id="gradientOrange" x1="0%" y1="0%" x2="100%" y2="100%" spreadMethod="pad">
				<stop offset="0%" stop-color="#f9ad67" stop-opacity="1" />
				<stop offset="100%" stop-color="#f97f00" stop-opacity="1" />
			</linearGradient>
			<linearGradient id="gradientWhite" x1="0%" y1="0%" x2="100%" y2="100%" spreadMethod="pad">
				<stop offset="0%" stop-color="#ffffff" stop-opacity="1" />
				<stop offset="100%" stop-color="#f0f0f0" stop-opacity="1" />
			</linearGradient>
			<linearGradient id="gradientGrey" x1="0%" y1="0%" x2="100%" y2="100%" spreadMethod="pad">
				<stop offset="0%" stop-color="#666" stop-opacity="1" />
				<stop offset="100%" stop-color="#aaa" stop-opacity="1" />
			</linearGradient>
			<linearGradient id="gradientBlue" x1="0%" y1="0%" x2="100%" y2="100%" spreadMethod="pad">
				<stop offset="0%" stop-color="#4f72a6" stop-opacity="1" />
				<stop offset="100%" stop-color="#3987" stop-opacity="1" />
			</linearGradient>
			<linearGradient id="gradientPurple" x1="0%" y1="0%" x2="100%" y2="100%" spreadMethod="pad">
				<stop offset="0%" stop-color="#E2B0FF" stop-opacity="1" />
				<stop offset="100%" stop-color="#9F44D3" stop-opacity="1" />
			</linearGradient>
			<linearGradient id="gradientPink" x1="0%" y1="0%" x2="100%" y2="100%" spreadMethod="pad">
				<stop offset="0%" stop-color="#f6c4dd" stop-opacity="1" />
				<stop offset="100%" stop-color="#f699c7" stop-opacity="1" />
			</linearGradient>
			<linearGradient id="gradientBlack" x1="0%" y1="0%" x2="100%" y2="100%" spreadMethod="pad">
				<stop offset="0%" stop-color="#3c3b3b" stop-opacity="1" />
				<stop offset="100%" stop-color="#000000" stop-opacity="1" />
			</linearGradient>
			<linearGradient id="gradientNeutral" x1="0%" y1="0%" x2="100%" y2="100%" spreadMethod="pad">
				<stop offset="0%" stop-color="#dbc6a0" stop-opacity="1" />
				<stop offset="100%" stop-color="#c69d56" stop-opacity="1" />
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
				<path d="M 60 0 L 0 0 0 60" fill="none" stroke="#777" stroke-width="0.25" />
			</pattern>
			<pattern id="grid" width="180" height="180" patternUnits="userSpaceOnUse">
				<rect width="180" height="180" fill="url(#smallGrid)" />
				<path d="M 200 10 L 200 0 L 190 0 M 0 10 L 0 0 L 10 0 M 0 190 L 0 200 L 10 200 M 190 200 L 200 200 L 200 190" fill="none" stroke="#999" stroke-width="0.8" />
			</pattern>
			<pattern id="hatch" width="5" height="5" patternTransform="rotate(50 0 0)" patternUnits="userSpaceOnUse">
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
		<br /><br />
		<h2 class="toHide" id="reportTotalSurface" style="display:none"></h2>
		<h2 class="toHide" id="reportNumberSurface" style="display:none"></h2>
		<hr />
		<section id="reportRooms" class="toHide" style="display:none">
		</section>
		<button class="btn btn-info fully" style="margin-top:50px" onclick="$('#reportTools').hide('500', function(){$('#panel').show(300);});mode = 'select_mode';"><i class="fa fa-2x fa-backward" aria-hidden="true"></i></button>
	</div>

	<div id="wallTools" class="leftBox">
		<h2 id="titleWallTools">Modifica la pared</h2>
		<hr />
		<section id="rangeThick">
			<p>Editando: <span id="wallWidthScale"></span> <span id="wallWidthVal"></span></span></p>
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
			<br />
			<li><button class="btn btn-danger halfy" id="wallTrash"><i class="fa fa-2x fa-trash-o" aria-hidden="true"></i></button>
				<button class="btn btn-info halfy pull-right" onclick="fonc_button('select_mode');$('#boxinfo').html('Modo selección');$('#wallTools').hide('300');$('#panel').show('300');"><i class="fa fa-2x fa-backward" aria-hidden="true"></i></button>
			</li>
		</ul>
	</div>

	<div id="objBoundingBox" class="leftBox">
		<h2>Modifica el objeto</h2>
		<hr />
		<section id="objBoundingBoxScale">
			<p>Width [<span id="bboxWidthScale"></span>] : <span id="bboxWidthVal"></span> cm</span></p>
			<input type="range" id="bboxWidth" step="1" class="range" />
			<p>Length [<span id="bboxHeightScale"></span>] : <span id="bboxHeightVal"></span> cm</span></p>
			<input type="range" id="bboxHeight" step="1" class="range" />
		</section>

		<section id="objBoundingBoxRotation">
			<p><i class="fa fa-compass" aria-hidden="true"></i> Rotación : <span id="bboxRotationVal"></span> °</p>
			<input type="range" id="bboxRotation" step="1" class="range" min="-180" max="180" />
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

		<br /><br />
		<button class="btn btn-danger fully" id="bboxTrash"><i class="fa fa-2x fa-trash-o" aria-hidden="true"></i></button>
		<button class="btn btn-info" style="margin-top:50px" onclick="fonc_button('select_mode');$('#boxinfo').html('Mode sélection');$('#objBoundingBox').hide(100);$('#panel').show(200);binder.graph.remove();delete binder;">
			<!--<i class="fa fa-2x fa-backward" aria-hidden="true" ></i>-->GUARDAR MODIFICACIÓN
		</button>
	</div>

	<div id="objTools" class="leftBox">
		<h2>Modificar puerta/ventana</h2>
		<hr />
		<ul class="list-unstyled">
			<br /><br />
			<li style="display:none;"><button class="btn btn-default fully" id="objToolsHinge">REVERTIR</button></li>
			<p style="display:none;">Ancho [<span id="doorWindowWidthScale"></span>] : <span id="doorWindowWidthVal"></span> cm</span></p>
			<p>Ancho:<br />
				<input type="range" id="doorWindowWidth" step="1" class="range" />
			</p>
			<p>Alto:<br />
				<input id="doorWindowHeight" type="range" value="1" min="0.60" max="5" step="0.1" oninput="this.nextElementSibling.value = this.value" class="form-control">
				Metros: <output style="display:inline-block">0.6</output>
			</p>
			<br />
			<li><button class="btn btn-danger fully objTrash"><i class="fa fa-2x fa-trash-o" aria-hidden="true"></i></button></li>
			<li><button class="btn btn-info" style="margin-top:50px" onclick="fonc_button('select_mode');$('#boxinfo').html('Mode sélection');$('#objTools').hide('100');$('#panel').show('200');binder.graph.remove();delete binder;rib();"><i class="fa fa-2x fa-backward" aria-hidden="true"></i></button></li>
		</ul>
	</div>

	<div id="roomTools" class="leftBox">
		<span style="color:#08d">Rehubic</span> :<br /><b><span class="size"></span></b>
		<br /><br />
		<p>Dibuja aquí</p>
		<div class="input-group">
			<input type="text" class="form-control" id="roomSurface" placeholder="surface réelle" aria-describedby="basic-addon2">
			<span class="input-group-addon" id="basic-addon2">m²</span>
		</div>
		<br />
		<input type="hidden" id="roomName" value="" />
		Wording :<br />
		<div class="btn-group">
			<button class="btn dropdown-toggle btn-default" data-toggle="dropdown" id="roomLabel">Wording of the room <span class="caret"></span></button>
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
		<br />
		<br />
		Meter :
		<div class="funkyradio">
			<div class="funkyradio-success">
				<input type="checkbox" name="roomShow" value="showSurface" id="seeArea" checked />
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
		<hr />

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
		<br /><br />
		<p>Materiales</p>
		<div class="roomColor" data-type="wood" style="background: url('https://orig00.deviantart.net/e1f2/f/2015/164/8/b/old_oak_planks___seamless_texture_by_rls0812-d8x6htl.jpg');"></div>
		<div class="roomColor" data-type="tiles" style="background: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQrkoI2Eiw8ya3J_swhfpZdi_ug2sONsI6TxEd1xN5af3DX9J3R');"></div>
		<div class="roomColor" data-type="granite" style="background: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ9_nEMhnWVV47lxEn5T_HWxvFwkujFTuw6Ff26dRTl4rDaE8AdEQ');"></div>
		<div class="roomColor" data-type="grass" style="background: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRWh5nEP_Trwo96CJjev6lnKe0_dRdA63RJFaoc3-msedgxveJd');"></div>
		<div data-type="#ff008a" style="clear:both"></div>
		<br /><br />
		<input type="hidden" id="roomBackground" value="gradientNeutral" />
		<input type="hidden" id="roomIndex" value="" />
		<button type="button" class="btn btn-primary" id="applySurface">Apply</button>
		<button type="button" class="btn btn-danger" id="resetRoomTools">Cancel</button>
		<br />
	</div>

	<div style="position:absolute;bottom:10px;left:310px;font-size:1.5em;color:#08d" id="boxinfo">
	</div>

	<div id="moveBox" style="position:absolute;right:0;top:10px;color:#08d;background:transparent;z-index:2;text-align:center;transition-duration: 0.2s;transition-timing-function: ease-in;">
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

	<div id="zoomBox" style="position:absolute;z-index:100;right:0;bottom:30px;text-align:center;background:transparent;padding:0px;color:#fff;transition-duration: 0.2s;transition-timing-function: ease-in;">
		<div class="pull-right" style="margin-right:10px">
			<button class="btn btn btn-default zoom" data-zoom="zoomin" style="box-shadow:2px 2px 3px #ccc;"><i class="fa fa-plus" aria-hidden="true"></i></button>
			<button class="btn btn btn-default zoom" data-zoom="zoomout" style="box-shadow:2px 2px 3px #ccc;"><i class="fa fa-minus" aria-hidden="true"></i></button>
		</div>
		<div style="clear:both"></div>
		<div id="scaleVal" class="pull-right" style="box-shadow:2px 2px 3px #ccc;width:60px;height:20px;background:#4b79aa;border-radius:4px;margin-right:10px">
			1m
		</div>
		<div style="clear:both"></div>
	</div>
</body>
<script src="jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
<script src="js/panzoom/panzoom.min.js"></script>
<script>
	const element = document.getElementById('imagen_bloque_estado_actual')
	const panzoom = Panzoom(element, {
		// options here
	});

	const elemzoomin = document.getElementById('zoom-in')
	elemzoomin.addEventListener('click', panzoom.zoomIn)

	const elemzoomout = document.getElementById('zoom-out')
	elemzoomout.addEventListener('click', panzoom.zoomOut)
</script>

<script>
	$("#visualizar_estado_actual").click(function() {
		var imagen_estado_actual = $("#visualizar_estado_actual").attr("src");
		if (imagen_estado_actual == "iconos/eye_icon_open.png") {
			$("#bloque_estado_actual").show();
			$("#visualizar_estado_actual").attr("src", "iconos/eye_icon_close.png");
		} else {
			$("#bloque_estado_actual").hide();
			$("#visualizar_estado_actual").attr("src", "iconos/eye_icon_open.png");
		}
	})

	$("input[type='checkbox'][name='todos_muros']").click(function() {
		var id = $(this).parent().attr("name");
		$("form[name='" + id + "'] * .child").trigger("click");

		//$("form[name='"+id+"'] * .paredes").trigger("click");
		/*if (!$(this).is(":checked"))
		{
			$("form[name='"+id+"'] * .child").attr("checked",false);
			$("form[name='"+id+"'] * .paredes").attr("checked",false);
		}
		else
		{
			$("form[name='"+id+"'] * .child").attr("checked",true);
			$("form[name='"+id+"'] * .paredes").attr("checked",true);
		}
	*/
	})

	$("input[name='opcion_tabique']").click(function() {
		var muro = $("#wallWidth").attr("class");
		if ($("input[name='opcion_tabique']:checked").val() == "demoler") {
			$("#" + muro).attr("fill", "#F08675");
		} else if ($("input[name='opcion_tabique']:checked").val() == "nuevo") {
			$("#" + muro).attr("fill", "green");
		} else {
			$("#" + muro).attr("fill", "#666");
		}
	})

	//zra9: "pasosInfo.js" estaba aquí

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

	$(document).ready(function() {
		$("#titulo_observaciones_plano").click(function() {
			if ($("#contenido_observaciones_plano").is(":visible"))
				$("#contenido_observaciones_plano").hide();
			else
				$("#contenido_observaciones_plano").show();
		})

		//Escribo la altura del techo en el plano
		$("#altura_paredes").change(function() {
			$("text[font-size='20px']").parent().remove();

			//Para que se pueda un objeto de texto y se pueda mover por el plano,
			//Debe crearse una instancia de editor y hay que pasarle coordenadas x e y en un array
			//El array que usa esto por defecto es el array de snap, pero puede que no esté creado (Se crea cuando interactuas con el plano)
			//Por ello, generamos un array llamando ceilingMap
			ceilingMap = [];
			ceilingMap["x"] = 900;
			ceilingMap["y"] = 250;
			ceilingMap["xMouse"] = 1294;
			ceilingMap["yMouse"] = 250;

			binder = new editor.obj2D("free", "text", document.getElementById('labelBox').style.color, ceilingMap, 0, 0, 0, "normal", 0, {
				text: "H:" + this.value + "m",
				size: 20
			});
			binder.update();
			OBJDATA.push(binder);
			binder.graph.remove();
			$('#boxText').append(OBJDATA[OBJDATA.length - 1].graph);
			OBJDATA[OBJDATA.length - 1].update();
			console.log("Mira a binder");
			console.log(binder);
			delete binder;
			save();
		});

		setInterval(function() {
			if ($("#boxcarpentry > g > circle").length)
				$("#boxcarpentry > g > circle").parent().remove();
		}, 3000);
	});
</script>

<script src="js/pasosInfo.js"></script>
<script src="js/jQueryUITouchPunchV0.2.3.js"></script>
<script src="bootstrap.min.js"></script>
<script src="mousewheel.js"></script>
<script src="decimal.min.js"></script>
<script src="func.js"></script>
<script src="qSVG.js"></script>
<script src="editor.js"></script>
<script src="engine.js"></script>
<script src="js/OwlCarousel/dist/owl.carousel.min.js"></script>
<script src="js/interactive.js"></script>
<script src="js/capturaPantalla.js"></script>
<!-- alertify -->
<script src="js/alertify.js"></script>

<?php
if (!isset($_SESSION["login"])) {
?>
	<script src="js/murosCreadosElenmentos.js"></script>
<?php
}
?>
<script>
	$(document).on("click", ".paredes", function() {
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

	$(document).ready(function() {
		//Ajusto zoom
		for (var i = 0; i < 3; i++) {
			$("button[data-zoom='zoomin']").trigger("click");
		}
		$("#observaciones").click(function() {
			$("#opciones_crear_plano").hide();
			$("#opciones_instalaciones").hide();
			$("#opciones_mobiliario").hide();
			$("#opciones_observacion").show();
		})

		if ($(window).width() < 1099) {
			$('.owl-carousel').owlCarousel({
				loop: false,
				margin: 50,
				responsiveClass: true,
				responsive: {
					0: {
						items: 3
					},
					600: {
						items: 4
					},
					1000: {
						items: 4
					},
					1099: {
						items: 4
					}
				}
			})
		}

		$(".elemento_instalacion").click(function() {

			var id = this.id;
			var selected = 0;

			if ($("#" + id).hasClass("selected")) {
				$("#" + id).removeClass("selected");
				selected = 0;
				$("#select_mode").trigger("click"); // simulo que le da click a la herramienta de selección, porque si no, al deseleccionar un elemento
				//Me lo pone para añadir una unidad al plano
			} else {
				$("#" + id).addClass("selected");
				selected = 1;
			}

			//listado muros
			if ($("#" + this.id + " + .listado_muros").length) {
				if (selected == 1 && id != "colocacion_solado")
					$("#" + this.id + " + .listado_muros").show();
				else
					$("#" + this.id + " + .listado_muros").hide();

				if (id == "colocacion_solado")
					$("#colocacion_solado + .listado_muros * input[name='todos_muros']").trigger("click");

				$("#" + this.id + " + .listado_muros > input[type='checkbox']").each(function() {
					//alert("checkbox!");
					if (selected == 1)
						$(this).addClass(id); //La vuelvo a generar
					else
						$(this).removeClass(id); //Primero elimino por si ya tenía esa clase
				})
			} else if ($("#" + this.id + " + .unidades_elemento").length) {
				if (selected == 1)
					$("#" + this.id + " + .unidades_elemento").show();
				else
					$("#" + this.id + " + .unidades_elemento").hide();
			} else if ($("#" + this.id + " + .metros_lineales").length) {
				if (selected == 1)
					$("#" + this.id + " + .metros_lineales").show();
				else
					$("#" + this.id + " + .metros_lineales").hide();
			} else {
				if (selected == 1)
					$("#" + this.id).parent().append('<img class="marcado" src="iconos/Tick_Mark-256.png" style="width: 32px;display: block;margin: 0px auto;">');
				else {
					$("#" + this.id + " + .marcado").remove();
					$("#" + this.id + " + form + .marcado").remove();
				}
			}
		})

		$("#btnFinalizar").click(function() {
			$("#btnFinalizar").attr("style", "pointer-events: none;");
			$("#btnFinalizar > span").html("Guardando...")

			btnFinalizar();

			//var dibujo=JSON.parse(localStorage.getItem('history'));
			var dibujo = localStorage.getItem('history');
			var observaciones_texto = $("#textarea_observaciones").val()
			var altura_techo = $("#altura_paredes").val();
			var metros_cuadrados = $("#areaValue").html();
			var observaciones_texto = $("#textarea_observaciones").val()
			var total_muros = "";
			var rejunte_pared = 0;
			var rejunte_suelo = 0;
			var id = "";
			var entro = false;
			var contador = 0;
			var formularios = [];
			var metros_ancho = 0;
			var metros_alto = 0;
			var presupuesto = $("body").attr("id");
			//alert(presupuesto);
			//alert("Los metros cuadrados del plano son: "+metros_cuadrados);
			/* var id="";
			var entro=false;
			var formularios=[];
			var contador=0;
			var altura_paredes=document.getElementById("altura_paredes").value;
			var metros_alto=0;
			var metros_ancho=0;
			var rejunte_pared=0;
			var medidas=0;
			var total_muros="";
			var rejunte_suelo=0;
			
			*/
			/*$("#boxScale > text").each(function() {
			 if (medidas == 0) //Son los metros de anchura
				metros_ancho=$(this).text();  
			 else //Son los metros de altura
				metros_alto=$(this).text(); 
			
			medidas++;
		});
		 */

			if (altura_techo != "") {
				//data: "&dibujo="+dibujo+"&observaciones="+observaciones_texto+"&altura_techo="+altura_techo+"&total_muros="+total_muros+"&metros_cuadrados="+metros_cuadrados,
				$.ajax({
					type: "POST",
					dataType: 'json',
					async: false,
					url: "ajax/finalizar_plano.php?presupuesto=" + presupuesto,
					data: {
						dibujo: dibujo,
						observaciones: observaciones_texto,
						altura_techo: altura_techo,
						total_muros: total_muros,
						metros_cuadrados: metros_cuadrados
					},
					success: function(respuesta) {
						alertify.success(respuesta.mensaje);
					}
				});

				$(".elemento_instalacion.selected").each(function() {
					entro = true;

					//Por cada elemento seleccionado, detecto si es muro o unidades y lo añado
					var formulario = $("form[name='" + this.id + "']").serialize();
					var id = this.id;
					console.log(formulario);

					//Me guardo también el total de los muros, aunque no estén seleccionados

					$(".info_muro").each(function() {
						//console.log($(this)[0].outerText);
						total_muros = $(this)[0].outerText + "," + total_muros;
					});

					//alert(formulario);

					$.ajax({
						type: "POST",
						dataType: 'json',
						async: false,
						url: "ajax/guardar_instalaciones.php",
						data: formulario + "&altura_techo=" + altura_techo + "&total_muros=" + total_muros + "&metros_cuadrados=" + metros_cuadrados,
						success: function(respuesta) {
							alertify.success(respuesta.mensaje);
						}
					});
					contador++;
				})

				if (!entro)
					alertify.error("Debes seleccionar, al menos, un elemento de instalaciones y equipamiento para finalizar el plano")
				else {
					//SACO LOS SINCODIGOS
					$.ajax({
						type: "POST",
						dataType: 'json',
						async: false,
						url: "ajax/guardar_sc_presupuesto.php?id_presupuesto=<?php if (isset($_GET['id_presupuesto'])) { echo $_GET['id_presupuesto']; } else { echo "0"; } ?>",
						success: function(respuesta) { if (respuesta.mensaje != "") alertify.success(respuesta.mensaje); },
					});

					//FIN DE SINCODIGOS

					//MATERIALES
					$("#materiales * button.active").each(function() {

						var id_material = $(this).attr("id");
						if (id_material !== undefined) {
							//alert("voy a guardar el material "+id_material);
							$.ajax({
								type: "POST",
								dataType: 'json',
								async: false,
								url: "ajax/guardar_materiales.php",
								data: {
									id_material: id_material
								},
								success: function(respuesta) {
									alertify.success(respuesta.mensaje);
								}
							});
						}
					})
					//Rejunte Pared 
					$(".RYLbuttonContainerPared").each(function() {
						if ($(this).hasClass("active")) {
							rejunte_pared = 1;
						}
					})
					//Rejunte Suelo 
					$(".RYLbuttonContainerSuelo").each(function() {
						if ($(this).hasClass("active"))
							rejunte_suelo = 1;
					})
					//alert("Rejunte pared ? "+rejunte_pared+". ¿Rejunte suelo? "+rejunte_suelo);
					//alert("Total muros "+total_muros);
					// alert("altura pared "+altura_paredes);
					$.ajax({
						type: "POST",
						dataType: 'json',
						async: false,
						url: "ajax/guardar_materiales.php?rejunte_pared=" + rejunte_pared + "&rejunte_suelo=" + rejunte_suelo + "&total_muros=" + total_muros + "&altura_paredes=" + altura_paredes,
						success: function(respuesta) {
							alertify.success(respuesta.mensaje);
						}
					});

					//FIN MATERIALES

					//LISTELOS
					$(".flexBtn.active").each(function() {
						var formulario = $(this).children(".unidades_elemento").children(".form_unidades").serialize();
						$.ajax({
							type: "POST",
							dataType: 'json',
							data: formulario,
							async: false,
							url: "ajax/guardar_materiales.php",
							success: function(respuesta) {
								alertify.success(respuesta.mensaje);
							}
						})
					})

					//FIN LISTELOS	 

					//EQUIPAMIENTO

					$(".equipamiento.active").each(function() {
						var id_material = $(this).attr("id");
						if (id_material !== undefined) {
							//alert("voy a guardar el equipamiento "+id_material);
							$.ajax({
								type: "POST",
								dataType: 'json',
								async: false,
								url: "ajax/guardar_materiales.php",
								data: {
									id_material: id_material
								},
								success: function(respuesta) {
									alertify.success(respuesta.mensaje);
								}
							});
						}
					})

					//FIN EQUIPAMIENTO	 

					//SIN CÓDIGOS

					//FIN SIN CÓDIGOS

					//Guardo para que el mapa se guarde en localstorage history para luego guardarlo en la BD
					//Y que el admin lo recupere
					console.log("LOCAL STORAGE ANTES DE SAVE");
					console.log(localStorage.getItem("history"));

					save();
					console.log("LOCAL STORAGE DESPUES DE SAVE");
					console.log(localStorage.getItem("history"));

					console.log("LOCALS STORAGE stringfy");
					var numero_muros = $(".muro").length;
					//console.log(HISTORY[4]);
					//var contenido=localStorage.getItem("history");
					// var contenido=localStorage.getItem("history");
					var contenido = HISTORY[numero_muros]; //El último muro es el que tiene la info de todo el dibujo
					var elementos_dibujados = $("#boxEnergy").html();
					var puertas_ventanas = $("#boxcarpentry").html();
					var observaciones = $("#boxText").html();
					var observaciones_texto = $("#anotaciones_observacion").html();

					console.log("ELEMENTOS DIBUJADOS");
					console.log(elementos_dibujados);
					$.ajax({
						type: "POST",
						dataType: 'json',
						async: false,
						url: "ajax/guardar_dibujo2d.php",
						data: {
							contenido: contenido,
							elementos_dibujados: elementos_dibujados,
							puertas_ventanas: puertas_ventanas,
							observaciones: observaciones,
							metros_ancho: metros_ancho,
							metros_alto: metros_alto,
							observaciones_texto: observaciones_texto
						},
						success: function(respuesta) {
							window.location.assign(" https://rehubik.com/presupuestador/2d_v0.0.2/registro_cliente.php");
						}
					});
				}

				setTimeout(function() {
					$("#btnFinalizar").attr("style", "pointer-events: unset;");
					$("#btnFinalizar > span").html("Finalizar")
				}, 2000);

			} else {
				alertify.error("Debes especificar la altura del techo");
				setTimeout(function() {
					$("#btnFinalizar").attr("style", "pointer-events: unset;");
					$("#btnFinalizar > span").html("Finalizar")
				}, 2000);
			}
		})

		$("#vitro_horno").click(function() {
			if (parseInt($("path[stroke-dasharray*='vitro_horno']").parent().length) >= 1) {
				$("path[stroke-dasharray*='vitro_horno']").parent().remove();
			}
		})
		$("#gas_horno").click(function() {
			if (parseInt($("path[stroke-dasharray*='gas_horno']").parent().length) >= 1) {
				$("path[stroke-dasharray*='gas_horno']").parent().remove();
			}
		})

		$("#frigo_americano").click(function() {
			if (parseInt($("path[stroke-dasharray*='frigo_americano']").parent().length) >= 1) {
				$("path[stroke-dasharray*='frigo_americano']").parent().remove();
			}
		})

		$("#escobero").click(function() {
			if (parseInt($("path[stroke-dasharray*='escobero']").parent().length) >= 1) {
				$("path[stroke-dasharray*='escobero']").parent().remove();
			}
		})

		$("#caldera_gas").click(function() {
			if (parseInt($("path[stroke-dasharray*='caldera_gas']").parent().length) >= 1) {
				$("path[stroke-dasharray*='caldera_gas']").parent().remove();
			}
		})

		$("#calentador_gas").click(function() {
			if (parseInt($("path[stroke-dasharray*='calentador_gas']").parent().length) >= 1) {
				$("path[stroke-dasharray*='calentador_gas']").parent().remove();
			}
		})

		$("#termo_electrico").click(function() {
			if (parseInt($("path[stroke-dasharray*='termo_electrico']").parent().length) >= 1) {
				$("path[stroke-dasharray*='termo_electrico']").parent().remove();
			}
		})

		$("#lavadero").click(function() {
			if (parseInt($("path[stroke-dasharray*='lavadero']").parent().length) >= 1) {
				$("path[stroke-dasharray*='lavadero']").parent().remove();
			}
		})

		$("#fregadero").click(function() {
			if (parseInt($("path[stroke-dasharray*='campana']").parent().length) >= 1) {
				$("path[stroke-dasharray*='campana']").parent().remove();
			}
		})

		$("#campana").click(function() {
			if (parseInt($("path[stroke-dasharray*='campana']").parent().length) >= 1) {
				$("path[stroke-dasharray*='campana']").parent().remove();
			}
		})

		$("#secadora").click(function() {
			if (parseInt($("path[stroke-dasharray*='secadora']").parent().length) >= 1) {
				$("path[stroke-dasharray*='secadora']").parent().remove();
			}
		})

		$("#lavadora").click(function() {
			if (parseInt($("path[stroke-dasharray*='lavadora']").parent().length) >= 1) {
				$("path[stroke-dasharray*='lavadora']").parent().remove();
			}

		})

		$("#lavavajillas").click(function() {
			if (parseInt($("path[stroke-dasharray*='lavavajillas']").parent().length) >= 1) {
				$("path[stroke-dasharray*='lavavajillas']").parent().remove();
			}
		})

		$("#frigo").click(function() {
			if (parseInt($("path[stroke-dasharray*='frigo']").parent().length) >= 1) {
				$("path[stroke-dasharray*='frigo']").parent().remove();
			}
		})

		$("#micro").click(function() {
			if (parseInt($("path[stroke-dasharray*='micro']").parent().length) >= 1) {
				$("path[stroke-dasharray*='micro']").parent().remove();
			}
		})

		$("#placa_gas").click(function() {
			if (parseInt($("path[stroke-dasharray*='placa_gas']").parent().length) >= 1) {
				$("path[stroke-dasharray*='placa_gas']").parent().remove();
			}
		})

		$("#vitro_induccion").click(function() {

			if (parseInt($("path[stroke-dasharray*='vitro_induccion']").parent().length) >= 1) {
				$("path[stroke-dasharray*='vitro_induccion']").parent().remove();
			}

		})

		$("#horno").click(function() {
			if (parseInt($("path[stroke-dasharray*='horno']").parent().length) >= 1) {
				$("path[stroke-dasharray*='horno']").parent().remove();
			}
		})

		//Cuando cambie de valor en las unidades
		$("select[name='unidades']").change(function() {
			var clase = this.className; //Obtengo la clase del select de las unidades
			clase = clase.replace('form-control', ''); //Quito el form-control para quedarme solo con la clase que hace referencia al elemento (ejemplo: puntos_electricos_extras)
			clase = $.trim(clase); //Le hago un trim para quitarle espacios en blanco

			if (parseInt($("path[stroke-dasharray*='" + clase + "']").parent().length) > this.value) {
				$("path[stroke-dasharray*='" + clase + "']").parent().remove();
			}
			//Los elementos solo se colocan cuando haces click al elemento. Si cambias de unidades, el elemento ya está seleccionado
			//por lo que no te lleva al mapa los elementos. Por ello simulo que hace click (para desclickear) y click (para volver a clickear el elemento)
			$("#" + clase).trigger("click");
			$("#" + clase).trigger("click");
			//esto lo hago porque si seleccionas en el desplegable 5 y añades 5 elementos y luego cambias a 8, te añade otros 8
		})

		/*$("select[name='unidades']").change(function() {
			
				$("path[stroke-dasharray='puntos_electricos_extras']").parent().remove();						
		})*/
	})

	function muestraContenido(id) {
		$(".tipo_mobiliario").removeClass("menu-mobiliario-activo");
		$(this).addClass("menu-mobiliario-activo");
		$(".objetos").attr("style", "display:none");
		$("#" + id).attr("style", "display:block");
	}

	function muestraInstalaciones(id) {
		$(".listado_instalaciones").hide();
		$("#" + id).show();
		$(".submenu_instalaciones").attr("style", "font-weight:500;color:gray;");
		$(".menu-" + id).attr("style", "font-weight:700;color:black;");
	}

	$("#guardar2d").click(function() {
		var contenido = "<html>";
		contenido += $("html").html();
		contenido += "</html>";
		var contador = 0;
		$("#boxEnergy > g").each(function() {
			contador++;
		});
		var plano = document.getElementById("boxRoom").getBoundingClientRect();
		console.log(plano.top, plano.right, plano.bottom, plano.left);
		var objetos_plano = document.getElementById("boxEnergy").getBoundingClientRect();
		console.log(objetos_plano.top, objetos_plano.right, objetos_plano.bottom, objetos_plano.left);

		if (objetos_plano.top != 0 && objetos_plano.right != 0 && objetos_plano.bottom != 0 && objetos_plano.left != 0 && contador > 0) {
			if (objetos_plano.top <= plano.bottom && objetos_plano.right <= plano.right && objetos_plano.bottom >= plano.top && objetos_plano.left >= plano.left && objetos_plano.bottom <= plano.bottom && objetos_plano.top >= plano.top) {
				if (typeof contador_muro !== 'undefined') {
					if (confirm("¿Quieres guardar tu plano?")) {
						var contenido = "<html>";
						contenido += $("html").html();
						contenido += "</html>";
						//localStorage.setItem('dibujo2d', contenido);
						//Guardo el dibujo2d en la BD para luego ya recuperarlo. 
						alertify.success("Plano guardado correctamente. Ahora debes crear las paredes");
					}
				} else {
					alertify.error("No puedes guardar un plano vacio");
				}
			} else {
				alertify.error("¡ATENCIÓN! Todos los elementos deben estar dentro de los límites del plano. Rectifica tu plano.");
			}
		}
		//localStorage.setItem('dibujo2d', contenido);
		//alert("Plano guardado correctamente. Ahora debes crear las paredes");
	})
</script>

<?php
if (isset($_GET["id_presupuesto"])) {
?>
	<script>
		//alert("dentro!");
		//Recupero el mapa de un usuario
		if (localStorage.getItem('history')) localStorage.removeItem('history');

		var id_presupuesto = <?php echo $_GET["id_presupuesto"]; ?>;
	</script>
	<script src="js/recuperarDatosUsuario.js"></script>
<?php
}
?>

<?php
if (isset($_GET["id_presupuesto"]) && isset($_SESSION["login"])) {
?>

	<script src="js/sc.js"></script>

	<?php
	//Es un material de los de la imagen
	if (in_array("IKEA001", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA001").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA002", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA002").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA003", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA003").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA004", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA004").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA005", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA005").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA006", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA006").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA007", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA007").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA008", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA008").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA009", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA009").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA010", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA010").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA011", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA011").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA012", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA012").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA013", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA013").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA014", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA014").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA015", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA015").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA016", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA016").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA017", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA017").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA018", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA018").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA019", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA019").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA020", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA020").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA021", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA021").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA022", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA022").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA023", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA023").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA024", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA024").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA025", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA025").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA026", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA026").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA027", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA027").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA028", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA028").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA029", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA029").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA030", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA030").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA031", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA031").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA032", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA032").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA033", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA033").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA034", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA034").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA035", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA035").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA036", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA036").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA037", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA037").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA038", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA038").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA039", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA039").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA040", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA040").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA041", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA041").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA042", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA042").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA043", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA043").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA044", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA044").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA045", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA045").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA046", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA046").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA047", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA047").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA048", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA048").trigger("click");
		</script>
	<?php
	}
	if (in_array("IKEA049", $referencia_material)) {
	?>
		<script>
			jQuery("#IKEA049").trigger("click");
		</script>
	<?php
	}
	if (in_array("PLA00117886", $referencia_material)) {
	?>
		<script>
			jQuery("#PLA00117886").trigger("click");
		</script>
	<?php
	}
	if (in_array("PLA00338006", $referencia_material)) {
	?>
		<script>
			jQuery("#PLA00338006").trigger("click");
		</script>
	<?php
	}
	if (in_array("PLA00406292", $referencia_material)) {
	?>
		<script>
			jQuery("#PLA00406292").trigger("click");
		</script>
	<?php
	}
	if (in_array("PLA00409147", $referencia_material)) {
	?>
		<script>
			jQuery("#PLA00409147").trigger("click");
		</script>
	<?php
	}
	if (in_array("PLA00479520", $referencia_material)) {
	?>
		<script>
			jQuery("#PLA00479520").trigger("click");
		</script>
<?php
	}
}
?>

</html>