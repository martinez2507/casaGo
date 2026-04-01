<?php
include("./php/conexionBD.php");

$idApartamento = $_POST['id_apartamento'];

$consulta = "SELECT * FROM apartamentos WHERE id_apartamento = '$idApartamento'";

$datos = $conn->query($consulta);

$filas = $datos->num_rows;
if ($datos && $datos->num_rows > 0) {
    $fila = $datos->fetch_assoc();
} else {
    header("Location: ./php/errorApartamento.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio CasaGo</title>

    <link rel="stylesheet" href="./librerias/bootstrap5.3.8/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="./css/responsivoIndex.css">
    <link rel="shortcut icon" href="./img/logoCasaGo.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/3b89af0a27.js" crossorigin="anonymous"></script>
    <script src="./librerias/bootstrap5.3.8/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="principal">
        <div class="titulo">
            <h2><?=$fila['nombre']?></h2>;
            
        </div>
        <div class="galeria">
            
        </div>
        <div class="detalles"></div>
        <div class="servicios"></div>
        <div class="valoracion">
            <div class="puntuacion"></div>
            <div class="comentarios"></div>
        </div>
    </div>
