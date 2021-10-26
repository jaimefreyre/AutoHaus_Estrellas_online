<?php
// Check for empty fields
require 'mailer/PHPMailerAutoload.php';

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");


 $postdata = file_get_contents("php://input");
 $request = json_decode($postdata);
 @$nomape = $request->nomape;
 @$email = $request->email;
 @$celular = $request->celular;
 @$orden = $request->orden;
 @$asesor = $request->asesor;
 @$taller = $request->taller;
 @$factura = $request->factura;
 @$espera = $request->espera;
 @$precio = $request->precio;
 @$srec = $request->srec;
 @$msj = $request->msj;



//Create a new PHPMailer instance
$mail = new PHPMailer;
//Set who the message is to be sent from
$mail->setFrom('entrega0km@volkswagen.com', 'Test de Entrega 0km');
// Set an alternative reply-to address
// $mail->addReplyTo('replyto@example.com', 'First Last');
//Set who the message is to be sent to
$mail->addAddress($email, $nomape);
//Set the subject line
$mail->Subject = 'PHPMailer mail() test';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->MsgHTML("<h1>Muchas Gracias por completar nuestro Test $nomape </h1> <br> <br> <img src='$srec'> ");
//Y por si nos bloquean el contenido HTML (algunos correos lo hacen por seguridad) una versión alternativa en texto plano (también será válida para lectores de pantalla)
$mail->AltBody = "Muchas Gracias por completar nuestro Test $nomape";
//Attach an image file
$mail->addAttachment("$srec");

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}



  
$link = mysqli_connect("mysql.hostinger.com.ar", "u856262595_ffiu", "formabudapest");
mysqli_select_db($link, "u856262595_ffi");
mysqli_query($link, "INSERT INTO Postventa VALUES ('$nomape', '$email', '$celular', '$orden', '$asesor', '$taller', '$factura','$espera', '$precio', '$srec', '$msj')");
return true;
mysqli_close($link); // Cerramos la conexion con la base de datos @




