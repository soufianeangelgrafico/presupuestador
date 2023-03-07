<?php
$mysqli = new mysqli("localhost","admin_rehubik","Rehubic2018","admin_rehubik");

if (!isset($_COOKIE["random"]))
  setcookie("random",md5(microtime()), time()+3600, "/"); 	

// Check connection
if ($mysqli -> connect_errno) {
  echo "Fallo al conectar con la base de datos: " . $mysqli -> connect_error;
  exit();
}

$sesion_temporal=$_COOKIE["random"];
$data = $_POST['photo'];
list($type, $data) = explode(';', $data);
list(, $data)      = explode(',', $data);
$data = base64_decode($data);

mkdir($_SERVER['DOCUMENT_ROOT'] . "/presupuestador_fotos_estado_actual");
file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/presupuestador_fotos_estado_actual/".time().'.png', $data);
$url=$_SERVER['DOCUMENT_ROOT'] . "/presupuestador_fotos_estado_actual/".time().'.png';
//Url ejemplo: /var/www/vhosts/rehubik.com/httpdocs/presupuestador_fotos_estado_actual/1633688347.png
$url=str_replace("/var/www/vhosts/rehubik.com/httpdocs","https://rehubik.com",$url);

$mysqli->query("INSERT sesiones_temporales(id_articulo_compuesto,sesion,png_estado_actual) VALUES(NULL,'$sesion_temporal','$url')");


die;
?>