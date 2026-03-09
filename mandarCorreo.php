
<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'librerias/PHPMailer-master/src/Exception.php';
require 'librerias/PHPMailer-master/src/PHPMailer.php';
require 'librerias/PHPMailer-master/src/SMTP.php';

$mail = new PHPMailer(true);
$_SESSION['reg_nombre']   = $_POST['nombre'];
$_SESSION['reg_email']    = $_POST['correo'];
$_SESSION['reg_codigo'] = random_int(100000, 999999);

$contraseñaUsu = $_POST['contraseña'];
$hash_passwd = password_hash($contraseñaUsu, PASSWORD_DEFAULT);

$_SESSION['contraseña'] = $hash_passwd;
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
    $mail->addAddress($_SESSION['reg_email']);

    // Contenido
    $mail->isHTML(true);
    $mail->Subject = 'Confirme su dirección de correo';
    $mail->Body    = $_SESSION['reg_codigo'];

    $mail->send();
    echo "Correo enviado correctamente";

    ?>
    <?php
    header("Location: ComprobarCorreo.php");
} catch (Exception $e) {
    echo "Error al enviar: {$mail->ErrorInfo}";
}

?>