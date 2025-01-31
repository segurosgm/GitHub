
<!--codigo de envio del mensaje al correo-->
      
<?php
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$asunt = $_POST['asunt'];
$message = $_POST['message'];


$message = "Este mensaje fue enviado por: " . $name . " \r\n";
$message .= "Su e-mail es: " . $email . " \r\n";
$message .= "Teléfono de contacto: " . $phone . " \r\n";
$message .= "Asunto: " . $asunt . " \r\n";
$message .= "Mensaje: " . $_POST['message'] . " \r\n";
$message .= "Enviado el: " . date(format: 'd/m/Y', timestamp: time());

$para = 'segurosgm874@gmail.com';
$asunto = $asunt ;

mail(to: $para, subject: $asunto, message: utf8_decode(string: $message), additional_headers: $header);

header(header: "Location:/GM/Home.html");
?>

