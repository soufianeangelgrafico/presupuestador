<?php
require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
$mysqli = new mysqli("localhost","admin_rehubik","Rehubic2018","admin_rehubik");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Fallo al conectar con la base de datos: " . $mysqli -> connect_error;
  exit();
}
 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../../../PHPMailer/src/Exception.php';
require '../../../PHPMailer/src/PHPMailer.php';
require '../../../PHPMailer/src/SMTP.php';


function generadorUsuario( $length ) {

$chars = "abcdefghijklmnopqrstuvwxyz123456789";
return substr(str_shuffle($chars),0,$length);

}


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


//Datos que est??n almacenados en la BD (elementos seleccionados y dibujo)

//Creo el usuario como si fuera uno de Wordpress

//PASO 1, guardar los datos en formato SERIALIZE en la tabla rehubik_wp_db7_forms
//Ejemplo de guardado:
/* OJO!!! DEBE TENER LOS MISMOIS CAMPOS, SI NO REVIENTA AL ENTRAR EN EL WP-ADMIN => FORMULARIOS DE CONTACTO
a:13:{s:12:"cfdb7_status";s:4:"read";s:9:"your-name";s:5:"Jimmy";s:9:"apellidos";s:6:"Vargas";s:9:"direccion";s:19:"Calle La Yesa 27-12";s:2:"cp";s:5:"46035";s:8:"telefono";s:9:"622264669";s:10:"your-email";s:25:"jimmyvalencia09@gmail.com";s:11:"centro_ikea";s:12:"Ikea Alfafar";s:12:"tipo_reforma";s:16:"Reforma de Ba??o";s:14:"acceptance-814";s:1:"1";s:14:"acceptance-813";s:1:"1";s:12:"your-captcha";s:0:"";s:14:"acceptance-536";s:0:"";}
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
	$usuario=generadorUsuario(12);
	$password=wp_generate_password(8,false,false);
	$password_encriptado=wp_hash_password($password);
	
	$result_existe=$mysqli->query("SELECT ID FROM rehubik_wp_users WHERE user_email='$email'");
	
	if ($result_existe->num_rows)
	{
		$respuesta->mensaje="Tu email ya est?? dado de alta en nuestra base de datos. Ahora puedes pedir cita entrando al ??rea de clientes";
		$respuesta->registrado=1;
		while ($arr_result_existe = $result_existe->fetch_array())
		  $id_usuario=$arr_result_existe["ID"];
		
		//Ahora guardo el resto de info (lo que ten??a dibujado y los elementos seleccionados)
		
	    $result=$mysqli->query("SELECT * FROM sesiones_temporales WHERE sesion='$sesion_temporal'");
		
		while ($arr_result = $result->fetch_array())
		{
			$referencia_material=$arr_result["referencia_material"];
			$id_articulo_compuesto=$arr_result["id_articulo_compuesto"];
			$paredes=$arr_result["paredes"];
			$longitud_pared=$arr_result["longitud_pared"];
			$altura_pared=$arr_result["altura_pared"];
			$total_paredes=$arr_result["total_paredes"];
			$unidades=$arr_result["unidades"];
			$metros_lineales=$arr_result["metros_lineales"];
			$dibujo_estado_actual=$arr_result["dibujo_estado_actual"];
			$boxcarpentry_estado_actual=$arr_result["boxcarpentry_estado_actual"];
			$valor=$arr_result["valor"];
			$boxenergy=$arr_result["boxenergy"];
			$boxcarpentry=$arr_result["boxcarpentry"];
			
			
			if ($id_articulo_compuesto == "" || is_null($id_articulo_compuesto))
			{
				$id_articulo_compuesto="NULL";
			}
			
			if ($referencia_material == "" || is_null($referencia_material))
			{
				$mysqli->query("INSERT clientes(id_usuario,id_presupuesto,id_articulo_compuesto,paredes,longitud_pared,altura_pared,total_paredes,unidades,metros_lineales,dibujo_estado_actual,boxcarpentry_estado_actual,valor,boxenergy,boxcarpentry) VALUES ($id_usuario,$id_presupuesto,$id_articulo_compuesto,'$paredes','$longitud_pared','$altura_pared','$total_paredes',$unidades,'$metros_lineales','$dibujo_estado_actual','$boxcarpentry_estado_actual','$valor','$boxenergy','$boxcarpentry')");
				//echo "INSERT clientes(id_usuario,id_presupuesto,id_articulo_compuesto,paredes,longitud_pared,altura_pared,total_paredes,unidades,metros_lineales,valor,boxenergy) VALUES ($id_usuario,$id_presupuesto,$id_articulo_compuesto,'$paredes','$longitud_pared','$altura_pared','$total_paredes',$unidades,'$metros_lineales','$valor','$boxenergy')";
				
			}
			else
			{
				$mysqli->query("INSERT clientes(id_usuario,id_presupuesto,referencia_material,id_articulo_compuesto,paredes,longitud_pared,altura_pared,total_paredes,unidades,metros_lineales,dibujo_estado_actual,boxcarpentry_estado_actual,valor,boxenergy,boxcarpentry) VALUES ($id_usuario,$id_presupuesto,'$referencia_material',$id_articulo_compuesto,'$paredes','$longitud_pared','$altura_pared','$total_paredes',$unidades,'$metros_lineales','$dibujo_estado_actual','$boxcarpentry_estado_actual','$valor','$boxenergy','$boxcarpentry')");
			
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
			$respuesta->mensaje="Usuario dado de alta correctamente. Ahora puedes pedir cita previa entrando al ??rea de clientes";
			//Le mando un email con sus datos de acceso
			/*$mail = new PHPMailer();
			include("../../../PHPMailer/configuracion.php");
			
			$mail->AddAddress($email);
			$mail->Subject = utf8_decode('Tus datos de acceso al ??rea de clientes');
			$mail->msgHTML(utf8_decode("Email: ".$email." / Contrase??a: ".$password));
			$mail->send();
			*/
			
			
			//Ahora guardo el resto de info (lo que ten??a dibujado y los elementos seleccionados)
			
			$result=$mysqli->query("SELECT * FROM sesiones_temporales WHERE sesion='$sesion_temporal'");
			
			while ($arr_result = $result->fetch_array())
			{
				$referencia_material=$arr_result["referencia_material"];
				$id_articulo_compuesto=$arr_result["id_articulo_compuesto"];
				$paredes=$arr_result["paredes"];
				$longitud_pared=$arr_result["longitud_pared"];
				$altura_pared=$arr_result["altura_pared"];
				$total_paredes=$arr_result["total_paredes"];
				$unidades=$arr_result["unidades"];
				$metros_lineales=$arr_result["metros_lineales"];
				$dibujo_estado_actual=$arr_result["dibujo_estado_actual"];
				$valor=$arr_result["valor"];
				$boxenergy=$arr_result["boxenergy"];
				
				
				if ($id_articulo_compuesto == "" || is_null($id_articulo_compuesto))
				{
					$id_articulo_compuesto=NULL;
				}
				
				if ($referencia_material == "" || is_null($referencia_material))
				{
					//$mysqli->query("INSERT clientes(id_usuario,id_presupuesto,id_articulo_compuesto,paredes,total_paredes,unidades,valor,boxenergy) VALUES ($id_usuario,$id_presupuesto,$id_articulo_compuesto,'$paredes','$total_paredes',$unidades,'$valor','$boxenergy')");
					$mysqli->query("INSERT clientes(id_usuario,id_presupuesto,id_articulo_compuesto,paredes,longitud_pared,altura_pared,total_paredes,unidades,metros_lineales,dibujo_estado_actual,valor,boxenergy) VALUES ($id_usuario,$id_presupuesto,$id_articulo_compuesto,'$paredes','$longitud_pared','$altura_pared','$total_paredes',$unidades,'$metros_lineales','$dibujo_estado_actual','$valor','$boxenergy')");
					
				}
				else
				{
					//$mysqli->query("INSERT clientes(id_usuario,id_presupuesto,referencia_material,id_articulo_compuesto,paredes,total_paredes,unidades,valor,boxenergy) VALUES ($id_usuario,$id_presupuesto,'$referencia_material',$id_articulo_compuesto,'$paredes','$total_paredes',$unidades,'$valor','$boxenergy')");
					$mysqli->query("INSERT clientes(id_usuario,id_presupuesto,referencia_material,id_articulo_compuesto,paredes,longitud_pared,altura_pared,total_paredes,unidades,metros_lineales,dibujo_estado_actual,valor,boxenergy) VALUES ($id_usuario,$id_presupuesto,'$referencia_material',$id_articulo_compuesto,'$paredes','$longitud_pared','$altura_pared','$total_paredes',$unidades,'$metros_lineales','$dibujo_estado_actual','$valor','$boxenergy')");
					
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




//Env??o de email con su c??digo de presupuesto para que pueda pedir cita previa.

if (!$error)
{
	
	//Elimino la cookie de la sesi??n temnporal
	//No ha habido ning??n error
	
    unset($_COOKIE['random']);
	setcookie("random", "", time()-3600);
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
							  <h3>??Hola <span style="color:#A8BD46">'.$nombre.'</span>!</h3>
							  <h3>Ahora que has finalizado tu planificaci??n de la reforma, puedes pedir cita previa</h3>
							  <hr/>
							  <p><b>??C??mo pedir cita previa?</b></p>
							  <ol>
							   <li style="margin-bottom:10px;">Inicia sesi??n en la web desde <b>https://rehubik.com/wp-login.php</b> o haciendo click <a href="https://rehubik.com/wp-login.php">AQU??</a>.</li>
							   <li style="margin-bottom:10px">Selecciona tu centro IKEA m??s cercano en la siguiente URL: https://rehubik.com/reservar/citas/?id='.$id_presupuesto.'&email='.$email.' o haciendo click <a href="https://rehubik.com/reservar/citas/?id='.$id_presupuesto.'&email='.$email.'">AQU??</a>
							   <li style="margin-bottom:10px">Elige la fecha y hora en la que quieras que uno de nuestros t??cnicos te haga una visita o televisita</p>
							   <li style="margin-bottom:10px">Si en alg??n momento del proceso, te pide que introduzcas <b>tu ID de presupuesto</b>, deber??s indicar que es el presupuesto <b>'.$id_presupuesto.'</b></li>
							  </ol>
							  <hr/>';
							  if ($nuevo_usuario)
							  {
								 $html.='<p><b>Tus datos de acceso son:</b><br/>Email: '.$email.' / Contrase??a: '.$password.'</p> <hr/>';
							  }
							  else
							  {
							    $html.='<p><b>??Has olvidado tu contrase??a?</b> Recup??rala desde <b>https://rehubik.com/wp-login.php?action=lostpassword</b> o haciendo click <a href="https://rehubik.com/wp-login.php?action=lostpassword">AQU??</a></p><hr/>';
							  }
							
							 $html.='<div id="footer">??No puedes acceder? Ll??manos al 900 878 440 o escr??benos un email a info@rehubikm2.com y te ayudaremos.</div>

						  </div>
						 </div>

					 </body>
					</html>'; 	
	
				   $mail = new PHPMailer();
				   include("../../../PHPMailer/configuracion.php");
			
				   $mail->AddAddress($email); //El email del receptor del presupuesto
		 		   $mail->AddBCC("info@rehubikm2.com", "Rehubik");
				   $mail->Subject = utf8_decode('Rehubik - Planificaci??n reforma '.$id_presupuesto.' - '.$nombre);
				   $mail->msgHTML(utf8_decode($html));
				   $mail->send();
	
}

echo json_encode($respuesta);

?>