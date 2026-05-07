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
    JOIN usuarios u ON a.id_anfitrion = u.id_usuario"; 
    $resultado = mysqli_query($conn, $consulta);

    $json = array("data" => array());

    if ($resultado) {
        while ($row = mysqli_fetch_assoc($resultado)) {
            
            $id = $row['id_apartamento'];
            
            if($row['activo'] == 0){
                $btnAcciones = "<button class='btn-deshabilitarApar' data-id='$id' title='Deshabilitar'><i class='fa-solid fa-toggle-on text-success'></i></button>";
            } else if($row['activo'] == 1){
                $btnAcciones = "<button class='btn-habilitarApar' data-id='$id' title='Habilitar'><i class='fa-solid fa-toggle-off text-danger'></i></button>";
            } else if($row['activo'] == 3){
                 $btnAcciones = "<span class='text-danger'>Apartamento rechazado</span>";
            }

            $item = array(
                'ID_APARTAMENTO' => $id,
                'ANFITRION' => $row['nombre_anfitrion'],
                'NOMBRE' => $row['nombre'],
                'UBICACION' => $row['direccion'] . ", " . $row['ciudad'],
                'PRECIO' => $row['precio_noche']. "€",
                'GESTIONAR' => $btnAcciones
            );

            $json['data'][] = $item;
        }
    }

    header('Content-Type: application/json');
    echo json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} else if($metodo == "POST") {


    $accion = $_POST['accion'];
    $idApartamento = $_POST['id'];
    $motivo = isset($_POST['motivo']) ? $_POST['motivo'] : null;

    $consulta = "SELECT u.*, a.nombre AS nombre_apartamento FROM usuarios u 
    JOIN apartamentos a ON u.id_usuario = a.id_anfitrion
    where a.id_apartamento = $idApartamento"; 
    $resultado = mysqli_query($conn, $consulta);

    $fila = mysqli_fetch_assoc($resultado);

    $nombreApartamento = $fila['nombre_apartamento'];

    if ($accion === 'deshabilitar') {
        $asunto = "Apartamento deshabilitado";
         $cuerpo = "
            <div style='background-color: #f4f4f4; padding: 20px; font-family: Arial, sans-serif;'>
                <div style='max-width: 600px; margin: auto; background: white; border-radius: 8px; overflow: hidden; border: 1px solid #ddd;'>

                    <div style='background-color: #dc3545; padding: 20px; text-align: center;'>
                        <h1 style='color: white; margin: 0;'>Apartamento Deshabilitado</h1>
                    </div>

                    <div style='padding: 20px; color: #333;'>
                        <p>Hola,</p>

                        <p>Lamentamos informarte que tu apartamento $nombreApartamento ha sido <strong style='color:#dc3545;'>deshabilitado por el siguiente motivo:</strong>.</p>

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

            $sqlApar = "UPDATE apartamentos SET activo = 1 WHERE id_apartamento = ?";
            $stmtApar = mysqli_prepare($conn, $sqlApar);
            mysqli_stmt_bind_param($stmtApar, "i", $idApartamento);
            mysqli_stmt_execute($stmtApar);

    } else if ($accion === 'habilitar') {
        $asunto = "Apartamento habilitado";
        $cuerpo = "<div style='background-color: #f4f4f4; padding: 20px; font-family: Arial, sans-serif;'>
        <div style='max-width: 600px; margin: auto; background: white; border-radius: 8px; overflow: hidden; border: 1px solid #ddd;'>

            <div style='background-color: #28a745; padding: 20px; text-align: center;'>
                <h1 style='color: white; margin: 0;'>Apartamento Habilitado</h1>
            </div>

            <div style='padding: 20px; color: #333;'>
                <p>Hola,</p>

                <p>Nos complace informarte que tu apartamento $nombreApartamento ha sido <strong style='color:#28a745;'>habilitado nuevamente.</strong>.</p>

                <p>Ya puedes usar la plataforma con normalidad.</p>
            </div>

            <div style='background: #eee; padding: 10px; text-align: center; font-size: 12px; color: #777;'>
                © 2026 CasaGo
            </div>

        </div>
    </div>";
    $sqlApar = "UPDATE apartamentos SET activo = 0 WHERE id_apartamento = ?";
    $stmtApar = mysqli_prepare($conn, $sqlApar);
    mysqli_stmt_bind_param($stmtApar, "i", $idApartamento);
    mysqli_stmt_execute($stmtApar);
    } else {
        echo json_encode(["status" => "error", "message" => "Acción no válida"]);
        exit();
    }

    

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