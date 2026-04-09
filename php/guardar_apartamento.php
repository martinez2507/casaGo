<?php
include 'conexionBD.php';
$nombreApartamento = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precioNoche = $_POST['precio_noche'];
$ciudad = $_POST['ciudad'];
$direccion = $_POST['direccion'];
$capacidad = $_POST['capacidad'];
$servicios = $_POST['servicios'];
$fotos = $_FILES['fotos'];

session_start();
$idAnfitrion = $_SESSION['id_usuario'];

// ismertamos el apartamento en la base de datos
$sql = "INSERT INTO apartamentos (nombre, descripcion, precio_noche, ciudad, direccion, capacidad, servicios, id_anfitrion) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param($nombre, $descripcion, $precio, $ciudad, $direccion, $capacidad, $servicios, $id_anfitrion);
$stmt->execute();

// cogemos el id del apartamento recién insertado para asociar las fotos
$id_apartamento = $conn->insert_id;


if (isset($_FILES['fotos'])) {
    $fotos = $_FILES['fotos'];
    $total = count($fotos['name']);
    $portada_asignada = false;

    for ($i = 0; $i < $total; $i++) {
        if ($fotos['error'][$i] === UPLOAD_ERR_OK) {
            
            $tmp_name = $fotos['tmp_name'][$i];
            
            // Usamos tu lógica de ruta completa
            $ruta_completa = "ruta/de/tu/servidor/" . $fotos['name'][$i]; 

            if (move_uploaded_file($tmp_name, $ruta_completa)) {
                
                // 1. INSERTAR SIEMPRE en la tabla de imágenes (todas van aquí)
                $sql_todas = "INSERT INTO imagenes_apartamento (id_apartamento, ruta) VALUES (?, ?)";
                $stmt_todas = $conn->prepare($sql_todas);
                $stmt_todas->bind_param("is", $id_apartamento, $ruta_completa);
                $stmt_todas->execute();

                // 2. ¿ES LA PRIMERA IMAGEN? La guardamos como portada en la tabla principal
                if ($i === 0) {
                    $sql_portada = "UPDATE apartamentos SET imagen_portada = ? WHERE id = ?";
                    $stmt_portada = $conn->prepare($sql_portada);
                    $stmt_portada->bind_param("si", $ruta_completa, $id_apartamento);
                    $stmt_portada->execute();
                }
            }
        }
    }
}