<?php
include("conexion.php");
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
				if (!isset($_COOKIE["idplano"])) {
				?>
					<p>No hemos podido calcular tu presupuesto. Tu sesión ha caducado.</p>
					<?php
				} else {
					$idplano = $_COOKIE["idplano"];
					$suma_precio = 0;
					$limpieza = array("Pared A", "Pared B", "Pared C", "Pared D", "m");

					$result = $mysqli->query("SELECT * FROM planos_articulos_compuestos WHERE id_plano=$idplano");

					$result_plano = $mysqli->query("SELECT * FROM planos WHERE id=$idplano");

					while ($arr_result_plano = $result_plano->fetch_array()) {
						$altura_pared = $arr_result_plano["altura_techo_reformado"];
						$metros_cuadrados = $arr_result_plano["m2"];
					}

					if ($result->num_rows) {
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
									$id_articulo_simple = $arr_result["id_articulo_simple"];
									$paredes = $arr_result["pared"];
									$longitud_pared = $arr_result["longitud"];
									$unidades = $arr_result["unidades"];
									$metros_lineales = $arr_result["metros_lineales"];

									$result_compuesto = $mysqli->query("SELECT * FROM articulos_compuestos WHERE id=$id_articulo_compuesto");

									while ($arr_result_compuesto = $result_compuesto->fetch_array()) {
										$nombre_articulo_compuesto = $arr_result_compuesto["nombre"];
										$tipo = $arr_result_compuesto["tipo"];
										$imagen = $arr_result_compuesto["imagen"];
										$id = $arr_result_compuesto["id_imagen"];

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
												<?php
												if (!is_null($id_articulo_simple)) {

													$result_simple = $mysqli->query("SELECT * FROM articulos_simples WHERE id=$id_articulo_simple");

													while ($arr_result_simple = $result_simple->fetch_array()) {
												?>
														<br /> * <?php echo $arr_result_simple["codigo"] . " - " . $arr_result_simple["descripcion"]; ?>
												<?php
													}
												}
												?>
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
													if ($id == "picado_desescombro_falso_techo" || $id == "picado_desescombro_solado" || $id == "colocacion_solado" || $id == "falso_techo") {
														//El precio se calcula sacando el área horizontal del plano
														//  $precio=($metros_ancho_reformado*$metros_alto_reformado)*$arr_result_precio["precio"];
														$precio = $metros_cuadrados * $arr_result_precio["precio"];
														echo " ==> 1, ";
													} else if ($id == "picado_desescombro_rodapie" || $id == "colocacion_zocalo" || $id == "picado_desescombro_rodapie") {
														$precio = $longitud_pared * $arr_result_precio["precio"];
														echo " ==> 2, ";
													} else if ($paredes != "") {
														if ($id == "alicatado_paredes" || $id == "colocacion_solado") {
															//m2 alicatado calculados x 1,15
															$precio = $metros_cuadrados * $arr_result_precio["precio"];
															$precio = $precio * 1.15;
															echo " ==> 3, ";
														} else if ($id == "colocacion_zocalo") {
															$precio = ($longitud_pared * $arr_result_precio["precio"]);
															$precio = $precio * 1.15;
															echo " ==> 4, ";
														} else {
															$precio = ($longitud_pared * $arr_result_precio["precio"]) * $altura_pared;
															echo "longitud pared: $longitud_pared, result precio:".$arr_result_precio['precio'].", altura pared: $altura_pared ==> 5, ";  
														}
													} else if ($metros_lineales != 0){
														$precio = $arr_result_precio["precio"] * $metros_lineales;
														echo " ==> 6, ";
													}
													else{
														$precio = $arr_result_precio["precio"] * $unidades;
														echo " ==> 7, ";
													}
												}
												$suma_precio = $suma_precio + $precio;
												echo round($precio, 2);
												?>&euro;
											</td>
										</tr>
										<?php
									}
								}

								$result_material = $mysqli->query("SELECT * FROM planos_materiales WHERE id_plano=$idplano");

								if ($result_material->num_rows) {
									while ($arr_result_material = $result_material->fetch_array()) {
										$referencia_material = $arr_result_material["referencia_material"];
										$paredes = $arr_result_material["paredes_reformado"];
										$longitud_pared = $arr_result_material["longitud_pared_reformado"];
										$unidades = $arr_result_material["unidades_reformado"];

										if ($unidades == 0)
											$unidades = 1; //unidad minima

										$result_precios_material = $mysqli->query("SELECT * FROM materiales WHERE referencia='$referencia_material'");

										if ($result_precios_material->num_rows) {
											while ($arr_result_precios_material = $result_precios_material->fetch_array()) {
												$modelo = $arr_result_precios_material["modelo"];
												$precio = $arr_result_precios_material["pvp"];
											}
										} else {
											$modelo = "";
											$precio = "";
										}
										if (strpos($referencia_material, "IKEA") === false) {
										?>
											<tr>
												<th scope="row">
													<?php echo str_replace("_", " ", $referencia_material); ?>
													<?php
													if ($modelo != "")
														echo ": " . utf8_encode($modelo);
													?>
												</th>
												<td>Material</td>
												<td>
													<?php
													if ($referencia_material == "REJUNTE_PARED" || $referencia_material == "REJUNTE_SUELO") {
														//la fórmula sería: m2 alicatado calculados en el Paso 3 x 1,15
														$metros_cuadrados = $longitud_pared * $altura_pared;

														$unidades = ceil($metros_cuadrados / 10);

														echo $unidades;
													?>
														unidades para la <?php echo $paredes; ?>
													<?php
													} else {
														echo $unidades;
													?>
														unidades
													<?php
													}
													?>
												</td>
												<td>
													<?php
													if ($precio != "") {

														$suma_precio = $suma_precio + $precio;
														echo $precio . "€";
													}
													?>
												</td>
											</tr>
								<?php
										}
									}
								}
								?>
								<tr style="text-align:right;font-size:14px;">
									<th colspan='4'>* PRECIO FINAL: <?php echo round($suma_precio, 2); ?>&euro;</th>
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