<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");


    $mysql=new mysqli('localhost', 'apptablets0km', 'tablet0km', 'apptable_app');    
    if ($mysql->connect_error){
      die('Problemas con la conexion a la base de datos');
    }
    else {

    $selector = $_REQUEST['selector'];

    switch ($selector) {
    case 1:
        # code...
    $mysql->query("SET NAMES 'utf8'");
    $tt = $mysql->query("SELECT nomape, srec, ID FROM EncuestaO ORDER BY ID DESC LIMIT 1");
    $todos = array();
    while($r = $tt->fetch_object()) {
    array_push($todos, $r);
    }
    $completa = json_encode($todos, 128);
    $mysql->close();
    echo $completa;
    break;


    case 'adc':
    $cta = $_REQUEST['cat'];
    $ass = $_REQUEST['asesor'];
    $fecha_1 = $_REQUEST['fc1'];
    $fecha_1 = str_replace("-","",$fecha_1);
    $fecha_2 = $_REQUEST['fc2'];
    $fecha_2 = str_replace("-","",$fecha_2);
        

    if (!$ass) {
        unset($ass);        
    }

        if ($fecha_2){
            //echo $fecha_1 . $fecha_2 . 'llego aca';
            $pista = "SELECT $cta FROM EncuestaO where (asesor = '$ass') AND (Fecha BETWEEN '$fecha_1' AND '$fecha_2')ORDER BY ID DESC ";
            //$pista = "SELECT $cta FROM EncuestaO where Fecha BETWEEN '$fecha_1' AND '$fecha_2' ORDER BY ID DESC ";
            echo 'primer if';
            echo $pista;
        }     
        elseif($ass){
            $pista = "SELECT $cta FROM EncuestaO where (asesor = '$ass')ORDER BY ID DESC";
            echo '2 if';
            echo $pista;
        }
        elseif ($ass && $fecha_2) {
            $pista = "SELECT $cta FROM EncuestaO where (asesor = '$ass') AND (Fecha BETWEEN '$fecha_1' AND '$fecha_2')ORDER BY ID DESC ";
            echo '4 if';
            echo $pista;
        }     
        else{
            $pista = "SELECT $cta FROM EncuestaO ORDER BY ID DESC";
            echo '5 if';
            echo $pista;
        }


    $compratt = $mysql->query($pista);
    $compra = array();
   while($r = $compratt->fetch_object()) {
    array_push($compra, $r);
    }
    $nivelCompra = json_encode($compra, 128);
    echo $nivelCompra;
    $mysql->close();
    break;
    

    case 'adc2':
    $cta = $_REQUEST['cat'];
    $ass = $_REQUEST['asesor'];
    $fecha_1 = $_REQUEST['fc1'];
    $fecha_1 = str_replace("-","",$fecha_1);
    $fecha_2 = $_REQUEST['fc2'];
    $fecha_2 = str_replace("-","",$fecha_2);
    /*
    if ($ass && $fecha_2) {
        $pista = "SELECT * FROM EncuestaO where (asesor = '$ass') AND (Fecha BETWEEN $fecha_1 AND $fecha_2)ORDER BY ID DESC ";
    }     
    elseif ($fecha_2) {
        $pista = "SELECT $cta FROM EncuestaO where Fecha BETWEEN $fecha_1 AND $fecha_2 ORDER BY ID DESC ";
    }     
    elseif($ass){
        $pista = "SELECT * FROM EncuestaO where (asesor = '$ass')ORDER BY ID DESC ";
    }
    else{
        $pista = "SELECT * FROM EncuestaO ORDER BY ID DESC ";
    };
    */
    if ($ass == 'noseasigno') {
        unset($ass);        
    }

        if ($fecha_2) {
            //echo $fecha_1 . $fecha_2 . 'llego aca';
            $pista = "SELECT * FROM EncuestaO where Fecha BETWEEN '$fecha_1' AND '$fecha_2' ORDER BY ID DESC ";
            //echo $pista;
        }     
        elseif($ass){
            $pista = "SELECT * FROM EncuestaO where (asesor = '$ass')ORDER BY ID DESC";
        }
        elseif ($ass && $fecha_2) {
            $pista = "SELECT * FROM EncuestaO where (asesor = '$ass') AND (Fecha BETWEEN '$fecha_1' AND '$fecha_2')ORDER BY ID DESC ";
        }     
        else{
            $pista = "SELECT * FROM EncuestaO ORDER BY ID DESC";
        }

    //echo $pista;   
    $compratt = $mysql->query($pista);
    $compra = array();
   while($r = $compratt->fetch_object()) {
    array_push($compra, $r);
    }
    $nivelCompra = json_encode($compra, 128);
    echo $nivelCompra;
    $mysql->close();
    break;
      


    

 
    case 'compra':
    $compratt = $mysql->query("SELECT compra FROM EncuestaO");
    $compra = array();
   while($r = $compratt->fetch_object()) {
    array_push($compra, $r);
    }
    $nivelCompra = json_encode($compra, 128);
    $mysql->close();
    echo $nivelCompra;
    break;
       
    case 'comercial':
    $comercialtt = $mysql->query("SELECT comercial FROM EncuestaO");
    $comercial = array();
    while($r = $comercialtt->fetch_object()) {
    array_push($comercial, $r);
    }
    $nivelComercial = json_encode($comercial, 128);
    echo $nivelComercial;
    $mysql->close();
    break;
       
    case 'admin':
    $admintt = $mysql->query("SELECT admin FROM EncuestaO");
    $admin = array();
    while($r = $admintt->fetch_object()) {
    array_push($admin, $r);
    }
    $nivelAdmin = json_encode($admin, 128);
    echo $nivelAdmin;
    $mysql->close();
    break;

    case 'manejo':
    $manejott = $mysql->query("SELECT manejo FROM EncuestaO");
    $manejo = array();
    while($r = $manejott->fetch_object()) {
    array_push($manejo, $r);
    }
    $Pmanejo = json_encode($manejo, 128);
    echo $Pmanejo;
    $mysql->close();
    break;
    
    case 'postventa':
    $postventatt = $mysql->query("SELECT postventa FROM EncuestaO");
    $postventa = array();
    while($r = $postventatt->fetch_object()) {
    array_push($postventa, $r);
    }
    $apostventa = json_encode($postventa, 128);
    echo $apostventa;
    $mysql->close();
    break;

    case 'controles':
    $controlestt = $mysql->query("SELECT controles FROM EncuestaO");
    $controles = array();
    while($r = $controlestt->fetch_object()) {
    array_push($controles, $r);
    }
    $nivelControles = json_encode($controles, 128);
    echo $nivelControles;
    $mysql->close();
    break;

    case 'limpieza':
    $limpiezatt = $mysql->query("SELECT limpieza FROM EncuestaO");
    $limpieza = array();
    while($r = $limpiezatt->fetch_object()) {
    array_push($limpieza, $r);
    }
    $nivelLimpieza = json_encode($limpieza, 128);
    echo $nivelLimpieza;
    $mysql->close();
    break;
    // Recorremos los registros de la Base de Datos para mostrarlos
    
    default:
        # code...
     $mysql->query("SET NAMES 'utf8'");
    $tt = $mysql->query("SELECT * FROM EncuestaO");
    $todos = array();
    while($r = $tt->fetch_object()) {
    array_push($todos, $r);
    }
    $completa = json_encode($todos, 128);
    $mysql->close();
    echo $completa;
        break;
}


}

  ?> 

  