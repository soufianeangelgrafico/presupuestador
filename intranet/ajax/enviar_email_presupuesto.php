<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../../PHPMailer/src/Exception.php';
require '../../PHPMailer/src/PHPMailer.php';
require '../../PHPMailer/src/SMTP.php';
include("../../conexion.php");
$mail = new PHPMailer;
$respuesta = new stdClass();
$respuesta->contestacion=1;

$id_presupuesto=(int)$_POST["id_presupuesto"];

$result=$mysqli->query("SELECT * FROM presupuestos WHERE id_presupuesto=$id_presupuesto");
$obj_result = $result->fetch_object();
 
$instalacion = explode(",", $obj_result->elementos_instalacion);
$imagenes_instalacion="";
		
for ($i=0;$i<count($instalacion)-1;$i++)
{
			
	$imagenes_instalacion.="<img src='http://angelgrafico.com/rehubic/iconos/".$instalacion[$i].".png'>";
			
}
 
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
			  <h3>¡Hola <span style="color:#A8BD46">'.$obj_result->nombre_cliente.' '.$obj_result->apellidos_cliente.'</span>!</h3>
			  <h3>Tu reforma está a punto de empezar.<br><u>Gracias por contar con nosotros</u></h3>
			  <hr/>
			  <p><b>Tipo de reforma: '.strtoupper($obj_result->tipo_reforma).'</b></p>
			  <p style="margin-top: 25px;margin-bottom: 50px;">
				   <span style="border:3px solid black;padding: 10px;">TU CÓDIGO DE PRESUPUESTO: <b>'.$obj_result->id_presupuesto.'</b></span>	  
			  </p>	  
			  <p>Gracias por solicitar tu presupuesto con nosotros. Solicita cita previa con uno de nuestros verificadores cualificados. Confirmarán los datos de tu proyecto, te asesorarán en todo lo que necesites y si estás interesado pondrán poner en marcha tu reforma.
			  </p>

			  <p style="margin-bottom: 50px;"><a href="http://angelgrafico.com/rehubic/presupuestador.php?paso=6" style="background:#A8BD46;color: white;text-decoration: none;padding: 11px;">SOLICITAR CITA PREVIA</a></p>

			  <div style="width:97%;background:#d6d6d6;margin:0px auto;padding:25px;">
				 <h2>PRESUPUESTO: '.$obj_result->id_presupuesto.'</h2>

				 <div style="width:95%;background:white;border:2px solid black;padding:15px;">
					 <h3>DATOS CLIENTE</h3>
					 <div style="width:100%">
					   <div style="width:32%;padding:5px;display:inline-block;"><b>Nombre y apellidos:</b><br/>'.$obj_result->nombre_cliente.' '.$obj_result->apellidos_cliente.'</div>
					   <div style="width:32%;padding:5px;display:inline-block;"><b>Dirección:</b><br/>'.$obj_result->direccion_cliente.' '.$obj_result->poblacion_cliente.'('.$obj_result->provincia_cliente.') '.$obj_result->cp_cliente.'</div>
					   <div style="width:32%;padding:5px;display:inline-block;"><b>Email:</b><br/>'.$obj_result->email_cliente.'</div>
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


	include("../../PHPMailer/configuracion.php");

	$mail->AddAddress($obj_result->email_cliente);
	$mail->Subject = utf8_decode('Presupuesto Nº '.$obj_result->id_presupuesto.' - '.strtoupper($obj_result->tipo_reforma).' - Rehubic');
	$mail->msgHTML(utf8_decode($html));
 
	if ($mail->send())
	{
		$respuesta->mensaje="Email enviado correctamente.";
		$respuesta->contestacion=0;
	}
	else
		$respuesta->mensaje="Ocurrió un error al enviar el presupuesto por email. Vuelve a intentarlo.";

	
	echo json_encode($respuesta);	
?>