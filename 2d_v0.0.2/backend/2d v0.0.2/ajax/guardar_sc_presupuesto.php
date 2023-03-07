<?php
include("../conexion.php");
$idplano=$_COOKIE["idplano"];
$id_presupuesto=(int) $_GET["id_presupuesto"];
$respuesta = new stdClass();
$respuesta->mensaje="";

$result = $mysqli->query("SELECT * FROM sincodigos WHERE id_presupuesto=$id_presupuesto");
$result_total_paredes = $mysqli->query("SELECT total_paredes FROM planos_articulos_compuestos WHERE id_plano = $id_presupuesto ORDER BY id ASC LIMIT 1");
$obj_total_paredes = $result_total_paredes->fetch_object();


if ($result->num_rows)
{

    while ($arr_result = $result->fetch_array())
    {
        
        $codigo=$arr_result["codigo"];
        $descripcion=$arr_result["descripcion"];
        $precio=$arr_result["precio"];
        
        $result_insert = $mysqli->query("INSERT articulos_simples(id_articulo_compuesto,tienda,codigo,descripcion,unidad,visible_cliente,precio) 
                                         VALUES (47,2701,'$codigo','$descripcion','Uni.',1,'$precio');");

        if ($result_insert)
        {
            $id_simple=$mysqli->insert_id;

            $mysqli->query("DELETE sincodigos.* FROM sincodigos WHERE id_presupuesto=$id_presupuesto");

            $mysqli->query("INSERT planos_articulos_compuestos(id_plano,id_articulo_compuesto,id_articulo_simple,total_paredes,unidades) 
                            VALUES($idplano,47,$id_simple,'$obj_total_paredes->total_paredes',1)");


        }

    }


  $respuesta->mensaje="S/C Añadidos al presupuesto";
}

echo json_encode($respuesta);
?>