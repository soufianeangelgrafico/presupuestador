<?php
//Aquí accederan desde el "Solicitar cita" que le llega por email.
//Por si en localstorage ya no están los datos, los obtengo de la BD mediante una llamada Ajax y posteriormente le redirijo al paso 6 del presupuesto (para que seleccione una fecha/hora). Let's Go!

$email=$_GET["email"];
$id_presupuesto=$_GET["id_presupuesto"];
	
?>
<html>
<head>
	<title>Cita previa</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Modern Business - Start Bootstrap Template</title>
	<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="css/modern-business.css" rel="stylesheet">
	<style>
	@import url('https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,700,700i,900&display=swap');
	</style>
</head> 
<body class="page-presupuestador" onload="traeDatos('<?php echo $email;?>','<?php echo $id_presupuesto;?>')">
 <div class="centrado">Obteniendo datos de su presupuesto. Espere...</div>
</body>
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>	
<script>
function traeDatos(email,id_presupuesto)
{
     $.ajax({
		 type: "POST",
		 dataType: 'json', 
		 url: "ajax/obtener_datos_presupuesto.php",
		 data: {email:email,id_presupuesto:id_presupuesto},
		 success:function(respuesta){	
		  if (respuesta.contestacion == 0)
		  {
			
			 localStorage.setItem('id_presupuesto', respuesta.id_presupuesto);
			 localStorage.setItem('presupuesto_nombre_cliente', respuesta.nombre);
			 localStorage.setItem('presupuesto_apellidos_cliente', respuesta.apellidos);
			 localStorage.setItem('presupuesto_direccion_cliente', respuesta.direccion);
			 localStorage.setItem('presupuesto_cp_cliente', respuesta.cp);
			 localStorage.setItem('presupuesto_telefono_cliente', respuesta.telefono);
			 localStorage.setItem('presupuesto_email_cliente', respuesta.email);
			 localStorage.setItem('presupuesto_poblacion_cliente', respuesta.poblacion);
			 localStorage.setItem('presupuesto_provincia_cliente', respuesta.provincia);
			 localStorage.setItem('tiporeforma', respuesta.tiporeforma);
			 localStorage.setItem('presupuestoikea', respuesta.presupuestoikea);	
			 localStorage.setItem('elementos_instalacion', respuesta.elementos_instalacion);	
			 localStorage.setItem('dibujo2d', respuesta.dibujo2d);	 
			  
			 setTimeout(function(){ window.location.assign("http://angelgrafico.com/rehubic/presupuestador.php?paso=6"); }, 3000);
		  }
		  else
		  {
		    alert(respuesta.mensaje);		
		  }
		 } 

	  }); 
}
	
</script>
	
</html>