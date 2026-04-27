<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../librerias/PHPMailer-master/src/Exception.php';
require '../librerias/PHPMailer-master/src/PHPMailer.php';
require '../librerias/PHPMailer-master/src/SMTP.php';
include("../php/conexionBD.php");

$idApartamento = $_POST['idApartamento'];
$nombreHuesped = $_SESSION['usuario'];
$emailHuesped  = $_SESSION['reg_email'];
$fechaLlegada  = $_POST['llegada'];
$fechaSalida   = $_POST['salida'];
$precioTotal   = $_POST['precioT'];

$sqlAnfitrion = "SELECT u.correo_electronico, u.nombre, a.nombre as nombre_apto 
                 FROM usuarios u 
                 JOIN apartamentos a ON u.id_usuario = a.id_usuario 
                 WHERE a.id_apartamento = ?";

$stmt = $conn->prepare($sqlAnfitrion);
$stmt->bind_param("i", $idApartamento);
$stmt->execute();
$res = $stmt->get_result()->fetch_assoc();

$emailAnfitrion  = $res['correo_electronico'];
$nombreAnfitrion = $res['nombre'];
$nombreApto      = $res['nombre_apto'];

$mail = new PHPMailer(true);

try {
    
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'casagoof@gmail.com';
    $mail->Password   = 'ulhx ioqc bdky yvgc';
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;
    $mail->CharSet    = 'UTF-8';

    $mail->setFrom('casagoof@gmail.com', 'CasaGo Reservas');
    $mail->addAddress($emailAnfitrion, $nombreAnfitrion);
    
    $mail->isHTML(true);
    $mail->Subject = '¡Nueva reserva recibida en CasaGo!';
    $mail->Body    = "
        <h2>¡Hola $nombreAnfitrion!</h2>
        <p>Has recibido una nueva reserva para tu propiedad: <strong>$nombreApto</strong>.</p>
        <p><strong>Detalles del huésped:</strong><br>
        Nombre: $nombreHuesped<br>
        Fechas: del $fechaLlegada al $fechaSalida<br>
        Ganancia: $precioTotal €</p>
        <p>Ponte en contacto con el huésped si necesitas coordinar la entrega de llaves.</p>";
    
    $mail->send();

    // PARA EL HUÉSPED
    $mail->clearAddresses();
    $mail->addAddress($emailHuesped, $nombreHuesped);
    
    $mail->Subject = 'Confirmación de tu reserva - CasaGo';
    $mail->Body    = "
        <h2>¡Tu reserva está confirmada!</h2>
        <p>Hola $nombreHuesped, hemos procesado correctamente tu pago para <strong>$nombreApto</strong>.</p>
        <p><strong>Resumen de tu viaje:</strong><br>
        Check-in: $fechaLlegada<br>
        Check-out: $fechaSalida<br>
        Total pagado: $precioTotal €</p>
        <p>¡Gracias por viajar con CasaGo!</p>";
    
    $mail->send();

    header("Location: ../exito_reserva.php");

} catch (Exception $e) {
    echo "Error al enviar los correos: {$mail->ErrorInfo}";
}
?>