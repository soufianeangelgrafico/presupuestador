<?php
include("../conexion.php");

$presupuesto=(int)$_GET["presupuesto"];


if ($presupuesto == 0)
{
  //Presupuesto nuevo
  $idplano=$_COOKIE["idplano"];
}
else 
{

	//Presupuesto modificado
  //Elimino cookie actual y guardo la nueva
  unset($_COOKIE["idplano"]);
  
	$mysqli->query("INSERT INTO planos(html_dibujo_actual,imagen_dibujo_actual,altura_techo_actual, observaciones_dibujo_actual,html_dibujo_reformado,altura_techo_reformado,observaciones,m2) SELECT html_dibujo_actual,imagen_dibujo_actual,altura_techo_actual, observaciones_dibujo_actual,html_dibujo_reformado,altura_techo_reformado,observaciones,m2 FROM planos WHERE id =".$presupuesto);
	$idplano=$mysqli->insert_id;
	//La asigno a la cookie para los siguientes procesos (guardado de materiales, trabajos a realizar, etc..)
	//$_COOKIE["idplano"]=$idplano; 
	setcookie("idplano", $idplano, time()+3600,'/');
}




$respuesta = new stdClass();


// LISTA NEGRA Y LIMPIEZA 
$very_bad = array("CONCAT","concat","password","PASSWORD","VERSION","version","VALUES","values","NULL","GROUP BY","group by","HEX","hex","WAITFOR","waitfor","BENCHMARK","benchmark","MD5","SHA1","1=1","1=2","delete","update","insert","drop","select","DELETE","UPDATE","INSERT","DROP","SELECT","(","\x00","\x1a","\'","to:","cc:","bcc:","content-type:","mime-version:","multipart-mixed:","content-transfer-enconding:","\r","\n","%0a","%0d",";","=","$","%","<",">","script","@","*","[","]","{","}","^","html","url","_","lyubovnaya");
$limpieza = array("Pared A","Pared B","Pared C","Pared D","Pared E","Pared F","Pared G","Pared H","Pared I","Pared J","Pared K","Pared L","Pared M","Pared N","Pared O","Pared P","Pared Q","Pared R","Pared S","Pared T","Pared U","Pared V","Pared W","Pared X","Pared Y","Pared Z","m");


$altura_techo=$_POST["altura_techo"];
$metros_cuadrados=$_POST["metros_cuadrados"];
$observaciones=$_POST["observaciones"];
$dibujo=addslashes($_POST["dibujo"]);

//Si el presupuesto NO es 0, quiere decir que es una modificación de uno ya existente, por ello, actualizo el campo de id_modificado
if ($presupuesto == 0)
{
 $mysqli->query("UPDATE planos SET html_dibujo_reformado='$dibujo',altura_techo_reformado='$altura_techo',observaciones='$observaciones',m2='$metros_cuadrados',finalizado=1 WHERE id=$idplano");
}
else 
{
  if ($dibujo == "null" || $dibujo == null)
  {
	//No ha modificado el dibujo original. LocalStorage almacena null
	$mysqli->query("UPDATE planos SET altura_techo_reformado='$altura_techo',observaciones='$observaciones',m2='$metros_cuadrados',finalizado=1,id_modificado=$presupuesto WHERE id=$idplano");
  }
  else 
  {
    $mysqli->query("UPDATE planos SET html_dibujo_reformado='$dibujo',altura_techo_reformado='$altura_techo',observaciones='$observaciones',m2='$metros_cuadrados',finalizado=1,id_modificado=$presupuesto WHERE id=$idplano");
  }
}

$respuesta->mensaje="Plano actualizado";


echo json_encode($respuesta);	

?>