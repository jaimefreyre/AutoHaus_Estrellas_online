<?php
//Base de datos
$mysql=new mysqli('localhost', 'apptablets0km', 'tablet0km', 'apptable_app');    
    if ($mysql->connect_error)
      die('Problemas con la conexion a la base de datos');

//fecha de la exportación
$fecha = date("d-m-Y");
$mysql->query("SET NAMES 'utf8'");
$resultado = $mysql->query("SELECT * FROM EncuestaO");
$todos = array();
while($r = $resultado->fetch_object()) {
array_push($todos, $r);
};



//Inicio de la instancia para la exportación en Excel
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=Listado_$fecha.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border=1> ";

/**
foreach ($todos as $key => $value) {
	foreach ($value as $key2 => $value2) {
		echo $key2 . " = " . $value2;

	}
}
**/



//Lista de Item
$control = 1;

	echo "<tr> ";
foreach ($todos as $key => $value) {
	if ($control < 2){
	
	foreach ($value as $key2 => $value2) {
		echo    "<th>". $key2 ."</th> ";
		
		}
	

	$control++;
	
	}

}
	echo "</tr> ";


foreach ($todos as $key => $value) {
 echo "<tr> ";
	foreach ($value as $key2 => $value2) {
  echo  "<td>".$value2."</td> "; 
}
 echo "</tr> ";
}



echo "</table> ";
?>