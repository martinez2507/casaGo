<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include './conexionBD.php';
$metodo = $_SERVER['REQUEST_METHOD'];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../librerias/PHPMailer-master/src/Exception.php';
require '../librerias/PHPMailer-master/src/PHPMailer.php';
require '../librerias/PHPMailer-master/src/SMTP.php';
include("../php/conexionBD.php");

if ($metodo === 'POST') {

    $idApartamento = $_POST['idApartamento'];
    $idUsuario = $_POST['idUsuario'];
    $precioT = $_POST['precioT'];
    $numPersonas = $_POST['numPersonas'];

    $fecha_inicio = date("Y-m-d", strtotime($_POST['llegada']));
    $fecha_fin    = date("Y-m-d", strtotime($_POST['salida']));

    $sql = "INSERT INTO reservas (id_apartamento, id_usuario, fecha_inicio, fecha_fin, precio_total, num_personas) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("iissdi", $idApartamento, $idUsuario, $fecha_inicio, $fecha_fin, $precioT, $numPersonas);

        if ($stmt->execute()) {
            
            $sqlDatos = "SELECT u.correo_electronico, u.nombre AS nombre_anfitrion, a.nombre AS nombre_apto, a.direccion as direccion_apto 
             FROM usuarios u 
             JOIN apartamentos a ON u.id_usuario = a.id_anfitrion 
             WHERE a.id_apartamento = ?";
            $stmt2 = $conn->prepare($sqlDatos);
            $stmt2->bind_param("i", $idApartamento);
            $stmt2->execute();
            $info = $stmt2->get_result()->fetch_assoc();

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

                // Correo al Anfitrión
                $mail->setFrom('casagoof@gmail.com', 'CasaGo');
                $mail->addAddress($info['correo_electronico'], $info['nombre_anfitrion']);
                $mail->isHTML(true);
                $mail->Subject = "¡Nueva reserva en {$info['nombre_apto']}!";
                $mail->Body = "
                    <div style='background-color: #f4f4f4; padding: 20px; font-family: Arial, sans-serif;'>
                        <div style='max-width: 600px; margin: auto; background: white; border-radius: 8px; overflow: hidden; border: 1px solid #ddd;'>
                            <div style='background-color: #ff5a5f; padding: 20px; text-align: center;'>
                                <h1 style='color: white; margin: 0;'>¡Nueva Reserva!</h1>
                            </div>
                            <div style='padding: 20px; color: #333;'>
                                <p>Hola <strong>{$info['nombre_anfitrion']}</strong>,</p>
                                <p>Tienes una nueva reserva para tu alojamiento: <strong>{$info['nombre_apto']}</strong>.</p>
                                <div style='background: #fff8f8; border: 1px solid #ff5a5f; border-radius: 5px; padding: 15px; margin: 20px 0;'>
                                    <p style='margin: 5px 0;'><strong>Huésped:</strong> {$_SESSION['usuario']}</p>
                                    <p style='margin: 5px 0;'><strong>Entrada:</strong> $fecha_inicio</p>
                                    <p style='margin: 5px 0;'><strong>Salida:</strong> $fecha_fin</p>
                                    <p style='margin: 5px 0;'><strong>Personas:</strong> $numPersonas</p>
                                    <p style='margin: 5px 0; font-size: 18px; color: #ff5a5f;'><strong>Ganancia: $precioT €</strong></p>
                                </div>
                                <p>Puedes contactar con el huésped a través de la plataforma para organizar la llegada.</p>
                            </div>
                            <div style='background: #eee; padding: 10px; text-align: center; font-size: 12px; color: #777;'>
                                2026 CasaGo - Gestión de Alojamientos Turísticos
                            </div>
                        </div>
                    </div>";
                $mail->send();

                // Correo al Huésped (El que reserva)
                $mail->clearAddresses();
                $mail->addAddress($_SESSION['reg_email'], $_SESSION['usuario']);
                $mail->Subject = "Tu reserva en CasaGo está confirmada";
                $mail->Body    = "<div style='background-color: #f4f4f4; padding: 20px; font-family: Arial, sans-serif;'>
                                <div style='max-width: 600px; margin: auto; background: white; border-radius: 8px; overflow: hidden; border: 1px solid #ddd;'>
                                    <div style='background-color: #484848; padding: 20px; text-align: center;'>
                                        <h1 style='color: white; margin: 0;'>¡Tu viaje está listo!</h1>
                                    </div>
                                    <div style='padding: 20px; color: #333;'>
                                        <p>Hola <strong>{$_SESSION['usuario']}</strong>,</p>
                                        <p>¡Felicidades! Tu reserva en <strong>{$info['nombre_apto']}</strong> ha sido confirmada correctamente.</p>
                                        <hr style='border: 0; border-top: 1px solid #eee;'>
                                        <p><strong>Resumen del alojamiento:</strong></p>
                                        <p>📍 Ubicación: {$info['direccion_apto']}</p>
                                        <p>📅 Fechas: del $fecha_inicio al $fecha_fin</p>
                                        <p>💰 Total pagado: $precioT € (IVA incluido)</p>
                                        <div style='text-align: center; margin-top: 30px;'>
                                            <a href='http://localhost/tu-proyecto/mis-reservas.php' 
                                            style='background-color: #ff5a5f; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold;'>
                                            Ver detalles de mi viaje
                                            </a>
                                        </div>
                                        <p style='margin-top: 30px; font-size: 14px;'>Si tienes alguna duda, responde a este correo o contacta con el anfitrión.</p>
                                    </div>
                                    <div style='background: #eee; padding: 10px; text-align: center; font-size: 12px; color: #777;'>
                                        2026 CasaGo - Gestión de Alojamientos Turísticos
                                    </div>
                                </div>
                            </div>";
                $mail->send();

                echo "success";

            } catch (Exception $e) {
                // Si el correo falla pero la reserva se guardó
                echo "reserva_ok_correo_fallo";
            }
        } else {
            echo "error_insert";
        }
        } else {
            echo json_encode(["status" => "error", "message" => "Error al ejecutar: " . $stmt->error]);
        }
        
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Error en la consulta: " . $conn->error]);
    }