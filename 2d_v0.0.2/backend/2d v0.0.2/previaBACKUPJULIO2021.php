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
		.owl-carousel.listado_instalaciones {
    width: 1400px;
    max-width: 100%;
    margin: 0px auto;
}
		.objetos {display:none;}
		.btn.btn-info {
    background: white;
    color: black;
    border: 1px solid black;
}
		.btn.btn-danger {
    background: white;
    color: black;
    border: 1px solid black;
}
		.alertify,.alertify-log{font-family:sans-serif}.alertify{background:#FFF;border:10px solid #5779bf;border:10px solid #5779bf;border-radius:8px;box-shadow:0 3px 3px rgba(0,0,0,.3);-webkit-background-clip:padding;-moz-background-clip:padding;background-clip:padding-box}.alertify-text{border:1px solid #CCC;padding:10px;border-radius:4px}.alertify-button{border-radius:4px;color:#FFF;font-weight:700;padding:6px 15px;text-decoration:none;box-shadow:inset 0 1px 0 0 rgba(255,255,255,.5);background-image:-webkit-linear-gradient(top,rgba(255,255,255,.3),rgba(255,255,255,0));background-image:-moz-linear-gradient(top,rgba(255,255,255,.3),rgba(255,255,255,0));background-image:-ms-linear-gradient(top,rgba(255,255,255,.3),rgba(255,255,255,0));background-image:-o-linear-gradient(top,rgba(255,255,255,.3),rgba(255,255,255,0));background-image:linear-gradient(top,rgba(255,255,255,.3),rgba(255,255,255,0))}.alertify-button:hover,.alertify-button:focus{color:#3C72A8;text-decoration:none;outline:none;box-shadow:0 0 15px #2B72D5;background-image:-webkit-linear-gradient(top,rgba(0,0,0,.1),rgba(0,0,0,0));background-image:-moz-linear-gradient(top,rgba(0,0,0,.1),rgba(0,0,0,0));background-image:-ms-linear-gradient(top,rgba(0,0,0,.1),rgba(0,0,0,0));background-image:-o-linear-gradient(top,rgba(0,0,0,.1),rgba(0,0,0,0));background-image:linear-gradient(top,rgba(0,0,0,.1),rgba(0,0,0,0))}.alertify-button:active{position:relative;top:1px}.alertify-button-cancel{color: #004386;background-color:#FFC4BE;border:1px solid #D83526}.alertify-button-ok{color: #004386;background-color:#C3E0F6;border:1px solid #082178}.alertify-log{background:#1F1F1F;background:rgba(0,0,0,.9);padding:15px;border-radius:4px;color:#FFF;text-shadow:-1px -1px 0 rgba(0,0,0,.5)}.alertify-log-error{background:#FFC4BE;background:rgba(254,26,0,.9)}.alertify-log-success{background:#C3E0F6;background:rgba(92,184,17,.9)}.alertify-show,.alertify-log{-webkit-transition:all 500ms cubic-bezier(0.175,0.885,0.320,1);-webkit-transition:all 500ms cubic-bezier(0.175,0.885,0.320,1.275);-moz-transition:all 500ms cubic-bezier(0.175,0.885,0.320,1.275);-ms-transition:all 500ms cubic-bezier(0.175,0.885,0.320,1.275);-o-transition:all 500ms cubic-bezier(0.175,0.885,0.320,1.275);transition:all 500ms cubic-bezier(0.175,0.885,0.320,1.275)}.alertify-hide{-webkit-transition:all 250ms cubic-bezier(0.600,0,0.735,0.045);-webkit-transition:all 250ms cubic-bezier(0.600,-0.280,0.735,0.045);-moz-transition:all 250ms cubic-bezier(0.600,-0.280,0.735,0.045);-ms-transition:all 250ms cubic-bezier(0.600,-0.280,0.735,0.045);-o-transition:all 250ms cubic-bezier(0.600,-0.280,0.735,0.045);transition:all 250ms cubic-bezier(0.600,-0.280,0.735,0.045)}.alertify-cover{position:fixed;z-index:99999;top:0;right:0;bottom:0;left:0;background-color:#333333;-moz-opacity:0.8;-ms-filter: "alpha(opacity=80)";filter:alpha(opacity=80);opacity:0.8}.alertify{position:fixed;z-index:99999;top:50px;left:50%;width:550px;margin-left:-275px}.alertify-hidden{top:-50px;visibility:hidden}.alertify-logs{position:fixed;z-index:99999999999;bottom:70px;right:20px;width:280px}.alertify-log{display:block;margin-top:10px;position:relative;right:-300px}.alertify-log-show{right:0}.alertify-dialog{font-size:14px;padding:25px}.alertify-resetFocus{border:0;clip:rect(0 0 0 0);height:1px;margin:-1px;overflow:hidden;padding:0;position:absolute;width:1px}.alertify-inner{text-align:center}.alertify-text{margin-bottom:15px;width:100%;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;font-size:100%}.alertify-button{line-height:1.5;font-size:100%;display:inline-block;cursor:pointer;margin-left:5px}@media only screen and (max-width: 680px){.alertify,.alertify-logs{width:90%;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}.alertify{left:5%;margin:0}}
		path[stroke-dasharray*="fillrojo"] {
			fill: red;
			stroke: none;
			opacity: 0.2;
		}
		div.tipo_mobiliario {
    background: #95C11F;
    margin-bottom: 10px;
    margin-top: 10px;
    color: black;
    padding: 2px;
}
		.titulo-material {
    background: #95C11F;
    margin-bottom: 10px;
    margin-top: 10px;
    color: black;
    padding: 2px;
    text-align: center;
}
	</style>
	
	<style>
		.owl-carousel .owl-item img {max-width:100px;margin:0px auto;}
		.owl-item > li {
    list-style: none;
}
	div#parte_superior {
     width: 100%;
     min-height: 200px;
     position: relative;
     top: 0;
     z-index: 9;
	}
	
	div#header {
     min-height: 100px;
     background: #95C11F;
     width: 100%;
     padding: 25px;
	}	
		
	div#logo {
     width: 49%;
     display: inline-block;
	}
	
	div#btnSiguientePaso {
		width: 49%;
		display: inline-block;
		text-align: right;
	}
	div#btnSiguientePasoVerificador {
		width: 49%;
		display: inline-block;
		text-align: right;
	}	
	div#menu_planificador {
     background: #dedede;
     min-height: 120px;
	}	
	.divmenu {
		width: 100%;
		display: block;
		padding: 25px;
		min-height: 100px;
		cursor: pointer;
	}	
	div#menu_planificador_desplegado {
     width: 100%;
     background: white;
     min-height: 100px;
     border-bottom: 2px solid black;
	}	
	#menu_plano, #menu_mobiliario, #menu_instalaciones,#menu_materiales {
     width: 33%;
     display: inline-block;
     padding: 25px;
		min-height:120px;
		cursor:pointer;
	}	
		.menu-activo {background:white;}
		#panel_informacion {
    	background: white;
    	width: 100%;
    	border-bottom:2px solid black;
		}
		div#panel {
			width: 25%;
			display: inline-block;
			text-align: center;
			padding: 25px;
			transform: unset !important;
			left: unset;
			transition-duration: 0.3s;
			transition-timing-function: ease-in;
			transition-delay: 250ms;
			background:white;
		}
		div#informacion_panel {
			width: 55%;
			display: inline-block;
			padding: 25px;
		}
		div#informacion_pared {
			width: 19%;
			display: inline-block;
			padding: 25px;
		}
		span.info_muro {
			margin-right: 25px;
		}
		.paso-menu {
    background: #95C11F;
    border-radius: 50%;
    color: white;
    padding: 5px;
    width: 35px;
    height: 33px;
    display: inline-block;
}
		h2.titular-planificador {
    color: gray;
}
		section#rangeThick + ul {
    text-align: left;
}
		div#mensaje_inicio {
    width: 75%;
    margin: 0px auto;
    text-align: center;
    padding: 25px;
    background: #95C11F;
    margin-top: 50px;
    min-height: 100px;
    color: white;
}
		div#opciones_mobiliario,div#opciones_sc {
			text-align: center;
			padding: 25px;
			/*overflow-y: scroll;
    		height: calc(100vh - 200px);*/
		}
		ul.listado_imagenes > li {
   		 display: inline-block;
   		 text-align: center;
    	 font-size: 13px;
    	 padding:12px;;
		 cursor:pointer;
		 vertical-align:top;
}
		ul.listado_imagenes {text-align:center;}
		
	.selected {
		border: 3px solid #95C11F;
	}
		.nombre_pared {font-weight:bold;}
		div#opciones_mobiliario > span.object {
    cursor: pointer;
}
		.menu-mobiliario-activo {font-weight:bold;}
		span.tipo_mobiliario {
    margin-left: 50px;
    margin-right: 50px;
}
		#opciones_instalaciones * li.submenu_instalaciones{
    font-size: 16px;
    font-weight: 500;
    color: gray;
}
		div#opciones_instalaciones {
    padding-top: 25px;
}
		
	ul.opciones_instalaciones_menu {
		margin-bottom: 50px;
	}	
	.listado_muros {
    color: #95C124;
    font-weight: bold;
		display:none;
}	
		.unidades_elemento > input {
    color: #95C124;
    font-weight: bold;
    border: 1px solid #95C124;
		
}
		.unidades_elemento {display:none;}
		.metros_lineales {display:none;}
		
		@media (min-width:1099px)
		{
			span.secondline {
				position: relative;
				left: 39px;
			}
			ul.opciones_instalaciones_menu {display:none;}
		    ul.listado_imagenes.opciones_instalaciones_menu_escritorio {display:block;}
			div#panel {
    			width: 100%;
				padding-top:0px !important;
			}
			div#informacion_pared {
    			width: 100%;
			}
			.unidades_elemento * select {
				width: 109px;
				margin: 0px auto;
				border-radius: 0;
			}
			.owl-carousel.listado_instalaciones {
				width: 100%;
				max-width: 100%;
				margin: 0px auto;
				height: 620px;
			}
			#opciones_instalaciones * li.submenu_instalaciones {
				padding: 5px;
				font-size: 14px;
				display:block;
						}
			div#informacion_panel {width:100%;}
			span.info_muro {
				margin-right: auto;
				display: block;
			}
			div#parte_superior {
				width: 35%;
				min-height: 200px;
				position: relative;
				top: 0;
				z-index: 9;
			}
			#menu_plano, #menu_mobiliario, #menu_instalaciones,#menu_materiales {
				width: 100%;
				display: block;
				padding: 25px;
				min-height: 100px;
				cursor: pointer;
			}
			div#opciones_instalaciones {
				/*overflow-y:scroll;
				height: calc(100vh - 200px);*/
			}
			div#menu_planificador {
				background: #dedede;
				min-height: 120px;
				width: 50%;
				display: inline-block;
				overflow-y:scroll;
				height: calc(100vh - 200px);
				vertical-align: top;
			}
			        ::-webkit-scrollbar {
					  -webkit-appearance: none;
					  width: 7px;
					}

					::-webkit-scrollbar-thumb {
					  border-radius: 4px;
					  background-color: rgba(0, 0, 0, .5);
					  box-shadow: 0 0 1px rgba(255, 255, 255, .5);
					}
			#panel_informacion {
				background: white;
				width: 49%;
				border-bottom: 2px solid black;
				display: inline-block;
				overflow-y:scroll;
				height: calc(100vh - 200px);
				vertical-align: top;
			}
			
			ul.listado_imagenes {padding-left:0px;}
			ul.listado_imagenes > li {display:block;}
		}
		
		path[stroke-dasharray*="fillblanco"] {
			fill: #ffffff;
			stroke: none;
		}
		path[stroke-dasharray*="fillnegro"] {
			fill: #000000;
			stroke: none;
		}
		path[stroke-dasharray*="fillblue"] {
			fill: skyblue;
			stroke: none;
			fill-opacity: 0.4;
		}
		path[stroke-dasharray*="fillblue"] + path[stroke-dasharray*="fillblanco"] {
			opacity: 0.4;
		}
		button.btn.btn-xs.btn-info.zoom,button[data-zoom='zoomin'],button[data-zoom='zoomout'] {
		color: #95C11F !important;
		border: 1px solid #95C11F !important;
	}
		div#scaleVal {
    display: none;
}
		div#btnSiguientePaso > span {
			background: #7ea21b;
			padding: 10px;
			color: white;
			cursor:pointer;
		}
		ul.listado_imagenes.opciones_instalaciones_menu_escritorio > li {
			text-align: left;
			padding-bottom: 0;
		}
		span.checkmuro {
			display: block;
		}
		
		
	   #menu_planificador_movil {display:none;}
	   @media (max-width:1199px)
	   {
		 div#moveBox,div#zoomBox {
			display: none;
		}
		   
		 #menu_plano, #menu_mobiliario, #menu_instalaciones, #menu_materiales {
				min-height: 75px;
				cursor: pointer;
				padding-top: 5px;
				padding-bottom: 0px !important;
			}  
		 .divmenu {
    		width: 100%;
    		display: block;
    		padding: 25px;
    		min-height: 75px;
		 }
		  
		 div#informacion_panel {
    		width: 100%;
		    padding-bottom: 8px;	 
		 }
		 
		 button#select_mode {
			border: 1px solid black;
			background-color: white;
			color: black;
			width: 88%;
		}
		   
		 button#line_mode {
			height: unset !important;
			border: 2px solid #95C11F;
		 }
		   
		 #listado_muros {display:none;}
		 div#panel {
    		width: 100%;
		 }
		 div#panel > p:first-child {
			display: none;
		 }
		 
		 div#panel {
			padding-top: 0px !important;
			padding-bottom: 0px !important;
		 }
		 
		 .divmenu {padding-bottom:0px;padding-top:3px;}
		   
		 #menu_planificador_movil {display:block;width:100%;background: #95C11F;}
	  	 #menu_planificador > .divmenu {display:none;}
	  	 #menu_planificador > .divmenu.menu-activo {display:block};
		 .paso_menu_movil.menu-activo {font-weight:bold;}
		 .paso_menu_movil {
				width: 19%;
				display: inline-block;
				color: black;
				padding: 5px;
				text-align: center;
			    word-break: break-word;
				vertical-align: top;
				font-size: 13px;
		 }
		   
		 div#menu_planificador {
			min-height: unset;
		 }   
		 div#panel_informacion > div {
			margin-top: 0px !important;
		 }   
		   
		  div#panel > button {
			width: 32%;
	   }
	   .btn {
    	  display: inline-block;
    	  padding: 5px 5px; 
		} 
		   
	   }
	  
	</style>
</head>

<body style="background:#d6d6d6;margin:0;padding:0; ">
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
		   <div id="btnSiguentePasoVerificador"><span>Siguiente paso</span></div>
		 <?php
		  }
		  else if (!isset($_GET["id_presupuesto"]))
		  {
		 ?>
		 <div id="btnSiguientePaso"><span>Siguiente paso</span></div>
		 <?php
		  }
		 ?>
	 </div>
	
	<div id="menu_planificador_movil">
	 <div class="paso_menu_movil menu-activo">PASO 1: ESTADO ACTUAL</div>
 	 <div class="paso_menu_movil">PASO 2: ESTADO REFORMADO</div>
	 <div class="paso_menu_movil">PASO 3: MOBILIARIO</div>
	 <div class="paso_menu_movil">PASO 4: INSTALACIONES</div>
	 <div class="paso_menu_movil">PASO 5: MATERIALES</div>
	</div> 
	
	<div id="menu_planificador">
		<div class="divmenu menu-activo"><h2 class="titular-planificador"><span class="paso-menu">1.</span> <b style="color:black">PASO 1:</b> ESTADO ACTUAL</h2></div>
		<div class="divmenu"><h2 class="titular-planificador"><span class="paso-menu">2.</span> <b style="color:black">PASO 2:</b> ESTADO REFORMADO</h2></div>
		<div class="divmenu"><h2 class="titular-planificador"><span class="paso-menu">3.</span> <b style="color:black">PASO 3:</b> MOBILIARIO</h2></div>
		<div class="divmenu"><h2 class="titular-planificador"><span class="paso-menu">4.</span> <b style="color:black">PASO 4:</b> INSTALACIONES Y EQUIPAMIENTOS</h2></div>
		<div class="divmenu"><h2 class="titular-planificador"><span class="paso-menu">5.</span> <b style="color:black">PASO 5:</b> MATERIALES</h2></div>
	</div>

	<div id="panel_informacion">
		
	 <div style="text-align:center;margin-top:10px;">
		
		<button class="btn btn-default" id="select_mode"><i class="fa fa-2x fa-mouse-pointer" aria-hidden="true"></i> Seleccionar</button>
		 
	 </div>
	 <div id="opciones_crear_plano">
		  <div id="panel">
			<p>
				<button class="btn" id="undo" title="undo"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i></button>
				<button class="btn" id="redo" title="redo"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i></button>
			</p>

			
			 <?php
	 		  if (!isset($_SESSION["login"]))
			  {
				 //El verificador no puede crear nuevos muros, puede modificar los que ya hay
			 ?>
				<button class="btn btn-success" style="height: 47px;" id="line_mode" data-toggle="tooltip" data-placement="right" title="Make walls">COMENZAR</button>
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
				  </div>
			</div>
		   <?php
	 /*
			<div id="informacion_pared">
				<b>Altura paredes </b> 
				<select name="altura_paredes" id="altura_paredes" class="form-control">
				 <option value="">-- Selecciona --</option>
				 <option value="2" <?php if ($altura_pared == 2) { ?>selected <?php } ?>>2.00 m</option>
				 <option value="2.05" <?php if ($altura_pared == 2.05) { ?>selected <?php } ?>>2.05 m</option>
				 <option value="2.10" <?php if ($altura_pared == 2.10) { ?>selected <?php } ?>>2.10 m</option>
				 <option value="2.15" <?php if ($altura_pared == 2.15) { ?>selected <?php } ?>>2.15 m</option>
				 <option value="2.20" <?php if ($altura_pared == 2.20) { ?>selected <?php } ?>>2.20 m</option>
				 <option value="2.25" <?php if ($altura_pared == 2.25) { ?>selected <?php } ?>>2.25 m</option>
				 <option value="2.30" <?php if ($altura_pared == 2.30) { ?>selected <?php } ?>>2.30 m</option>
				 <option value="2.35" <?php if ($altura_pared == 2.35) { ?>selected <?php } ?>>2.35 m</option>
				 <option value="2.40" <?php if ($altura_pared == 2.40) { ?>selected <?php } ?>>2.40 m</option>
				 <option value="2.45" <?php if ($altura_pared == 2.45) { ?>selected <?php } ?>>2.45 m</option>
				 <option value="2.50" <?php if ($altura_pared == 2.50) { ?>selected <?php } ?>>2.50 m</option>
				 <option value="2.55" <?php if ($altura_pared == 2.55) { ?>selected <?php } ?> >2.55 m</option>
				 <option value="2.60" <?php if ($altura_pared == 2.60) { ?>selected <?php } ?> >2.60 m</option>
				 <option value="2.65" <?php if ($altura_pared == 2.65) { ?>selected <?php } ?>>2.65 m</option>
				 <option value="2.70" <?php if ($altura_pared == 2.70) { ?>selected <?php } ?>>2.70 m</option>
				 <option value="2.75" <?php if ($altura_pared == 2.75) { ?>selected <?php } ?>>2.75 m</option>
				 <option value="2.80" <?php if ($altura_pared == 2.80) { ?>selected <?php } ?>>2.80 m</option>
				 <option value="2.85" <?php if ($altura_pared == 2.85) { ?>selected <?php } ?>>2.85 m</option>
				 <option value="2.90" <?php if ($altura_pared == 2.90) { ?>selected <?php } ?>>2.90 m</option>
				 <option value="2.95" <?php if ($altura_pared == 2.95) { ?>selected <?php } ?>>2.95 m</option>
				 <option value="3" <?php if ($altura_pared == 3) { ?>selected <?php } ?>>3.00 m</option>
				</select>
			</div>
		
		*/ 
		?>
		 
	 </div>

	</div>
	 
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
  </div>

  <div id="wallTools" class="leftBox">
    <h2 id="titleWallTools">Modifica la pared</h2>
    <hr/>
    <section id="rangeThick">
      <p>Editando: <span id="wallWidthScale"></span>  <span id="wallWidthVal"></span></span></p>
      <input type="text" id="wallWidth" />
    </section>
    <ul class="list-unstyled">
    <br/>
    <li><button class="btn btn-danger halfy" id="wallTrash"><i class="fa fa-2x fa-trash-o" aria-hidden="true"></i></button>
    <button class="btn btn-info halfy pull-right" onclick="fonc_button('select_mode');$('#boxinfo').html('Modo selección');$('#wallTools').hide('300');$('#panel').show('300');"><i class="fa fa-2x fa-backward" aria-hidden="true" ></i></button></li>
    </ul>
  </div>

<!-- divs vacios -->
  <div style="display:none" id="objBoundingBox" class="leftBox"></div>
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
  <div style="display:none" id="bboxTrash"></div>
  <div style="display:none" id="doorWindowWidth"></div>
  <div style="display:none" id="objToolsHinge"></div>
  <div style="display:none" id="applySurface"></div>
  <div style="display:none" id="resetRoomTools"></div>
  <div style="display:none" id="roomTools" class="leftBox"></div>
  <div style="display:none" id="bboxStepsAdd"></div>
  <div style="display:none" id="bboxStepsMinus"></div>
  <div style="display:none" id="bboxWidth"></div>
  <div style="display:none" id="bboxHeight"></div>
  <div style="display:none" id="bboxRotation"></div>
<!-- fin divs vacios -->

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
<!-- alertify -->
<script>
!function(t,k){"use strict";var e,E=t.document;e=function(){var m,s,a,o,r,n={},l={},c=!1,v=27,g=32,f=[];return l=E.location.href.includes("mis_datos.php")?{buttons:{holder:'<nav class="alertify-buttons">{{buttons}}</nav>',submit:'<button type="submit" class="alertify-button alertify-button-ok" id="alertify-ok" />{{ok}}</button>',ok:'<a href="#" class="alertify-button alertify-button-ok" id="alertify-ok">{{ok}}</a>',cancel:'<a href="#" class="alertify-button alertify-button-cancel" id="alertify-cancel">{{cancel}}</a>'},input:'<input type="password" class="alertify-text" id="alertify-text">',message:'<p class="alertify-message">{{message}}</p>',log:'<article class="alertify-log{{class}}">{{message}}</article>'}:{buttons:{holder:'<nav class="alertify-buttons">{{buttons}}</nav>',submit:'<button type="submit" class="alertify-button alertify-button-ok" id="alertify-ok" />{{ok}}</button>',ok:'<a href="#" class="alertify-button alertify-button-ok" id="alertify-ok">{{ok}}</a>',cancel:'<a href="#" class="alertify-button alertify-button-cancel" id="alertify-cancel">{{cancel}}</a>'},input:'<input type="text" class="alertify-text" id="alertify-text">',message:'<p class="alertify-message">{{message}}</p>',log:'<article class="alertify-log{{class}}">{{message}}</article>'},m=function(t){return E.getElementById(t)},{alert:function(t,e){return n.dialog(t,"alert",e),this},confirm:function(t,e){return n.dialog(t,"confirm",e),this},extend:(n={labels:{ok:"Aceptar",cancel:"Cancelar"},delay:8e3,addListeners:function(e){var i,n,a,s,o,r=m("alertify-resetFocus"),l=m("alertify-ok")||k,c=m("alertify-cancel")||k,f=m("alertify-text")||k,u=m("alertify-form")||k,d=void 0!==l,y=void 0!==c,b=void 0!==f,p="",h=this;i=function(t){void 0!==t.preventDefault&&t.preventDefault(),a(t),void 0!==f&&(p=f.value),"function"==typeof e&&e(!0,p)},n=function(t){void 0!==t.preventDefault&&t.preventDefault(),a(t),"function"==typeof e&&e(!1)},a=function(t){h.hide(),h.unbind(E.body,"keyup",s),h.unbind(r,"focus",o),b&&h.unbind(u,"submit",i),d&&h.unbind(l,"click",i),y&&h.unbind(c,"click",n)},s=function(t){var e=t.keyCode;e!==g||b||i(t),e===v&&y&&n(t)},o=function(t){b?f.focus():y?c.focus():l.focus()},this.bind(r,"focus",o),d&&this.bind(l,"click",i),y&&this.bind(c,"click",n),this.bind(E.body,"keyup",s),b&&this.bind(u,"submit",i),t.setTimeout(function(){f?(f.focus(),f.select()):l.focus()},50)},bind:function(t,e,i){"function"==typeof t.addEventListener?t.addEventListener(e,i,!1):t.attachEvent&&t.attachEvent("on"+e,i)},build:function(t){var e="",i=t.type,n=t.message;switch(e+='<div class="alertify-dialog">',"prompt"===i&&(e+='<form id="alertify-form">'),e+='<article class="alertify-inner">',e+=l.message.replace("{{message}}",n),"prompt"===i&&(e+=l.input),e+=l.buttons.holder,e+="</article>","prompt"===i&&(e+="</form>"),e+='<a id="alertify-resetFocus" class="alertify-resetFocus" href="#">Reset Focus</a>',e+="</div>",i){case"confirm":e=(e=e.replace("{{buttons}}",l.buttons.ok+l.buttons.cancel)).replace("{{ok}}",this.labels.ok).replace("{{cancel}}",this.labels.cancel);break;case"prompt":e=(e=e.replace("{{buttons}}",l.buttons.submit+l.buttons.cancel)).replace("{{ok}}",this.labels.ok).replace("{{cancel}}",this.labels.cancel);break;case"alert":e=(e=e.replace("{{buttons}}",l.buttons.ok)).replace("{{ok}}",this.labels.ok)}return o.className="alertify alertify-show alertify-"+i,a.className="alertify-cover",e},close:function(t,e){var i=e&&!isNaN(e)?+e:this.delay;this.bind(t,"click",function(){r.removeChild(t)}),setTimeout(function(){void 0!==t&&t.parentNode===r&&r.removeChild(t)},i)},dialog:function(t,e,i,n){s=E.activeElement;var a=function(){o&&null!==o.scrollTop||a()};if("string"!=typeof t)throw new Error("message must be a string");if("string"!=typeof e)throw new Error("type must be a string");if(void 0!==i&&"function"!=typeof i)throw new Error("fn must be a function");return"function"==typeof this.init&&(this.init(),a()),f.push({type:e,message:t,callback:i,placeholder:n}),c||this.setup(),this},extend:function(i){return function(t,e){this.log(t,i,e)}},hide:function(){f.splice(0,1),0<f.length?this.setup():(c=!1,o.className="alertify alertify-hide alertify-hidden",a.className="alertify-cover alertify-hidden",s.focus())},init:function(){E.createElement("nav"),E.createElement("article"),E.createElement("section"),(a=E.createElement("div")).setAttribute("id","alertify-cover"),a.className="alertify-cover alertify-hidden",E.body.appendChild(a),(o=E.createElement("section")).setAttribute("id","alertify"),o.className="alertify alertify-hidden",E.body.appendChild(o),(r=E.createElement("section")).setAttribute("id","alertify-logs"),r.className="alertify-logs",E.body.appendChild(r),E.body.setAttribute("tabindex","0"),delete this.init},log:function(t,e,i){var n=function(){r&&null!==r.scrollTop||n()};return"function"==typeof this.init&&(this.init(),n()),this.notify(t,e,i),this},notify:function(t,e,i){var n=E.createElement("article");n.className="alertify-log"+("string"==typeof e&&""!==e?" alertify-log-"+e:""),n.innerHTML=t,r.insertBefore(n,r.firstChild),setTimeout(function(){n.className=n.className+" alertify-log-show"},50),this.close(n,i)},set:function(t){var e;if("object"!=typeof t&&t instanceof Array)throw new Error("args must be an object");for(e in t)t.hasOwnProperty(e)&&(this[e]=t[e])},setup:function(){var t=f[0];c=!0,o.innerHTML=this.build(t),"string"==typeof t.placeholder&&(m("alertify-text").value=t.placeholder),this.addListeners(t.callback)},unbind:function(t,e,i){"function"==typeof t.removeEventListener?t.removeEventListener(e,i,!1):t.detachEvent&&t.detachEvent("on"+e,i)}}).extend,init:n.init,log:function(t,e,i){return n.log(t,e,i),this},prompt:function(t,e,i){return n.dialog(t,"prompt",e,i),this},success:function(t,e){return n.log(t,"success",e),this},error:function(t,e){return n.log(t,"error",e),this},set:function(t){n.set(t)},labels:n.labels}},"function"==typeof define?define([],function(){return new e}):void 0===t.alertify&&(t.alertify=new e)}(this);
</script>
<script>
	
  $( document ).ready(function() {
	  
	 //Ajusto zoom
	 for (var i=0;i<3;i++)
	 {
	   //$("button[data-zoom='zoomin']").trigger("click"); 
	 }
	  
	 if ($(window).width() < 1099)
	 {
		  $('.owl-carousel').owlCarousel({
			loop:false,
			margin:50,
			responsiveClass:true,
			responsive:{
				0:{
					items:2
				},
				600:{
					items:3
				},
				1000:{
					items:4
				},
				1099: {
					items:2
				}
			}
		})
	 }
	  
	 $("#btnSiguientePaso").click(function() {
		 
		 $("#btnSiguientePaso").attr("style","pointer-events: none;");
		 $("#btnSiguientePaso > span").html("Guardando...")

		 console.log("LOCAL STORAGE ANTES DE SAVE");
		 console.log(localStorage.getItem("history"));

		 save();
		 console.log("LOCAL STORAGE DESPUES DE SAVE");
		 console.log(localStorage.getItem("history"));
		 console.log("LOCALS STORAGE stringfy");
		 var numero_muros=$(".muro").length;
		 
		 if (numero_muros > 0)
		 {
			 var contenido=HISTORY[numero_muros]; //El último muro es el que tiene la info de todo el dibujo
			 var puertas_ventanas=$("#boxcarpentry").html();
			 $.ajax({
					 type: "POST",
					 dataType: 'json', 
					 async:false,
					 url: "ajax/guardar_dibujo2d_estado_actual.php",
					 data: {contenido:contenido,puertas_ventanas:puertas_ventanas},
					 success:function(respuesta){
							window.location.assign("https://rehubik.com/presupuestador/2d/index.php"); 
				  }

			 });
	      }
		  else
		  {
			alertify.error("Debes dibujar el estado actual de tu cocina antes de continuar");
		    setTimeout(function(){ $("#btnSiguientePaso").attr("style","pointer-events: unset;"); $("#btnSiguientePaso > span").html("Siguiente paso")  }, 2000);
		  }

	 }) 

	 $("#btnSiguientePasoVerificador").click(function() {
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
			 $.ajax({
					 type: "POST",
					 dataType: 'json', 
					 async:false,
					 url: "ajax/guardar_dibujo2d_verificador.php?id_presupuesto=<?php echo $_GET['id_presupuesto'];?>",
					 data: {contenido:contenido,elementos_dibujados:elementos_dibujados},
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
	  
	  console.log("HISTORY PUSH ES ");
	  console.log(HISTORY);

	</script>
<?php
}
?>

</html>
