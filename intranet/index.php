<!DOCTYPE html>
<html lang="es">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Modern Business - Start Bootstrap Template</title>

  <!-- Bootstrap core CSS -->
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="../css/modern-business.css" rel="stylesheet">
  <style>
   @import url('https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,700,700i,900&display=swap');
</style>
  <style>
	  ::placeholder {
    font-size: 12px;
}
	</style>
</head>

<body class="page-presupuestador"> 

  <!-- Page Content -->
  <div class="container">
   <div class="centrado">
	<div class="row">
	  <div class="col-md-12 paddingbottom0">
       <img src="../img/area_privada.png" width="302" style="max-width:100%" class="marginbottom25">
	  </div>
	</div>
	  
	<div class="row"> 
	 <div class="col-md-12">
     	<form name="login" id="login" method="POST" action="#">
			<p><input type="text" id="email" class="form form-control" placeholder="EMAIL"></p>
			<p><input type="password" id="password" class="form form-control" placeholder="CONTRASEÑA">
			<p class="font13">Sólo usuarios profesionales registrados</p>
			<p class="textRight"><input type="button" class="btn-redondeado" value="Entrar" id="login_ok"></p>
		</form>	
	 </div>
	</div>
   </div>
  </div>
  <!-- /.container -->
  <!-- Bootstrap core JavaScript -->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
<script>
$(document).ready(function() {
	
$( "#login_ok" ).click(function() {
				
		 var email=document.getElementById("email").value;
		 var password=document.getElementById("password").value;
		 $.ajax({
		  type: "POST",
		  dataType: 'json', 
		  url: "ajax/comprobar_login.php",
		  data: {email:email,password:password},
		  success:function(respuesta){	
		 	if (respuesta.contestacion == 0)
		 	 window.location.assign("main.php");
			else
			 alert(respuesta.mensaje);
		  }

		}); // fin $.ajax 

	 });
	
	
})	
</script>	
</html>
