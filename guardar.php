<?php
//require 'mailer/PHPMailerAutoload.php';
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

 $datosEntrega = file_get_contents("php://input");
 $request = json_decode($datosEntrega);
/*
// Check for empty fields
@$asesor =$request->asesor;
@$nomape =$request->nomape;
@$email =$request->email;
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
$fecha = date("Y-m-d");

$pp= new mysqli('localhost', 'apptablets0km', 'RenovacionPass2019', 'apptable_app'); 
$pp->query("SET NAMES 'utf8'");

$pista = "INSERT INTO EncuestaO VALUES (null,";

foreach ($request as $key => $value) {
$pista .= " '" . $value . "', ";
}

$pista .= "'$fecha')";

echo $pista;

$pp->query($pista);
$pp->close();


/*
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
$mail->MsgHTML( $valorEmail );
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

echo "guardado";	
*/

?>
