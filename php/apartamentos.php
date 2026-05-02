<?php

include("conexionBD.php");
$consulta = "SELECT * FROM apartamentos"; 
$resultado = mysqli_query($conn, $consulta);

$json = array("data" => array());

if ($resultado) {
    while ($row = mysqli_fetch_assoc($resultado)) {
        
        $id = $row['id_apartamento'];
        
        $btnAcciones = "<div class='botones-tabla'>";
        $btnAcciones .= "<button class='btn-aprobar' onclick='gestionarApartamento($id, 1)' title='Aprobar'><i class='fa-solid fa-check'></i></button>";
        $btnAcciones .= "<button class='btn-rechazar' onclick='gestionarApartamento($id, 2)' title='Rechazar'><i class='fa-solid fa-xmark'></i></button>";
        $btnAcciones .= "</div>";

        $item = array(
            'ID_APARTAMENTO' => $id,
            'NOMBRE' => $row['nombre'],
            'DIRECCION' => $row['direccion'],
            'PRECIO' => $row['precio_noche'] . " €",
            'ACCIONES' => $btnAcciones
        );

        $json['data'][] = $item;
    }
}

header('Content-Type: application/json');
echo json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);