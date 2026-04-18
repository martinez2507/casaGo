<?php
if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
include './conexionBD.php';

$metodo = $_SERVER['REQUEST_METHOD'];


if ($metodo === 'GET') {
    $idApartamento = $_GET['idApartamento'];

    $sql = "SELECT * FROM apartamentos WHERE id_apartamento = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param( $_SESSION['id_usuario']); 
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

    $idApartamento = $_POST['idApartamento'];
    
    if ($_POST['motivo'] == "guardar"){

    

    } else if ($_POST['motivo'] == "borrar"){

        $sql = "UPDATE apartamentos SET activo = ? WHERE id_apartamento = ?";
        $stmt = $conn->prepare($sql);

        $activo = 1;
        $stmt->bind_param("ii",$activo,$idApartamento); 
        $stmt->execute();

    }
}