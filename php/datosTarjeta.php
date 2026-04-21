<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include './conexionBD.php';

$metodo = $_SERVER['REQUEST_METHOD'];


if ($metodo === 'GET') {

    $idUsuario = $_GET['idUsuario'];

    $sql = "SELECT * FROM datos_bancarios WHERE id_usuario = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idUsuario);
    $stmt->execute();

    $resultado = $stmt->get_result();
    $datos = $resultado->fetch_assoc();

    header('Content-Type: application/json');
    echo json_encode($datos);
    exit;

} else  if($metodo === 'POST') {

    $idUsuario = $_POST['idUsuario'];
    $titular = $_POST['titular'];
    $numTarjeta = $_POST['numTarjeta'];
    $ccv = $_POST['ccv'];
    $caducidad_raw = $_POST['caducidad']; 
    $caducidad = $caducidad_raw . "-01";

    $sql = "INSERT INTO datos_bancarios (id_usuario,titular,numero_encriptado,fecha_expiracion,num_tarjeta) VALUES (?,?,?,?,?)";
    $stmt = $conn->prepare($sql);

    $activo = 1;
    $stmt->bind_param("isiss",$idUsuario,$titular,$ccv,$caducidad,$numTarjeta); 
    if ($stmt->execute()) {
        echo "Datos guardados correctamente";
    } else {
        echo "Error: " . $stmt->error;
    }
}