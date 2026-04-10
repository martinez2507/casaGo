

<?php
include 'conexionBD.php';
session_start();

// 1. Recoger datos (Asegúrate de que los nombres coincidan con tu formulario)
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio_noche'];
$ciudad = $_POST['ciudad'];
$direccion = $_POST['direccion'];
$capacidad = $_POST['capacidad'];
$id_anfitrion = $_SESSION['id_usuario'];

// Recogemos el array de servicios (los checkboxes)
$servicios_seleccionados = isset($_POST['servicios']) ? $_POST['servicios'] : [];

// 2. INSERTAR EL APARTAMENTO
// Eliminamos "servicios" del INSERT de apartamentos porque ahora van a su propia tabla
$sql = "INSERT INTO apartamentos (nombre, descripcion, precio_noche, ciudad, direccion, capacidad, id_anfitrion) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
// Corregido: Las variables deben coincidir exactamente con las de arriba
$stmt->bind_param("ssdssii", $nombre, $descripcion, $precio, $ciudad, $direccion, $capacidad, $id_anfitrion);
$stmt->execute();

$id_apartamento = $conn->insert_id;

// 3. INSERTAR LOS SERVICIOS (Tabla intermedia)
if (!empty($servicios_seleccionados)) {
    $sql_serv = "INSERT INTO apartamento_servicios (id_apartamento, id_servicio) VALUES (?, ?)";
    $stmt_serv = $conn->prepare($sql_serv);
    
    foreach ($servicios_seleccionados as $id_servicio) {
        $stmt_serv->bind_param("ii", $id_apartamento, $id_servicio);
        $stmt_serv->execute();
    }
}

// 4. SUBIDA DE FOTOS
if (isset($_FILES['fotos'])) {
    $fotos = $_FILES['fotos'];
    $total = count($fotos['name']);

    for ($i = 0; $i < $total; $i++) {
        if ($fotos['error'][$i] === UPLOAD_ERR_OK) {
            
            $nombre_archivo = time() . "_" . $fotos['name'][$i]; // Añadimos timestamp para evitar nombres duplicados
            $tmp_name = $fotos['tmp_name'][$i];
            $ruta_destino = "uploads/" . $nombre_archivo; // Ruta relativa para la DB

            if (move_uploaded_file($tmp_name, $ruta_destino)) {
                
                // Insertar en imagenes_apartamento (usando url_imagen como pediste)
                $sql_img = "INSERT INTO imagenes_apartamento (id_apartamento, url_imagen) VALUES (?, ?)";
                $stmt_img = $conn->prepare($sql_img);
                $stmt_img->bind_param("is", $id_apartamento, $ruta_destino);
                $stmt_img->execute();

                // Si es la primera foto ($i == 0), actualizamos la portada del apartamento
                if ($i === 0) {
                    $sql_portada = "UPDATE apartamentos SET imagen_portada = ? WHERE id_apartamento = ?";
                    $stmt_p = $conn->prepare($sql_portada);
                    $stmt_p->bind_param("si", $ruta_destino, $id_apartamento);
                    $stmt_p->execute();
                }
            }
        }
    }
}

echo "Apartamento registrado con éxito.";
?>