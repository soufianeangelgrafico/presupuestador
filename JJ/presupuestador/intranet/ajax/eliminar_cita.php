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
 
$result_cita=$mysqli->query("SELECT id_presupuesto FROM presupuestos_citas WHERE id_presupuesto=$id_presupuesto");
$obj_result_cita = $result_cita->fetch_object();

$result=$mysqli->query("SELECT * FROM presupuestos WHERE id_presupuesto=".$obj_result_cita->id_presupuesto);

$obj_result = $result->fetch_object();

$result_delete=$mysqli->query("DELETE presupuestos_citas.* FROM presupuestos_citas WHERE id_presupuesto=$id_presupuesto");

if ($result_delete)
{
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
			  <h3>Tu cita asignada al código de presupuesto '.$obj_result->id_presupuesto.' ha sido cancelada.</u></h3>
			  <hr/>	  
			  <p>Sentimos las molestias que esto te haya podido causar. Para cualquier duda estamos a tu disposición a través del correo info@rehubikm2.com o por teléfono al XX XXXXXX
			  </p>
			  <hr/>
			  <div id="footer">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam eratugue duis dolore te feugait nulla facilisi.</div>

		  </div>
		 </div>

	 </body>
	</html>'; 


	include("../../PHPMailer/configuracion.php");

	$mail->AddAddress($obj_result->email_cliente);
	$mail->Subject = utf8_decode('Cita Cancelada - Presupuesto Nº '.$obj_result->id_presupuesto.' - '.strtoupper($obj_result->tipo_reforma).' - Rehubic');
	$mail->msgHTML(utf8_decode($html));
 
	if ($mail->send())
	{
		$respuesta->mensaje="Email enviado correctamente.";
		$respuesta->contestacion=0;
	}
	else
		$respuesta->mensaje="Ocurrió un error al enviar el presupuesto por email. Vuelve a intentarlo.";

}
else
	$respuesta->mensaje="Ocurrió un error al eliminar la cita. Vuelve a intentarlo";
	echo json_encode($respuesta);	
?>