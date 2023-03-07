<?php
$mysqli = new mysqli("localhost","admin_rehubik","Rehubic2018","admin_rehubik");
// Check connection
if ($mysqli -> connect_errno) {
    echo "Fallo al conectar con la base de datos: " . $mysqli -> connect_error;
    exit();
  }

?>