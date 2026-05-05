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


if ($metodo === 'GET') {
    
    $consulta = "SELECT * FROM usuarios"; 
    $resultado = mysqli_query($conn, $consulta);

    $json = array("data" => array());

    if ($resultado) {
        while ($row = mysqli_fetch_assoc($resultado)) {
            
            $id = $row['id_usuario'];
            
            if($row['activo'] == 0){
                $btnAcciones = "<button class='btn-deshabilitar' data-id='$id' title='Deshabilitar'><i class='fa-solid fa-toggle-on text-success'></i></button>";
            } else if($row['activo'] == 1){
                $btnAcciones = "<button class='btn-habilitar' data-id='$id' title='Habilitar'><i class='fa-solid fa-toggle-off text-danger'></i></button>";
            } 

            $item = array(
                'ID_USUARIO' => $id,
                'NOMBRE' => $row['nombre'],
                'CORREO' => $row['correo_electronico'],
                'ROL' => $row['rol'],
                'GESTIONAR' => $btnAcciones
            );

            $json['data'][] = $item;
        }
    }

    header('Content-Type: application/json');
    echo json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} else if($metodo == "POST") {


    $accion = $_POST['accion'];
    $idUsuario = $_POST['id'];
    $motivo = $_POST['motivo'];

    

    if ($accion === 'deshabilitar') {

        $sql = "UPDATE usuarios SET activo = 1 WHERE id_usuario = ?";
        $asunto = "Cuenta deshabilitada";
         $cuerpo = "
            <div style='background-color: #f4f4f4; padding: 20px; font-family: Arial, sans-serif;'>
                <div style='max-width: 600px; margin: auto; background: white; border-radius: 8px; overflow: hidden; border: 1px solid #ddd;'>

                    <div style='background-color: #dc3545; padding: 20px; text-align: center;'>
                        <h1 style='color: white; margin: 0;'>Cuenta Deshabilitada</h1>
                    </div>

                    <div style='padding: 20px; color: #333;'>
                        <p>Hola,</p>

                        <p>Lamentamos informarte que tu cuenta ha sido <strong style='color:#dc3545;'>deshabilitada por el siguiente motivo:</strong>.</p>

                        <div style='background: #fff5f5; border: 1px solid #dc3545; border-radius: 5px; padding: 15px; margin: 20px 0;'>
                            <p style='margin: 5px 0;'><strong>Motivo:</strong></p>
                            <p style='margin: 5px 0;'><i>$motivo</i></p>
                        </div>

                        <p>Si crees que esto es un error, contacta con soporte.</p>
                    </div>

                    <div style='background: #eee; padding: 10px; text-align: center; font-size: 12px; color: #777;'>
                        © 2026 CasaGo
                    </div>

                </div>
            </div>";

    } else if ($accion === 'habilitar') {
        $sql = "UPDATE usuarios SET activo = 0 WHERE id_usuario = ?";
        $asunto = "Cuenta habilitada";
        $cuerpo = "<div style='background-color: #f4f4f4; padding: 20px; font-family: Arial, sans-serif;'>
        <div style='max-width: 600px; margin: auto; background: white; border-radius: 8px; overflow: hidden; border: 1px solid #ddd;'>

            <div style='background-color: #28a745; padding: 20px; text-align: center;'>
                <h1 style='color: white; margin: 0;'>Cuenta Activada</h1>
            </div>

            <div style='padding: 20px; color: #333;'>
                <p>Hola,</p>

                <p>Nos complace informarte que tu cuenta ha sido <strong style='color:#28a745;'>habilitada nuevamente por el siguiente motivo:</strong>.</p>

                <div style='background: #f1fff5; border: 1px solid #28a745; border-radius: 5px; padding: 15px; margin: 20px 0;'>
                    <p style='margin: 5px 0;'><strong>Motivo:</strong></p>
                    <p style='margin: 5px 0;'><i>$motivo</i></p>
                </div>

                <p>Ya puedes usar la plataforma con normalidad.</p>
            </div>

            <div style='background: #eee; padding: 10px; text-align: center; font-size: 12px; color: #777;'>
                © 2026 CasaGo
            </div>

        </div>
    </div>";
    } else {
        echo json_encode(["status" => "error", "message" => "Acción no válida"]);
        exit();
    }

    $stmtUpdate = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmtUpdate, "i", $idUsuario);
    $ejecucion = mysqli_stmt_execute($stmtUpdate);

    $consulta = "SELECT * FROM usuarios where id_usuario = $idUsuario"; 
    $resultado = mysqli_query($conn, $consulta);

if ($fila = mysqli_fetch_assoc($resultado)) {
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
    echo "Correo enviado correctamente";
} else {
    echo "Usuario no encontrado";
}
}