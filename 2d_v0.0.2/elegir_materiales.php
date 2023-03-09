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
		<div class="row">
			<div class="col-md-12 ">
				<h2 class="marginbottom25" style="margin-top:50px;">Personaliza tu reforma / Materiales</h2>
			</div>
			<div class="col-md-6 ">
				<ul class="cuadrados_estilo">
					<li>
						<div class="texto-li centrado">PAVIMENTOS</div>
					</li>
					<ul style="margin: 0px;padding: 0;padding-bottom: 15px;list-style: none;">
						<?php
						$result = $mysqli->query("SELECT * FROM materiales WHERE rvpv='Pavimento'");
						while ($arr_result = $result->fetch_array()) {
						?>
							<li style="padding:2px;"><img class="elemento_material" id="<?php echo $arr_result["referencia"]; ?>" width="75" src="<?php echo $arr_result["foto"]; ?>"> <?php echo $arr_result["modelo"]; ?> (<?php echo $arr_result["pvp"]; ?>&euro;)</li>
						<?php
						}
						$result->free();
						?>
					</ul>
				</ul>
			</div>

			<div class="col-md-6 ">
				<ul class="cuadrados_estilo">
					<li>
						<div class="texto-li centrado">REVESTIMIENTOS</div>
					</li>
					<ul style="margin: 0px;padding: 0;padding-bottom: 15px;list-style: none;">
						<?php
						$result = $mysqli->query("SELECT * FROM materiales WHERE rvpv='Revestimiento'");
						while ($arr_result = $result->fetch_array()) {
						?>
							<li style="padding:2px;"><img class="elemento_material" id="<?php echo $arr_result["referencia"]; ?>" width="75" src="<?php echo $arr_result["foto"]; ?>"> <?php echo $arr_result["modelo"]; ?> (<?php echo $arr_result["pvp"]; ?>&euro;)</li>
						<?php
						}
						$result->free();
						?>
					</ul>
				</ul>
			</div>

			<div class="col-md-6 ">
				<ul class="cuadrados_estilo">
					<li>
						<div class="texto-li centrado">VENTANAS</div>
					</li>

					<ul style="margin: 0px;padding: 0;padding-bottom: 15px;list-style: none;">
						<?php
						$result = $mysqli->query("SELECT * FROM materiales WHERE rvpv='Ventanas'");
						while ($arr_result = $result->fetch_array()) {
						?>
							<li style="padding:2px;"><img class="elemento_material" id="<?php echo $arr_result["referencia"]; ?>" width="75" src="<?php echo $arr_result["foto"]; ?>"> <?php echo $arr_result["modelo"]; ?> (<?php echo $arr_result["pvp"]; ?>&euro;)</li>
						<?php
						}
						$result->free();
						?>
					</ul>
				</ul>
			</div>

			<div class="col-md-6 ">
				<ul class="cuadrados_estilo">
					<li>
						<div class="texto-li centrado">PUERTAS</div>
					</li>

					<ul style="margin: 0px;padding: 0;padding-bottom: 15px;list-style: none;">
						<?php
						$result = $mysqli->query("SELECT * FROM materiales WHERE rvpv='Puertas'");
						while ($arr_result = $result->fetch_array()) {
						?>
							<li style="padding:2px;"><img class="elemento_material" id="<?php echo $arr_result["referencia"]; ?>" width="75" src="<?php echo $arr_result["foto"]; ?>"> <?php echo $arr_result["modelo"]; ?> (<?php echo $arr_result["pvp"]; ?>&euro;)</li>
						<?php
						}
						$result->free();
						?>
					</ul>
				</ul>
			</div>

			<div class="col-md-6 ">
				<ul class="cuadrados_estilo">
					<li>
						<div class="texto-li centrado">ILUMINACIÓN</div>
					</li>
				</ul>
			</div>
			<div class="col-md-6 ">
				<ul class="cuadrados_estilo">
					<li>
						<div class="texto-li centrado">MECANISMOS ELÉCTRICOS</div>
					</li>
				</ul>
			</div>

			<div class="col-md-6 ">
				<ul class="cuadrados_estilo">
					<li>
						<div class="texto-li centrado">CANTONERAS</div>
					</li>
				</ul>
			</div>

			<div class="col-md-6 ">
				<ul class="cuadrados_estilo">
					<li>
						<div class="texto-li centrado">BORADOS</div>
					</li>
				</ul>
			</div>

			<div class="col-md-6 ">
				<ul class="cuadrados_estilo">
					<li>
						<div class="texto-li centrado">CALENTADOR</div>
					</li>
				</ul>
			</div>

			<div class="col-md-6 ">
				<ul class="cuadrados_estilo">
					<li>
						<div class="texto-li centrado">TERMOS</div>
					</li>
				</ul>
			</div>

			<div class="col-md-6 ">
				<ul class="cuadrados_estilo">
					<li>
						<div class="texto-li centrado">CALDERA</div>
					</li>
				</ul>
			</div>

			<div class="col-md-6 ">
				<ul class="cuadrados_estilo">
					<li>
						<div class="texto-li centrado">RADIADORES</div>
					</li>
				</ul>
			</div>

			</ul>
			<div class="col-md-12">
				<p><input type="button" id="btnMateriales" class="btn btn-success" value="CONTINUAR" style="background:#74941d;"></p>
			</div>
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
				}
			});
		})

		$(".elemento_material").click(function() {
			var id = this.id;
			if ($("#" + id).hasClass("selected"))
				$("#" + id).removeClass("selected");
			else
				$("#" + id).addClass("selected");
		})

		$("#btnMateriales").click(function() {

			var id = "";
			var entro = false;

			$(".elemento_material.selected").each(function() {
				entro = true;
				id = this.id; //Paso el ID del material

				$.ajax({
					type: "POST",
					dataType: 'json',
					async: false,
					url: "ajax/elegir_materiales_presupuesto.php",
					data: {
						id: id
					},
					success: function(respuesta) {
						//alert("Material añadido con éxito");
					}

				});

			})

			if (!entro)
				alertify.error("Debes seleccionar, al menos, un material")
			else
				window.location.assign("https://rehubik.com/presupuestador/2d/registro_cliente.php");

		})
	</script>
</body>

</html>