<?php
$mysqli = new mysqli("localhost", "admin_rehubik", "Rehubic2018", "admin_rehubik");

// Check connection
if ($mysqli->connect_errno) {
	echo "Fallo al conectar con la base de datos: " . $mysqli->connect_error;
	exit();
}
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
		::placeholder {
			font-size: 12px !important;
			color: gray !important;
			font-weight: 300 !important;
		}

		.selected {
			border: 3px solid black;
		}

		input[type="text"],
		input[type="email"],
		input[type="file"],
		input[type="number"] {
			border: 1px solid black;
			border-radius: 0;
			font-weight: 300;
			padding: 15px;
			height: 50px;
			margin-bottom: 10px;
		}
	</style>
</head>

<body class="page-presupuestador">

	<!-- Page Content -->
	<div class="container">
		<div class="row" style="padding-top:50px;">
			<div class="col-md-12">
				<h1 class="my-4 colorwhite">Tu presupuesto</h1>
				<h2 class="my-4-subtitulo colorwhite">Te mostramos tu presupuesto según los elementos seleccionados en el plano</h2>
				<?php
				if (!isset($_COOKIE["random"])) {
				?>
					<p>No hemos podido calcular tu presupuesto. Tu sesión ha caducado.</p>
					<?php
				} else {
					$sesion_temporal = $_COOKIE["random"];
					$suma_precio = 0;
					$limpieza = array("Pared A", "Pared B", "Pared C", "Pared D", "m");

					$result = $mysqli->query("SELECT * FROM sesiones_temporales WHERE sesion='$sesion_temporal' AND id_articulo_compuesto IS NOT NULL");

					$result_altura_pared = $mysqli->query("SELECT altura_pared FROM sesiones_temporales WHERE sesion='$sesion_temporal' AND altura_pared != 0 LIMIT 1");

					while ($arr_result_altura_pared = $result_altura_pared->fetch_array())
						$altura_pared = $arr_result_altura_pared["altura_pared"];



					$result_material = $mysqli->query("SELECT sesiones_temporales.referencia_material as referencia_material, sesiones_temporales.paredes as paredes,sesiones_temporales.longitud_pared as longitud_pared, sesiones_temporales.altura_pared as altura_pared,sesiones_temporales.total_paredes as total_paredes,materiales.rvpv as rvpv, materiales.modelo as modelo, materiales.pvp as precio,materiales.mostrar as mostrar FROM sesiones_temporales,materiales WHERE materiales.referencia = sesiones_temporales.referencia_material AND sesion='$sesion_temporal' AND referencia_material IS NOT NULL");


					if ($result->num_rows || $result_material->num_rows) {

					?>
						<table class="table" style="font-size:12px;">
							<thead>
								<tr>
									<th scope="col">Artículo</th>
									<th scope="col">Tipo</th>
									<th scope="col">Ubicación</th>
									<th scope="col">Precio</th>
								</tr>
							</thead>
							<tbody>
								<?php
								while ($arr_result = $result->fetch_array()) {

									$id_articulo_compuesto = $arr_result["id_articulo_compuesto"];
									$paredes = $arr_result["paredes"];
									$longitud_pared = $arr_result["longitud_pared"];
									$unidades = $arr_result["unidades"];
									$metros_lineales = $arr_result["metros_lineales"];

									$result_compuesto = $mysqli->query("SELECT * FROM articulos_compuestos WHERE id=$id_articulo_compuesto");

									while ($arr_result_compuesto = $result_compuesto->fetch_array()) {
										$nombre_articulo_compuesto = $arr_result_compuesto["nombre"];
										$tipo = $arr_result_compuesto["tipo"];
										$imagen = $arr_result_compuesto["imagen"];

										if ($tipo == 1) {
											$tipo = "Demoliciones";
										} else if ($tipo == 2) {
											$tipo = "Instalación eléctrica";
										} else if ($tipo == 3) {
											$tipo = "Instalaciones Equipamiento";
										} else if ($tipo == 4) {
											$tipo = "Revestimientos";
										} else if ($tipo == 5) {
											$tipo = "Gas";
										} else if ($tipo == 6) {
											$tipo = "Carpinteria Interior";
										} else if ($tipo == 7) {
											$tipo = "Carpinteria Exterior";
										} else if ($tipo == 8) {
											$tipo = "Otros servicios";
										} else {
											$tipo = "SC";
										}

								?>

										<tr>
											<th scope="row">
												<?php echo $nombre_articulo_compuesto; ?>

											</th>
											<td><?php echo $tipo; ?></td>
											<td>
												<?php
												if ($paredes != "") {
													echo $paredes;

													if ($longitud_pared != 0)
														echo "<br/> (" . $longitud_pared . " m seleccionados) ";
												} else if ($metros_lineales != 0) {

													echo $metros_lineales . " m.lineales";
												} else {
													if ($unidades == 1)
														echo $unidades . " unidad";
													else
														echo $unidades . " unidades";
												}
												?>
											</td>
											<td>
												<?php
												$result_precio = $mysqli->query("SELECT ROUND(SUM(precio),2) as precio FROM articulos_simples WHERE id_articulo_compuesto=$id_articulo_compuesto AND visible_cliente=1");

												while ($arr_result_precio = $result_precio->fetch_array()) {

													if ($paredes != "") {
														if ($longitud_pared != 0)
															$precio = ($longitud_pared * $arr_result_precio["precio"]) * $altura_pared;
														else {
															$metros = str_replace($limpieza, '', $paredes);
															$precio = ($metros * $arr_result_precio["precio"]) * $altura_pared;
														}
													} else if ($metros_lineales != 0)
														$precio = $arr_result_precio["precio"] * $metros_lineales;
													else
														$precio = $arr_result_precio["precio"] * $unidades;
												}
												$suma_precio = $suma_precio + $precio;
												echo $precio;
												?>&euro;

											</td>
										</tr>

									<?php

									}
								}

								while ($arr_result_material = $result_material->fetch_array()) {
									$referencia_material = $arr_result_material["referencia_material"];
									$rvpv = $arr_result_material["rvpv"];
									$modelo_material = $arr_result_material["modelo"];
									$precio_material = $arr_result_material["precio"];
									$mostrar = $arr_result_material["mostrar"];
									$paredes = $arr_result_material["paredes"];
									$longitud_pared = $arr_result_material["longitud_pared"];
									$altura_pared = $arr_result_material["altura_pared"];
									$total_paredes = $arr_result_material["total_paredes"];
									$suma_precio = $suma_precio + $precio_material;
									?>
									<tr>

										<th scope="row" colspan='2'>
											MATERIAL <?php echo $referencia_material; ?>: <?php echo $modelo_material; ?> (<?php echo $rvpv; ?>)
										</th>
										<td><?php if ($paredes != "") { ?> <?php echo $paredes; ?><br>(<?php echo $longitud_pared; ?>m seleccionados) <?php }
																																					  ?></td>
										<td>
											<?php
											if ($rvpv == "Pavimento") {

												//En total paredes tengo algo como esto:
												//Pared D 8.01 m,Pared C 11.45 m,Pared B 8.01 m,Pared A 11.45 m
												//Debo quedarme con los m para sacar el área (m2) y el precio a calcular
												$paredes = explode(",", $total_paredes);
												$area = 0;
												for ($i = 0; $i < count($paredes); $i++) {
													$metros = str_replace($limpieza, '', $paredes[$i]);
													$area = $area + $metros;
												}

												echo round($area * $altura_pared * 1.15, 2);
											} else {
												echo round($longitud_pared * $altura_pared * $precio_material * 1.15, 2);
											}

											?>€
										</td>
									</tr>
								<?php
								}

								?>
								<tr style="text-align:right;font-size:14px;">
									<th colspan='4'>* PRECIO FINAL: <?php echo $suma_precio; ?>&euro;</th>
								</tr>
							</tbody>
						</table>

						<p style="font-size:13px">* En este precio no está incluido el mobiliario ni los electrodomésticos, sólo la instalación y mano de obra.</p>
					<?php
					} else {
					?>
						<p>No hemos detectado ningún elemento seleccionado en el plano. Vuelve al paso anterior y elige las instalaciones y equipamiento que necesitas para tu reforma.</p>
				<?php
					}
				}
				?>
			</div>


		</div>

		<div class="row">
			<div class="col-md-12 paddingbottom0">
				<h1 class="my-4 colorwhite">Tus datos</h1>
				<h2 class="my-4-subtitulo colorwhite">Rellena este formulario con tus datos, pulsa en "Registrar" y podrás pedir cita previa</b></h2>
				<form method="POST" action="#" name="form_registro" id="form_registro">
					<div class="row">
						<div class="col-md-6">
							<input type="text" name="nombre" class="form-control" placeholder="Nombre">
						</div>
						<div class="col-md-6">
							<input type="text" name="apellidos" class="form-control" placeholder="Apellidos">
						</div>
						<div class="col-md-8">
							<input type="text" name="direccion" class="form-control" placeholder="Dirección">
						</div>
						<div class="col-md-4">
							<input type="number" name="cp" class="form-control" placeholder="CP">
						</div>

						<div class="col-md-4">
							<input type="number" name="telefono" class="form-control" placeholder="Telefono">
						</div>
						<div class="col-md-8">
							<input type="text" name="email" class="form-control" placeholder="Email">
						</div>
						<div class="col-md-12">
							<p>
								<input type="button" class="btn btn-success" value="REGISTRAR Y PEDIR CITA PREVIA" name="btnRegistrar" id="btnRegistrar" style="background:#7EA220">
							</p>

						</div>

					</div>
				</form>
			</div>


		</div>

	</div>
	<script src="jquery.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
	<script>
		$("#btnRegistrar").click(function() {

			var formulario = $("#form_registro").serialize();
			var elementos_marcados = localStorage.getItem('formularios');
			var dibujo2d = localStorage.getItem("history");

			var datos = formulario;
			console.log(datos);
			$.ajax({
				type: "POST",
				dataType: 'json',
				url: "ajax/registrar_usuario.php",
				data: datos,
				success: function(respuesta) {
					alert(respuesta.mensaje);

					if (respuesta.registrado == 1)
						window.location.assign("https://rehubik.com/wp-login.php");
				}

			});



		})
	</script>
</body>

</html>