<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include './conexionBD.php';
$metodo = $_SERVER['REQUEST_METHOD'];


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
            echo json_encode(["status" => "success", "message" => "Reserva confirmada"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al ejecutar: " . $stmt->error]);
        }
        
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Error en la consulta: " . $conn->error]);
    }

}