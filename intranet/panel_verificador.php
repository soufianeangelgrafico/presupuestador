<?php
///  ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
///  ║ //zra9                                               Panel Verificador                                                   .     ///    ║
///  ╠═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════╣
///  ║     //    muestra una lista de enlaces a presupuestos y opciones para ver un PDF, ver el presupuesto en línea, exportar        ///    ║
///  ║     //  el presupuesto a un archivo de Excel (.xlsx) o exportar una lista de materiales a un archivo de Excel.                 ///    ║
///  ║     //  La página web muestra un título ("LISTADO CITAS") y luego un bloque de código que realiza una consulta				  ///    ║
///  ║     //  a una base de datos para obtener información sobre los presupuestos que han sido finalizados. Para cada     		      ///    ║
///  ║     //  presupuesto encontrado, se muestra un enlace para ver el PDF, ver el presupuesto en línea, exportar el presupuesto     ///    ║
///  ║     //  a Excel o exportar la lista de materiales a Excel.     																  ///    ║
///  ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
?>
<div class="row">
	<div class="col-md-12">
		<h5>LISTADO CITAS</h5>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<?php
		$result = $mysqli->query("SELECT id,id_modificado FROM planos WHERE finalizado=1");

		while ($arr_result = $result->fetch_array()) { ?>
			<p>
				<a href="https://rehubik.com/presupuestador/2d_v0.0.2/?id_presupuesto=<?php echo $arr_result["id"]; ?>" target="_blank">
					PRESUPUESTO #<?php echo $arr_result["id"]; ?>
					<?php
					if (!is_null($arr_result["id_modificado"])) { ?>
						(Modificación del presupuesto #<?php echo $arr_result["id_modificado"]; ?>)
					<?php	} ?>
				</a>
			</p>
			<p>
				<a target="_blank" href="https://rehubik.com/generar_pdf.php?id=<?php echo $arr_result["id"]; ?>">VER PDF</a> |
				<a href="https://rehubik.com/presupuestador/2d_v0.0.2/?id_presupuesto=<?php echo $arr_result["id"]; ?>" target="_blank">VER PRESUPUESTO</a> |
				<a href="https://rehubik.com/exportar_xlsx.php?id_presupuesto=<?php echo $arr_result["id"]; ?>">EXPORTAR UDO</a> |
				<a href="https://rehubik.com/exportar_materiales_xlsx.php?id_presupuesto=<?php echo $arr_result["id"]; ?>">EXPORTAR MATERIALES</a>
			</p>
			<hr />
		<?php	} ?>
	</div>
</div>