<?php

include("conexionBD.php");
$consulta = "SELECT * FROM usuarios"; 
$resultado = mysqli_query($conn, $consulta);

$json = array("data" => array());

if ($resultado) {
    while ($row = mysqli_fetch_assoc($resultado)) {
        
        $id = $row['id_usuario'];
        
        if($row['activo'] == 0){
            $btnAcciones = "<button class='btn-deshabilitar' data-id='$id' title='Deshabilitar'><i class='fa-solid fa-toggle-on text-success'></i></button>";
        } else if($row['activo'] == 1){
            $btnAcciones = "<button class='btn-habilitar' data-id='$id' title='Habilitar'><i class='fa-solid fa-toggle-off text-danger'></i></button>";
        } 

        $item = array(
            'ID_USUARIO' => $id,
            'NOMBRE' => $row['nombre'],
            'CORREO' => $row['correo_electronico'],
            'ROL' => $row['rol'],
            'GESTIONAR' => $btnAcciones
        );

        $json['data'][] = $item;
    }
}

header('Content-Type: application/json');
echo json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);