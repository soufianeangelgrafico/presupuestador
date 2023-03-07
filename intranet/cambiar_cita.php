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

$id_presupuesto=(int)$_GET["id"];


$result=$mysqli->query("SELECT * FROM presupuestos WHERE id_presupuesto=$id_presupuesto");
if (!$result->num_rows)
 header("Location:index.php");

$obj_presupuesto = $result->fetch_object();

?>
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
       <p class="textCenter"><a href="https://rehubik.com/presupuestador/main.php"><img src="../img/area_privada.png" width="302" style="max-width:100%" class="marginbottom25 margintop25"></a></p>
	
	  </div>
		
	  <div class="col-md-9" style="background:#F0F0F0;">
     	
		 <div class="row margintop25 marginbottom25">
			<div class="col-md-6">
				<p><img src="../iconos/icono_verificador.png"> Hola, <b><?php echo $obj_admin->email;?></b></p>
			</div>	
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
		 </div> 
		 <hr class="separacion"/> 
		  <div class="row">
			
			 <div class="col-md-6">
				  <h2>Cita actual</h2>
				 
				  <p>
					  <b>ID presupuesto:</b> <?php echo $obj_presupuesto->id_presupuesto;?><br/>
					 <b>Nombre del cliente:</b> <?php echo $obj_presupuesto->nombre_cliente;?><br/>
					 <b>Dirección:</b> <?php echo $obj_presupuesto->direccion_cliente;?> (<?php echo $obj_presupuesto->poblacion_cliente;?> / <?php echo $obj_presupuesto->provincia_cliente;?>)<br/>
					 <b>Teléfono:</b> <?php echo $obj_presupuesto->telefono_cliente;?><br/>
					 <b>Email:</b> <?php echo $obj_presupuesto->email_cliente;?><br/>
					 <b>Fecha / hora cita previa:</b>
					  
					   <?php
						$result_cita_asignada=$mysqli->query("SELECT calendario.fecha as fecha, horarios_calendario.hora as hora FROM presupuestos_citas,horarios_calendario,calendario WHERE horarios_calendario. id_calendario = calendario.id AND horarios_calendario.id = presupuestos_citas.id_cita AND id_presupuesto=$id_presupuesto");
					    
					    if ($result_cita_asignada->num_rows)
						{
							while ($arr_result_cita_asignada = $result_cita_asignada->fetch_array())
							{

							 echo date("d-m-Y",strtotime($arr_result_cita_asignada["fecha"]))." a las ".$arr_result_cita_asignada["hora"];

							}
						}
				  		?>
					  
					  
					  
				  </p>
			 </div>
			 
			 <div class="col-md-6">
				  <h2>Cambiar cita</h2>

				  <iframe width="330" height="500" style="background-color: transparent;margin:0 auto;" frameborder="0" scrolling="auto" src="../calendario/index.php?admin=1"></iframe>
			 </div>
		 
		  </div>
		
		</div>	<!-- col-md-9 -->
		
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
				 window.location.assign("https://rehubik.com/presupuestador/ver_presupuesto.php?id="+respuesta.id);
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
