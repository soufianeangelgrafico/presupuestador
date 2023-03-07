<?php
include("conexion.php");
$fecha=date("Y-m-d");

$mysqli->query("UPDATE calendario SET ocupado=1 WHERE fecha <= '$fecha'");
?>