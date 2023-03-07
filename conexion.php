<?php
$mysqli = new mysqli('localhost', 'admin_rehubik', 'Rehubic2018', 'admin_rehubik');

if ($mysqli->connect_error) {
    die('Error de conexión: ' . $mysqli->connect_error);
}

?>