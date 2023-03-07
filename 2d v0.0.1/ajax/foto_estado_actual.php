<?php
include ("../conexion.php");

$_GET["id_presupuesto"] = (int)$_GET["id_presupuesto"];
				
    //Dibujo estado actual para mostrar en la ventana
    $result_estado_actual = $mysqli->query("SELECT * FROM planos WHERE id=349");
    $obj_estado_actual = $result_estado_actual->fetch_object();

    if (!$result_dibujo_actual->num_rows)
    {
        //Si no tiene dibujo actual, saco el dibujo actual del padre
        $result_dibujo_actual=$mysqli->query("SELECT png_estado_actual FROM clientes WHERE id_presupuesto_modificado=".$_GET["id_presupuesto"]." AND png_estado_actual != '' ");
    }

    $png_estado_actual = $obj_estado_actual->imagen_dibujo_actual;

    $observaciones = $obj_estado_actual->observaciones;
    $altura_pared = $obj_estado_actual->altura_techo_reformado;

// $respuesta = new stdClass();

// $id=(int)$_POST["id"];
// //$dibujo=$_POST["dibujo"];
// $observaciones_texto=$_POST["observaciones_texto"];

// $mysqli->query("SELECT png_estado_actual FROM clientes WHERE id_presupuesto_modificado=".$_GET["id_presupuesto"]." AND png_estado_actual != '' ");

// $respuesta->mensaje="Guardado";

// echo json_encode($respuesta);
echo json_encode($png_estado_actual);

?>