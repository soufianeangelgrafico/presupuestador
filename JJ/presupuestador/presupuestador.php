<!DOCTYPE html>
<html lang="es">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Modern Business - Start Bootstrap Template</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/modern-business.css" rel="stylesheet">
  <style>
@import url('https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,700,700i,900&display=swap');
</style>
	<style>
		::placeholder {
    font-size: 12px !important;
    color: gray!important;
    font-weight: 300 !important;
}
		.selected {
    border: 3px solid black;
}
	</style>
</head>

<body <?php if (isset($_GET["paso"]) && $_GET["paso"] == 3 || (isset($_GET["paso"]) && $_GET["paso"] == 4))  {?> style="background:white" <?php } else if (isset($_GET["paso"]) && $_GET["paso"] >= 4) { ?> style="background:#F0F0F0" <?php } else { ?>class="page-presupuestador"<?php } ?>> 

<?php
	
if (isset($_GET["paso"]) && $_GET["paso"] == 2)
{
	 //Formulario para subir la foto de ikea
?>
	    <div id="popupfoto" style="display: none;">
		 <span id="close">X</span>
		 <div id="subpopupfoto">
		  <div class="container">
			  <div class="row presentacion"> 
			   <div class="col-md-6">
				   <p><img src="iconos/icon_imagen.png"></p>
				   <h2>¿Tienes ya tu cocina IKEA?</h2>
				   <p class="texto1">Haz la reforma completa de tu cocina fácil y cómodamente.</p>
				   <p class="texto2">Sube una imagen de tu proyecto ikea, elige tu centro y continua con la reforma.</p>
				   <form method="POST" id="image-form" enctype="multipart/form-data" onSubmit="return false;">
					   <p class="margintop25"><input type="file" name="file" id="file" class="form form-control" style="width:100%"></p>
					   <p class="textRight"><input type="submit" id="subir_ikea" name="subir_ikea" value="Subir archivo" class="btn-redondeado"></p>
					   <div id="msg"></div>
					   <p class="instrucciones margintop25">Puedes cargar tu archivo PDF, o una imagen JPEG.
						   Esta información no es vinculante al presupuesto.</p>
				   </form>	   
			   
				  </div>

			   <div class="col-md-6 textCenter">
				 <img src="img/contacto.png" width="330" style="max-width:100%">

			   </div>

			  </div>
		  </div>
		</div>
  </div>	
<?php
}
?>	

<?php
if (isset($_GET["paso"]) && $_GET["paso"] == 5)
{
	 //Formulario CITA PREVIA
?>
	    <div id="popupfoto" style="display: none;">
		 <span id="close">X</span>
		 <div id="subpopupfoto">
		  <div class="container">
			  <div class="row presentacion">
			   <div class="col-md-6">
				   <p><img src="iconos/icon_aviso.png"></p>
				   <h2>Cita previa verificador</h2>
				   <p class="texto1">Selecciona fecha y hora para que uno de nuestros verificadores confirmen los datos de tu reforma.</p>
				   <p class="texto2">Esta visita tiene un coste de 60 € que se descontarán del importe final si se lleva a cabo la reforma</p>
				   <p><input type="text" class="form form-control" value="Código Postal"></p>	   
			   </div>

			   <div class="col-md-6 textCenter">
				 
					<iframe class="centrado" width="330" height="250" style="background-color: transparent;margin:0 auto;" frameborder="0" scrolling="auto" src="calendario/index.php"></iframe>

			   </div>

			  </div>
		  </div>
		</div>
  </div>	
<?php
}
?>
	
	
	
	
	
  <?php include("includes/menu_presupuestador.php");?>

  <!-- Page Content -->
  <div class="container">
  <?php
	 if (!isset($_GET["paso"]) || $_GET["paso"] == 1)
	 {
  ?>
	<div class="row">
	  <div class="col-md-12 textoIntro paddingbottom0">
       <h1 class="my-4 colorwhite">¡Bienvenido!</h1>
		<h2 class="my-4-subtitulo colorwhite">TU PRESUPUESTO DE REFORMA EN <b>5 SENCILLOS PASOS</b></h2>
	  </div>
	</div>
	  
	<div class="row">  
     <div class="col-md-12 textoIntro paddingbottom0">
      <h1 class="my-4">1. Elige tu centro Ikea</h1>
	 </div>
	</div>
	  
	<div class="row"> 
	 <div class="col-md-12 textoIntro">
      <ul class="cuadrados">
		 <li class="pointer" onclick="avanza(1,'roquetes')"><div class="texto-li centrado">Ikea Roquetes</div></li>
		 <li class="pointer" onclick="avanza(1,'ondara')"><div class="texto-li centrado">Ikea Ondara</div></li>
		 <li class="pointer" onclick="avanza(1,'castellon')"><div class="texto-li centrado">Ikea Castellón</div></li>
		 <li class="pointer" onclick="avanza(1,'alfafar')"><div class="texto-li centrado">Ikea Alfafar</div></li>
		 <li class="pointer" onclick="avanza(1,'coruna')"><div class="texto-li centrado">Ikea A Coruña</div></li>
		 <li class="pointer" onclick="avanza(1,'badalona')"><div class="texto-li centrado">Ikea Badalona</div></li>
		 <li class="pointer" onclick="avanza(1,'hospitalet')"><div class="texto-li centrado">Ikea Hospitalet</div></li>
		 <li class="pointer" onclick="avanza(1,'sabadell')"><div class="texto-li centrado">Ikea Sabadell</div></li>
		 <li class="pointer" onclick="avanza(1,'ss')"><div class="texto-li centrado">Ikea SS De los Reyes</div></li>
		 <li class="pointer" onclick="avanza(1,'valladolid')"><div class="texto-li centrado">Ikea Valladolid</div></li>
	  </ul>
	 </div>
	</div>
   <?php
	 }
	 else if (isset($_GET["paso"]) && $_GET["paso"] == 2)
	 {
  ?>
	  
	<div class="row">  
     <div class="col-md-12 textoIntro paddingbottom0">
      <h1 class="my-4">2. Elige tu reforma</h1>
	 </div>
	</div>
	  
	<div class="row"> 
	 <div class="col-md-12 textoIntro">
      <ul class="cuadrados">
		 <li class="pointer" onclick="avanza(2,'cocina')"><div class="texto-li centrado">COCINA</div></li>
		 <li class="deshabilitado"><div class="texto-li centrado">BAÑO</div></li>
		 <li class="deshabilitado"><div class="texto-li centrado">BAÑERA<br/>POR DUCHA</div></li>
		 <li class="deshabilitado"><div class="texto-li centrado">PEQUEÑA<br/>REFORMA</div></li>
		 <li class="deshabilitado"><div class="texto-li centrado">REFORMA<br/>INTEGRAL</div></li>
	  </ul>
	 </div>
	</div>
	 
	<div class="row margintop25">
		 <div class="col-md-12">
			<p class="textLeft">
			  <a class="btn-redondeado" href="presupuestador.php?paso=1">Atrás</a>
		    </p>	
		 </div>	
	    </div>
	  
   <?php
	 }
	 else if (isset($_GET["paso"]) && $_GET["paso"] == 3)
	 {
   ?>
	   <div class="row margintop25">  
		 <div class="col-md-10 textoIntro paddingbottom0 bordenegro" style="padding-left:50px;">
		  <div class="row">
		   <div class="col-md-8">
			   <h1 class="my-4">3. Presupuesto IKEA <span class="interrogante">?</span></h1>
		       <ul class="textCenter cuadrados_planificador	width100">
				 <li onclick="subidaPopup()" class="pointer"><div class="texto-li centrado">SUBIR</div></li>
				 <li><div class="pointer texto-li centrado" onclick="avanza(3,'sin presupuesto ikea');">NO TENGO</div></li>
			  </ul>
		   </div>
		   <div class="col-md-4"> 
			   <p><img src="iconos/cocina_medidas.png" width="305"></p>
		     
		   </div>	  
		  </div>
		 </div>
		</div>
		
	    <div class="row margintop25">
		 <div class="col-md-12">
			<p class="textLeft">
			  <a class="btn-redondeado" href="presupuestador.php?paso=2">Atrás</a>
		    </p>	
		 </div>	
	    </div>	
    <!--<div class="row">	  
     <div class="col-md-6">
	  <div class="centrado width80">
        <h1 class="my-4">2. Edición de plano</h1>
		<h2 class="my-4-subtitulo">INTRODUCE LAS MEDIDAS DE TU <b>COCINA</b></h2>
		<p class="textRight margintop25 marginbottom25">
		  <img src="img/flecha_derecha.png" width="135">	
		</p>	
		<p class="textLeft">
			<a class="btn-redondeado" href="presupuestador.php">Atrás</a>
		</p>
	  </div>
	</div>
	
	 <div class="col-md-6 white height100vh">
      <div class="centrado">
		  <p class="textCenter"><img src="iconos/cocina_medidas.png" width="305"></p>
		  <form name="medidas" method="POST" action="#">
			 <div class="row">
				<div class="col-md-6">
					<input type="number" name="largo" placeholder="Largo (m)" class="form form-control">
				</div>	 
				<div class="col-md-6">
					<input type="number" name="ancho" placeholder="Ancho (m)" class="form form-control">
				</div>	
				<div class="col-md-6">
					<input type="number" name="altura" placeholder="Altura (m)" class="form form-control">
				</div>	 
				<div class="col-md-6">
					<input type="number" name="mobiliario" placeholder="Mobiliario (ml)" class="form form-control">
				</div>
				<div class="col-md-6">
					<input type="number" name="suelo" placeholder="Suelo (m2)" class="form form-control">
				</div>	 
				<div class="col-md-6">
					<input type="number" name="paredes" placeholder="Paredes (m2)" class="form form-control">
				</div>	
				<div class="col-md-12">
					<textarea name="comentarios" placeholder="Comentarios (m)" class="form form-control"></textarea>
				</div>	
				<div class="col-md-12 textRight">
					<input type="button" class="btn-redondeado" value="Siguiente" onclick="window.location.assign('presupuestador.php?paso=3')">
				</div> 
				 
			 </div>	 
		  </form>	  
	  </p>	  
	 </div> 
	</div>-->
   <?php
	 }
	 else if (isset($_GET["paso"]) && $_GET["paso"] == 4)
	 {
   ?>
	  
		<div class="row margintop25">  
		 <div class="col-md-10 textoIntro paddingbottom0 bordenegro" style="padding-left:50px;">
		  <div class="row">
		   <div class="col-md-8">
			   <h1 class="my-4">4. Planifica tu cocina <span class="interrogante">?</span></h1>
		       <p><img src="iconos/cocina_medidas.png" width="305"></p>
		   </div>
		   <div class="col-md-4"> 
		     <ul class="cuadrados_planificador centrado width100">
				 <li><div class="pointer texto-li centrado" onclick="window.location.assign('2d/index.html')">Crea tu cocina</div></li>
			  </ul>
		   </div>	   
		  </div>
		 </div>
		</div>
		
	    <div class="row margintop25">
		 <div class="col-md-12">
			<p class="textLeft">
			  <a class="btn-redondeado" href="presupuestador.php?paso=3">Atrás</a>
		    </p>	
		 </div>	
	    </div>		
	  
   <?php
	 }
	 else if (isset($_GET["paso"]) && $_GET["paso"] == 5)
	 {
	?> 
		
		  <div class="row">
		   <div class="col-md-12 textoIntro">
			   <h1 class="my-4">5. Personaliza tu cocina</h1>
		   </div>
		  </div>
		
	      <div class="row">
			<div class="col-md-7 textoIntro">
			  <h2 class="marginbottom25">Elige un estilo</h2>
			  <ul class="cuadrados_presupuesto">
				  <li><div class="texto-li centrado">ESTILO 1</div></li>
				  <li><div class="texto-li centrado">ESTILO 2</div></li>
				  <li><div class="texto-li centrado">ESTILO 3</div></li>
				  <li><div class="texto-li centrado">ESTILO 4</div></li>
				  <li><div class="texto-li centrado">ESTILO 5</div></li>
				  <li><div class="texto-li centrado">ESTILO 6</div></li>
				  <li><div class="texto-li centrado">ESTILO 7</div></li>
				  <li><div class="texto-li centrado">ESTILO 8</div></li>
				  <li><div class="texto-li centrado">ESTILO 9</div></li>	  
			 </ul>	  
			</div>	  
			<div class="col-md-5 margintop25" style="padding:0;"><img src="img/foto_personalizar.png" style="width:100%"></div>
	      </div>	  
		
	      <div class="row">
			<div class="col-md-5 textoIntro">
			  <h2 class="marginbottom25">Personaliza tu reforma / Estilo X</h2>
			  <ul class="cuadrados_estilo"> 
				  <li><div class="texto-li centrado">ARMARIOS</div></li>
				  <li><div class="texto-li centrado">CHAPADO</div></li>
				  <li><div class="texto-li centrado">PINTURA</div></li>
				  <li><div class="texto-li centrado">ESTILO 4</div></li>
				  <li><div class="texto-li centrado">SUELO</div></li>
				  <li><div class="texto-li centrado">VENTANAS</div></li>
				  <li><div class="texto-li centrado">PUERTA</div></li>	  
			 </ul>	  
			</div>	  
			<div class="col-md-7 margintop25"><img src="img/foto_personalizar.png" style="width:100%"></div>
	      </div>
	  		
	  	  <div class="row paddingbottom0">
		   <div class="col-md-12 textoIntro">
			   <h1 class="my-4">Instalación y obra</h1>
			   <h2>¿QUÉ NECESITAS INSTALAR? <span class="interrogante">?</span><div class="respuesta">Los electrodomésticos no están incluidos</div></h2> 
			   <p>CADA ELEMENTO DE INSTALACIÓN REQUIERE DE UNOS SERVICIO ESPECIFICOS ( LUZ, AGUA, GAS...). SELECCIONA TODO LO QUE NECESITES INSTALAR EN TU NUEVA COCINA.</p>
		   </div>
		  </div>
		
	      <div class="row paddingtop0">
			<div class="col-md-12 textoIntro">
			  <h2 class="marginbottom25">_PARA COCINAR</h2> 
			  <ul class="listado_imagenes">
				  <li><img src="iconos/placa_gas.png" class="elemento_instalacion" id="placa_gas"><br/>PLACA DE GAS</li>
				  <li><img src="iconos/vitro_induccion.png" class="elemento_instalacion" id="vitro_induccion"><br/>VITRO/INDUCCIÓN</li>
				  <li><img src="iconos/horno.png" class="elemento_instalacion" id="horno"><br/>HORNO</li>
				  <li><img src="iconos/microondas.png" class="elemento_instalacion" id="microondas"><br/>MICROONDAS</li>
				  <li><img src="iconos/extractor.png" class="elemento_instalacion" id="extractor"><br/>EXTRACTOR</li>
				  <li><img src="iconos/frigorifico.png" class="elemento_instalacion" id="frigorifico"><br/>FRIGORIFICO</li>
				  
			  </ul>
			</div>	  
	      </div>
	  	  
	  	  <div class="row paddingtop0">
			<div class="col-md-12 textoIntro">
			  <h2 class="marginbottom25">_PARA LAVAR</h2> 
			  <ul class="listado_imagenes">
				  <li><img src="iconos/fregadero.png" class="elemento_instalacion" id="fregadero"><br/>FREGADERO</li>
				  <li><img src="iconos/lavavajillas.png" class="elemento_instalacion" id="lavavajillas"><br/>LAVAVAJILLAS</li>
				  <li><img src="iconos/lavadora.png" class="elemento_instalacion" id="lavadora"><br/>LAVADORA</li>
				  <li><img src="iconos/secadora.png" class="elemento_instalacion" id="secadora"><br/>SECADORA</li>
				  
			  </ul>
			</div>	  
	      </div>
	  
	  
	  	  <div class="row paddingtop0">
			<div class="col-md-12 textoIntro">
			  <h2 class="marginbottom25">_PARA CALENTAR</h2> 
			  <ul class="listado_imagenes">
				  <li><img src="iconos/calentador.png" class="elemento_instalacion" id="calentador"><br/>CALENTADOR GAS</li>
				  <li><img src="iconos/termo.png" class="elemento_instalacion" id="termo"><br/>TERMO</li>
				  <li><img src="iconos/caldera.png" class="elemento_instalacion" id="caldera"><br/>CALDERA</li>
				  <li><img src="iconos/radiador.png" class="elemento_instalacion" id="radiador"><br/>RADIADOR</li>
				  
			  </ul>
			</div>	  
	      </div>
	  	
	  	  <div class="row paddingbottom0">
		   <div class="col-md-12 textoIntro">
			   <h1 class="my-4">¿Necesitas algo más?</h1>
		   </div>
		  </div>
	  
	  
	  	  <div class="row paddingtop0">
			<div class="col-md-12 textoIntro">
			  <h2 class="marginbottom25">_DE ELECTRICIDAD</h2> 
			  <ul class="listado_imagenes">
				  <li><img src="iconos/puntos_extras.png" class="elemento_instalacion" id="puntos_extras"><br/>PUNTOS ELÉCTRICOS<br/> EXTRAS</li>
				  <li><img src="iconos/puntos_luz_techo.png" class="elemento_instalacion" id="puntos_luz_techo"><br/>PUNTOS DE LUZ<br/> EN TECHO</li>
			  </ul>
			</div>	  
	      </div>
	  	
	  	  <div class="row paddingtop0">
			<div class="col-md-12 textoIntro">
			  <h2 class="marginbottom25">_DE FONTANERÍA</h2> 
			  <ul class="listado_imagenes">
				  <li><img src="iconos/llave_corte_agua.png" class="elemento_instalacion" id="llave_corte_agua"><br/>LLAVE DE CORTE<br/> EN LA VIVIENDA</li>
			  </ul>
			</div>	  
	      </div>
	  	
	      <div class="row paddingtop0">
			<div class="col-md-12 textoIntro">
			  <h2 class="marginbottom25">_DE GAS</h2> 
			  <ul class="listado_imagenes">
				  <li><img src="iconos/instalacion_gas.png" class="elemento_instalacion" id="instalacion_gas"><br/>INSTALACIÓN DE GAS</li>
				  <li><img src="iconos/anular_punto_gas.png" class="elemento_instalacion" id="anular_punto_gas"><br/>ANULACIÓN PUNTO GAS</li>
			  </ul>
			</div>	  
	      </div>
	  	
	  	  <div class="row paddingtop0">
			<div class="col-md-12 textoIntro">
			  <h2 class="marginbottom25">_DE ALBAÑILERÍA</h2> 
			  <ul class="listado_imagenes">
				  <li><img src="iconos/hacer_tabique.png" class="elemento_instalacion" id="hacer_tabique"><br/>HACER TABIQUE</li>
				  <li><img src="iconos/tirar_tabique.png" class="elemento_instalacion" id="tirar_tabique"><br/>TIRAR TABIQUE</li>
				  <li><img src="iconos/falso_techo.png" class="elemento_instalacion" id="falso_techo"><br/>FALSO TECHO</li>
			  </ul>
			</div>	  
	      </div>
	  	  
	  	  <div class="row paddingtop0">
			<div class="col-md-12 textRight">
			  <h2 class="marginbottom25 padding50" id="precio_reforma">Tu reforma: 9.996 €</h2> 
			</div>	  
	      </div>
	  
	 	  <div class="row marginbottom25">
	        <div class="col-md-6 textLeft">
				<input type="button" class="btn-redondeado" value="Atrás" onclick="window.location.assign('presupuestador.php?paso=4')">
		    </div>
			<div class="col-md-6 textRight">
				<input type="button" class="btn-redondeado" value="Siguiente" onclick="avanza(5,'selected')">
		    </div>  
	  	  </div>
	  
	<?php	 
	 }
	 else if (isset($_GET["paso"]) && $_GET["paso"] == 6)
	 {
   ?>
		  <div class="row">
		   <div class="col-md-12 textoIntro">
			   <h1 class="my-4">6. Recibe tu presupuesto</h1>
			   <h2>RELLENA TUS DATOS, RECIBE TU PRESUPUESTO Y PIDE CITA PREVIA</h2>
		   </div>	  
		  </div>
		  
	  	  <form name="form_presupuestador_cita" method="POST" action="POST" id="form_presupuestador_cita">
	   	   <div class="row">
			  <div class="col-md-8 textoIntro">
			   <div class="row">
			     
				 <div class="col-md-6">
					 <input type="text" class="form form-control" id="nombre" name="nombre" placeholder="Nombre">
				 </div>
				   
				 <div class="col-md-6">  
				  	 <input type="text" class="form form-control" id="apellidos" name="apellidos" placeholder="Apellidos">
				 </div>
				   
				 <div class="col-md-8">  
				  	 <input type="text" class="form form-control" id="direccion" name="direccion" placeholder="Dirección (Calle / Piso / Puerta...)">
				 </div>  
				  
				 <div class="col-md-4">  
				  	 <input type="text" class="form form-control" id="cp" name="cp" placeholder="Código Postal">
				 </div>  
				  
				 <div class="col-md-6">  
				  	 <input type="text" class="form form-control" id="poblacion" name="poblacion" placeholder="Población">
				 </div>  
				  
				 <div class="col-md-6">  
				  	 <input type="text" class="form form-control" id="provincia" name="provincia" placeholder="Provincia">
				 </div>   
				   
				 <div class="col-md-4">  
				  	 <input type="text" class="form form-control" id="telefono" name="telefono" placeholder="Teléfono">
				 </div>  
				  
				 <div class="col-md-8">  
				  	 <input type="text" class="form form-control" id="email" name="email" placeholder="Correo Electrónico">
				 </div>  
				 
				 <div class="col-md-12 col-condiciones"><input type="checkbox" id="condiciones" name="condiciones" value="1" required> He leido y acepto el aviso legal y la política de privacidad</div>
				   

				   
			   </div>
			  </div>
			  <div class="col-md-4">
				<div class="centrado">
				  <p><input type="button" class="btn btn-success" value="RECIBIR PRESUPUESTO" id="btnPresupuesto"></p>
				  <p><input disabled id="btnCitaPrevia" onclick="window.location.assign('presupuestador.php?paso=7')" type="button" class="btn btn-success" value="CITA PREVIA"></p>	
			    </div>
			  </div>
	      </div>
	  </form>
	  <hr class="marginbottom25" style="border: 3px solid black;">
	  <div class="row marginbottom25">
	     <div class="col-md-6 textLeft">
		  <input type="button" class="btn-redondeado" value="Atrás" onclick="window.location.assign('presupuestador.php?paso=5')">
		 </div>
		<div class="col-md-6 textRight"></div>  
	  </div>
	  
   <?php
	 }
	 else if (isset($_GET["paso"]) && $_GET["paso"] == 7)
	 {
   ?>
		  <div class="row">
		   <div class="col-md-12 textoIntro">
			   <h1 class="my-4">7. CITA PREVIA VERIFICADOR</h1>
			   <h2>Selecciona fecha y hora para que uno de nuestros verificadores confirmen los datos de tu reforma.</h2>
		   </div>	  
		  </div>
		  
	  	 <div class="row textoIntro">
			<div class="col-md-6">
			 <p class="texto1">Esta visita tiene un coste de 60 € que se descontarán del importe final si se lleva a cabo la reforma</p>
			
			 <p><input type="text" class="form form-control" value="Código Postal"></p>	 
			 <p>
				 <input type="button" class="btn-redondeado" value="Atrás" onclick="window.location.assign('presupuestador.php?paso=6')">
				</p>
			</div>
 
			<div class="col-md-6 textCenter">
				 
			 <iframe width="330" height="500" style="background-color: transparent;margin:0 auto;" frameborder="0" scrolling="auto" src="calendario/index.php"></iframe>

			 </div>

		 </div>
	  
   <?php
	 }
   ?> 
   
	  
	  
  </div>
  <!-- /.container -->
  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script>
	  function subidaPopup()
	  {
		  
		  $("#popupfoto").fadeIn();
		  
	  }
	  
	  $("#close").click(function() {
		  
		  $("#popupfoto").hide();
		  
	  })
	  
	  function avanza(paso,valor)
	  {
		  //Paso1 = tipo de reforma
		 //Paso2 = presupuesto ikea 
		  if (paso == 1)
		  { 
		    localStorage.setItem('centroikea', valor);
			window.location.assign('presupuestador.php?paso=2');
		  }
		  else if (paso == 2)
		  { 
		    localStorage.setItem('tiporeforma', valor);
			window.location.assign('presupuestador.php?paso=3');
		  }
		  else if (paso == 3)
		  {
			localStorage.setItem('presupuestoikea', valor);	
			window.location.assign('presupuestador.php?paso=4');  
		  } 
		  else if (paso == 4)
		  {
			 var ids="";
			 $("."+valor).each(function( ) {
				 //Recorro en busca de todos los IDS que tienen la clase SELECTED. Que son los servicios que se han seleccionado
				 ids+=this.id+",";
				 
			 });
			  
			 if (ids == "")
				alert("No has seleccionado ningún elemento de instalación");
			 else
			 {
			   localStorage.setItem('elementos_instalacion', ids);	
			   window.location.assign('presupuestador.php?paso=6');  
			 }
		}
	 }
	  
	 $(".elemento_instalacion").click(function() {
		 var id=this.id;
		 if ($("#"+id).hasClass("selected"))
		  $("#"+id).removeClass("selected");
		 else
		  $("#"+id).addClass("selected"); 
		 
	 })
	  
	 $("#btnPresupuesto").click(function() {
		
		 /*Datos del formulario */
		 var nombre=document.getElementById("nombre").value;
		 var apellidos=document.getElementById("apellidos").value;
		 var direccion=document.getElementById("direccion").value;
		 var cp=document.getElementById("cp").value;
		 var telefono=document.getElementById("telefono").value;
		 var email=document.getElementById("email").value;
		 var poblacion=document.getElementById("poblacion").value;
		 var provincia=document.getElementById("provincia").value;
		 var checkBox = document.getElementById("condiciones");
		 if (checkBox.checked == false)
			 alert("Debes aceptar el aviso legal y la política de privacidad");
		 else
		 {
			 /* LocalStorage de los datos del formulario */

			 localStorage.setItem('presupuesto_nombre_cliente', nombre);
			 localStorage.setItem('presupuesto_apellidos_cliente', apellidos);
			 localStorage.setItem('presupuesto_direccion_cliente', direccion);
			 localStorage.setItem('presupuesto_cp_cliente', cp);
			 localStorage.setItem('presupuesto_telefono_cliente', telefono);
			 localStorage.setItem('presupuesto_email_cliente', email);
			 localStorage.setItem('presupuesto_poblacion_cliente', poblacion);
			 localStorage.setItem('presupuesto_provincia_cliente', provincia);


			 /* Datos de los anteriores pasos */
			 var tiporeforma = localStorage.getItem('tiporeforma');
			 var presupuestoikea = localStorage.getItem('presupuestoikea');
			 var elementos_instalacion = localStorage.getItem('elementos_instalacion');
			 var dibujo2d = localStorage.getItem('dibujo2d');
			 var total_paredes = localStorage.getItem('total_paredes');
			 var paredes = new Array();
			 var pared_actual=0;
			 
			 //Guardo en un array el contenido de las paredes
			 for (i=0;i<total_paredes;i++)
			 {
				 pared_actual++;
				 
				 if (localStorage.getItem('pared'+pared_actual) != null)
				 {
					 
					 paredes[i]=localStorage.getItem('pared'+pared_actual);
					 
				 }
				 else
				 {
					 paredes[i]=0;
				 }
			 }
			 
			 
			 $.ajax({
				 type: "POST",
				 dataType: 'json', 
				 url: "ajax/presupuestador_enviar_presupuesto.php",
				 data: {nombre:nombre,apellidos:apellidos,direccion:direccion,cp:cp,telefono:telefono,email:email,poblacion:poblacion,provincia:provincia,tiporeforma:tiporeforma,presupuestoikea:presupuestoikea,elementos_instalacion:elementos_instalacion,dibujo2d:dibujo2d,paredes:paredes},
				 success:function(respuesta){	
					 alert(respuesta.mensaje);
					 if (respuesta.contestacion == 0)
					 {
						localStorage.setItem('id_presupuesto', respuesta.id_presupuesto);
						document.getElementById("btnCitaPrevia").disabled=false;
					 }
				 } 

			 }); 
	   }
	 })
  </script>
	
  <script type="text/javascript"> 
	$(document).ready(function(e) {
	  $("#image-form").on("submit", function() {
		$("#msg").html('<div class="alert alert-info"><i class="fa fa-spin fa-spinner"></i> Por favor, espere...</div>');
		$.ajax({
		  type: "POST",
		  dataType: 'json',	
		  url: "ajax/presupuestador_ikea.php",
		  data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
		  contentType: false, // The content type used when sending data to the server.
		  cache: false, // To unable request pages to be cached
		  processData: false, // To send DOMDocument or non processed data file it is set to false
		  success: function(data) {
			 
			if (data.respuesta == 1 || parseInt(data.respuesta) == 1) {
			  localStorage.setItem('presupuestoikea', data.fichero);
			  $("#msg").html(
				'<div class="alert alert-success"><i class="fa fa-thumbs-up"></i> Fichero subido correctamente.</div>'
			  );
				
			  setTimeout(function(){ window.location.assign('presupuestador.php?paso=4'); }, 3000);	
			  	
				
			} else {
			  $("#msg").html(
				'<div class="alert alert-info"><i class="fa fa-exclamation-triangle"></i> Extensión no permitida. Sólo <strong>GIF, JPG, PNG, JPEG, PDF</strong>.</div>'
			  );
			}
		  },
		  error: function(data) {
			$("#msg").html(
			  '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Ocurrió un error.</div>'
			);
		  }
		});
	  });
}); 
  </script>	
	
<?php
//En cada paso, detecto si está guardado el valor de la pantalla anterior, si no, lo mando atrás
 if (!isset($_GET["paso"]) || $_GET["paso"] == 1)
 {
	 //En el primer paso, vacio todo localStorage para que no me mantenga datos de antiguos formularios
?>
	<script>
		localStorage.clear();
	</script>
<?php
 }
 else if ($_GET["paso"] == 2)
 {
	 
?>
	<script>
	  if (localStorage.getItem('centroikea') == null)
	  {
		 alert("No has especificado tu centro Ikea. Por favor, vuelve al paso anterior");
	     window.location.assign("https://rehubik.com/presupuestador/presupuestador.php?paso=1");
	  }
	</script>
<?php
 }
 else if ($_GET["paso"] == 3)
 {
?>
   <script>
	  if (localStorage.getItem('tiporeforma') == null)
	  {
		 alert("No has especificado el tipo de reforma. Por favor, vuelve al paso anterior");
	     window.location.assign("https://rehubik.com/presupuestador/presupuestador.php?paso=2");
	  }
	</script>
<?php
 }
 else if ($_GET["paso"] == 4)
 {
?>
   <script>
	  if (localStorage.getItem('presupuestoikea') == null)
	  {
		 alert("No has especificado si tienes un presupuesto de ikea. Por favor, vuelve al paso anterior");
	     window.location.assign("https://rehubik.com/presupuestador/presupuestador.php?paso=3");
	  }
	</script>	
<?php	 
 }
 else if ($_GET["paso"] == 5)
 {
	 /*
?>	 
   <script>
	  if (localStorage.getItem('dibujo2d') == null)
	  {
		 alert("No has creado tu cocina en nuestro planificador. Por favor, vuelve al paso anterior");
	     window.location.assign("https://rehubik.com/presupuestador/2d/index.html");
	  }
   </script>	 
<?php	 
*/
 }
 else if ($_GET["paso"] == 6)
 {
?>	 
	<script>
	  if (localStorage.getItem('elementos_instalacion') == null)
	  {
		 alert("No has especificado los elementos de tu instalación. Por favor, vuelve al paso anterior");
	     window.location.assign("https://rehubik.com/presupuestador/presupuestador.php?paso=5");
	  }
   </script>
<?php
 }
 else if ($_GET["paso"] == 7)
 {
?>	 
	<script>
	  if (localStorage.getItem('presupuesto_nombre_cliente') == null || localStorage.getItem('presupuesto_apellidos_cliente') == null || localStorage.getItem('presupuesto_nombre_cliente') == null || localStorage.getItem('presupuesto_direccion_cliente') == null || localStorage.getItem('presupuesto_cp_cliente') == null || localStorage.getItem('presupuesto_telefono_cliente') == null || localStorage.getItem('presupuesto_email_cliente') == null || localStorage.getItem('presupuesto_poblacion_cliente') == null || localStorage.getItem('presupuesto_provincia_cliente') == null || localStorage.getItem('id_presupuesto') == null)
	  {
		 alert("No has especificado algún dato en el formulario de contacto. Por favor, vuelve al paso anterior");
	     window.location.assign("https://rehubik.com/presupuestador/presupuestador.php?paso=5");
	  }
   </script>

<?php	 
 }
?>
	
</body>

</html>
