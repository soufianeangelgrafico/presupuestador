<?php
session_start();
if (!isset($_SESSION["login"]))
 header("Location:index.php");

include("../conexion.php");
$_SESSION["login"]=(int)$_SESSION["login"];

$result_admin=$mysqli->query("SELECT * FROM administradores WHERE id=".$_SESSION["login"]);


if (!$result_admin->num_rows)
 header("Location:index.php");

$obj_admin = $result_admin->fetch_object();

$id_centro=(int)$_GET["id"];

$result_centro=$mysqli->query("SELECT * FROM centros WHERE id_centro=".$id_centro);
$obj_ikea = $result_centro->fetch_object();
?>
<html lang="es">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Rehubik</title>

  <!-- Bootstrap core CSS -->
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="../css/modern-business.css" rel="stylesheet">
  <style>
   @import url('https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,700,700i,900&display=swap');
</style>
	
	<style>
		hr.separacion {
    border: 1px solid black;
}
		.container {
    max-width: 100% !important;
}
		body {font-size:14px;}
		
		.table td, .table th {
			border-top: 0;
			border-bottom: 1px solid #dee2e6;
		}
		.table-responsive {padding:10px;}
	</style>
</head>

<body class="page-presupuestador"> 
 
  <!-- Page Content -->
  <div class="container">
 
	<div class="row">
	  
	  <div class="col-md-3" style="height:100vh">
       <p class="textCenter"><a href="https://rehubik.com/presupuestador/intranet/main.php"><img src="../img/area_privada.png" width="302" style="max-width:100%" class="marginbottom25 margintop25"></a></p>
	  </div>
		
	  <div class="col-md-9" style="background:white;">
     	
		 <div class="row margintop25 marginbottom25">
			<div class="col-md-6">
				<p><img src="../iconos/icono_verificador.png"> Hola, <b><?php echo $obj_admin->email;?></b></p>
			</div>	
			 <!--
			<div class="col-md-6">
				<div class="codigo_presupuesto">
				  <form name="buscar_presupuesto" id="buscar_presupuesto" method="POST" action="#">	
					<div class="row">
					  <div class="col-md-4">
						  <p class="font18"><b>Código de presupuesto</b></p>
					  </div>
					  <div class="col-md-8">
						<input type="text" name="numero_presupuesto" id="numero_presupuesto" class="transparent form form-control" placeholder="Código presupuesto">
						  <input type="button" style="padding:5px" class="btn btn-success" value="Buscar" id="buscar_presupuesto_ok" id="buscar_presupuesto_ok">
					  </div>
					 </div>
					</form>
				  </div>	
			<span style="position: relative;top: 5px;"><a href="cerrar_sesion.php"><img alt="cerrar sesión" title="Cerrar sesión" src="img/icono_cerrar_sesion.png"></a></span>
		  </div>	
			 -->
		 </div> 
		 <hr class="separacion"/> 
		  <h2>Centro de trabajo <?php echo utf8_encode($obj_ikea->nombre);?></h2>
		  
		  <p>Selecciona un verificador para ver sus citas de forma detallada</p>
		  
		  <?php
		   //Trabajadores de ese centro ikea
		   $result_trabajadores=$mysqli->query("SELECT DISTINCT administradores.* FROM administradores,administradores_centros WHERE administradores_centros.id_administrador = administradores.id AND tipo = 0 AND id_centro=$id_centro");
		  
		   if ($result_trabajadores->num_rows)
		   {
		  ?>
		    <ul>
		  <?php
			 while ($arr_result_trabajador = $result_trabajadores->fetch_array())
			 {
			?>
		  		<li style="margin-bottom:15px;display:inline-block;width:33%"><a href="ver_verificador.php?id_usuario=<?php echo $arr_result_trabajador['id'];?>&id_centro=<?php echo $id_centro;?>"><?php echo utf8_encode($arr_result_trabajador["nombre"])." ".utf8_encode($arr_result_trabajador["apellidos"])."</a><br/>(".$arr_result_trabajador["email"].")";?></li>
		    <?php
			 }
		  ?>
		    </ul>		
		  <?php
		   }
		   else
		   {
		   ?>
		  	<p>No hay verificadores en este centro</p>
		  <?php
		   }
		  ?>
		  
		</div>	<!-- col-md-8 -->
		
	</div>
	  

  </div>
  <!-- /.container -->
  <!-- Bootstrap core JavaScript -->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script>
	 $("#buscar_presupuesto_ok").click(function() {
		 var id_presupuesto=document.getElementById("numero_presupuesto").value;
		 
		 $.ajax({
		  type: "POST",
		  dataType: 'json',  
		  url: "ajax/buscar_presupuesto.php",
		  data: {id_presupuesto:id_presupuesto},
		  success:function(respuesta){	
			 if (respuesta.contestacion == 0)
				 window.location.assign("https://rehubik.com/presupuestador/intranet/ver_presupuesto.php?id="+respuesta.id);
			 else
				 alert(respuesta.mensaje);
		  }

		}); // fin $.ajax 
		 
	 })
	  
	 function eliminarCita(id)
	 {
	   var id_presupuesto=id;
	   if (confirm("Vas a eliminar esta cita. Esta acción es irreversible"))
	   {
		   
		   $.ajax({
			  type: "POST",
			  dataType: 'json',  
			  url: "ajax/eliminar_cita.php",
			  data: {id_presupuesto:id_presupuesto},
			  success:function(respuesta){	
				location.reload();
			  }

		  }); // fin $.ajax 

	   }
		  
	 }
  </script>
</body>

</html>
