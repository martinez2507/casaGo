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
    $stmt->bind_param("i", $idApartamento); 
    $stmt->execute();


    $resultado = $stmt->get_result();

    $apartamento = $resultado->fetch_assoc();

    header('Content-Type: application/json');
    echo json_encode($apartamento);
    exit;

} else  if($metodo === 'POST') {

    $idApartamento = $_POST['idApartamento'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precioNoche = $_POST['precioNoche'];
    $ciudad = $_POST['ciudad'];
    $direccion = $_POST['direccion'];
    $capacidad = $_POST['capacidad'];
    
    if ($_POST['motivo'] == "guardar"){

        $sql = "UPDATE apartamentos SET nombre = ?,descripcion = ?, precio_noche = ?, ciudad = ?, direccion = ?, capacidad = ? WHERE id_apartamento = ?";
        $stmt = $conn->prepare($sql);

        $activo = 1;
        $stmt->bind_param("ssissii",$nombre,$descripcion,$precioNoche,$ciudad,$direccion,$capacidad,$idApartamento); 
        if ($stmt->execute()) {
            echo "Éxito";
        } else {
            echo "Error: " . $stmt->error;
        }

    } else if ($_POST['motivo'] == "borrar"){

        $sql = "UPDATE apartamentos SET activo = ? WHERE id_apartamento = ?";
        $stmt = $conn->prepare($sql);

        $activo = 1;
        $stmt->bind_param("ii",$activo,$idApartamento); 
        $stmt->execute();

    }
}