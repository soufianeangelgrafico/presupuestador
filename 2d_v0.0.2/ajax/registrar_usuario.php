<?php
require_once '../../../httpdocs/dompdf-master/lib/html5lib/Parser.php';
require_once '../../../httpdocs/dompdf-master/src/Autoloader.php';
Dompdf\Autoloader::register();

use Dompdf\Dompdf;

//require($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
require('/var/www/vhosts/rehubik.com/httpdocs/wp-load.php');
include("../conexion.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$idplano = $_COOKIE["idplano"];

$result_datos_plano_pdf = $mysqli->query("SELECT * FROM planos WHERE id=$idplano");
$obj_datos_plano = $result_datos_plano_pdf->fetch_object();

$respuesta = new stdClass();
$nuevo_usuario = false;
$respuesta->registrado = 0;
//Datos del formulario
$nombre = $mysqli->real_escape_string(trim(htmlentities($_POST["nombre"], ENT_QUOTES)));
$apellidos = $mysqli->real_escape_string(trim(htmlentities($_POST["apellidos"], ENT_QUOTES)));
$direccion = $mysqli->real_escape_string(trim(htmlentities($_POST["direccion"], ENT_QUOTES)));
$cp = (int)$_POST["cp"];
$telefono = (int)$_POST["telefono"];
$email = $mysqli->real_escape_string(trim(htmlentities($_POST["email"], ENT_QUOTES)));
$error = false;

$cliente["cfdb7_status"] = "unread"; //Estado del formulario no leido por defecto
$cliente["your-name"] = $nombre;
$cliente["apellidos"] = $apellidos;
$cliente["direccion"] = $direccion;
$cliente["cp"] = $cp;
$cliente["telefono"] = $telefono;
$cliente["your-email"] = $email;
$cliente["centro_ikea"] = "Ikea Badalona";
$cliente["tipo_reforma"] = "Reforma de cocina";
$cliente["acceptance-814"] = 1;
$cliente["acceptance-813"] = 1;
$cliente["your-captcha"] = "";
$cliente["acceptance-536"] = 0;

$formulario = serialize($cliente);
$result_form = $mysqli->query("INSERT rehubik_wp_db7_forms(form_post_id,form_value,form_date,asignado) VALUES (76,'$formulario','$fecha',0)");

//Actualizo tabla plano con los datos del form

$mysqli->query("UPDATE planos SET nombre_cliente='$nombre',apellidos_cliente='$apellidos',direccion_cliente='$direccion',cp_cliente='$cp',telefono_cliente='$telefono',email_cliente='$email' WHERE id=$idplano");

//Fin actualización

$numero_aleatorio = rand(3, 4);
$password = substr($nombre, 0, 3) . "" . $numero_aleatorio;

//wp_create_user( cadena  $nombre de usuario , cadena  $contraseña , cadena  $correo electrónico  =  ''  )
if (wp_create_user($email, $password, $email))
	$respuesta->mensaje = "Tu usuario se ha generado correctamente. Ahora puedes iniciar sesión en el área de clientes";
else
	$respuesta->mensaje = "Tu usuario " . $email . " ya está creado en Rehubik.com. Ahora puedes iniciar sesión en el área de clientes";

$respuesta->registrado = 1;

//GENERAR PDF Y ENVIARLO AL USUARIO

//HTML QUE SE IMPRIMIRÁ EN EL PDF 
$codigoHTML .= '<html><head>
<style>
	@import url("https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700;900&display=swap");
</style>
<style>
	@page { margin-top: 30px;margin-bottom:0px; } 
	body,h1,h2,h3,p,div,span{font-family:"Montserrat", sans-serif; !important;} 
	.page_break { page-break-before: always; }
	.table thead th {
		vertical-align: bottom;
		border-bottom: 2px solid #dee2e6;
	}
	.table td, .table th {
		padding: 0.75rem;
		vertical-align: top;
		border-top: 1px solid #dee2e6;
	}
	.table {
		width: 100%;
		margin-bottom: 1rem;
		color: #212529;
	}
	.fondo {background:#81b934;width:100%;height:700px;}
	.contenido {
		width:100%;
		margin: 0;
		position: absolute;
		top: 50%;
		-ms-transform: translateY(-50%);
		transform: translateY(-50%);
	}
	.separacion {width:100px;}
	.nombre {border-bottom:1px solid black;padding-bottom:10px;}
	#logo {text-align:right}
	#logo,#cliente {width:48%;display:inline-block;margin:0.5%;overflow:hidden;vertical-align:middle}
	#cliente {font-weight:bold;}
	.tipo_reforma {color:white;}
	.cabecera_reforma {padding-left:25px;padding-top:10px;}
	.titular_proyecto {margin-top:25px;background:#81b934; width:600px; padding:25px;padding-top:10px;padding-bottom:10px;font-weight:bold;}
	.numero_proyecto {color:white;}
	.datos_completos_cliente {margin-top:25px;padding-left:25px;}
	.titular_dato {font-weight:bold;padding-right:25px;}
	.contenedor_cocina {width:100%; margin-top:25px;}
	.texto_cocina,.fotografia_cocina {display:inline-block;vertical-align:bottom;}
	.texto_cocina {width:27%;margin-right:2%;font-size:13px;}
	.fotografia_cocina {width:70%;}
	.white {color:white;}
	.foto_plano {margin-top:25px;}
	.observaciones {margin-top:25px;}
</style>
</head>
<body>';

///  ╔════════════════════════════════════════════════════════════════════════════════════════╗
///  ║ //zra9 ***************************** PÁGINA 1 ******************************** ///     ║
///  ╚════════════════════════════════════════════════════════════════════════════════════════╝

$codigoHTML .= '
<div class="fondo">
	<div class="contenido">
	<div id="logo">
		<img src="https://rehubik.com/wp-content/uploads/2020/07/logo_blanco.png">
	</div>
	<div id="cliente">
		<p>¡HOLA!<br/>
		<span class="nombre">
		' . $nombre . ' ' . $apellidos . '
		</span></p>
		<p>
		TU PROYECTO<br/>
		<span class="tipo_reforma">
			REFORMA DE COCINA
		</span>
		</p>
	</div>
	</div>
</div>
';

$codigoHTML .= "<div class='page_break'></div>";

///  ╔════════════════════════════════════════════════════════════════════════════════════════╗
///  ║ //zra9 ***************************** PÁGINA 2 ******************************** ///     ║
///  ╚════════════════════════════════════════════════════════════════════════════════════════╝

$codigoHTML .= '
<div class="cabecera_reforma">
	<b>SERVICIO DE REFORMAS</b> | TU PROYECTO | <b>' . $nombre . ' ' . $apellidos . '</b> 
</div>

<div class="titular_proyecto"> 
	<span class="numero_proyecto">01</span> 
	<span class="titular_proyecto">TU PROYECTO</span>
</div>

<div class="datos_completos_cliente"> 
	<table>
		<tr>
			<td class="titular_dato">Nombre</td><td>' . $nombre . ' ' . $apellidos . '</td>
		</tr>
		<tr>
			<td class="titular_dato">Dirección</td> <td>' . $direccion . '<br/>' . $cp . '</td>
		</tr>
		<tr>
			<td class="titular_dato">Fecha</td> <td>' . date("d-m-Y") . '</td>
		</tr> 
		<tr>
			<td class="titular_dato">Proyecto</td> <td>Cocina</td>
		</tr>
	</table>

	<div class="contenedor_cocina"> 
		<div class="texto_cocina"> 
			<b>Una cocina renovada y a
			la última</b><br/>
			Trasla toma de datos necesaria y
			atendiendo a tus necesidades,
			gustos y deseos, Rehubikm 2 ha
			concebido y desarrollado el
			siguiente proyecto en la confianza que has depositado en nuestra
			empresa, de haber creado el
			ambiente más acorde con tu idea
			de lo que es un hogar acogedor y
			práctico.
			Rehubik ha recreado en tus
			partidas, planos e infografías un
			conjunto de conceptos a ejecutar
			y que pasamos a detallarte en
			espera de que el resultado sea de
			tu agrado con el fin de que tu
			confianza se consolide para la
			prestación de nuestros servicios.
		</div>';
$codigoHTML .= '
		<div class="fotografia_cocina">
			<img src="' . $obj_datos_plano->imagen_equipamiento . '" style="width:100%;">
		</div>';
$codigoHTML .= '
	</div>';

$codigoHTML .= "<div class='page_break'></div>";

///  ╔════════════════════════════════════════════════════════════════════════════════════════╗
///  ║ //zra9 ***************************** PÁGINA 3 ******************************** ///     ║
///  ╚════════════════════════════════════════════════════════════════════════════════════════╝

$codigoHTML .= '
<div class="cabecera_reforma">
	<b>SERVICIO DE REFORMAS</b> | TU PROYECTO | <b>' . $nombre . ' ' . $apellidos . '</b> 
</div>
<div class="titular_proyecto"> 
	<span class="numero_proyecto">02</span> 
	<span class="titular_proyecto">MEMORIA DE CALIDADES</span>
	<span class="white"> | REVESTIMIENTO Y EQUIPAMIENTO</span>
</div>';

$result_revestimientos = $mysqli->query("SELECT materiales.* FROM materiales,planos_materiales WHERE materiales.referencia = planos_materiales.referencia_material AND planos_materiales.id_plano=$idplano");

if ($result_revestimientos->num_rows) {
	$codigoHTML .= '<table style="width:50%">';

	while ($arr_result_revestimientos = $result_revestimientos->fetch_array()) {
		if ($arr_result_revestimientos["foto"] != "")
			$foto_revestimiento = $arr_result_revestimientos["foto"];
		else
			$foto_revestimiento = "https://rehubik.com/wp-content/uploads/2020/07/logo-2.png";

		$codigoHTML .= '<tr>';
		$codigoHTML .= '
		<td style="">
			<img src="' . $foto_revestimiento . '" style="width:100px;height:auto;">
		</td>';
		$codigoHTML .= '
		<td> 
			<p> 
			' . $arr_result_revestimientos["modelo"] . '
			</p>';
		if ($arr_result_revestimientos['pvp'] != 0) {
			$codigoHTML .= '
			<p>' . $arr_result_revestimientos['pvp'] . ' &euro;</p>';
		}
		$codigoHTML .= '
		</td>';

		if ($i%2 != true)
			$codigoHTML .= '</tr>';
		
	}
	$codigoHTML .= '</table>';
}

$codigoHTML .= "<div class='page_break'></div>";

///  ╔════════════════════════════════════════════════════════════════════════════════════════╗
///  ║ //zra9 ***************************** PÁGINA 5 ******************************** ///     ║
///  ╚════════════════════════════════════════════════════════════════════════════════════════╝

$codigoHTML .= '
<div class="cabecera_reforma">
	<b>SERVICIO DE REFORMAS</b> | TU PROYECTO | <b>' . $nombre . ' ' . $apellidos . '</b> 
</div>
	<div class="titular_proyecto"> 
	<span class="numero_proyecto">03</span> 
	<span class="titular_proyecto">PLANOS</span>
	<span class="white"> | ESTADO ACTUAL</span>
</div>';

$codigoHTML .= '<div class="foto_plano">
					<img src="' . $obj_datos_plano->imagen_dibujo_actual . '" style="width:100%;">
				</div>';

$codigoHTML .= "<div class='page_break'></div>";

///  ╔════════════════════════════════════════════════════════════════════════════════════════╗
///  ║ //zra9 ***************************** PÁGINA 6 ******************************** ///     ║
///  ╚════════════════════════════════════════════════════════════════════════════════════════╝

$codigoHTML .= '
<div class="cabecera_reforma">
	<b>SERVICIO DE REFORMAS</b> | TU PROYECTO | <b>' . $nombre . ' ' . $apellidos . '</b> 
</div>
<div class="titular_proyecto"> 
	<span class="numero_proyecto">03</span> 
	<span class="titular_proyecto">PLANOS</span>
	<span class="white"> | ESTADO REFORMADO</span>
</div>';

$codigoHTML .= '
<div class="foto_plano">
	<img src="' . $obj_datos_plano->imagen_dibujo_reformado . '" style="width:100%;">
</div>';

$codigoHTML .= "<div class='page_break'></div>";

///  ╔════════════════════════════════════════════════════════════════════════════════════════╗
///  ║ //zra9 ***************************** PÁGINA 7 ******************************** ///     ║
///  ╚════════════════════════════════════════════════════════════════════════════════════════╝

$codigoHTML .= '
<div class="cabecera_reforma">
	<b>SERVICIO DE REFORMAS</b> | TU PROYECTO | <b>' . $nombre . ' ' . $apellidos . '</b> 
</div>
<div class="titular_proyecto"> 
	<span class="numero_proyecto">04</span> 
	<span class="titular_proyecto">PRESUPUESTO</span>
</div>';

$suma_precio = 0;
$limpieza = array("Pared A", "Pared B", "Pared C", "Pared D", "m");

$result = $mysqli->query("SELECT * FROM planos_articulos_compuestos WHERE id_plano=$idplano");
$result_plano = $mysqli->query("SELECT * FROM planos WHERE id=$idplano");

while ($arr_result_plano = $result_plano->fetch_array()) {
	$altura_pared = $arr_result_plano["altura_techo_reformado"];
	$metros_cuadrados = $arr_result_plano["m2"];
}

if ($result->num_rows) {
	$codigoHTML .= '
	<table class="table" style="font-size:12px; margin-top:25px;">
		<thead>
			<tr>
				<th scope="col">Artículo</th>
				<th scope="col">Tipo</th>
				<th scope="col">Ubicación</th>
				<th scope="col">Precio</th>
			</tr>
		</thead>
		<tbody>';

	while ($arr_result = $result->fetch_array()) {
		$id_articulo_compuesto = $arr_result["id_articulo_compuesto"];
		$paredes = $arr_result["pared"];
		$longitud_pared = $arr_result["longitud"];
		$unidades = $arr_result["unidades"];
		$metros_lineales = $arr_result["metros_lineales"];

		$result_compuesto = $mysqli->query("SELECT * FROM articulos_compuestos WHERE id=$id_articulo_compuesto");

		while ($arr_result_compuesto = $result_compuesto->fetch_array()) {
			$nombre_articulo_compuesto = $arr_result_compuesto["nombre"];
			$tipo = $arr_result_compuesto["tipo"];
			$imagen = $arr_result_compuesto["imagen"];
			$id = $arr_result_compuesto["id_imagen"];

			if ($tipo == 1) {
				$tipo = "Demoliciones";
			} else if ($tipo == 2) {
				$tipo = "Instalación eléctrica";
			} else if ($tipo == 3) {
				$tipo = "Instalaciones Equipamiento";
			} else if ($tipo == 4) {
				$tipo = "Revestimientos";
			} else if ($tipo == 5) {
				$tipo = "Gas";
			} else if ($tipo == 6) {
				$tipo = "Carpinteria Interior";
			} else if ($tipo == 7) {
				$tipo = "Carpinteria Exterior";
			} else if ($tipo == 8) {
				$tipo = "Otros servicios";
			} else {
				$tipo = "SC";
			}

			$codigoHTML .= '
			<tr>
				<th scope="row">
				' . $nombre_articulo_compuesto . '
				</th>
				<td>' . $tipo . '</td>
				<td>';
			if ($paredes != "") {
				$codigoHTML .= $paredes;

				if ($longitud_pared != 0)
					$codigoHTML .= "<br/> (" . $longitud_pared . " m seleccionados) ";
			} else if ($metros_lineales != 0) {

				$codigoHTML .= $metros_lineales . " m.lineales";
			} else {
				if ($unidades == 1)
					$codigoHTML .= $unidades . " unidad";
				else
					$codigoHTML .= $unidades . " unidades";
			}

			$codigoHTML .= '</td>';
			$codigoHTML .= '<td>';

			$result_precio = $mysqli->query("SELECT ROUND(SUM(precio),2) as precio FROM articulos_simples WHERE id_articulo_compuesto=$id_articulo_compuesto AND visible_cliente=1");

			while ($arr_result_precio = $result_precio->fetch_array()) {
				if ($id == "picado_desescombro_falso_techo" || $id == "picado_desescombro_solado" || $id == "colocacion_solado" || $id == "falso_techo") {
					$precio = $metros_cuadrados * $arr_result_precio["precio"];
				} else if ($id == "picado_desescombro_rodapie" || $id == "colocacion_zocalo" || $id == "picado_desescombro_rodapie") {
					$precio = $longitud_pared * $arr_result_precio["precio"];
				} else if ($paredes != "") {
					if ($id == "alicatado_paredes" || $id == "colocacion_solado") {
						//m2 alicatado calculados x 1,15
						$precio = $metros_cuadrados * $arr_result_precio["precio"];
						$precio = $precio * 1.15;
					} else if ($id == "colocacion_zocalo") {
						$precio = ($longitud_pared * $arr_result_precio["precio"]);
						$precio = $precio * 1.15;
					} else
						$precio = ($longitud_pared * $arr_result_precio["precio"]) * $altura_pared;
				} else if ($metros_lineales != 0)
					$precio = $arr_result_precio["precio"] * $metros_lineales;
				else
					$precio = $arr_result_precio["precio"] * $unidades;
			}

			$suma_precio = $suma_precio + $precio;
			$codigoHTML .= round($precio, 2);
			$codigoHTML .= '€';
			$codigoHTML .= '</td>
	</tr>';
		}
	}

	$result_material = $mysqli->query("SELECT * FROM planos_materiales WHERE id_plano=$idplano");

	if ($result_material->num_rows) {
		while ($arr_result_material = $result_material->fetch_array()) {
			$referencia_material = $arr_result_material["referencia_material"];
			$paredes = $arr_result_material["paredes_reformado"];
			$longitud_pared = $arr_result_material["longitud_pared_reformado"];
			$unidades = $arr_result_material["unidades_reformado"];

			if ($unidades == 0)
				$unidades = 1; //unidad minima

			$result_precios_material = $mysqli->query("SELECT * FROM materiales WHERE referencia='$referencia_material'");

			if ($result_precios_material->num_rows) {
				while ($arr_result_precios_material = $result_precios_material->fetch_array()) {
					$modelo = $arr_result_precios_material["modelo"];
					$precio = $arr_result_precios_material["pvp"];
				}
			} else {
				$modelo = "";
				$precio = "";
			}

			if (strpos($referencia_material, "IKEA") === false) {

				$codigoHTML .= '<tr>';
				$codigoHTML .= '<th scope="row">' . str_replace("_", " ", $referencia_material);
				$codigoHTML .= ": " . utf8_encode($modelo);

				$codigoHTML .= '</th>';

				$codigoHTML .= '<td>Material</td>';
				$codigoHTML .= '<td>';

				if ($referencia_material == "REJUNTE_PARED" || $referencia_material == "REJUNTE_SUELO") {
					//la fórmula sería: m2 alicatado calculados en el Paso 3 x 1,15
					$metros_cuadrados = $longitud_pared * $altura_pared;

					$unidades = ceil($metros_cuadrados / 10);

					$codigoHTML .= $unidades;

					$codigoHTML .= 'unidades para la ' . $paredes;
				} else {
					$codigoHTML .= $unidades . " unidades";
				}

				$codigoHTML .= '</td>';
				$codigoHTML .= '<td>';
				if ($precio != "") {
					$suma_precio = $suma_precio + $precio;
					$codigoHTML .= $precio . "€";
				}

				$codigoHTML .= '</td>';
				$codigoHTML .= '</tr>';
			}
		}
	}

	$codigoHTML .= '		<tr style="text-align:right;font-size:14px;">';
	$codigoHTML .= '			<th colspan="4">* PRECIO FINAL: ' . round($suma_precio, 2) . '&euro;</th>';
	$codigoHTML .= '		</tr>';
	$codigoHTML .= '	</tbody>';
	$codigoHTML .= '</table>';

	$codigoHTML .= '<p style="font-size:13px">* En este precio no está incluido el mobiliario ni los electrodomésticos, sólo la instalación y mano de obra.</p>';
}

$codigoHTML .= "<div class='page_break'></div>";

///  ╔════════════════════════════════════════════════════════════════════════════════════════╗
///  ║ //zra9 ***************************** PÁGINA 8 ******************************** ///     ║
///  ╚════════════════════════════════════════════════════════════════════════════════════════╝

$codigoHTML .= '
<div class="cabecera_reforma">
	<b>SERVICIO DE REFORMAS</b> | TU PROYECTO | <b>' . $nombre . ' ' . $apellidos . '</b> 
</div>
<div class="titular_proyecto"> 
	<span class="numero_proyecto">05</span> 
	<span class="titular_proyecto">OBSERVACIONES DEL PRESUPUESTO</span>
</div>';

$codigoHTML .= '<div class="observaciones">' . nl2br($obj_datos_plano->observaciones) . '</div>';

$codigoHTML .= "<div class='page_break'></div>";

///  ╔════════════════════════════════════════════════════════════════════════════════════════╗
///  ║ //zra9 ***************************** PÁGINA 9 ******************************** ///     ║
///  ╚════════════════════════════════════════════════════════════════════════════════════════╝

$codigoHTML .= '<img src="https://presupuestador.rehubik.com/2d_v0.0.2/contraportada.png" style="width:1000px">';
$codigoHTML .= '</body></html>';

$dompdf = new Dompdf(array('enable_remote' => true));
$dompdf->loadHtml($codigoHTML);

// (Optional) Setup the paper size and orientation
$dompdf->set_paper('A4', 'landscape');
//Cambiando la fuente
//$dompdf->set_option('defaultFont', 'Helvetica');
$dompdf->render();

$output = $dompdf->output();
$microtime = md5(microtime());
$file_to_save = 'pdfs/' . $microtime . "_" . 'presupuesto.pdf';
file_put_contents("../../../" . $file_to_save, $output);

///  ╔════════════════════════════════════════════════════════════════════════════════════════╗
///  ║ //zra9                                    MAIL                               . ///     ║
///  ╚════════════════════════════════════════════════════════════════════════════════════════╝

$mail = new PHPMailer();
include("../../../PHPMailer/configuracion.php");

$html = "
<html>
	<head>
		<meta charset='utf-8'>
		<meta http-equiv='X-UA-Compatible' content='IE=edge'>
		<meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
		<title>Rehubik</title>
	</head>
	<body>
		<div id='header'>
			<p style='text-align:left'><img src='https://rehubik.com/wp-content/uploads/2020/07/logo-2.png' style='width:150px'></p>
		</div>
		<div id='body'>
		<div id='sub-body'>
			<h3>Otros venden reformas. Nosotros creamos hogares</h3>
			<p>Hola $nombre,</p>
			<p>Gracias por registrarte y confiar en nosotros para crear la reforma de tu hogar.</p>
			<p>A continuación te enviamos nuestro presupuesto.</p>
			<p>Para más información puedes contactar con nosotros en el siguiente número de teléfono: <b>900 878 440</b></p>
			<p>Tu id plano es: $idplano</p>  
			<p>¡Un saludo!</p>
		</div>
		</div>
	</body>
</html>";

$mail->AddAddress($email); //El email del receptor del presupuesto
$mail->AddBCC("info@rehubikm2.com", "Rehubik");
$mail->Subject = utf8_decode('Rehubik - Planificación reforma ');
$mail->msgHTML($html);
$mail->AddAttachment("../../../" . $file_to_save);
$mail->send();

//FIN GENERAR PDF Y ENVIARLO AL USUARIO

echo json_encode($respuesta);
