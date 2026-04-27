<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("conexionBD.php");

$idApartamento = $_POST['idApartamento'];
$fechaEntrada = $_POST['fechaEntrada'];
$fechaSalida = $_POST['fechaSalida'];


$sql = "SELECT id_reserva 
        FROM reservas 
        WHERE id_apartamento = ? 
        AND fecha_inicio < ? 
        AND fecha_fin > ? 
        LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $idApartamento, $fechaSalida, $fechaEntrada);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    echo "ocupado";
} else {
    echo "libre";
}

$stmt->close();
$conn->close();
?>