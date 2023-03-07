<?php
require_once("../../wp-load.php");
$current_user = wp_get_current_user();

/*
Current user devuelve algo como esto
WP_User Object ( [data] => stdClass Object ( [ID] => 1 [user_login] => rehubik [user_pass] => $P$BTfJ3TFDHS/WH?eBnX8ese6w4fTGm4z0 [user_nicename] => rehubik [user_email] => hector@angelgrafico.com [user_url] => https://rehubik.com [user_registered] => 2020-07-08 16:48:23 [user_activation_key] => [user_status] => 0 [display_name] => rehubik [tienda] => 2601 ) [ID] => 1 [caps] => Array ( [administrator] => 1 ) [cap_key] => rehubik_wp_capabilities [roles] => Array ( [0] => administrator ) [allcaps] => Array ( [switch_themes] => 1 [edit_themes] => 1 [activate_plugins] => 1 [edit_plugins] => 1 [edit_users] => 1 [edit_files] => 1 [manage_options] => 1 [moderate_comments] => 1 [manage_categories] => 1 [manage_links] => 1 [upload_files] => 1 [import] => 1 [unfiltered_html] => 1 [edit_posts] => 1 [edit_others_posts] => 1 [edit_published_posts] => 1 [publish_posts] => 1 [edit_pages] => 1 [read] => 1 [level_10] => 1 [level_9] => 1 [level_8] => 1 [level_7] => 1 [level_6] => 1 [level_5] => 1 [level_4] => 1 [level_3] => 1 [level_2] => 1 [level_1] => 1 [level_0] => 1 [edit_others_pages] => 1 [edit_published_pages] => 1 [publish_pages] => 1 [delete_pages] => 1 [delete_others_pages] => 1 [delete_published_pages] => 1 [delete_posts] => 1 [delete_others_posts] => 1 [delete_published_posts] => 1 [delete_private_posts] => 1 [edit_private_posts] => 1 [read_private_posts] => 1 [delete_private_pages] => 1 [edit_private_pages] => 1 [read_private_pages] => 1 [delete_users] => 1 [create_users] => 1 [unfiltered_upload] => 1 [edit_dashboard] => 1 [update_plugins] => 1 [delete_plugins] => 1 [install_plugins] => 1 [update_themes] => 1 [install_themes] => 1 [update_core] => 1 [list_users] => 1 [remove_users] => 1 [promote_users] => 1 [edit_theme_options] => 1 [delete_themes] => 1 [export] => 1 [manage_woocommerce] => 1 [view_woocommerce_reports] => 1 [edit_product] => 1 [read_product] => 1 [delete_product] => 1 [edit_products] => 1 [edit_others_products] => 1 [publish_products] => 1 [read_private_products] => 1 [delete_products] => 1 [delete_private_products] => 1 [delete_published_products] => 1 [delete_others_products] => 1 [edit_private_products] => 1 [edit_published_products] => 1 [manage_product_terms] => 1 [edit_product_terms] => 1 [delete_product_terms] => 1 [assign_product_terms] => 1 [edit_shop_order] => 1 [read_shop_order] => 1 [delete_shop_order] => 1 [edit_shop_orders] => 1 [edit_others_shop_orders] => 1 [publish_shop_orders] => 1 [read_private_shop_orders] => 1 [delete_shop_orders] => 1 [delete_private_shop_orders] => 1 [delete_published_shop_orders] => 1 [delete_others_shop_orders] => 1 [edit_private_shop_orders] => 1 [edit_published_shop_orders] => 1 [manage_shop_order_terms] => 1 [edit_shop_order_terms] => 1 [delete_shop_order_terms] => 1 [assign_shop_order_terms] => 1 [edit_shop_coupon] => 1 [read_shop_coupon] => 1 [delete_shop_coupon] => 1 [edit_shop_coupons] => 1 [edit_others_shop_coupons] => 1 [publish_shop_coupons] => 1 [read_private_shop_coupons] => 1 [delete_shop_coupons] => 1 [delete_private_shop_coupons] => 1 [delete_published_shop_coupons] => 1 [delete_others_shop_coupons] => 1 [edit_private_shop_coupons] => 1 [edit_published_shop_coupons] => 1 [manage_shop_coupon_terms] => 1 [edit_shop_coupon_terms] => 1 [delete_shop_coupon_terms] => 1 [assign_shop_coupon_terms] => 1 [manage_bookings_settings] => 1 [manage_bookings_timezones] => 1 [manage_bookings_connection] => 1 [edit_bookable_person] => 1 [read_bookable_person] => 1 [delete_bookable_person] => 1 [edit_bookable_persons] => 1 [edit_others_bookable_persons] => 1 [publish_bookable_persons] => 1 [read_private_bookable_persons] => 1 [delete_bookable_persons] => 1 [delete_private_bookable_persons] => 1 [delete_published_bookable_persons] => 1 [delete_others_bookable_persons] => 1 [edit_private_bookable_persons] => 1 [edit_published_bookable_persons] => 1 [edit_bookable_resource] => 1 [read_bookable_resource] => 1 [delete_bookable_resource] => 1 [edit_bookable_resources] => 1 [edit_others_bookable_resources] => 1 [publish_bookable_resources] => 1 [read_private_bookable_resources] => 1 [delete_bookable_resources] => 1 [delete_private_bookable_resources] => 1 [delete_published_bookable_resources] => 1 [delete_others_bookable_resources] => 1 [edit_private_bookable_resources] => 1 [edit_published_bookable_resources] => 1 [edit_wc_booking] => 1 [read_wc_booking] => 1 [delete_wc_booking] => 1 [edit_wc_bookings] => 1 [edit_others_wc_bookings] => 1 [publish_wc_bookings] => 1 [read_private_wc_bookings] => 1 [delete_wc_bookings] => 1 [delete_private_wc_bookings] => 1 [delete_published_wc_bookings] => 1 [delete_others_wc_bookings] => 1 [edit_private_wc_bookings] => 1 [edit_published_wc_bookings] => 1 [edit_global_availability] => 1 [read_global_availability] => 1 [delete_global_availability] => 1 [edit_global_availabilities] => 1 [delete_global_availabilities] => 1 [cfdb7_access] => 1 [loco_admin] => 1 [wpseo_manage_options] => 1 [administrator] => 1 ) [filter] => [site_id:WP_User:private] => 1 )
*/

$allowed_roles = array('administrator');

	
if (!is_user_logged_in()) {
?>
<h2>Debes iniciar sesión para ver esta página</h2>
<?php
}
else if (array_intersect($allowed_roles, $current_user->roles))
{
?>
	<html lang="es">

	<head>

	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	  <meta name="description" content="">
	  <meta name="author" content="">

	  <title>Rehubic</title>

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
		   <p class="textCenter"><img src="../img/area_privada.png" width="302" style="max-width:100%" class="marginbottom25 margintop25"></p>
		  </div>

		  <div class="col-md-9" style="background:white;">

			 <div class="row margintop25 marginbottom25">
				<div class="col-md-6">
					<p><img src="../iconos/icono_verificador.png"> Hola, <b><?php echo $current_user->user_login;?></b></p>
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

			  <?php 
 				if ($current_user->ID == 1)
				{
					include("panel_admin.php");
				}
 				else 
				{
					include("panel_verificador.php");
				}
			  /*
			   if ($obj_admin->tipo == 0)
			   {
				  include("panel_verificador.php");
			   }
			   else if ($obj_admin->tipo == 1)
			   {
				  include("panel_controler.php"); 
			   }
			   else if ($obj_admin->tipo == 2)
			   {
				   include("panel_supervisor.php");
			   }
			   else if ($obj_admin->tipo == 3)
			   {
				   include("panel_admin.php");
			   }
			   */
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
					 window.location.assign("http://angelgrafico.com/rehubic/intranet/ver_presupuesto.php?id="+respuesta.id);
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

		 function cambiaEstado(estado,id_presupuesto)
		 {
			var estado=estado;
			var id_presupuesto=id_presupuesto;

			 $.ajax({
				  type: "POST",
				  dataType: 'json',  
				  url: "ajax/presupuesto_cambiar_estado.php",
				  data: {estado:estado,id_presupuesto:id_presupuesto},
				  success:function(respuesta){	
					alert(respuesta.mensaje);
					location.reload();
				  }

			  }); // fin $.ajax 

		 }
	  </script>
	</body>

	</html>
<?php
}
else
{
?>
  <h2>No tienes permisos para ver esta página</h2>
<?php
}
?>
