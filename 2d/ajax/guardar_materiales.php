<?php
include("../conexion.php");

$respuesta = new stdClass();
$idplano=$_COOKIE["idplano"];

if (isset($_POST["elemento"]))
{
	
	$elemento=$_POST["elemento"];
	
	if (isset($_POST["unidades"]))
	 $unidades=(int)$_POST["unidades"];
	else
	 $unidades=1;
	
	//$mysqli->query("INSERT sesiones_temporales(referencia_material,id_articulo_compuesto,sesion,unidades_reformado) VALUES('$elemento',NULL,'$sesion_temporal',$unidades)");
	$mysqli->query("INSERT planos_materiales(id_plano,referencia_material,unidades) VALUES($idplano,'$elemento',$unidades)");
	
	
}
else if (isset($_GET["rejunte_pared"]) && isset($_GET["rejunte_suelo"]))
{
	
	$rejunte_pared=(int)$_GET["rejunte_pared"];
	$rejunte_suelo=(int)$_GET["rejunte_suelo"];
	$total_paredes=$_GET["total_muros"]; //Pared D 3.26 m,Pared C 2.08 m,Pared B 3.25 m,Pared A 2.36 m,
	$altura_paredes=$_GET["altura_paredes"];
	$limpieza = array("Pared A","Pared B","Pared C","Pared D","Pared E","Pared F","Pared G","Pared H","Pared I","Pared J","Pared K","Pared L","Pared M","Pared N","Pared O","Pared P","Pared Q","Pared R","Pared S","Pared T","Pared U","Pared V","Pared W","Pared X","Pared Y","Pared Z","m");
	$total_paredes=substr($total_paredes,0,-1); //Quito última coma
	
	$paredes = explode(",", $total_paredes); //Aquí tengo algo como: Pared A 2.36m
	
	for ($i=0;$i<count($paredes);$i++)
	{
	
		$metros=str_replace($limpieza,'',$paredes[$i]); 
		
		if ($rejunte_pared != 0)
		  $mysqli->query("INSERT planos_rejuntes(id_plano,tipo,pared,longitud,total_paredes) VALUES ($idplano,'REJUNTE_PARED','$paredes[$i]','$metros','$total_paredes')");
		if ($rejunte_suelo != 0)
		  $mysqli->query("INSERT planos_rejuntes(id_plano,tipo,pared,longitud,total_paredes) VALUES ($idplano,'REJUNTE_SUELO','$paredes[$i]','$metros','$total_paredes')");
	
	}
} 
else
{
	
  $id_material=$_POST["id_material"];
  //$mysqli->query("INSERT sesiones_temporales(referencia_material,id_articulo_compuesto,sesion) VALUES('$id_material',NULL,'$sesion_temporal')");
  $mysqli->query("INSERT planos_materiales(id_plano,referencia_material) VALUES($idplano,'$id_material')");
}
$respuesta->mensaje="Guardado material $id_material";
 
echo json_encode($respuesta);

?>