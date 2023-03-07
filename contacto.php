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
  <link href="css/alertify.min.css" rel="stylesheet"> 
  <!-- Custom styles for this template -->
  <link href="css/modern-business.css" rel="stylesheet">
  <style>
@import url('https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,700,700i,900&display=swap');
</style>
</head>

<body class="white">

  <?php include("includes/menu.php");?>

  <!-- Page Content -->
  <div class="container">
	<form name="contacto" id="contacto" method="POST" action="#">  
    <div class="row">
		 <div class="col-md-7 textoIntro green">
			<h1 class="my-4">Contactar con nosotros</h1>
			 <p><input type="text" class="form form-control" placeholder="Nombre" name="nombre"></p>
			 <p><input type="email" class="form form-control" placeholder="Email" name="email"> </p>
			 <p><textarea name="mensaje" class="form form-control" placeholder="Tu mensaje..." name="mensaje"></textarea></p>
			 <p><input type="checkbox" value="1" name="condiciones"> He leido y acepto la política de privacidad</p>
		  </div>
		  <div class="col-md-1"></div>
		  <div class="col-md-4">
			  <p><img src="img/contacto.png"></p>
			  <p><input type="button" class="btn btn-success" value="ENVIAR" name="btncontacto" id="btncontacto"></p>
		  </div>
    </div>
	</form>  
	  
	  
  </div>
  <!-- /.container -->
  <?php include("includes/footer.php");?>
  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="js/alertify.min.js"></script>	
  <script>
	  $("#btncontacto").click(function() {
		
		  var formulario=$("#contacto").serialize();
		  $.ajax({
		   type: "POST",
		   dataType: 'json', 
		   url: "ajax/envio_contacto.php",
		   data: formulario,
		   success:function(respuesta){	  
			if (respuesta.contestacion==1)
			  alertify.error(respuesta.mensaje);
			else   
			{
		      alertify.success(respuesta.mensaje);
			  setTimeout(function(){ location.reload(); }, 3000);
			}
		  }

		 });
		  
	  })
	</script>
</body>

</html>
