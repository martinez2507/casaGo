
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'librerias/PHPMailer-master/src/Exception.php';
require 'librerias/PHPMailer-master/src/PHPMailer.php';
require 'librerias/PHPMailer-master/src/SMTP.php';

$mail = new PHPMailer(true);

try {

    // Configuración SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'casagoof@gmail.com'; // tu gmail
    $mail->Password   = 'ulhx ioqc bdky yvgc'; // contraseña de aplicación
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // Remitente
    $mail->setFrom('casagoof@gmail.com', 'CasaGo');

    // Destinatario
    $mail->addAddress('sergio17olvega@gmail.com');

    // Contenido
    $mail->isHTML(true);
    $mail->Subject = 'Prueba CasaGo';
    $mail->Body    = 'Correo enviado correctamente desde CasaGo';

    $mail->send();
    echo "Correo enviado correctamente";

} catch (Exception $e) {
    echo "Error al enviar: {$mail->ErrorInfo}";
}

?>