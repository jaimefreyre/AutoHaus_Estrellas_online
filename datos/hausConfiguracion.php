<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

$str_datos = file_get_contents("haus.json");

$selector = $_REQUEST['fun'];
switch ($selector) {
	case 'N':
		$Jnuevo = file_get_contents("php://input");
		echo 'Joya';
		echo $Jnuevo;
		//$Jnuevo = '{ "asesores": [ "3", "2", "1" ] }';
 		$fh = fopen("haus.json", 'w')or die("Error al abrir fichero de salida");
		fwrite($fh, $Jnuevo);
		fclose($fh);
	break;
	default:
		echo $str_datos;
	break;
}
?> 

  