<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("conexionBD.php");
$metodo = $_SERVER['REQUEST_METHOD'];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../librerias/PHPMailer-master/src/Exception.php';
require '../librerias/PHPMailer-master/src/PHPMailer.php';
require '../librerias/PHPMailer-master/src/SMTP.php';

$mail = new PHPMailer(true);
if($metodo == "POST") {


    $idUsuario = $_POST['id'];
    $accion = $_POST['accion'];
    $consulta = "SELECT * FROM usuarios where id_usuario = $idUsuario"; 
    $resultado = mysqli_query($conn, $consulta);
    $fila = mysqli_fetch_assoc($resultado);

    if ($accion === "solicitar") {
        // activo = 2 -> en revisión
        $sql = "UPDATE usuarios SET activo = 2 WHERE id_usuario = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $idUsuario);
        $resultado = mysqli_stmt_execute($stmt);
    } else if ($accion === "aprobar") {
        // rol = anfitrion

            $sql = "UPDATE usuarios SET rol = 'anfitrion', activo = 0 WHERE id_usuario = ?";
            $asunto = "Solicitud para ser anfitrion";
            $cuerpo = "<div style='background-color: #f4f4f4; padding: 20px; font-family: Arial, sans-serif;'>
            <div style='max-width: 600px; margin: auto; background: white; border-radius: 8px; overflow: hidden; border: 1px solid #ddd;'>

                <div style='background-color: #28a745; padding: 20px; text-align: center;'>
                    <h1 style='color: white; margin: 0;'>Solicitud Aprobada</h1>
                </div>

                <div style='padding: 20px; color: #333;'>
                    <p>Hola,</p>

                    <p>Nos complace informarte que tu solicitud para ser anfitrión ha sido <strong style='color:#28a745;'>aprobada</strong>.</p>

                    <p>Ya puedes subir tu primer apartamento y recibir tus primeros huéspedes.</p>
                </div>

                <div style='background: #eee; padding: 10px; text-align: center; font-size: 12px; color: #777;'>
                    © 2026 CasaGo
                </div>

            </div>
        </div>";
        
    } else if ($accion === "rechazar") {

     $sql = "UPDATE usuarios SET rol = 'usuario', activo = 0 WHERE id_usuario = ?";
     $asunto = "Solicitud para ser anfitrion";
            $cuerpo = "<div style='background-color: #f4f4f4; padding: 20px; font-family: Arial, sans-serif;'>
            <div style='max-width: 600px; margin: auto; background: white; border-radius: 8px; overflow: hidden; border: 1px solid #ddd;'>

                <div style='background-color: #dc3545; padding: 20px; text-align: center;'>
                    <h1 style='color: white; margin: 0;'>Solicitud Rechazada</h1>
                </div>

                <div style='padding: 20px; color: #333;'>
                    <p>Hola,</p>

                    <p>Le informamos que su solicitud para ser anfitrión ha sido <strong style='color:#dc3545;'>rechazada</strong>.</p>

                    <p>Si tienes dudas contacta con nosotros.</p>
                </div>

                <div style='background: #eee; padding: 10px; text-align: center; font-size: 12px; color: #777;'>
                    © 2026 CasaGo
                </div>

            </div>
        </div>";

    }
        // rol = usuario
        $stmtUpdate = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmtUpdate, "i", $idUsuario);
        $ejecucion = mysqli_stmt_execute($stmtUpdate);

        

        $correo = $fila['correo_electronico'];

        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'casagoof@gmail.com';
        $mail->Password   = 'ulhx ioqc bdky yvgc';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Remitente
        $mail->setFrom('casagoof@gmail.com', 'CasaGo');

        // Destinatario
        $mail->addAddress($correo);
        // Contenido
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body    = $cuerpo;

        $mail->send();
    }
