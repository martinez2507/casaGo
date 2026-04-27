<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include './conexionBD.php';
$metodo = $_SERVER['REQUEST_METHOD'];


if ($metodo === 'POST') {

    $idApartamento = $_POST['idApartamento'];
    $idUsuario = $_POST['idUsuario'];
    $puntos = $_POST['puntos'];
    $comentario = $_POST['comentario'];
    $fechaHoy = date("Y-m-d");

    $sql = "INSERT INTO valoraciones (id_apartamento, id_usuario, fecha, puntuacion, comentario) 
    VALUES (?, ?, ?, ?,?)";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("iisis", $idApartamento, $idUsuario,$fechaHoy, $puntos, $comentario);

        if ($stmt->execute()) {
            header("Location: ../perfil.php");
        } else {
            echo json_encode(["status" => "error", "message" => "Error al ejecutar: " . $stmt->error]);
        }
        
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Error en la consulta: " . $conn->error]);
    }

}