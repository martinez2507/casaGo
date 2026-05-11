

<?php
include 'conexionBD.php';
if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio_noche'];
$ciudad = $_POST['ciudad'];
$direccion = $_POST['direccion'];
$capacidad = $_POST['capacidad'];
$id_anfitrion = $_SESSION['id_usuario'];


$servicios_seleccionados = isset($_POST['servicios']) ? $_POST['servicios'] : [];

$sql = "INSERT INTO apartamentos (nombre,id_anfitrion, descripcion, precio_noche, ciudad, direccion, capacidad,activo) 
        VALUES (?, ?, ?, ?, ?, ?, ?,?)";
$stmt = $conn->prepare($sql);
$activo = 2; // 0 = activo, 2 = pendiente revisión
$stmt->bind_param("sisdssii", $nombre, $id_anfitrion, $descripcion, $precio, $ciudad, $direccion, $capacidad, $activo);
$stmt->execute();

$id_apartamento = $conn->insert_id;

// INSERTAR LOS SERVICIOS (Tabla intermedia)
if (!empty($servicios_seleccionados)) {
    $sql_serv = "INSERT INTO apartamento_servicios (id_apartamento, id_servicio) VALUES (?, ?)";
    $stmt_serv = $conn->prepare($sql_serv);
    
    foreach ($servicios_seleccionados as $id_servicio) {
        $stmt_serv->bind_param("ii", $id_apartamento, $id_servicio);
        $stmt_serv->execute();
    }
}

// SUBIDA DE FOTOS
if (isset($_FILES['fotos'])) {
    $fotos = $_FILES['fotos'];
    $total = count($fotos['name']);
    
    $directorio_fisico = "../img/apartamentos/";

    if (!is_dir($directorio_fisico)) {
        mkdir($directorio_fisico, 0777, true);
    }

    for ($i = 0; $i < $total; $i++) {
        if ($fotos['error'][$i] === UPLOAD_ERR_OK) {
            
            $nombre_archivo = time() . "_" . $i . "_" . basename($fotos['name'][$i]);
            $tmp_name = $fotos['tmp_name'][$i];
            
            $ruta_para_mover = $directorio_fisico . $nombre_archivo;
            
            $ruta_db = "./img/apartamentos/" . $nombre_archivo;

            if (move_uploaded_file($tmp_name, $ruta_para_mover)) {
                
                $sql_img = "INSERT INTO imagenes_apartamento (id_apartamento, url_imagen) VALUES (?, ?)";
                $stmt_img = $conn->prepare($sql_img);
                $stmt_img->bind_param("is", $id_apartamento, $ruta_db);
                $stmt_img->execute();

                if ($i === 0) {
                    $sql_portada = "UPDATE apartamentos SET imagen_portada = ? WHERE id_apartamento = ?";
                    $stmt_p = $conn->prepare($sql_portada);
                    $stmt_p->bind_param("si", $ruta_db, $id_apartamento);
                    $stmt_p->execute();
                }
            } else {
                echo "Error: No se pudo mover el archivo " . $fotos['name'][$i];
            }
        }
    }
}

header("Location: ../gestionarApartamentos.php");
exit();
?>