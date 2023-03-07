<?php
require_once '../../../dompdf-master/lib/html5lib/Parser.php';
require_once '../../../dompdf-master/src/Autoloader.php';
Dompdf\Autoloader::register();
use Dompdf\Dompdf;

require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
$mysqli = new mysqli("localhost","admin_rehubik","Rehubic2018","admin_rehubik");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Fallo al conectar con la base de datos: " . $mysqli -> connect_error;
  exit();
}
 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
//require '../../../PHPMailer/src/Exception.php';
//require '../../../PHPMailer/src/PHPMailer.php';
//require '../../../PHPMailer/src/SMTP.php';

/*
function generadorUsuario( $length ) {

$chars = "abcdefghijklmnopqrstuvwxyz123456789";
return substr(str_shuffle($chars),0,$length);

}
*/

$sesion_temporal=$_COOKIE["random"];
$respuesta = new stdClass();
$nuevo_usuario=false;
$respuesta->registrado=0;
//Datos del formulario
$nombre=$mysqli->real_escape_string(trim(htmlentities($_POST["nombre"],ENT_QUOTES)));
$apellidos=$mysqli->real_escape_string(trim(htmlentities($_POST["apellidos"],ENT_QUOTES)));
$direccion=$mysqli->real_escape_string(trim(htmlentities($_POST["direccion"],ENT_QUOTES)));
$cp=(int)$_POST["cp"];
$telefono=(int)$_POST["telefono"];
$email=$mysqli->real_escape_string(trim(htmlentities($_POST["email"],ENT_QUOTES)));
$error=false;

$cliente["cfdb7_status"]="unread"; //Estado del formulario no leido por defecto
$cliente["your-name"]=$nombre;
$cliente["apellidos"]=$apellidos;
$cliente["direccion"]=$direccion;
$cliente["cp"]=$cp;
$cliente["telefono"]=$telefono;
$cliente["your-email"]=$email;
$cliente["centro_ikea"]="Ikea Alfafar";
$cliente["tipo_reforma"]="Reforma de cocina";
$cliente["acceptance-814"]=1;
$cliente["acceptance-813"]=1;
$cliente["your-captcha"]="";
$cliente["acceptance-536"]=0;
 

//Ahora en formulario tengo serializado los datos. Ejemplo:
//a:8:{s:9:"your-name";s:7:"gdfgdfg";s:9:"apellidos";s:6:"dfgdfg";s:9:"direccion";s:3:"fdg";s:2:"cp";s:5:"46970";s:8:"telefono";s:9:"961518270";s:10:"your-email";s:21:"info@angelgrafico.com";s:11:"centro_ikea";s:12:"Ikea Alfafar";s:12:"tipo_reforma";s:17:"Reforma de cocina";}{}

$formulario = serialize($cliente); 

//form_post_id = FORMULARIO DESDE EL QUE LO ENVIA, ID 76 para el GENERAL


//Datos que están almacenados en la BD (elementos seleccionados y dibujo)

//Creo el usuario como si fuera uno de Wordpress

//PASO 1, guardar los datos en formato SERIALIZE en la tabla rehubik_wp_db7_forms
//Ejemplo de guardado:
/* OJO!!! DEBE TENER LOS MISMOIS CAMPOS, SI NO REVIENTA AL ENTRAR EN EL WP-ADMIN => FORMULARIOS DE CONTACTO
a:13:{s:12:"cfdb7_status";s:4:"read";s:9:"your-name";s:5:"Jimmy";s:9:"apellidos";s:6:"Vargas";s:9:"direccion";s:19:"Calle La Yesa 27-12";s:2:"cp";s:5:"46035";s:8:"telefono";s:9:"622264669";s:10:"your-email";s:25:"jimmyvalencia09@gmail.com";s:11:"centro_ikea";s:12:"Ikea Alfafar";s:12:"tipo_reforma";s:16:"Reforma de Baño";s:14:"acceptance-814";s:1:"1";s:14:"acceptance-813";s:1:"1";s:12:"your-captcha";s:0:"";s:14:"acceptance-536";s:0:"";}
*/
$fecha=date("Y-m-d H:i:s");
$result_id_presupuesto=$mysqli->query("SELECT id_presupuesto FROM clientes ORDER BY id_presupuesto DESC LIMIT 1");

if ($result_id_presupuesto->num_rows)
{
	while ($arr_result_id_presupuesto = $result_id_presupuesto->fetch_array())
	 $id_presupuesto=$arr_result_id_presupuesto["id_presupuesto"]+1;
}
else
 $id_presupuesto=1;

$result=$mysqli->query("INSERT rehubik_wp_db7_forms(form_post_id,form_value,form_date,asignado) VALUES (76,'$formulario','$fecha',0)");

//PASO 2: Guardar el usuario en rehubik_wp_users
if ($result)
{
	//$usuario=generadorUsuario(12);
	
	//El usuario será: nombre + apellidos + un numero aleatorio (del 0 al 999)
	//$usuario=preg_replace('/\s+/', '', $nombre)."".preg_replace('/\s+/', '', $apellidos).rand(0,999);
	$usuario=$email;
	$password=wp_generate_password(4,false,false);
	$password_encriptado=wp_hash_password($password);
	
	$result_existe=$mysqli->query("SELECT ID FROM rehubik_wp_users WHERE user_email='$email'");
	
	if ($result_existe->num_rows)
	{
		$respuesta->mensaje="Tu email ya está dado de alta en nuestra base de datos. Ahora puedes pedir cita entrando al área de clientes";
		$respuesta->registrado=1;
		while ($arr_result_existe = $result_existe->fetch_array())
		  $id_usuario=$arr_result_existe["ID"];
		
		//Ahora guardo el resto de info (lo que tenía dibujado y los elementos seleccionados)
		
	    $result=$mysqli->query("SELECT * FROM sesiones_temporales WHERE sesion='$sesion_temporal'");
		
		while ($arr_result = $result->fetch_array())
		{
			$referencia_material=$arr_result["referencia_material"];
			$id_articulo_compuesto=$arr_result["id_articulo_compuesto"];
			$paredes_reformado=$arr_result["paredes_reformado"];
			$longitud_pared_reformado=$arr_result["longitud_pared_reformado"];
			$altura_techo_reformado=$arr_result["altura_techo_reformado"];
			$altura_techo_actual=$arr_result["altura_techo_actual"];
			$total_paredes_reformado=$arr_result["total_paredes_reformado"];
			$unidades_reformado=$arr_result["unidades_reformado"];
			$metros_lineales_reformado=$arr_result["metros_lineales_reformado"];
			$dibujo_general_actual=$arr_result["dibujo_general_actual"];
			$dibujo_puertas_ventanas_actual=$arr_result["dibujo_puertas_ventanas_actual"];
			$png_estado_actual=$arr_result["png_estado_actual"];
			$dibujo_mobiliario_actual=$arr_result["dibujo_mobiliario_actual"];
			$observaciones_dibujo_actual=$arr_result["observaciones_dibujo_actual"];
			$observaciones_dibujo_actual_txt=$arr_result["observaciones_dibujo_actual_txt"];
			$dibujo_general_reformado=$arr_result["dibujo_general_reformado"];
			$dibujo_mobiliario_reformado=$arr_result["dibujo_mobiliario_reformado"];
			$dibujo_puertas_ventanas_reformado=$arr_result["dibujo_puertas_ventanas_reformado"];
			$observaciones_dibujo_reformado=$arr_result["observaciones_dibujo_reformado"];
			$observaciones_dibujo_reformado_txt=$arr_result["observaciones_dibujo_reformado_txt"];
			$metros_ancho_reformado=$arr_result["metros_ancho_reformado"];
			$metros_alto_reformado=$arr_result["metros_alto_reformado"];
			
			
			if ($id_articulo_compuesto == "" || is_null($id_articulo_compuesto))
			{
				$id_articulo_compuesto="NULL";
			}
			
			if ($referencia_material == "" || is_null($referencia_material))
			{
				$mysqli->query("INSERT clientes(id_usuario,id_presupuesto,id_articulo_compuesto,paredes_reformado,longitud_pared_reformado,altura_techo_reformado,altura_techo_actual,total_paredes_reformado,unidades_reformado,metros_lineales_reformado,dibujo_general_actual,png_estado_actual,dibujo_puertas_ventanas_actual,dibujo_mobiliario_actual,observaciones_dibujo_actual,dibujo_general_reformado,dibujo_mobiliario_reformado,dibujo_puertas_ventanas_reformado,observaciones_dibujo_reformado,metros_ancho_reformado,metros_alto_reformado) VALUES ($id_usuario,$id_presupuesto,$id_articulo_compuesto,'$paredes_reformado','$longitud_pared_reformado','$altura_techo_reformado','$altura_techo_actual','$total_paredes_reformado',$unidades_reformado,'$metros_lineales_reformado','$dibujo_general_actual','$png_estado_actual','$dibujo_puertas_ventanas_actual','$dibujo_mobiliario_actual','$observaciones_dibujo_actual','$dibujo_general_reformado','$dibujo_mobiliario_reformado','$dibujo_puertas_ventanas_reformado','$observaciones_dibujo_reformado','$metros_ancho_reformado','$metros_alto_reformado')");
				
				//echo "INSERT clientes(id_usuario,id_presupuesto,id_articulo_compuesto,paredes_reformado,longitud_pared_reformado,altura_techo_reformado,altura_techo_actual,total_paredes_reformado,unidades_reformado,metros_lineales_reformado,dibujo_general_actual,dibujo_puertas_ventanas_actual,dibujo_mobiliario_actual,observaciones_dibujo_actual,dibujo_general_reformado,dibujo_mobiliario_reformado,dibujo_puertas_ventanas_reformado,observaciones_dibujo_reformado,metros_ancho_reformado,metros_alto_reformado) VALUES ($id_usuario,$id_presupuesto,$id_articulo_compuesto,'$paredes_reformado','$longitud_pared_reformado','$altura_techo_reformado','$altura_techo_actual','$total_paredes_reformado',$unidades_reformado,'$metros_lineales_reformado','$dibujo_general_actual','$dibujo_puertas_ventanas_actual','$dibujo_mobiliario_actual','$observaciones_dibujo_actual','$dibujo_general_reformado','$dibujo_mobiliario_reformado','$dibujo_puertas_ventanas_reformado','$observaciones_dibujo_reformado','$metros_ancho_reformado','$metros_alto_reformado')";
				
			}
			else
			{
				/* Es un material
				$mysqli->query("INSERT clientes(id_usuario,id_presupuesto,referencia_material,id_articulo_compuesto,paredes,longitud_pared,altura_pared,total_paredes,unidades,metros_lineales,dibujo_estado_actual,boxcarpentry_estado_actual,valor,boxenergy,boxcarpentry) VALUES ($id_usuario,$id_presupuesto,'$referencia_material',$id_articulo_compuesto,'$paredes','$longitud_pared','$altura_pared','$total_paredes',$unidades,'$metros_lineales','$dibujo_estado_actual','$boxcarpentry_estado_actual','$valor','$boxenergy','$boxcarpentry')");
			*/
			}
			
			
		
		}	
	  
		
		
	}
	else
	{
		$result_usuario=$mysqli->query("INSERT rehubik_wp_users(user_login,user_pass,user_nicename,user_email,user_registered,user_status,display_name) VALUES ('$usuario','$password_encriptado','$usuario','".$email."','$fecha',0,'".$nombre."')");
		
		if ($result_usuario)
		{
			$id_usuario=$mysqli->insert_id;
			$respuesta->registrado=1;
			$nuevo_usuario=true;
			$respuesta->mensaje="Usuario dado de alta correctamente. Ahora puedes pedir cita previa entrando al área de clientes";
			//Le mando un email con sus datos de acceso
			$mail = new PHPMailer();
			include("../../../PHPMailer/configuracion.php");
			
			$mail->AddAddress($email);
			$mail->Subject = utf8_decode('Tus datos de acceso al área de clientes');
			$mail->msgHTML(utf8_decode("Email: ".$email." / Contraseña: ".$password));
			$mail->send();
			
			
			
			//Ahora guardo el resto de info (lo que tenía dibujado y los elementos seleccionados)
			
			$result=$mysqli->query("SELECT * FROM sesiones_temporales WHERE sesion='$sesion_temporal'");
			
			while ($arr_result = $result->fetch_array())
			{
				
				$referencia_material=$arr_result["referencia_material"];
				$id_articulo_compuesto=$arr_result["id_articulo_compuesto"];
				$paredes=$arr_result["paredes_reformado"];
				$longitud_pared=$arr_result["longitud_pared_reformado"];
				$altura_pared=$arr_result["altura_techo_reformado"];
				$total_paredes=$arr_result["total_paredes_reformado"];
				$unidades=$arr_result["unidades_reformado"];
				$metros_lineales=$arr_result["metros_lineales_reformado"];
				
				$dibujo_general_actual=$arr_result["dibujo_general_actual"];
				$dibujo_mobiliario_actual=$arr_result["dibujo_mobiliario_actual"];
				$dibujo_puertas_ventanas_actual=$arr_result["dibujo_puertas_ventanas_actual"];
				$observaciones_dibujo_actual=$arr_result["observaciones_dibujo_actual"];
				
				$dibujo_general_reformado=$arr_result["dibujo_general_reformado"];
				$dibujo_mobiliario_reformado=$arr_result["dibujo_mobiliario_reformado"];
				$dibujo_puertas_ventanas_reformado=$arr_result["dibujo_puertas_ventanas_reformado"];
				$observaciones_dibujo_reformado=$arr_result["observaciones_dibujo_reformado"];
				$metros_ancho_reformado=$arr_result["metros_ancho_reformado"];
				$metros_alto_reformado=$arr_result["metros_alto_reformado"];
				
				if ($id_articulo_compuesto == "" || is_null($id_articulo_compuesto))
				{
					$id_articulo_compuesto=NULL;
				}
				
				if ($referencia_material == "" || is_null($referencia_material))
				{
					
					$mysqli->query("INSERT clientes(id_usuario,id_presupuesto,id_articulo_compuesto,paredes_reformado,longitud_pared_reformado,altura_techo_reformado,total_paredes_reformado,unidades_reformado,metros_lineales_reformado,dibujo_general_actual,dibujo_puertas_ventanas_actual,dibujo_mobiliario_actual,dibujo_general_reformado,dibujo_mobiliario_reformado,dibujo_puertas_ventanas_reformado,observaciones_dibujo_reformado,metros_ancho_reformado,metros_alto_reformado) VALUES ($id_usuario,$id_presupuesto,$id_articulo_compuesto,'$paredes','$longitud_pared','$altura_pared','$total_paredes',$unidades,'$metros_lineales','$dibujo_general_actual','$dibujo_puertas_ventanas_actual','$dibujo_mobiliario_actual','$dibujo_general_reformado','$dibujo_mobiliario_reformado','$dibujo_puertas_ventanas_reformado','$observaciones_dibujo_reformado','$metros_ancho_reformado','$metros_alto_reformado')");
					
				}
				else
				{
					
					$mysqli->query("INSERT clientes(id_usuario,id_presupuesto,referencia_material,id_articulo_compuesto,paredes_reformado,longitud_pared_reformado,altura_techo_reformado,total_paredes_reformado,unidades_reformado,metros_lineales_reformado,dibujo_general_actual,dibujo_puertas_ventanas_actual,dibujo_mobiliario_actual,dibujo_general_reformado,dibujo_mobiliario_reformado,dibujo_puertas_ventanas_reformado,observaciones_dibujo_reformado,metros_ancho_reformado,metros_alto_reformado) VALUES ($id_usuario,$id_presupuesto,'$referencia_material',$id_articulo_compuesto,'$paredes','$longitud_pared','$altura_pared','$total_paredes',$unidades,'$metros_lineales','$dibujo_general_actual','$dibujo_puertas_ventanas_actual','$dibujo_mobiliario_actual','$dibujo_general_reformado','$dibujo_mobiliario_reformado','$dibujo_puertas_ventanas_reformado','$observaciones_dibujo_reformado','$metros_ancho_reformado','$metros_alto_reformado')");
					
				}

			}
			
		}
		else
		{
		   $respuesta->mensaje="El usuario no se ha podido crear. Vuelve a intentarlo";
		   $error=true;
		}
	}
}
else
{
	$respuesta->mensaje="No se ha podido guardar tu formulario. Vuelve a intentarlo";
	$error=true;
}




//Envío de email con su código de presupuesto para que pueda pedir cita previa.

if (!$error)
{
	
	//Elimino la cookie de la sesión temnporal
	//No ha habido ningún error
	unset($_COOKIE['random']);
	setcookie('random', null, -1, '/');
	$mysqli->query("DELETE sesiones_temporales.* FROM sesiones_temporales WHERE sesion='$sesion_temporal'");
	
	//genero pdf
			$result = $mysqli->query("SELECT DISTINCT id_articulo_compuesto FROM clientes WHERE id_presupuesto=".$id_presupuesto." AND id_articulo_compuesto IS NOT NULL");

			$result_altura_pared=$mysqli->query("SELECT altura_techo_reformado FROM clientes WHERE id_presupuesto=".$id_presupuesto." AND altura_techo_reformado != 0 LIMIT 1");

			while ($arr_result_altura_pared = $result_altura_pared->fetch_array())
			   $altura_pared=$arr_result_altura_pared["altura_techo_reformado"];

			$result_material=$mysqli->query("SELECT clientes.referencia_material as referencia_material, clientes.paredes_reformado as paredes,clientes.longitud_pared_reformado as longitud_pared, clientes.altura_techo_reformado as altura_pared,clientes.total_paredes_reformado as total_paredes,materiales.rvpv as rvpv, materiales.modelo as modelo, materiales.pvp as precio,materiales.mostrar as mostrar FROM clientes,materiales WHERE materiales.referencia = clientes.referencia_material AND id_presupuesto=".$id_presupuesto." AND referencia_material IS NOT NULL");

			$codigoHTML="";

			//LIMPIEZA
			$limpieza = array("Pared A","Pared B","Pared C","Pared D","m");


			//HTML QUE SE IMPRIMIRÁ EN EL PDF 
			$codigoHTML.='<html><head><style>
			@import url("https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700;900&display=swap");
			</style>
			<style>@page { margin-top: 30px;margin-bottom:0px; } body,h1,h2,h3,p,div,span{font-family:"Montserrat", sans-serif; !important;} .page_break { page-break-before: always; }</style></head><body>';

			$codigoHTML.='<p><img width="100" src="https://rehubik.com/wp-content/uploads/2020/07/logo-2.png" alt="Rehubik" title="Rehubik"></p>';
			$codigoHTML.='<h2>Presupuesto #'.$id_presupuesto.'</h2>';

			$codigoHTML.='<table border="1" width="100%"><tr style="background:rgb(149, 193, 31);color:white;text-transform:uppercase;"><td style="font-size:12px;font-weight:bold;padding:5px;border:0;">Artículo</td><td style="font-size:12px;font-weight:bold;padding:5px;border:0;">Tipo</td><td style="font-size:12px;font-weight:bold;padding:5px;border:0;">Pared/Unidades</td><td style="font-size:12px;font-weight:bold;padding:5px;border:0;">Precio</td></tr>';

			$suma_precio=0;
			if ($result->num_rows || $result_material->num_rows)
			{
			  while ($arr_result = $result->fetch_array())
			  {



				$id_articulo_compuesto=$arr_result["id_articulo_compuesto"];

				//Saco toda la información de ese artículo compuesto
				$result_articulo_compuesto = $mysqli->query("SELECT * FROM articulos_compuestos WHERE id=".$id_articulo_compuesto);

				while ($arr_result_articulo_compuesto = $result_articulo_compuesto->fetch_array())
				{

				  $nombre_articulo_compuesto=$arr_result_articulo_compuesto["nombre"];
				  $tipo=$arr_result_articulo_compuesto["tipo"];

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

				}

				//Saco toda la información de todos los artículos simples. Si id_articulo_simple es NULL, saco todo lo que visible sea 1
				$result_ids_articulos_simples = $mysqli->query("SELECT id_articulo_simple FROM clientes WHERE id_presupuesto=".$id_presupuesto." AND id_articulo_compuesto=".$id_articulo_compuesto." AND id_articulo_simple IS NOT NULL");

				if ($result_ids_articulos_simples->num_rows)
				{
					$ids_articulos_simples="";

					while ($arr_result_ids_articulos_simples = $result_ids_articulos_simples->fetch_array())
					{
					  $ids_articulos_simples=$ids_articulos_simples."".$arr_result_ids_articulos_simples["id_articulo_simple"].",";
					}

					$ids_articulos_simples=substr($ids_articulos_simples,0,-1); //Quito la última coma

					$result_articulos_simples=$mysqli->query("SELECT * FROM articulos_simples WHERE id IN (".$ids_articulos_simples.")");

					//Precio artículo compuesto
					$result_precio=$mysqli->query("SELECT SUM(precio) as precio FROM articulos_simples WHERE id IN (".$ids_articulos_simples.")");

				}
				else
				{
					//Saco los articulos simples que visible sea 1
					$result_articulos_simples=$mysqli->query("SELECT * FROM articulos_simples WHERE id_articulo_compuesto=".$id_articulo_compuesto." AND visible_cliente=1");

					//Precio artículo compuesto
					$result_precio=$mysqli->query("SELECT SUM(precio) as precio FROM articulos_simples WHERE id_articulo_compuesto='$id_articulo_compuesto' AND visible_cliente=1");
				}




				while ($arr_result_precio = $result_precio->fetch_array())
				{
					$precio=$arr_result_precio["precio"];
				}


				$codigoHTML.='<tr><td style="font-size:12px;padding:5px;border:0;border-top:1px solid black">'.$nombre_articulo_compuesto;



				  while ($arr_result_articulos_simples = $result_articulos_simples->fetch_array())
				  {

					  $codigo_articulo_simple=$arr_result_articulos_simples["codigo"];
					  $descripcion_articulo_simple=$arr_result_articulos_simples["descripcion"];

					  $codigoHTML.='<br/> <span style="font-size:10px"> - '.$codigo_articulo_simple.': '.utf8_encode($descripcion_articulo_simple)."</span>";

				  }


				 $codigoHTML.='</td>';

				$codigoHTML.='<td style="font-size:12px;padding:5px;border:0;border-top:1px solid black">'.$tipo.'</td><td style="font-size:12px;padding:5px;border:0;border-top:1px solid black">';

				$result_paredes_unidades = $mysqli->query("SELECT DISTINCT paredes_reformado,longitud_pared_reformado,unidades_reformado,metros_lineales_reformado FROM clientes WHERE id_presupuesto=".$id_presupuesto." AND id_articulo_compuesto=".$id_articulo_compuesto);

				while ($arr_result_paredes_unidades = $result_paredes_unidades->fetch_array())
				{
					$paredes=$arr_result_paredes_unidades["paredes_reformado"];
					$longitud_pared=$arr_result_paredes_unidades["longitud_pared_reformado"];
					$unidades=$arr_result_paredes_unidades["unidades_reformado"];
					$metros_lineales=$arr_result_paredes_unidades["metros_lineales_reformado"];
					


					if ($paredes != "")
					{
						$codigoHTML.=$paredes."<br>";

						if ($longitud_pared != 0)
						{
						   $codigoHTML.="(".$longitud_pared." m seleccionados)<br/>";

						   $calcula_precio=($precio*$longitud_pared)*$altura_pared;
						   $precio_final=$precio_final+$calcula_precio;

						}
					}
					else if ($metros_lineales != 0)
					{
						$codigoHTML.=$metros_lineales." m.lineales<br/>";
						$precio_final=$precio*$metros_lineales;
					}
					else
					{
					  if ($unidades == 1)
						$codigoHTML.=$unidades." unidad";
					  else
						$codigoHTML.=$unidades." unidades";

					  $codigoHTML.="<br>";
					  $precio_final=$precio*$unidades;	
					}



				}
				$codigoHTML.='</td>';

				$codigoHTML.='<td style="font-size:12px;padding:5px;border:0;border-top:1px solid black">'.round($precio_final,2).'€</td></tr>';

				$suma_precio=$suma_precio+$precio_final;
				$precio_final=0;

			  }
			  while ($arr_result_material = $result_material->fetch_array())
			  {
					$referencia_material=$arr_result_material["referencia_material"];
					$rvpv=$arr_result_material["rvpv"];
					$modelo_material=$arr_result_material["modelo"];
					$precio_material=$arr_result_material["precio"];
					$mostrar=$arr_result_material["mostrar"];
					$paredes=$arr_result_material["paredes"];
					$longitud_pared=$arr_result_material["longitud_pared"];
					$altura_pared=$arr_result_material["altura_pared"];
					$total_paredes=$arr_result_material["total_paredes"];



					$codigoHTML.='<tr>
									  <td colspan="2" style="font-size:12px;padding:5px;border:0;border-top:1px solid black">
										MATERIAL '.$referencia_material.': '.$modelo_material.' ('.$rvpv.')
									  </td>';



					if ($rvpv == "Pavimento")
					{

					   //En total paredes tengo algo como esto:
					   //Pared D 8.01 m,Pared C 11.45 m,Pared B 8.01 m,Pared A 11.45 m
					   //Debo quedarme con los m para sacar el área (m2) y el precio a calcular
						$paredes = explode(",", $total_paredes);
						$area=0;
						for ($i=0;$i<count($paredes);$i++) {
						   $metros=str_replace($limpieza,'',$paredes[$i]);
						   $area=$area+$metros;
						}

						$codigoHTML.='<td style="font-size:12px;padding:5px;border:0;border-top:1px solid black">';

						 if ($paredes != "") 
						   $codigoHTML.=$area.' m2';


						$codigoHTML.='</td>';

						$codigoHTML.='<td style="font-size:12px;padding:5px;border:0;border-top:1px solid black">'.round($area * $altura_pared * 1.15*$precio_material,2).'€</td>';		

						$suma_precio=$suma_precio+round($area * $altura_pared * 1.15,2)*$precio_material;						
					}
					else
					{				

					  $codigoHTML.='<td style="font-size:12px;padding:5px;border:0;border-top:1px solid black">';

					  if ($paredes != "") 
					   $codigoHTML.=$paredes.'<br>('.$longitud_pared.'m seleccionados)'; 


					   $codigoHTML.='</td>';	

						$codigoHTML.='<td style="font-size:12px;padding:5px;border:0;border-top:1px solid black">'.round($longitud_pared * $altura_pared * $precio_material * 1.15,2)*$precio_material.'€</td>';

					  $suma_precio=$suma_precio+round($longitud_pared * $altura_pared * $precio_material * 1.15,2)*$precio_material;

					}

					$codigoHTML.='</tr>';

				}	

			}
			$codigoHTML.='<tr style="color:white;background:rgb(149, 193, 31);text-align:right"><td colspan="4" style="font-size:12px;font-weight:bold;padding:5px;border:0;border-top:1px solid black">PRECIO FINAL: '.round($suma_precio,2).'€</td></tr>';

			$codigoHTML.='</table>';
			$codigoHTML.='<p>Puedes acceder a tu plano desde <a href="https://rehubik.com/presupuestador/2d/?id_presupuesto='.$id_presupuesto.'" target="_blank" rel="noopener">AQUÍ</p>';

			$codigoHTML.='</body></html>';
			//echo $codigoHTML; 
			//GENERO PDF



			$dompdf = new Dompdf(array('enable_remote' => true));
			$dompdf->loadHtml($codigoHTML);

			// (Optional) Setup the paper size and orientation
			$dompdf->set_paper('A4', 'portrait');
			//Cambiando la fuente
			//$dompdf->set_option('defaultFont', 'Helvetica');
			$dompdf->render();

			$output = $dompdf->output();

			$microtime=md5(microtime()); 
			$file_to_save = 'pdfs/'.$microtime."_".'presupuesto.pdf';
			file_put_contents("../../../".$file_to_save, $output);  

			

			
			//fin genero pdf
	
	
    
	//Envio el email
	$html='<html>
						<head>
							<meta charset="utf-8">
							<meta http-equiv="X-UA-Compatible" content="IE=edge">
							<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
							<title>Rehubik</title>
						</head>
					 <body>

						 <div id="header">
							 <p style="text-align:left"><img src="https://rehubik.com/wp-content/uploads/2020/07/logo-2.png" style="width:150px"></p>
						 </div>
						 <div id="body">
						  <div id="sub-body">
							  <h3>¡Hola <span style="color:#A8BD46">'.$nombre.'</span>!</h3>
							  <h3>Ahora que has finalizado tu planificación de la reforma, puedes pedir cita previa</h3>
							  <hr/>
							  <p><b>¿Cómo pedir cita previa?</b></p>
							  <ol>
							   <li style="margin-bottom:10px;">Inicia sesión en la web desde <b>https://rehubik.com/wp-login.php</b> o haciendo click <a href="https://rehubik.com/wp-login.php">AQUÍ</a>.</li>
							   <li style="margin-bottom:10px">Selecciona tu centro IKEA más cercano en la siguiente URL: https://rehubik.com/reservar/citas/?id='.$id_presupuesto.'&email='.$email.' o haciendo click <a href="https://rehubik.com/reservar/citas/?id='.$id_presupuesto.'&email='.$email.'">AQUÍ</a>
							   <li style="margin-bottom:10px">Elige la fecha y hora en la que quieras que uno de nuestros técnicos te haga una visita o televisita</p>
							   <li style="margin-bottom:10px">Si en algún momento del proceso, te pide que introduzcas <b>tu ID de presupuesto</b>, deberás indicar que es el presupuesto <b>'.$id_presupuesto.'</b></li>
							  </ol>
							  <hr/>';
							  if ($nuevo_usuario)
							  {
								 $html.='<p><b>Tus datos de acceso son:</b><br/>Email: '.$email.' / Contraseña: '.$password.'</p> <hr/>';
							  }
							  else
							  {
							    $html.='<p><b>¿Has olvidado tu contraseña?</b> Recupérala desde <b>https://rehubik.com/wp-login.php?action=lostpassword</b> o haciendo click <a href="https://rehubik.com/wp-login.php?action=lostpassword">AQUÍ</a></p><hr/>';
							  }
							
							 $html.='<div id="footer">¿No puedes acceder? Llámanos al 900 878 440 o escríbenos un email a info@rehubikm2.com y te ayudaremos.</div>

						  </div>
						 </div>

					 </body>
					</html>'; 	
	
				   $mail = new PHPMailer();
				   include("../../../PHPMailer/configuracion.php");
			
				   $mail->AddAddress($email); //El email del receptor del presupuesto
		 		   $mail->AddBCC("info@rehubikm2.com", "Rehubik");
				   $mail->Subject = utf8_decode('Rehubik - Planificación reforma '.$id_presupuesto.' - '.$nombre);
				   $mail->msgHTML(utf8_decode($html));
				   $mail->AddAttachment("../../../".$file_to_save);
				   $mail->send();
	
}

echo json_encode($respuesta);

?>