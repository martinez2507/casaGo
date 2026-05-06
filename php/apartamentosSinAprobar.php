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
    
    $consulta = "SELECT a.*, u.nombre AS nombre_anfitrion FROM apartamentos a
    JOIN usuarios u ON a.id_anfitrion = u.id_usuario where a.activo = 2"; 
    $resultado = mysqli_query($conn, $consulta);

    $json = array("data" => array());

    if ($resultado) {
        while ($row = mysqli_fetch_assoc($resultado)) {
            
            $id = $row['id_apartamento'];
            
            
            $btnAprobar = "<button class='btn-aprobar' data-id='$id' title='Aprobar'><i class='fa-solid fa-check text-success'></i></button>";
            $btnRechazar = "<button class='btn-rechazar' data-id='$id' title='Rechazar'><i class='fa-solid fa-xmark text-danger'></i></button>";
            

            $item = array(
                'ID_APARTAMENTO' => $id,
                'ANFITRION' => $row['nombre_anfitrion'],
                'NOMBRE' => $row['nombre'],
                'UBICACION' => $row['direccion'] . ", " . $row['ciudad'],
                'PRECIO' => $row['precio_noche']. "€",
                'APROBAR' => $btnAprobar,
                'RECHAZAR' => $btnRechazar
            );

            $json['data'][] = $item;
        }
    }

    header('Content-Type: application/json');
    echo json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} else if($metodo == "POST") {

    $accion = $_POST['accion'];
    $idApartamento = $_POST['idApartamento'];
    $motivo = isset($_POST['motivo']) ? $_POST['motivo'] : null;

    $consulta = "SELECT u.*, a.nombre as nombre_apartamento FROM usuarios u 
    JOIN apartamentos a ON u.id_usuario = a.id_anfitrion
    where a.id_apartamento = $idApartamento"; 
    $resultado = mysqli_query($conn, $consulta);

    $fila = mysqli_fetch_assoc($resultado);

    $nombreApartamento = $fila['nombre_apartamento'];

    if($accion === "aprobar") {

        $sql = "UPDATE apartamentos SET activo = 0 WHERE id_apartamento = ?";
        $asunto = "Apartamento aprobado";
        $cuerpo = "<div style='background-color: #f4f4f4; padding: 20px; font-family: Arial, sans-serif;'>
        <div style='max-width: 600px; margin: auto; background: white; border-radius: 8px; overflow: hidden; border: 1px solid #ddd;'>

            <div style='background-color: #28a745; padding: 20px; text-align: center;'>
                <h1 style='color: white; margin: 0;'>Apartamento Aprobado</h1>
            </div>

            <div style='padding: 20px; color: #333;'>
                <p>Hola,</p>

                <p>Nos complace informarte que tu apartamento '$nombreApartamento' ha sido <strong style='color:#28a745;'>aprobado</strong>.</p>

                <p>Ya pueden reservar tu apartamento.</p>
            </div>

            <div style='background: #eee; padding: 10px; text-align: center; font-size: 12px; color: #777;'>
                © 2026 CasaGo
            </div>

        </div>
    </div>";
    } else if($accion === "rechazar") {

        $sql = "UPDATE apartamentos SET activo = 3 WHERE id_apartamento = ?";
        $asunto = "Apartamento no aprobado";
        $cuerpo = "<div style='background-color: #f4f4f4; padding: 20px; font-family: Arial, sans-serif;'>
        <div style='max-width: 600px; margin: auto; background: white; border-radius: 8px; overflow: hidden; border: 1px solid #ddd;'>

            <div style='background-color: #dc3545; padding: 20px; text-align: center;'>
                <h1 style='color: white; margin: 0;'>Apartamento No Aprobado</h1>
            </div>

            <div style='padding: 20px; color: #333;'>
                <p>Hola,</p>

                <p>Lamentamos informarte que tu apartamento '$nombreApartamento' no ha sido aprobado.</p>

                <div style='background: #fff1f0; border: 1px solid #dc3545; border-radius: 5px; padding: 15px; margin: 20px 0;'>
                    <p style='margin: 5px 0;'><strong>Motivo:</strong></p>
                    <p style='margin: 5px 0;'><i>$motivo</i></p>
                </div>

                <p>Por favor, revisa los requisitos y vuelve a enviar tu apartamento para su aprobación.</p>
            </div>

            <div style='background: #eee; padding: 10px; text-align: center; font-size: 12px; color: #777;'>
                © 2026 CasaGo
            </div>

        </div>
    </div>";
    }
    $stmtUpdate = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmtUpdate, "i", $idApartamento);
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
    echo "Correo enviado correctamente";
} else {
    echo "Usuario no encontrado";
}