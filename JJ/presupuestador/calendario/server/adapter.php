<?php
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, Content-Language, Authorization');
header('Access-Control-Expose-Headers: Authorization');

$mysqli = new mysqli("localhost","angelgra_rehubic","Montse2016","angelgra_rehubic");
$result=$mysqli->query("SELECT fecha FROM calendario WHERE ocupado=1 ORDER BY id ASC");

while ($arr_result = $result->fetch_array())
{
	
	$unavailable[] = $arr_result['fecha'];
	
}

echo(json_encode($unavailable));
exit();