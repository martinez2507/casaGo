<?php
include("conexionBD.php");

$idApartamento = $_GET['idApartamento'] ?? null;
$fechaEntrada  = $_GET['fechaEntrada']  ?? null;
$fechaSalida   = $_GET['fechaSalida']   ?? null;

if (!$idApartamento || !$fechaEntrada || !$fechaSalida) {
    echo "error_datos";
    exit();
}

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