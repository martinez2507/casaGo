<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("conexionBD.php");
$metodo = $_SERVER['REQUEST_METHOD'];
if ($metodo === 'GET') {
    
    $consulta = "SELECT * FROM usuarios where activo = 2"; 
    $resultado = mysqli_query($conn, $consulta);

    $json = array("data" => array());

    if ($resultado) {
        while ($row = mysqli_fetch_assoc($resultado)) {
            
            $id = $row['id_usuario'];
            
            
            $btnAprobar = "<button class='btn-aprobarSol' data-id='$id' title='Aprobar'><i class='fa-solid fa-check text-success'></i></button>";
            $btnRechazar = "<button class='btn-rechazarSol' data-id='$id' title='Rechazar'><i class='fa-solid fa-xmark text-danger'></i></button>";
            

            $item = array(
                'ID_USUARIO' => $id,
                'NOMBRE' => $row['nombre'],
                'CORREO' => $row['correo_electronico'],
                'ROL' => $row['rol'],
                'APROBAR' => $btnAprobar,
                'RECHAZAR' => $btnRechazar,
            );

            $json['data'][] = $item;
        }
    }

    header('Content-Type: application/json');
    echo json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}