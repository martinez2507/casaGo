
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../librerias/PHPMailer-master/src/Exception.php';
require '../librerias/PHPMailer-master/src/PHPMailer.php';
require '../librerias/PHPMailer-master/src/SMTP.php';

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
    $codigo = $_SESSION["reg_codigo"];
    // Contenido
    $mail->isHTML(true);
    $mail->Subject = 'Confirme su direccion de correo';
    $mail->Body    = 'Hola,<br>

                        Hemos recibido una solicitud para verificar tu cuenta.<br>

                        Tu código de verificación es:<br>

                        <h4>' . $codigo . '</h4><br>

                        Introduce este código en la página de confirmación para continuar.<br>

                        Si no has solicitado esta verificación, puedes ignorar este correo.<br>

                        Un saludo,<br>
                        Equipo de soporte.';

    $mail->send();
    echo "Correo enviado correctamente";

    ?>
    <?php
    header("Location: ComprobarCorreo.php");
} catch (Exception $e) {
    echo "Error al enviar: {$mail->ErrorInfo}";
}

?>