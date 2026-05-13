<?php
include("conexionBD.php");
$metodo = $_SERVER['REQUEST_METHOD'];
if ($metodo === 'GET') {
    
    $consulta = "SELECT r.id_reserva, u.nombre AS nombre_anfitrion, a.nombre AS nombre_apartamento, CONCAT(a.direccion, ', ', a.ciudad) AS ubicacion, r.precio_total, res.nombre AS reservador, r.fecha_inicio, r.fecha_fin FROM reservas r JOIN apartamentos a ON r.id_apartamento = a.id_apartamento JOIN usuarios u ON a.id_anfitrion = u.id_usuario JOIN usuarios res ON r.id_usuario = res.id_usuario ORDER BY r.id_reserva DESC"; 
    $resultado = mysqli_query($conn, $consulta);

    $json = array("data" => array());

    if ($resultado) {
        while ($row = mysqli_fetch_assoc($resultado)) {

            $item = array(
                'ID_RESERVA' => $row['id_reserva'],
                'ANFITRION' => $row['nombre_anfitrion'],
                'APARTAMENTO' => $row['nombre_apartamento'],
                'UBICACION' => $row['ubicacion'],
                'PRECIO_TOTAL' => $row['precio_total']. "€",
                'RESERVADOR' => $row['reservador'],
                'FECHA_INICIO' => $row['fecha_inicio'],
                'FECHA_FIN' => $row['fecha_fin'],
            );

            $json['data'][] = $item;
        }
    }

    header('Content-Type: application/json');
    echo json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}