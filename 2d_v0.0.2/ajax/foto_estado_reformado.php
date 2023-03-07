<?php
include ("../conexion.php");

$_GET["id_presupuesto"] = (int)$_GET["id_presupuesto"];
				
    //Dibujo estado reformado para mostrar en la ventana
    $result_estado_reformado = $mysqli->query("SELECT * FROM planos WHERE id=349");
    $obj_estado_reformado = $result_estado_reformado->fetch_object();

    if (!$result_dibujo_reformado->num_rows)
    {
        //Si no tiene dibujo reformado, saco el dibujo reformado del padre
        $result_dibujo_reformado=$mysqli->query("SELECT png_estado_reformado FROM clientes WHERE id_presupuesto_modificado=".$_GET["id_presupuesto"]." AND png_estado_reformado != '' ");
    }

    $png_estado_reformado = $obj_estado_reformado->imagen_dibujo_reformado;

    $observaciones = $obj_estado_reformado->observaciones;
    $altura_pared = $obj_estado_reformado->altura_techo_reformado;

// $respuesta = new stdClass();

// $id=(int)$_POST["id"];
// //$dibujo=$_POST["dibujo"];
// $observaciones_texto=$_POST["observaciones_texto"];

// $mysqli->query("SELECT png_estado_reformado FROM clientes WHERE id_presupuesto_modificado=".$_GET["id_presupuesto"]." AND png_estado_reformado != '' ");

// $respuesta->mensaje="Guardado";

// echo json_encode($respuesta);
echo json_encode($png_estado_reformado);

?>