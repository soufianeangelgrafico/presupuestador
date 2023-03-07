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


echo htmlspecialchars_decode($obj_presupuesto->dibujo2d);
?>