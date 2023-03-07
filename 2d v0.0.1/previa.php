<?php
session_start();
include("conexion.php");

if (isset($_COOKIE["idplano"]))
  unset($_COOKIE["idplano"]);

if (isset($_GET["id_presupuesto"])) {
  $result_altura_pared = $mysqli->query("SELECT altura_pared FROM clientes WHERE id_presupuesto=" . $_GET["id_presupuesto"] . " AND altura_pared != 0");

  while ($arr_result_pared = $result_altura_pared->fetch_array())
    $altura_pared = $arr_result_pared["altura_pared"];
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
  <style>
    #txt_altura_techo>text {
      font-size: 24px;
    }
  </style>
</head>

<body style="background:#d6d6d6;margin:0;padding:0; ">

  <div id="observaciones_plano">
    <div id="titulo_observaciones_plano">OBSERVACIONES DE TU PROYECTO</div>
    <div id="contenido_observaciones_plano" style="padding: 5px;height: 300px;max-width: 100%;">
      Escribe tus anotaciones<br><textarea id="textarea_observaciones" class="form-control" style="resize: none; width: 100%;height: 200px;max-height: 100%;" resize="off">ESTADO ACTUAL:&#13;&#10;</textarea>
    </div>
  </div>

  <div class="modal fade" id="textToLayer" tabindex="-1" role="dialog" aria-labelledby="textToLayerLabel">

    <div class="modal-dialog" role="document">

      <div class="modal-content">

        <div class="modal-header">

          <button type="button" class="close cancelarObservacion" aria-label="Close"><span aria-hidden="true">&times;</span></button>

          <h4 class="modal-title" id="textToLayerLabel">Observaciones</h4>

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
        <div id="logo"><img src="https://rehubik.com/wp-content/uploads/2020/07/logo_blanco.png" width="95"></div>
        <h1 style="
            color: white;
            padding: 0 0 0 10px;
            text-align: initial;
            margin-bottom: 0;
            font-size: x-large;
        ">DISEÑA <br>
          TU COCINA</h1>
      </div>

      <div id="menu_planificador">
        <div class="divmenu menu-activo">
          <h2 class="titular-planificador">
            <div style="color:#95C11F;">
              PASO 1
            </div>
            DIBUJA EL ESTADO ACTUAL
            <br>
            <i class="fa fa-info-circle instructionsBtn" onclick="instrucciones('paso1')"></i>
          </h2>
          <div class="open-close-menu-btn noBefore"></div>
        </div>
        
        <img src="iconos/comenzarBTn.png" alt="Comenzar" class="startBtn" onclick="instrucciones('paso1')" />
        <div class="divmenu menu-activo" id="tabiques">
          <h5 class="subtitular-planificador">
            <div class="submenu-header"><b>PASO_1.1</b></div><b>TABIQUES, PUERTAS Y VENTANAS</b><br> <i class="fa fa-info-circle instructionsBtn" onclick="instrucciones('paso11')"></i>
          </h5>
        </div>
        <div class="divmenu" id="mobiliario">
          <h5 class="subtitular-planificador">
            <div class="submenu-header"><b>PASO_1.2</b></div><b> MOBILIARIO Y ELECTRODOMÉSTICOS </b><br><i class="fa fa-info-circle instructionsBtn" onclick="instrucciones('paso12')"></i>
          </h5>
        </div>
        <div class="divmenu" id="instalaciones">
          <h5 class="subtitular-planificador">
            <div class="submenu-header"><b>PASO_1.3</b></div><b>INSTALACIONES </b><br><i class="fa fa-info-circle instructionsBtn" onclick="instrucciones('paso13')"></i>
          </h5>
        </div>
        <div class="divmenu" id="observaciones">
          <h5 class="subtitular-planificador">
            <div class="submenu-header"><b>PASO_1.4</b></div><b> ANOTACIONES EN EL PLANO</b><br> <i class="fa fa-info-circle instructionsBtn" onclick="instrucciones('paso14')"></i>
          </h5>
        </div>
        <?php
        if (isset($_GET["id_presupuesto"]) && isset($_SESSION["login"])) {
        ?>
          <div class="nextBtn" id="btnSiguentePasoVerificador"><span>Siguiente paso</span></div>
        <?php
        } else if (!isset($_GET["id_presupuesto"])) {
        ?>
          <div class="nextBtn" id="btnSiguientePaso"><span>Siguiente paso</span></div>
        <?php
        }
        ?>
      </div>

      <div id="menu_planificador_movil">
        <!--<div class="paso_menu_movil menu-activo"><span class="numeropaso">PASO_1</span><br /> ESTADO ACTUAL</div>-->
        <div class="paso_menu_movil" id="tabiques_movil"><span class="numeropaso">PASO 1.1</span><br /> TABIQUES, PUERTAS Y VENTANAS</div>
        <div class="paso_menu_movil" id="mobiliario_movil"><span class="numeropaso">PASO 1.2</span><br /> MOBILIARIO Y ELECTRODOMÉSTICOS</div>
        <div class="paso_menu_movil" id="instalaciones_movil"><span class="numeropaso">PASO 1.3</span><br /> INSTALACIONES</div>
        <div class="paso_menu_movil" id="observaciones_movil"><span class="numeropaso">PASO 1.4</span><br /> ANOTACIONES EN EL PLANO</div>
      </div>

      <div id="panel_informacion">
        <div id="opciones_observacion" style="display:none;">
          <button class="btn greenBtn fully " id="text_mode" data-toggle="tooltip" data-placement="right" title="Nueva observación">Añadir Anotaciones</button>
          <i class="fa fa-info-circle instructionsBtn" onclick="alertify.alert('Indica las observaciones que consideres necesarias para la reforma de tu cocina y que no hayan sido definidas en los pasos anteriores.<br/><br/> Ej.1: No existe falso techo en mi cocina actual.<br/> Ej.2: Tengo una viga que atraviesa la cocina en horizontal, en ese punto. <br/><br/> Para ello, <b>haz clic en la parte del plano que quieras añadir la observación. Escríbela y pulsa en Guardar</b>')"></i>
          <!-- onclick="alertify.alert('Indica las observaciones que consideres necesarias para la reforma de tu cocina y que no hayan sido definidas en los pasos anteriores.<br/><br/> Ej.1: No existe falso techo en mi cocina actual.<br/> Ej.2: Tengo una viga que atraviesa la cocina en horizontal, en ese punto. <br/><br/> Para ello, <b>haz clic en la parte del plano que quieras añadir la observación. Escríbela y pulsa en Guardar</b>')" -->
          <div id="anotaciones_observacion">
            <div style="margin-bottom:15px;text-align:center"><strong>Observaciones Paso 1: Dibuja el estado actual</strong></div>
          </div>
        </div>
        <div id="opciones_instalaciones" style="display:none;">
          <div class="tipo_mobiliario" onclick="hideStep2Menus(this);">ELECTRICIDAD</div>
          <div class="father_list">
            <ul class="owl-carousel owl-theme" style="display: block;">
              <li><img src="electricidad/enchufe-servicio.png" class="modulo btn fully object" id="electricidad-enchufeservicio"><br />ENCHUFE DE SERVICIO</li>
              <li><img src="electricidad/toma-25A.png" class="modulo btn fully object" id="electricidad-toma25a"><br />TOMA 25A</li>
              <li><img src="electricidad/interruptor.png" class="modulo btn fully object" id="electricidad-interruptor"><br />INTERRUPTOR</li>
              <li><img src="electricidad/cuadro-general.png" class="modulo btn fully object" id="electricidad-cuadrogeneral"><br />CUADRO GENERAL</li>
              <li><img src="electricidad/lampara-pared.png" class="modulo btn fully object" id="electricidad-lamparapared"><br />LÁMPARA PARED</li>
              <li><img src="electricidad/caja-electrica.png" class="modulo btn fully object" id="electricidad-cajaelectrica"><br />CAJA ELÉCTRICA</li>
              <li><img src="electricidad/downlicht-led.png" class="modulo btn fully object" id="electricidad-downlightled"><br />DOWNLIGHT LED</li>
              <li><img src="electricidad/toma-TV.png" class="modulo btn fully object" id="electricidad-tomatelevision"><br />TOMA TELEVISIÓN</li>
              <li><img src="electricidad/halogeno-led.png" class="modulo btn fully object" id="electricidad-halogenoled"><br />HALÓGENO LED</li>
              <li><img src="electricidad/toma-datos.png" class="modulo btn fully object" id="electricidad-tomadatos"><br />TOMA DATOS</li>
              <li><img src="electricidad/lampara.png" class="modulo btn fully object" id="electricidad-lampara"><br />LÁMPARA</li>
              <li><img src="electricidad/toma-telf.png" class="modulo btn fully object" id="electricidad-tomatelefono"><br />TOMA TELÉFONO</li>
              <li><img src="electricidad/tubo-fluor.png" class="modulo btn fully object" id="electricidad-tubofluorescente"><br />TUBO FLUORESCENTE</li>
              <li><img src="electricidad/telefonillo.png" class="modulo btn fully object" id="electricidad-telefonillo"><br />TELEFONILLO</li>
              <li><img src="electricidad/punto-luz-mueble.png" class="modulo btn fully object" id="electricidad-mueble"><br />PUNTO LUZ MUEBLE</li>
            </ul>
          </div>
          <div class="tipo_mobiliario" onclick="hideStep2Menus(this);">FONTANERÍA</div>
          <div class="father_list">
            <ul class="owl-carousel owl-theme" style="display: block;">
              <li><img src="fontaneria_gas/agua-fria-aux.png" class="modulo btn fully object" id="fontaneria-aguafria"><br />TOMA AGUA FRÍA <b>AUXILIAR</b></li>
              <li><img src="fontaneria_gas/agua-fria-caliente-aux.png" class="modulo btn fully object" id="fontaneria-aguafriacaliente"><br />TOMA AGUA FRÍA Y CALIENTE <b>AUXILIAR</b></li>
              <li><img src="fontaneria_gas/contador-agua.png" class="modulo btn fully object" id="fontaneria-contadoragua"><br />CONTADOR DE AGUA</li>
              <li><img src="fontaneria_gas/llaves-corte-agua.png" class="modulo btn fully object" id="fontaneria-llaves"><br />LLAVES DE CORTE <b>ESTANCIA</b></li>
            </ul>
          </div>
          <div class="tipo_mobiliario" onclick="hideStep2Menus(this);">GAS</div>
          <div class="father_list">
            <ul class="owl-carousel owl-theme" style="display: block;">
              <li><img src="fontaneria_gas/contador-gas.png" class="modulo btn fully object" id="gas-contador"><br />CONTADOR DE GAS</b></li>
              <li><img src="fontaneria_gas/llave-corte-gas.png" class="modulo btn fully object" id="gas-llave"><br />LLAVE DE CORTE GAS</b></li>
              <li><img src="fontaneria_gas/rejilla-ventilacion-gas.png" class="modulo btn fully object" id="gas-rejilla"><br />REJILLA VENTILACIÓN GAS</b></li>
            </ul>
          </div>

          <div class="tipo_mobiliario" onclick="hideStep2Menus(this);">CLIMATIZACIÓN</div>
          <div class="father_list">
            <ul class="owl-carousel owl-theme" style="display: block;">
              <li><img src="climatizacion/radiador-agua.png" class="modulo btn fully object" id="climatizacion-radiadoragua"><br />RADIADOR AGUA</b></li>
              <li><img src="climatizacion/radiador-electrico.png" class="modulo btn fully object" id="climatizacion-radiadorelectrico"><br />RADIADOR ELÉCTRICO</b></li>
              <li><img src="climatizacion/aire-acondicionado-conductos.png" class="modulo btn fully object" id="climatizacion-aire"><br />APARATO DE AIRE ACONDICIONADO</b></li>
              <li><img src="climatizacion/rejilla-aire-conductos.png" class="modulo btn fully object" id="climatizacion-rejilla"><br />REJILLA AIRE POR CONDUCTOS</b></li>
              <li><img src="climatizacion/split-aire-acondicionado.png" class="modulo btn fully object" id="climatizacion-split"><br />SPLIT AIRE ACONDICIONADO</li>
            </ul>
          </div>

        </div>
        <div id="opciones_mobiliario" style="display:none;">
          <p style="font-size:12px">* Gire o elimine el mobiliario dando click al elemento una vez lo haya añadido al plano</p>

          <div class="object tipo_mobiliario" onclick="hideStep2Menus(this);">MÓDULOS BAJOS</div>

          <!-- class objetos -->


          <div id="modulos_bajos" class="father_list" style="display:none;">

            <div class="greenBtn" onclick="hideStep2SubMenus(this);">Profundidad 60cm</div>

            <!-- 7mar: add onclick -->
            <div class="child_list">
              <ul class="owl-carousel owl-theme" style="display: block;">
                <li><img src="modulos_bajos/60cm/lavadora.png" class="modulo btn fully object" id="lavadora_bajo"></li>
                <li><img src="modulos_bajos/60cm/secadora.png" class="modulo btn fully object" id="secadora_bajo"></li>
                <li><img src="modulos_bajos/60cm/lavavajillas.png" class="modulo btn fully object" id="lavavajillas_bajo"></li>
                <li><img src="modulos_bajos/60cm/lavavajillas-45.png" class="modulo btn fully object" id="lavavajillas_45"></li>
                <li><img src="modulos_bajos/60cm/placa-electrica-80.png" class="modulo btn fully object" id="placa-electrica80"></li>
                <li><img src="modulos_bajos/60cm/placa-electrica-60.png" class="modulo btn fully object" id="placa-electrica60"></li>
                <li><img src="modulos_bajos/60cm/placa-electrica-horno-60.png" class="modulo btn fully object" id="placa-electrica-horno60"></li>
                <li><img src="modulos_bajos/60cm/placa-electrica-40.png" class="modulo btn fully object" id="placa-electrica40"></li>
                <li><img src="modulos_bajos/60cm/placa-gas-80.png" class="modulo btn fully object" id="placa-gas80"></li>
                <li><img src="modulos_bajos/60cm/placa-gas-60.png" class="modulo btn fully object" id="placa-gas60"></li>
                <li><img src="modulos_bajos/60cm/placa-gas-horno-60.png" class="modulo btn fully object" id="placa-gas-horno"></li>
                <li><img src="modulos_bajos/60cm/placa-gas-40.png" class="modulo btn fully object" id="placa-gas40"></li>
                <li><img src="modulos_bajos/60cm/fregadero-80.png" class="modulo btn fully object" id="fregadero80"></li>
                <li><img src="modulos_bajos/60cm/fregadero-60.png" class="modulo btn fully object" id="fregadero60"></li>
                <li><img src="modulos_bajos/60cm/fregadero-40.png" class="modulo btn fully object" id="fregadero40"></li>
                <li><img src="modulos_bajos/60cm/mueble-bajo-80.png" class="modulo btn fully object" id="mueble-bajo80"></li>
                <li><img src="modulos_bajos/60cm/mueble-bajo-60.png" class="modulo btn fully object" id="mueble-bajo60"></li>
                <li><img src="modulos_bajos/60cm/mueble-bajo-40.png" class="modulo btn fully object" id="mueble-bajo40"></li>
                <li><img src="modulos_bajos/60cm/mueble-bajo-30.png" class="modulo btn fully object" id="mueble-bajo30"></li>
                <li><img src="modulos_bajos/60cm/mueble-bajo-20.png" class="modulo btn fully object" id="mueble-bajo20"></li>
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

          <div class="object tipo_mobiliario" onclick="hideStep2Menus(this);">MÓDULOS ALTOS</div>
          <!-- class objetos -->
          <div id="modulos_altos" class="father_list">
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

          <div class="object tipo_mobiliario" onclick="hideStep2Menus(this);">TORRES</div>

          <!-- class objetos -->
          <div id="torres" class="father_list" style="display:none;">

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
        <div id="informacion_pared" style="display: none;">
          <div id="opciones_crear_plano">
            <div id="panel">
              <button class="btn greenBtn" id="line_mode" data-toggle="tooltip" data-placement="right" title="Comenzar a dibujar"><i class="fa fa-arrow-right" style="" aria-hidden="true"></i> COMENZAR PLANO</button>
              <span id="redo" style="display:none;"></span>
              <span id="undo" style="display:none"></span>
              <span id="sizePolice"></span>
            </div>
            <!-- aquí iba el div de informacion_panel -->
          </div>
          <button class="btn greenBtn fully " id="door_mode" onclick="$('.sub').hide();$('#door_list').toggle(200);$('#window_list').hide();">Puertas</button>
          <div id="door_list" class="owl-carousel owl-theme owl-loaded owl-drag" style="display:none;background:#fff;padding:10px;">
            <!-- 7mar: tart codigo puertas -->
            <?php
              $dir_path = "puertas";
              $extensions_array = array('jpg', 'png', 'jpeg');
              //$id_array = array('aperture','double','left-door','left-sliding-door','pocket','right-door','right-door','right-sliding-door');
              $id_array = array('aperture','pasaplatos','right-door','left-door','double','left-sliding-door','right-sliding-door','right-sliding-door','right-sliding-door');

              function Quitar_Espacios($Frase, $extensions)
              {
                $Frase_Bien = preg_replace(array('/\s{2,}/', '/[-]/'), ' ', preg_replace(array('/\s{2,}/', '/.'.$extensions.'/'), '', $Frase));
                echo $Frase_Bien;
              }

              if (is_dir($dir_path)) {
                $files = scandir($dir_path);

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
                <img src="<?php if (in_array($extension, $extensions_array)) { echo $dir_path.'/'.$files[$i]; } ?>" style="width:83px">
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
                <img src="./puertas/apertura-hueco.png" style="width:83px">
              </button>
              <p>Apertura hueco</p>
            </div>

            <div class="invertedBtn">
              <button class="btn fully door" id="double">
                <img src="puertas/puerta-abatible-doble.png" style="width:83px">
              </button>
              <p>Puerta abatible doble</p>
            </div>

            <div class="invertedBtn">
              <button class="btn fully door" id="pocket">
                <img src="./puertas/puerta-abatible-apertura-derecha.png" style="width:83px">
              </button>
              <p> Puerta corredera guía <br /> exterior apertura izquierda</p>
            </div>

            <div class="invertedBtn">
              <button class="btn fully door" id="left-door">
                <img src="./puertas/puerta-abatible-apertura-izquierda.png" style="width:83px">
              </button>
              <p> Puerta abatible<br> apertura izquierda</p>
            </div>

            <div class="invertedBtn">
              <button class="btn fully door" id="right-door">
                <img src="./puertas/puerta-corredera-guia-exterior-apertura-derecha.png" style="width:83px">
              </button>
              <p> Puerta abatible<br> apertura derecha</p>
            </div>

            <div class="invertedBtn">
              <button class="btn fully door" id="right-door">
                <img src="./puertas/puerta-corredera-guia-exterior-apertura-derecha.png" style="width:83px">
              </button>
              <p> Puerta abatible<br> apertura derecha</p>
            </div>

            <div class="invertedBtn">
              <button class="btn fully door" id="right-sliding-door">
                <img src="./puertas/puerta-corredera-encastrada-apertura-derechaa.png" style="width:83px">
              </button>
              <p> Puerta corredera encastrada apertura derecha</p>
            </div>

            <div class="invertedBtn">
              <button class="btn fully door" id="left-sliding-door">
                <img src="./puertas/puerta-corredera-encastrada-apertura-izquierda.png" style="width:83px">
              </button>
              <p> Puerta corredera encastrada apertura izquierda</p>
            </div> -->
          </div>
          <button class="btn greenBtn fully " id="window_mode" onclick="$('.sub').hide();$('#window_list').toggle(200);$('#door_list').hide()">Ventanas</button>
          <!-- zra9: bdlt class="list-unstyled sub" o drt class="owl-carousel owl-theme owl-loaded owl-drag" bach tbdl skrol -->
          <div id="window_list" class="owl-carousel owl-theme owl-loaded owl-drag" style="display:none;background:#fff; padding:10px;">
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
          </div>
          <label>Altura techo:</label>
          <input type="range" value="2" min="2" max="5" step="0.01" oninput="this.nextElementSibling.value = this.value" id="altura_techo_actual">
          <output style="display:inline-block; color:#95C11F; font-size: 1em">2</output>
          <span>M</span>
          <button class="btn invertedBtn" style="width:100%" id="select_mode"> Seleccionar Muros</button>
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
          </div>
        </div>
      </div>
    </div>
    </div>

  <?php
  } else {

  ?>
    <div id="parte_superior"></div>
  <?php
  }
  ?>


  <svg id="lin" viewBox="0 0 1100 700" preserveAspectRatio="xMidYMin slice" xmlns="http://www.w3.org/2000/svg" style="z-index:2;margin:0;padding:0;width:100vw;height:100vh;position:absolute;top:0;left:0;right:0;bottom:0">

    <defs>
      <linearGradient id="gradientRed" x1="0%" y1="0%" x2="100%" y2="100%" spreadMethod="pad">
        <stop offset="0%" stop-color="#e65d5e" stop-opacity="1" />
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
        <stop offset="100%" stop-color="#365987" stop-opacity="1" />
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
  </div>

  <div id="wallTools" class="leftBox">
    <h2 id="titleWallTools">Modifica la pared</h2>
    <hr />
    <section id="rangeThick">
      <p>Editando: <span id="wallWidthScale"></span> <span id="wallWidthVal"></span></span></p>
      <input type="text" id="wallWidth" />
    </section>
    <ul class="list-unstyled">
      <br />
      <li><button class="btn btn-danger halfy" id="wallTrash"><i class="fa fa-2x fa-trash-o" aria-hidden="true"></i></button>
        <button class="btn btn-info halfy pull-right" onclick="fonc_button('select_mode');$('#boxinfo').html('Modo selección');$('#wallTools').hide('300');$('#panel').show('300');"><i class="fa fa-2x fa-backward" aria-hidden="true"></i></button>
      </li>
    </ul>
  </div>

  <!-- divs vacios -->
  <div style="display:none" id="objBoundingBox" class="leftBox">


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
      <li style="display:none;"><button class="btn greenBtn fully" id="objToolsHinge">REVERTIR</button></li>

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
  <div id="zoomBox">
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
<script src="html2canvas.js"></script>
<script src="FileSaver.js"></script>
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
  ! function(a) {
    function f(a, b) {
      if (!(a.originalEvent.touches.length > 1)) {
        a.preventDefault();
        var c = a.originalEvent.changedTouches[0],
          d = document.createEvent("MouseEvents");
        d.initMouseEvent(b, !0, !0, window, 1, c.screenX, c.screenY, c.clientX, c.clientY, !1, !1, !1, !1, 0, null), a.target.dispatchEvent(d)
      }
    }
    if (a.support.touch = "ontouchend" in document, a.support.touch) {
      var e, b = a.ui.mouse.prototype,
        c = b._mouseInit,
        d = b._mouseDestroy;
      b._touchStart = function(a) {
        var b = this;
        !e && b._mouseCapture(a.originalEvent.changedTouches[0]) && (e = !0, b._touchMoved = !1, f(a, "mouseover"), f(a, "mousemove"), f(a, "mousedown"))
      }, b._touchMove = function(a) {
        e && (this._touchMoved = !0, f(a, "mousemove"))
      }, b._touchEnd = function(a) {
        e && (f(a, "mouseup"), f(a, "mouseout"), this._touchMoved || f(a, "click"), e = !1)
      }, b._mouseInit = function() {
        var b = this;
        b.element.bind({
          touchstart: a.proxy(b, "_touchStart"),
          touchmove: a.proxy(b, "_touchMove"),
          touchend: a.proxy(b, "_touchEnd")
        }), c.call(b)
      }, b._mouseDestroy = function() {
        var b = this;
        b.element.unbind({
          touchstart: a.proxy(b, "_touchStart"),
          touchmove: a.proxy(b, "_touchMove"),
          touchend: a.proxy(b, "_touchEnd")
        }), d.call(b)
      }
    }
  }(jQuery);
</script>
<script src="bootstrap.min.js"></script>
<script src="mousewheel.js"></script>
<script src="decimal.min.js"></script>
<script src="func.js"></script>
<script src="qSVG.js"></script>
<script src="editor.js"></script>
<script src="engine.js"></script>
<script src="js/OwlCarousel/dist/owl.carousel.min.js"></script>
<!-- alertify -->
<script>
  ! function(t, k) {
    "use strict";
    var e, E = t.document;
    e = function() {
      var m, s, a, o, r, n = {},
        l = {},
        c = !1,
        v = 27,
        g = 32,
        f = [];
      return l = E.location.href.includes("mis_datos.php") ? {
        buttons: {
          holder: '<nav class="alertify-buttons">{{buttons}}</nav>',
          submit: '<button type="submit" class="alertify-button alertify-button-ok" id="alertify-ok" />{{ok}}</button>',
          ok: '<a href="#" class="alertify-button alertify-button-ok" id="alertify-ok">{{ok}}</a>',
          cancel: '<a href="#" class="alertify-button alertify-button-cancel" id="alertify-cancel">{{cancel}}</a>'
        },
        input: '<input type="password" class="alertify-text" id="alertify-text">',
        message: '<p class="alertify-message">{{message}}</p>',
        log: '<article class="alertify-log{{class}}">{{message}}</article>'
      } : {
        buttons: {
          holder: '<nav class="alertify-buttons">{{buttons}}</nav>',
          submit: '<button type="submit" class="alertify-button alertify-button-ok" id="alertify-ok" />{{ok}}</button>',
          ok: '<a href="#" class="alertify-button alertify-button-ok" id="alertify-ok">{{ok}}</a>',
          cancel: '<a href="#" class="alertify-button alertify-button-cancel" id="alertify-cancel">{{cancel}}</a>'
        },
        input: '<input type="text" class="alertify-text" id="alertify-text">',
        message: '<p class="alertify-message">{{message}}</p>',
        log: '<article class="alertify-log{{class}}">{{message}}</article>'
      }, m = function(t) {
        return E.getElementById(t)
      }, {
        alert: function(t, e) {
          return n.dialog(t, "alert", e), this
        },
        confirm: function(t, e) {
          return n.dialog(t, "confirm", e), this
        },
        extend: (n = {
          labels: {
            ok: "Aceptar",
            cancel: "Cancelar"
          },
          delay: 8e3,
          addListeners: function(e) {
            var i, n, a, s, o, r = m("alertify-resetFocus"),
              l = m("alertify-ok") || k,
              c = m("alertify-cancel") || k,
              f = m("alertify-text") || k,
              u = m("alertify-form") || k,
              d = void 0 !== l,
              y = void 0 !== c,
              b = void 0 !== f,
              p = "",
              h = this;
            i = function(t) {
              void 0 !== t.preventDefault && t.preventDefault(), a(t), void 0 !== f && (p = f.value), "function" == typeof e && e(!0, p)
            }, n = function(t) {
              void 0 !== t.preventDefault && t.preventDefault(), a(t), "function" == typeof e && e(!1)
            }, a = function(t) {
              h.hide(), h.unbind(E.body, "keyup", s), h.unbind(r, "focus", o), b && h.unbind(u, "submit", i), d && h.unbind(l, "click", i), y && h.unbind(c, "click", n)
            }, s = function(t) {
              var e = t.keyCode;
              e !== g || b || i(t), e === v && y && n(t)
            }, o = function(t) {
              b ? f.focus() : y ? c.focus() : l.focus()
            }, this.bind(r, "focus", o), d && this.bind(l, "click", i), y && this.bind(c, "click", n), this.bind(E.body, "keyup", s), b && this.bind(u, "submit", i), t.setTimeout(function() {
              f ? (f.focus(), f.select()) : l.focus()
            }, 50)
          },
          bind: function(t, e, i) {
            "function" == typeof t.addEventListener ? t.addEventListener(e, i, !1) : t.attachEvent && t.attachEvent("on" + e, i)
          },
          build: function(t) {
            var e = "",
              i = t.type,
              n = t.message;
            switch (e += '<div class="alertify-dialog">', "prompt" === i && (e += '<form id="alertify-form">'), e += '<article class="alertify-inner">', e += l.message.replace("{{message}}", n), "prompt" === i && (e += l.input), e += l.buttons.holder, e += "</article>", "prompt" === i && (e += "</form>"), e += '<a id="alertify-resetFocus" class="alertify-resetFocus" href="#">Reset Focus</a>', e += "</div>", i) {
              case "confirm":
                e = (e = e.replace("{{buttons}}", l.buttons.ok + l.buttons.cancel)).replace("{{ok}}", this.labels.ok).replace("{{cancel}}", this.labels.cancel);
                break;
              case "prompt":
                e = (e = e.replace("{{buttons}}", l.buttons.submit + l.buttons.cancel)).replace("{{ok}}", this.labels.ok).replace("{{cancel}}", this.labels.cancel);
                break;
              case "alert":
                e = (e = e.replace("{{buttons}}", l.buttons.ok)).replace("{{ok}}", this.labels.ok)
            }
            return o.className = "alertify alertify-show alertify-" + i, a.className = "alertify-cover", e
          },
          close: function(t, e) {
            var i = e && !isNaN(e) ? +e : this.delay;
            this.bind(t, "click", function() {
              r.removeChild(t)
            }), setTimeout(function() {
              void 0 !== t && t.parentNode === r && r.removeChild(t)
            }, i)
          },
          dialog: function(t, e, i, n) {
            s = E.activeElement;
            var a = function() {
              o && null !== o.scrollTop || a()
            };
            if ("string" != typeof t) throw new Error("message must be a string");
            if ("string" != typeof e) throw new Error("type must be a string");
            if (void 0 !== i && "function" != typeof i) throw new Error("fn must be a function");
            return "function" == typeof this.init && (this.init(), a()), f.push({
              type: e,
              message: t,
              callback: i,
              placeholder: n
            }), c || this.setup(), this
          },
          extend: function(i) {
            return function(t, e) {
              this.log(t, i, e)
            }
          },
          hide: function() {
            f.splice(0, 1), 0 < f.length ? this.setup() : (c = !1, o.className = "alertify alertify-hide alertify-hidden", a.className = "alertify-cover alertify-hidden", s.focus())
          },
          init: function() {
            E.createElement("nav"), E.createElement("article"), E.createElement("section"), (a = E.createElement("div")).setAttribute("id", "alertify-cover"), a.className = "alertify-cover alertify-hidden", E.body.appendChild(a), (o = E.createElement("section")).setAttribute("id", "alertify"), o.className = "alertify alertify-hidden", E.body.appendChild(o), (r = E.createElement("section")).setAttribute("id", "alertify-logs"), r.className = "alertify-logs", E.body.appendChild(r), E.body.setAttribute("tabindex", "0"), delete this.init
          },
          log: function(t, e, i) {
            var n = function() {
              r && null !== r.scrollTop || n()
            };
            return "function" == typeof this.init && (this.init(), n()), this.notify(t, e, i), this
          },
          notify: function(t, e, i) {
            var n = E.createElement("article");
            n.className = "alertify-log" + ("string" == typeof e && "" !== e ? " alertify-log-" + e : ""), n.innerHTML = t, r.insertBefore(n, r.firstChild), setTimeout(function() {
              n.className = n.className + " alertify-log-show"
            }, 50), this.close(n, i)
          },
          set: function(t) {
            var e;
            if ("object" != typeof t && t instanceof Array) throw new Error("args must be an object");
            for (e in t) t.hasOwnProperty(e) && (this[e] = t[e])
          },
          setup: function() {
            var t = f[0];
            c = !0, o.innerHTML = this.build(t), "string" == typeof t.placeholder && (m("alertify-text").value = t.placeholder), this.addListeners(t.callback)
          },
          unbind: function(t, e, i) {
            "function" == typeof t.removeEventListener ? t.removeEventListener(e, i, !1) : t.detachEvent && t.detachEvent("on" + e, i)
          }
        }).extend,
        init: n.init,
        log: function(t, e, i) {
          return n.log(t, e, i), this
        },
        prompt: function(t, e, i) {
          return n.dialog(t, "prompt", e, i), this
        },
        success: function(t, e) {
          return n.log(t, "success", e), this
        },
        error: function(t, e) {
          return n.log(t, "error", e), this
        },
        set: function(t) {
          n.set(t)
        },
        labels: n.labels
      }
    }, "function" == typeof define ? define([], function() {
      return new e
    }) : void 0 === t.alertify && (t.alertify = new e)
  }(this);
</script>

<script>
  function instrucciones(paso) {

    if (paso == "paso1") {
      alertify.alert("<p>Dibuja la tabiquería del estado actual de tu cocina, con la ubicación de las puertas y ventanas de la misma. A continuación define el mobiliario actual de la estancia. Para preparar tu oferta, nos ayudará conocer el tipo y ubicación de tus instalaciones actuales. Si consideras necesario añadir alguna observación aprovecha el último punto para ello.Si necesitas más información en cada punto podrás encontrar una explicación del mismo.</p>");
    } else if (paso == "paso11") {
      alertify.alert("<p><b>Dibuja la tabiquería del estado actual de tu cocina</b>, con la ubicación de las puertas y ventanas de la misma.También podrás seleccionar entre los distintos tipos de apertura de ventanas y puertas. Haz doble clic en cada una de ellas para definir sus dimensiones.<br/><br/>Recuerda definir la altura actual de suelo a techo de tu cocina. Si en tu cocina hay dos alturas diferentes, una viga o un falseado a una altura inferior, en este paso indica únicamente la altura mayor de suelo a techo y en el último paso “1.4 Indica observaciones” podrás añadir un cuadro de texto indicando la situación en concreto así como las diferentes alturas. Ej.Tengo una viga que atraviesa la cocina en horizontal, en ese punto la altura de suelo a techo es de 2.22m.</p>");
    } else if (paso == "paso12") {
      alertify.alert("<p>Define la distribución de mobiliario y electrodomésticos actual de tú cocina.</p>");
    } else if (paso == "paso13") {
      alertify.alert("<p>Para preparar tu oferta, nos ayudará conocer el tipo y ubicación de tus instalaciones actuales. Para ello selecciona entre las diferentes simbologías y arrástralas hasta dejarlas ubicada en el plano. No será necesario que definas las instalaciones de tus electrodomésticos puesto que ya han quedado definidas en el paso anterior.</p>");
    } else if (paso == "paso14") {
      alertify.alert("<p>Indica las observaciones que consideres necesarias para la reforma de tu cocina y que no hayan sido definidas en los pasos anteriores.</p><p>Ej.1: No existe falso techo en mi cocina actual.<br/> Ej.2 Tengo una viga que atraviesa la cocina en horizontal, en ese punto</p>");
    }


  }
</script>

<script>
  $(document).ready(function() {

    $("#titulo_observaciones_plano").click(function() {
      if ($("#contenido_observaciones_plano").is(":visible"))
        $("#contenido_observaciones_plano").hide();
      else
        $("#contenido_observaciones_plano").show();
    })

    //Ajusto zoom
    for (var i = 0; i < 3; i++) {
      $("button[data-zoom='zoomin']").trigger("click");
    }


    $('#altura_techo_actual').on('focusin', function() {
      console.log("Saving value " + $(this).val());
      $(this).data('val', $(this).val()); //Me quedo con el valor antiguo
    });

    //Escribo la altura del techo en el plano
    $("#altura_techo_actual").change(function() {


      //var prev = $(this).data('val');
      //alert(prev);

      /*$( "text" ).each(function() {
          console.log($(this).text());

          if ($(this).text() == "H:"+prev)
              $(this).parent().remove();
        }); */

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

      //document.getElementById("boxText").innerHTML+='<g transform="translate(850,200) rotate(0,0,0) scale(1, 1)" id="txt_altura_techo"><text x="0" y="0" font-size="15px" stroke="rgb(51, 51, 51)" stroke-width="0px" font-family="roboto" text-anchor="middle" fill="rgb(51, 51, 51)">H: '+this.value+'m</text></g>'; 
      //$("#boxText").html('<g transform="translate(1339.75,229.41666666666666) rotate(0,0,0) scale(1, 1)" id="txt_altura_techo"><text x="0" y="0" font-size="15px" stroke="rgb(51, 51, 51)" stroke-width="0px" font-family="roboto" text-anchor="middle" fill="rgb(51, 51, 51)">H: '+this.value+'m</text></g>');


    });

    $("#tabiques").click(function() {
      if ($(this).hasClass("paso_menu_movil menu-activo")) {
        $(this).removeClass("menu-activo");
        $("#opciones_crear_plano").hide();
        $("#informacion_pared").hide();
        console.log("remove");
      } else {
        $(this).addClass("menu-activo");
        $("#opciones_crear_plano").show();
        $("#informacion_pared").show();
        console.log("add");
      }
      $("#opciones_observacion").hide();
      $("#opciones_instalaciones").hide();
      $("#opciones_mobiliario").hide();
      $(".divmenu").removeClass("menu-activo");
      $("#tabiques_movil").removeClass("menu-activo");
      $("#mobiliario").removeClass("menu-activo");
      $("#mobiliario_movil").removeClass("menu-activo");
      $("#instalaciones").removeClass("menu-activo");
      $("#instalaciones_movil").removeClass("menu-activo");
      $("#observaciones").removeClass("menu-activo");
      $("#observaciones_movil").removeClass("menu-activo");
    })

    $("#tabiques_movil").click(function() {
      if ($(this).hasClass("paso_menu_movil menu-activo")) {
        $(this).removeClass("menu-activo");
        $("#opciones_crear_plano").hide();
        $("#informacion_pared").hide();
        console.log("remove");
      } else {
        $(this).addClass("menu-activo");
        $("#opciones_crear_plano").show();
        $("#informacion_pared").show();
        console.log("add");
      }
      $("#opciones_mobiliario").hide();
      $("#opciones_instalaciones").hide();
      $("#opciones_observacion").hide();
      $(".divmenu").removeClass("menu-activo");
      $(".divmenu").removeClass("menu-activo");
      $("#tabiques").removeClass("menu-activo");
      $("#mobiliario").removeClass("menu-activo");
      $("#mobiliario_movil").removeClass("menu-activo");
      $("#instalaciones").removeClass("menu-activo");
      $("#instalaciones_movil").removeClass("menu-activo");
      $("#observaciones").removeClass("menu-activo");
      $("#observaciones_movil").removeClass("menu-activo");
    })

    $("#mobiliario").click(function() {
      if ($(this).hasClass("paso_menu_movil menu-activo")) {
        $(this).removeClass("menu-activo");
        $("#opciones_mobiliario").hide();
        console.log("remove");
      } else {
        $(this).addClass("menu-activo");
        $("#opciones_mobiliario").show();
        console.log("add");
      }
      $("#opciones_crear_plano").hide();
      $("#informacion_pared").hide();
      $("#opciones_instalaciones").hide();
      $("#opciones_observacion").hide();
      $(".divmenu").removeClass("menu-activo");
      $(".divmenu").removeClass("menu-activo");
      $("#tabiques").removeClass("menu-activo");
      $("#tabiques_movil").removeClass("menu-activo");
      $("#mobiliario_movil").removeClass("menu-activo");
      $("#instalaciones").removeClass("menu-activo");
      $("#instalaciones_movil").removeClass("menu-activo");
      $("#observaciones").removeClass("menu-activo");
      $("#observaciones_movil").removeClass("menu-activo");
    })

    $("#mobiliario_movil").click(function() {
      if ($(this).hasClass("paso_menu_movil menu-activo")) {
        $(this).removeClass("menu-activo");
        $("#opciones_mobiliario").hide();
        console.log("remove");
      } else {
        $(this).addClass("menu-activo");
        $("#opciones_mobiliario").show();
        console.log("add");
      }
      $("#opciones_crear_plano").hide();
      $("#informacion_pared").hide();
      $("#opciones_instalaciones").hide();
      $("#opciones_observacion").hide();
      $(".divmenu").removeClass("menu-activo");
      $(".divmenu").removeClass("menu-activo");
      $("#tabiques").removeClass("menu-activo");
      $("#tabiques_movil").removeClass("menu-activo");
      $("#mobiliario").removeClass("menu-activo");
      $("#instalaciones").removeClass("menu-activo");
      $("#instalaciones_movil").removeClass("menu-activo");
      $("#observaciones").removeClass("menu-activo");
      $("#observaciones_movil").removeClass("menu-activo");
    })

    $("#instalaciones").click(function() {
      if ($(this).hasClass("paso_menu_movil menu-activo")) {
        $(this).removeClass("menu-activo");
        $("#opciones_instalaciones").hide();
        console.log("remove");
      } else {
        $(this).addClass("menu-activo");
        $("#opciones_instalaciones").show();
        console.log("add");
      }
      $("#opciones_crear_plano").hide();
      $("#informacion_pared").hide();
      $("#opciones_observacion").hide();
      $("#opciones_mobiliario").hide();
      $(".divmenu").removeClass("menu-activo");
      $(".divmenu").removeClass("menu-activo");
      $("#tabiques").removeClass("menu-activo");
      $("#tabiques_movil").removeClass("menu-activo");
      $("#mobiliario").removeClass("menu-activo");
      $("#mobiliario_movil").removeClass("menu-activo");
      $("#instalaciones_movil").removeClass("menu-activo");
      $("#observaciones").removeClass("menu-activo");
      $("#observaciones_movil").removeClass("menu-activo");
    })

    $("#instalaciones_movil").click(function() {
      if ($(this).hasClass("paso_menu_movil menu-activo")) {
        $(this).removeClass("menu-activo");
        $("#opciones_instalaciones").hide();
        console.log("remove");
      } else {
        $(this).addClass("menu-activo");
        $("#opciones_instalaciones").show();
        console.log("add");
      }
      $("#opciones_crear_plano").hide();
      $("#informacion_pared").hide();
      $("#opciones_observacion").hide();
      $("#opciones_mobiliario").hide();
      $(".divmenu").removeClass("menu-activo");
      $(".divmenu").removeClass("menu-activo");
      $("#tabiques").removeClass("menu-activo");
      $("#tabiques_movil").removeClass("menu-activo");
      $("#mobiliario").removeClass("menu-activo");
      $("#mobiliario_movil").removeClass("menu-activo");
      $("#instalaciones").removeClass("menu-activo");
      $("#observaciones").removeClass("menu-activo");
      $("#observaciones_movil").removeClass("menu-activo");
    })

    $("#observaciones").click(function() {
      if ($(this).hasClass("paso_menu_movil menu-activo")) {
        $(this).removeClass("menu-activo");
        $("#opciones_observacion").hide();
        console.log("remove");
      } else {
        $(this).addClass("menu-activo");
        $("#opciones_observacion").show();
        console.log("add");
      }
      $("#opciones_crear_plano").hide();
      $("#informacion_pared").hide();
      $("#opciones_instalaciones").hide();
      $("#opciones_mobiliario").hide();
      $(".divmenu").removeClass("menu-activo");
      $(".divmenu").removeClass("menu-activo");
      $("#tabiques").removeClass("menu-activo");
      $("#tabiques_movil").removeClass("menu-activo");
      $("#mobiliario").removeClass("menu-activo");
      $("#mobiliario_movil").removeClass("menu-activo");
      $("#instalaciones").removeClass("menu-activo");
      $("#instalaciones_movil").removeClass("menu-activo");
      $("#observaciones_movil").removeClass("menu-activo");
    })

    $("#observaciones_movil").click(function() {
      if ($(this).hasClass("paso_menu_movil menu-activo")) {
        $(this).removeClass("menu-activo");
        $("#opciones_observacion").hide();
        console.log("remove");
      } else {
        $(this).addClass("menu-activo");
        $("#opciones_observacion").show();
        console.log("add");
      }
      $("#opciones_crear_plano").hide();
      $("#informacion_pared").hide();
      $("#opciones_instalaciones").hide();
      $("#opciones_mobiliario").hide();
      $(".divmenu").removeClass("menu-activo");
      $(".divmenu").removeClass("menu-activo");
      $("#tabiques").removeClass("menu-activo");
      $("#tabiques_movil").removeClass("menu-activo");
      $("#mobiliario").removeClass("menu-activo");
      $("#mobiliario_movil").removeClass("menu-activo");
      $("#instalaciones").removeClass("menu-activo");
      $("#instalaciones_movil").removeClass("menu-activo");
      $("#observaciones").removeClass("menu-activo");
    })

    if ($(window).width() < 1099) {
      $('.owl-carousel').owlCarousel({
        loop: false,
        margin: 50,
        responsiveClass: true,
        responsive: {
          0: {
            items: 2
          },
          600: {
            items: 3
          },
          1000: {
            items: 3
          },
          1099: {
            items: 2
          }
        }
      })
    }

    $("#btnSiguientePaso").click(function() {



      $("#btnSiguientePaso").attr("style", "pointer-events: none;");
      $("#btnSiguientePaso > span").html("Guardando...")
      save();

      if (localStorage.getItem('history') == null) {
        alertify.alert("Debes dibujar el estado actual de tu cocina antes de continuar");
        setTimeout(function() {
          $("#btnSiguientePaso").attr("style", "pointer-events: unset;");
          $("#btnSiguientePaso > span").html("Siguiente paso")
        }, 2000);
      } else {
        var dibujo = localStorage.getItem('history');
        var observaciones_texto = $("#textarea_observaciones").val()
        var altura_techo = $("#altura_techo_actual").val();

        //alert(observaciones_texto);
        $("#observaciones_plano").remove(); //Elimino el div de las observaciones para que no salga en el pantallazo
        $("#parte_superior").attr("style", "display:none");
        $("#moveBox").attr("style", "display:none");
        $("#zoomBox").attr("style", "display:none");

        jQuery("#boxRib > text").each(function() {
          jQuery(this).attr("font-size", "0.80em");
        })

        html2canvas($("html")[0]).then((canvas) => {

          console.log("done ... ");
          var photo = canvas.toDataURL('image/jpeg');
          $.ajax({
            method: 'POST',
            dataType: 'json',
            url: 'photo_upload.php',
            data: {
              photo: photo
            },
            success: function(mensaje) {
              //alert(mensaje.id);
              localStorage.setItem('estado_actual', mensaje.id);

              $.ajax({
                type: "POST",
                dataType: 'json',
                async: false,
                url: "ajax/guardar_estado_actual.php",
                data: {
                  id: mensaje.id,
                  dibujo: dibujo,
                  observaciones_texto: observaciones_texto,
                  altura_techo: altura_techo
                },
                success: function(respuesta) {
                  window.location.assign("https://rehubik.com/presupuestador/2d v0.0.1/index.php");
                  console.log("Guardado");
                }
              });


            }

          });

        });



      }

    })

    $("#btnSiguientePasoVerificador").click(function() {
      var id = "";
      var entro = false;
      var formularios = [];
      var contador = 0;
      var altura_paredes = document.getElementById("altura_paredes").value;

      if (altura_paredes != "") {
        $(".elemento_instalacion.selected").each(function() {
          entro = true;

          //Por cada elemento seleccionado, detecto si es muro o unidades y lo añado a la cookie
          var formulario = $("form[name='" + this.id + "']").serialize();
          var id = this.id;
          console.log(formulario);
          //alert(formulario);
          $.ajax({
            type: "POST",
            dataType: 'json',
            async: false,
            url: "ajax/finalizar_plano_verificador.php?altura_paredes=" + altura_paredes + "&id_presupuesto=<?php echo $_GET['id_presupuesto']; ?>",
            data: formulario,
            success: function(respuesta) {
              alertify.success(respuesta.mensaje);

            }

          });
          contador++;

        })

        if (!entro)
          alertify.error("Debes seleccionar, al menos, un elemento de instalaciones y equipamiento para finalizar el plano")
        else {
          save();
          var numero_muros = $(".muro").length;
          var contenido = HISTORY[0]; //El último muro es el que tiene la info de todo el dibujo
          console.log("OJO, el CONTENIDO ES " + contenido);
          var elementos_dibujados = $("#boxEnergy").html();
          $.ajax({
            type: "POST",
            dataType: 'json',
            async: false,
            url: "ajax/guardar_dibujo2d_verificador.php?id_presupuesto=<?php echo $_GET['id_presupuesto']; ?>",
            data: {
              contenido: contenido,
              elementos_dibujados: elementos_dibujados
            },
            success: function(respuesta) {

            }

          });



          //window.location.assign("https://rehubik.com/presupuestador/2d/registro_cliente.php"); 
        }

      } else {
        alertify.error("Debes especificar la altura de las paredes en el PASO 1");
      }

    })

  })
</script>

<?php
if (isset($_GET["id_presupuesto"])) {
?>
  <script>
    //Recupero el mapa de un usuario
    if (localStorage.getItem('history')) localStorage.removeItem('history');

    var id_presupuesto = <?php echo $_GET["id_presupuesto"]; ?>;
    $.ajax({
      type: "POST",
      dataType: 'json',
      async: false,
      url: "ajax/sacar_dibujo2d.php",
      data: {
        id_presupuesto: id_presupuesto
      },
      success: function(mensaje) {
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
<script>
  $(function() {
    $("#btnSave").click(function() {
      $("#parte_superior").attr("style", "display:none");
      html2canvas($("html")[0]).then((canvas) => {
        console.log("done ... ");
        //$("#img-out").append(canvas);


        canvas.toBlob(function(blob) {
          saveAs(blob, "Dashboard.png");
        });

        var photo = canvas.toDataURL('image/jpeg');
        $.ajax({
          method: 'POST',
          url: 'photo_upload.php',
          data: {
            photo: photo
          }
        });

      });

    });
  });

  function hideStep2SubMenus(caller) {
    var visibility = $(caller).next(".child_list").is(":visible");
    $(caller).parent().children(".child_list").hide();

    if (visibility) {
      console.log("in");
      $(caller).next(".child_list").hide();
    } else {
      console.log("out");
      $(caller).next(".child_list").show();
    }

  }

  function hideStep2Menus(caller) {
    var visibility = $(caller).next(".father_list").is(":visible");
    $(caller).parent().children(".father_list").hide();

    if (visibility) {
      console.log("in");
      $(caller).next(".father_list").hide();
    } else {
      console.log("out");
      $(caller).next(".father_list").show();
    }

  }
</script>

</html>