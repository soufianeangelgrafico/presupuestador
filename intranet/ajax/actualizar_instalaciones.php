<?php
include("../../conexion.php");

$respuesta = new stdClass();
$respuesta->contestacion=1;

$id_presupuesto=(int)$_POST["id_presupuesto"];
$elementos_instalacion=trim(htmlentities($_POST["elementos_instalacion"])); //Elementos de la obra que quiere instalar separados por COMAS
$elementos_instalacion=substr($elementos_instalacion,0,-1);
 
//$password=encrypt("".$password."","".$semilla."");

if ($elementos_instalacion == "")
{
	$respuesta->mensaje="Debes seleccionar al menos un elemento de instalación y obras";
}
else if ($id_presupuesto == 0)
{
	$respuesta->mensaje="No se ha podido obtener el ID de presupuesto. Recarga la página y vuelve a intentarlo";
}
else
{
	
  //Ahora ya no se crea el presupuesto actual, si no que se genera otro
  $result=$mysqli->query("SELECT * FROM presupuestos WHERE id_presupuesto=$id_presupuesto");
  $obj_result = $result->fetch_object();
  
  $sql="INSERT presupuestos(nombre_cliente,apellidos_cliente,direccion_cliente,cp_cliente,poblacion_cliente,provincia_cliente,telefono_cliente,email_cliente,presupuesto_ikea,dibujo2d,elementos_instalacion,tipo_reforma,id_padre) ";
	$sql.="VALUES ('$obj_result->nombre_cliente','$obj_result->apellidos_cliente','$obj_result->direccion_cliente','$obj_result->cp_cliente','$obj_result->poblacion_cliente','$obj_result->provincia_cliente','$obj_result->telefono_cliente','$obj_result->email_cliente','$obj_result->presupuesto_ikea','$obj_result->dibujo2d','$elementos_instalacion','$obj_result->tipo_reforma',$id_presupuesto);";	
	
   $result_presupuesto=$mysqli->query($sql);	

	if ($result_presupuesto)
	{
		$respuesta->mensaje="Nuevo presupuesto generado correctamente";
	}
	else
	{
	   $respuesta->mensaje="No se ha podido generar un nuevo presupuesto. Comprueba tu selección y vuelve a intentarlo";
	}
	
}
echo json_encode($respuesta);	
	
?>