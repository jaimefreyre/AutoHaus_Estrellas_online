<?php
require 'mailer/PHPMailerAutoload.php';
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

 $datosEntrega = file_get_contents("php://input");
 $request = json_decode($datosEntrega);
/*
// Check for empty fields
@$asesor =$request->asesor;
@$celular =$request->celular;
@$chasis =$request->chasis;
@$compra =$request->compra;
@$comercial =$request->comercial;
@$admin =$request->admin;
@$manejo =$request->manejo;
@$postventa =$request->postventa;
@$controles =$request->controles;
@$limpieza =$request->limpieza;
@$volveria =$request->volveria;
//@$entrega =$request->entrega;
@$msj =$request->msj;
@$srec =$request->srec;

$pista = "INSERT INTO haus VALUES (null, '$asesor', '$nomape', '$email', '$celular', '$chasis', '$compra', '$comercial', '$admin', '$manejo', '$postventa', '$controles', '$limpieza', '$volveria', '$msj', '$srec', '$fecha')";

*/
$orden = $_REQUEST['orden'];
$fecha = date("Y-m-d");
$pp= new mysqli('localhost', 'apptablets0km', 'RenovacionPass2019', 'apptable_app'); 
$pp->query("SET NAMES 'utf8'");

switch ($orden) {
    case 'nuevo':

		$email =  null;
		$nomape= null;
		$pista = "INSERT INTO EncuestaO VALUES (null,";
		foreach ($request as $key => $value) {
			if ($key == 0) {
				$nomape = $value;
			}
			if ($key == 1) {
				$email = $value;
			}
			$pista .= " '" . $value . "', ";
		}
		$pista .= "'$fecha')";
		echo $pista;
		$pp->query($pista);
		

		if (isset($email)) 
			{
		 
				include('e.php');
				//Create a new PHPMailer instance
				$mail = new PHPMailer;
				//Set who the message is to be sent from
				$mail->setFrom('entregas@autohaus.com.ar', 'Auto Haus - Volkswagen');
				// Set an alternative reply-to address
				// $mail->addReplyTo('replyto@example.com', 'First Last');
				//Set who the message is to be sent to
				$mail->addAddress($email, $nomape);
				//Set the subject line
				$mail->Subject = 'Felicidades por la adquisicion de su 0km !!!';
				//Read an HTML message body from an external file, convert referenced images to embedded,
				//convert HTML into a basic plain-text alternative body
				$mail->MsgHTML( '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<title>Auto Haus - Experiencia 5 Estrellas</title>

			        <style type="text/css">
			        body {margin: 0; padding: 0; min-width: 100%!important; text-align:center}
			        </style>
			        
			</head>

			<body>
			<a href="'.$linkeo.'" target="_blank"><img src="http://apptablets0km.com/Haus/Datos2018/email-2019.jpeg" border="0"/></a>
			</body>
			</html>' );
				//Y por si nos bloquean el contenido HTML (algunos correos lo hacen por seguridad) una versión alternativa en texto plano (también será válida para lectores de pantalla)
				$mail->AltBody = $valorEmail ;
				//Attach an image file
				$mail->addAttachment('$srec');

				//send the message, check for errors
				if (!$mail->send()) {
				    echo "Mailer Error: " . $mail->ErrorInfo;
				} else {
				    echo "Message sent!";
				}
			}
			else
			{
				echo "No habia Email!!!";
			}
		 	


	 break;
    case 'nuevoApp':
		$email =  null;
		$nomape= null;
		$linkeo = null; 
		$pista = "INSERT INTO EncuestaO (ID, NOMBRE, EMAIL, TELEFONO, PATENTE, FOTO, J) VALUES (null,";
		foreach ($request as $key => $value) {
			if ($key == 'nomape') {
				echo 'se activa nombre';
				$nomape = $value;
			}
			if ($key == 'email') {
				$email = $value;
				echo 'se activa email';
				echo $email;
			}
			if ($key == 'srec') {
				$srec = 'http://apptablets0km.com/Haus/' . $value;
				print_r($srec);
			}
			echo 'la clave : '.$key. 'posee el valor' .$value;
			$pista .= " '" . $value . "', ";
		}
		$pista .= "'$fecha')";

		

		$pp->query($pista);
		$veridi = $pp->insert_id;
		$linkeo = 'http://apptablets0km.com/EncuestaO/Index.html?id=' . $veridi;

		echo 'Pista' . $pista . '<br>';
		echo 'Link' . $linkeo . '<br>';


		//Create a new PHPMailer instance
		$mail = new PHPMailer;
		//Set who the message is to be sent from
		$mail->setFrom('entregas@autohaus.com.ar', 'Auto Haus - Volkswagen');
		// Set an alternative reply-to address
		// $mail->addReplyTo('replyto@example.com', 'First Last');
		//Set who the message is to be sent to
		$mail->addAddress($email, $nomape);
		//Set the subject line
		$mail->Subject = 'Felicidades por la adquisicion de su 0km !!!';
		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		$mail->MsgHTML( 
			'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<title>Auto Haus - Experiencia 5 Estrellas</title>

			        <style type="text/css">
			        body {margin: 0; padding: 0; min-width: 100%!important; text-align:center}
			        </style>
			        
			</head>

			<body>
			<a href="'.$linkeo.'" target="_blank"><img src="http://apptablets0km.com/Haus/Datos2018/email-2019.jpeg" border="0"/></a>
			</body>
			</html>'
		);
		//Y por si nos bloquean el contenido HTML (algunos correos lo hacen por seguridad) una versión alternativa en texto plano (también será válida para lectores de pantalla)
		$mail->AltBody = 
			'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<title>Auto Haus - Experiencia 5 Estrellas</title>

			        <style type="text/css">
			        body {margin: 0; padding: 0; min-width: 100%!important; text-align:center}
			        </style>
			        
			</head>

			<body>
			<a href="'.$linkeo.'" target="_blank"><img src="http://apptablets0km.com/Haus/Datos2018/email-2019.jpeg" border="0"/></a>
			</body>
			</html>' ;
		//Attach an image file
		$mail->addAttachment('$srec');

		//send the message, check for errors
		if (!$mail->send()) {
		    echo "Mailer Error: " . $mail->ErrorInfo;
		} else {
		    echo "Message sent!";
		}
		 	

	 break;

	 case 'update':
	 	$arrayLetras = array(1, 2, 3, 4, 5, 'a' ,'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i' );
		$UID = $_REQUEST['uid'];
	 	$pista = "UPDATE EncuestaO SET ";
		foreach ($request as $key => $value) {
			if ($key == 0) {
				$nomape = $value;
			}
			if ($key == 1) {
				$email = $value;
			}
			if ($key > 4) {
				$pista .= $arrayLetras[$key] . " = '" . $value . "', ";
			}
		
		}

		$pista .= "J = '$fecha' WHERE ID =" . $UID;
		print_r($pista);


		//UPDATE EncuestaO SET 0 = 'limon', 1 = '022', 2 = 'limn', 3 = 'aaa', 4 = 'aaaaaa', 5 = '1', 6 = '1', 7 = '1', 8 = '2', 9 = '1', 10 = 'no', 11 = 'si', 12 = '1', 13 = 'si', J = '2018-02-14' WHERE ID =1
		

		
		$pp->query($pista);
	 break;

	 default:
	 	echo 'Se declaro default';
	 break;
}

$pp->close();



?>
