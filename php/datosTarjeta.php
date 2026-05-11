<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include './conexionBD.php';

$metodo = $_SERVER['REQUEST_METHOD'];


if ($metodo === 'GET') {

    $idUsuario = $_GET['idUsuario'];

    $sql = "SELECT * FROM datos_bancarios WHERE id_usuario = ? order by fecha_guardado desc LIMIT 1 ";
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
    $hoy = date("Y-m-d");


    $sql = "INSERT INTO datos_bancarios (id_dato,id_usuario,titular,numero_encriptado,fecha_expiracion,fecha_guardado) VALUES (?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);

    $activo = 1;
    $stmt->bind_param("sisiss",$numTarjeta,$idUsuario,$titular,$ccv,$caducidad,$hoy); 
    if ($stmt->execute()) {
        echo "Datos guardados correctamente";
    } else {
        echo "Error: " . $stmt->error;
    }
}