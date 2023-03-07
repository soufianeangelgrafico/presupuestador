<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
include("../conexion.php");

$mail = new PHPMailer;
$respuesta = new stdClass();
$respuesta->mensaje="";

if (isset($_POST["horario"]))
{
	$horario=(int)$_POST["horario"];
	$id_presupuesto=(int)$_GET["id_presupuesto"];
	$tipocita=(int)$_GET["tipocita"];
	$email=htmlentities($_GET["email"]);
	
	
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    	$respuesta->mensaje="Tu email no es correcto. Por favor, vuelve al paso anterior";
	}
	else
	{
		//Compruebo auditoria si no es el administrador (tipocita = 0). Si lo es, no compruebo.
		
		if ($tipocita == 0)
		 $result_presupuesto=$mysqli->query("SELECT * FROM presupuestos WHERE id_presupuesto=$id_presupuesto AND email_cliente='$email'");
		else
		 $result_presupuesto=$mysqli->query("SELECT * FROM presupuestos WHERE id_presupuesto=$id_presupuesto");
		
		//Compruebo si ya tiene una cita asignada
		$result_cita_asignada=$mysqli->query("SELECT id FROM presupuestos_citas WHERE id_presupuesto=$id_presupuesto");
		
		if ($result_cita_asignada->num_rows && $tipocita == 0)
		{
		  
			$respuesta->mensaje="Ya tienes una cita asignada para el presupuesto $id_presupuesto";
		
		}
		else
		{
			if ($result_presupuesto->num_rows)
			{
				
				$obj_presupuesto = $result_presupuesto->fetch_object();
				$result=$mysqli->query("SELECT id_calendario FROM horarios_calendario WHERE id=$horario AND ocupado=0");
				
				if ($result->num_rows)
				{
					
					if ($tipocita == 1)
					{
						
						//Obtengo datos de la cita anterior para volver a dejarla libre.
						$result_cita_anterior=$mysqli->query("SELECT id_cita FROM presupuestos_citas WHERE id_presupuesto=$id_presupuesto");
						
						while ($arr_result_cita_anterior = $result_cita_anterior->fetch_array())
							$id_cita=$arr_result_cita_anterior["id_cita"];
						
						
						//Ahora, elimino citas anteriores de ese presupuesto
						$mysqli->query("DELETE presupuestos_citas.* FROM presupuestos_citas WHERE id_presupuesto=$id_presupuesto");
						
						//Al eliminar una cita, el horario se queda libre
						$mysqli->query("UPDATE horarios_calendario SET ocupado=0 WHERE id=$id_cita");
					}
					
					//Inserto su cita en la tabla presupuestos_citas

					$result_cita=$mysqli->query("INSERT presupuestos_citas(id_presupuesto,id_cita,asignada,confirmada) VALUES($id_presupuesto,$horario,1,0)");

					if ($result_cita)
					{ 
						//Si el insert se ha hecho, hago el update de la hora asignada
						
						$result_update=$mysqli->query("UPDATE horarios_calendario SET ocupado=1 WHERE id=$horario");
						
						if ($result_update)
						{
							//Obtengo los datos de ese fecha
							$result_fecha_asignada=$mysqli->query("SELECT horarios_calendario.*,calendario.fecha as fecha FROM horarios_calendario,calendario WHERE horarios_calendario.id_calendario = calendario.id AND horarios_calendario.id=$horario");
							$obj_fecha_asignada=$result_fecha_asignada->fetch_object();
							
							$respuesta->mensaje="¡Cita previa asignada!";

							//Compruebo si todas las horas disponibles de esa fecha están ocupadas para hacer la FECHA entera como ocupada (y que así en el calendario salga en rojo)
							while ($arr_result = $result->fetch_array())
								$id_calendario=$arr_result["id_calendario"];

							$result_totales=$mysqli->query("SELECT id FROM horarios_calendario WHERE id_calendario=".$id_calendario);
							$result_ocupadas=$mysqli->query("SELECT id FROM horarios_calendario WHERE id_calendario=".$id_calendario." AND ocupado=1");

							if ($result_totales->num_rows == $result_ocupadas->num_rows)
							{
								//Todas las horas de esa fecha están ocupadas
								$mysqli->query("UPDATE calendario SET ocupado=1 WHERE id=$id_calendario");
							}
							
							//Envio de email
							
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
								  <h3>¡Hola <span style="color:#A8BD46">'.$obj_presupuesto->nombre_cliente.' '.$obj_presupuesto->apellidos_cliente.'</span>!</h3>
								  <h3><u>Tu confirmación de cita previa.</u><br>Tu reforma está a punto de empezar.</h3>
								  <hr/> 
								  <p><b>Tipo de reforma: '.strtoupper($obj_presupuesto->tipo_reforma).'</b></p>
								  <p style="margin-top: 25px;margin-bottom: 50px;">
									   <span style="border:3px solid black;padding: 10px;">Tu código de presupuesto: <b>'.$id_presupuesto.'</b></span>	  
								  </p>
 
								  <h3 style="text-align:center">TU CITA<br/>'.date("d-m-Y",strtotime($obj_fecha_asignada->fecha)).' de '.$obj_fecha_asignada->hora.'</h3>
								  <p style="text-align:center">Uno de nuestros verificadores se pondrá en contacto contigo para confirmar tu cita.</p>

								  <hr/>

								  <h4>Tus datos de contacto</h4>
								  <p>
									  '.$obj_presupuesto->nombre_cliente.' '.$obj_presupuesto->apellidos_cliente.'<br/>
									  '.$obj_presupuesto->direccion_cliente.' ('.$obj_presupuesto->poblacion_cliente. ' / '.$obj_presupuesto->provincia_cliente.')<br/>
									  '.$obj_presupuesto->telefono_cliente.'<br/>
									  '.$obj_presupuesto->email_cliente.'<br/>
								  </p>

								  <hr/>

								  <div id="footer">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam eratugue duis dolore te feugait nulla facilisi.</div>

							  </div>
							 </div>

						 </body>
						</html>'; 


						include("../PHPMailer/configuracion.php");

						$mail->AddAddress($email);
						$mail->Subject = utf8_decode('Cita previa para presupuesto nº '.$id_presupuesto.' - Rehubic');
						$mail->msgHTML(utf8_decode($html));

						if ($mail->send())
						{
							$respuesta->mensaje="Cita previa asignada correctamente. Nos pondremos en contacto contigo a la mayor brevedad";
							$respuesta->contestacion=0;
						}
						else
							$respuesta->mensaje="Ocurrió un error al enviar tu cita previa por email. No obstante, ha quedado registrado en nuestra base de datos. Nos pondremos en contacto contigo.";
							
							
							
							
					  }
					  else
						 $respuesta->mensaje="Ocurrió un error al asignarte la cita. Vuelve a intentarlo";
				  }
				  else
					 $respuesta->mensaje="Ocurrió un error al guardar tu cita en la base de datos. Vuelve a intentarlo";
				}
				else
				{
					$respuesta->mensaje="Este horario ya está ocupado";
				}
		 }
		 else
		  $respuesta->mensaje="Tus datos no coinciden. No se te puede asignar una cita previa. Vuelve a intentarlo";
  
  }
	
 }

}
else
   $respuesta->mensaje="Selecciona una hora";
echo json_encode($respuesta);	
?>