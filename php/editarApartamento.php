<?php
if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
include './php/conexionBD.php';

$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo === 'GET') {
    $sql = "SELECT * FROM apartamentos WHERE id_anfitrion = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION['id_usuario']); 
    $stmt->execute();


    $resultado = $stmt->get_result();

    $apartamentos = [];

    if ($resultado) { 
        while ($fila = $resultado->fetch_assoc()) { 
            $apartamentos[] = $fila;
        }
    }

    header('Content-Type: application/json');
    echo json_encode($apartamentos);
} else  if($metodo === 'POST') {
    // Procesar la solicitud POST para actualizar un apartamento
}