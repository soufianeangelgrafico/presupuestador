<?php
include("../conexion.php");
$mensaje = new stdClass();

$data = $_POST['photo'];
$id_plano = $_POST['id'];

list($type, $data) = explode(';', $data);
list(, $data)      = explode(',', $data);
$data = base64_decode($data);

mkdir($_SERVER['DOCUMENT_ROOT'] . "/presupuestador_fotos_equipamiento");
file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/presupuestador_fotos_equipamiento/".time().'.png', $data);
$url=$_SERVER['DOCUMENT_ROOT'] . "/presupuestador_fotos_equipamiento/".time().'.png';
//Url ejemplo: /var/www/vhosts/rehubik.com/httpdocs/presupuestador_fotos_estado_actual/1633688347.png
$url=str_replace("/var/www/vhosts/rehubik.com/httpdocs","https://rehubik.com",$url);

// $mysqli->query("ALTER TABLE planos MODIFY imagen_dibujo_reformado $url");
$mysqli->query("UPDATE planos SET imagen_equipamiento = '$url' WHERE id = $id_plano");
// $mensaje->id=$mysqli->insert_id;

// setcookie("idplano",$mensaje->id, time()+3600); 

echo json_encode($id_plano);

die;
?>