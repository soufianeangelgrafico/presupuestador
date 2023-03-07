<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
include("../conexion.php");
$mail = new PHPMailer;
$respuesta = new stdClass();
$respuesta->contestacion=1; 


$nombre=trim(htmlentities($_POST["nombre"]));
$apellidos=trim(htmlentities($_POST["apellidos"]));
$direccion=trim(htmlentities($_POST["direccion"]));
$poblacion=trim(htmlentities($_POST["poblacion"]));
$provincia=trim(htmlentities($_POST["provincia"]));
$cp=(int)$_POST["cp"];
$telefono=trim(htmlentities($_POST["telefono"]));
$email=htmlentities($_POST["email"]);
$paredes=$_POST["paredes"]; //Array. Contiene 0 si esa pared está vacia (no dibujó nada) o el dibujo en HTML si dibujo una pared
//Datos que voy arrastrando de localstorage
$tiporeforma=trim(htmlentities($_POST["tiporeforma"])); //Cocina, baño...
$presupuestoikea=trim(htmlentities($_POST["presupuestoikea"])); // Contiene el nombre del fichero que ha subido de ikea. Si no ha subido, este valor también lo indica
$elementos_instalacion=trim(htmlentities($_POST["elementos_instalacion"])); //Elementos de la obra que quiere instalar separados por COMAS
$dibujo2d=trim(htmlentities($_POST["dibujo2d"])); //Lo que ha dibujado

$dibujo2d=str_replace('\'','"',$dibujo2d);

$fecha=date("d-m-Y");
$ip=$_SERVER["REMOTE_ADDR"];

if (!isset($_POST["tiporeforma"]) || $tiporeforma == "")
{
	$respuesta->mensaje="No hemos detectado el tipo de reforma. Por favor, vuelve al paso 1 del presupuestador";
}
else if (!isset($_POST["presupuestoikea"]) || $presupuestoikea == "")
{
	$respuesta->mensaje="No hemos detectado si has subido un presupuesto de ikea o no. Por favor, vuelve al paso 2 del presupuestador";
}
else if (!isset($_POST["dibujo2d"]) || $dibujo2d == "")
{
	$respuesta->mensaje="No hemos detectado tu dibujo. Por favor, vuelve al paso 3 del presupuestador";
}
else if (!isset($_POST["elementos_instalacion"]) || $elementos_instalacion == "")
{
	$respuesta->mensaje="No hemos detectado los elementos de instalación necesarios. Por favor, vuelve al paso 4 del presupuestador";
}
else if ($nombre == "") 
{
	$respuesta->mensaje="Por favor, completa tu nombre";
}
else if ($apellidos == "")
{
	$respuesta->mensaje="Por favor, completa tus apellidos";
}
else if ($direccion == "")
{
	$respuesta->mensaje="Por favor, completa tu dirección";
}
else if ($poblacion == "")
{
	$respuesta->mensaje="Por favor, completa tu población";
}
else if ($provincia == "")
{
	$respuesta->mensaje="Por favor, completa tu provincia";
}
else if ($cp == 0)
{
	$respuesta->mensaje="Debes introducir un código postal válido (numérico)";
}
else if ($telefono == "")
{
	$respuesta->mensaje="Por favor, completa tu teléfono";
}
else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	$respuesta->mensaje="El email no es correcto";
}
else
{
	
	
	$sql="INSERT presupuestos(nombre_cliente,apellidos_cliente,direccion_cliente,cp_cliente,poblacion_cliente,provincia_cliente,telefono_cliente,email_cliente,presupuesto_ikea,dibujo2d,elementos_instalacion,tipo_reforma) ";
	$sql.="VALUES ('$nombre','$apellidos','$direccion','$cp','$poblacion','$provincia','$telefono','$email','$presupuestoikea','$dibujo2d','$elementos_instalacion','$tiporeforma');";
	
	
	$result=$mysqli->query($sql);
	
	if ($result)
	{
		$id_presupuesto=$mysqli->insert_id;
		
		//leo las paredes
		for ($i=0;$i<count($paredes);$i++)
		{
			
			
				//echo "PARED ".$i." DISTINTO DE 0 ";
				
				$pared=trim(htmlentities($paredes[$i])); //Lo que ha dibujado
			    $pared=str_replace('\'','"',$pared);
				
				$numero_pared=$i+1;
				
				$mysqli->query("INSERT paredes(id_presupuesto,nombre_pared,dibujopared) VALUES ($id_presupuesto,'pared".$numero_pared."','$pared')");
			
				
			
			
			
		}
		
		
		
		//fin paredes
		$respuesta->contestacion=0;
		
		//Recorro los elementos de instalación con sus respectivas imágenes
		$respuesta->id_presupuesto=$mysqli->insert_id;
		
		$instalacion = explode(",", $elementos_instalacion);
		$imagenes_instalacion="";
		
		for ($i=0;$i<count($instalacion)-1;$i++)
		{
			
			$imagenes_instalacion.="<img src='http://angelgrafico.com/rehubic/iconos/".$instalacion[$i].".png'>";
			
		}
		
		
		//Si la inserción ha sido correcta. Envío el email
		$html='<html>
		<head>
			<meta charset="utf-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
			<title>Rehubic</title>
		</head>
	 <body>

		 <div id="header">
			 <p style="text-align:center"><img src="http://angelgrafico.com/rehubic/iconos/logo.png" style="width:199px"></p>
		 </div>
		 <div id="body">
		  <div id="sub-body">
			  <h3>¡Hola <span style="color:#A8BD46">'.$nombre.' '.$apellidos.'</span>!</h3>
			  <h3>Tu reforma está a punto de empezar.<br><u>Gracias por contar con nosotros</u></h3>
			  <hr/>
			  <p><b>Tipo de reforma: '.strtoupper($tiporeforma).'</b></p>
			  <p style="margin-top: 25px;margin-bottom: 50px;">
				   <span style="border:3px solid black;padding: 10px;">TU CÓDIGO DE PRESUPUESTO: <b>'.$mysqli->insert_id.'</b></span>	  
			  </p>	  
			  <p>Gracias por solicitar tu presupuesto con nosotros. Solicita cita previa con uno de nuestros verificadores cualificados. Confirmarán los datos de tu proyecto, te asesorarán en todo lo que necesites y si estás interesado pondrán poner en marcha tu reforma.
			  </p>

			  <p style="margin-bottom: 50px;"><a href="http://angelgrafico.com/rehubic/presupuestador.php?paso=6" style="background:#A8BD46;color: white;text-decoration: none;padding: 11px;">SOLICITAR CITA PREVIA</a></p>

			  <div style="width:97%;background:#d6d6d6;margin:0px auto;padding:25px;">
				 <h2>PRESUPUESTO: '.$mysqli->insert_id.'</h2>

				 <div style="width:95%;background:white;border:2px solid black;padding:15px;">
					 <h3>DATOS CLIENTE</h3>
					 <div style="width:100%">
					   <div style="width:32%;padding:5px;display:inline-block;"><b>Nombre y apellidos:</b><br/>'.$nombre.' '.$apellidos.'</div>
					   <div style="width:32%;padding:5px;display:inline-block;"><b>Dirección:</b><br/>'.$direccion.' '.$poblacion.'('.$provincia.') '.$cp.'</div>
					   <div style="width:32%;padding:5px;display:inline-block;"><b>Email:</b><br/>'.$email.'</div>
					 </div>
				  </div>

				  <div style="margin-top:25px;width:95%;background:white;border:2px solid black;padding:15px;">
					 <h3>DATOS TÉCNICOS Y ACABADOS</h3>
				  </div>

				  <div style="margin-top:25px;width:95%;background:white;border:2px solid black;padding:15px;">
					 <h3>INSTALACIÓN Y OBRA</h3>
					 <p>'.$imagenes_instalacion.'</p>
				  </div>

			  </div>

			  <hr/>
			  <div id="footer">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam eratugue duis dolore te feugait nulla facilisi.</div>

		  </div>
		 </div>

	 </body>
	</html>'; 


		include("../PHPMailer/configuracion.php");

		$mail->AddAddress($email);
		$mail->Subject = utf8_decode('Presupuesto Nº '.$mysqli->insert_id.' - '.strtoupper($tiporeforma).' - Rehubic');
		$mail->msgHTML(utf8_decode($html));

		if ($mail->send())
		{
			$respuesta->mensaje="Email enviado correctamente. Nos pondremos en contacto contigo a la mayor brevedad";
			$respuesta->contestacion=0;
		}
		else
			$respuesta->mensaje="Ocurrió un error al enviar tu presupuesto por email. No obstante, ha quedado registrado en nuestra base de datos. Nos pondremos en contacto contigo.";

 }
 else
 {
	 $respuesta->mensaje="Ocurrió un error al guardar tu presupuesto. Vuelve a intentarlo";
 }

}
echo json_encode($respuesta);	
	
?>