<?php

if (session_status() === PHP_SESSION_NONE) { session_start(); }
include("./php/conexionBD.php");

$ciudad = $_POST['destino'];


$consulta = "SELECT * FROM apartamentos a WHERE 1=1";
if (!empty($ciudad)) {
    $ciudad_safe = $conn->real_escape_string($ciudad);
    $consulta .= " AND a.ciudad LIKE '%$ciudad_safe%'";
}
if(isset($_REQUEST['huespedes'])) $_SESSION['huespedes'] = (int)$_REQUEST['huespedes'];

if($_SESSION['huespedes'] == 0){
    $_SESSION['huespedes'] = 1;
}
// echo $consulta;
// exit;
$datos = $conn->query($consulta);

$filas = $datos->num_rows;
?>
<head>
    
</head>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    if($ciudad === '' || $ciudad === null){
        echo "<title>Apartamentos en España</title>";
    } else {
        echo "<title>Búsquedas en $ciudad</title>";
    }
    ?>
    

    <link rel="stylesheet" href="./librerias/bootstrap5.3.8/css/bootstrap.min.css">
    <link rel="shortcut icon" href="./img/logoCasaGo.png" type="image/x-icon">

    <script src="https://kit.fontawesome.com/3b89af0a27.js" crossorigin="anonymous"></script>
    <script src="./librerias/bootstrap5.3.8/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="./css/responsivoIndex.css">
    <link rel='stylesheet' type='text/css' media='screen' href='./css/busqueda.css'>
</head>
<body>
    <?php
    include 'cabecera.php';?>
<div class="main-container">
    <aside class="sidebar">
        <h3>Filtros</h3>
        <form id="filtros">

            <label>Ciudad:</label>
                <input type="text" name="ciudad" id="ciudad" value="<?php echo $ciudad ?? ''; ?>">
            <label>Precio Máximo:</label>
            <input type="range" id="precio" name="precio" min="0" max="2000" step="100">
            <span id="precioS">2000</span>€

            <h4>Servicios:</h4>
            <div class="filtro-serv">
                <label><input type="checkbox" name="extras[]" value="wifi"> Wi-Fi</label><br>
                <label><input type="checkbox" name="extras[]" value="parking"> Parking</label><br>
                <label><input type="checkbox" name="extras[]" value="piscina"> Piscina</label><br>
                <label><input type="checkbox" name="extras[]" value="mascotas"> Admite mascotas</label>
            </div>
        </form>
    </aside>

    <section class="apartamentos" id="resultadosApar">
        <?php

        if($ciudad === '' || $ciudad === null){
        echo "<h2>Hay un total de $filas apartamentos en España.</h2>";
        } else {
            echo "<h2>Hay un total de $filas apartamentos en $ciudad.</h2>";
        }
        

        while ($filas = $datos->fetch_assoc()) {
    ?>
    <form action="apartamento.php" method="POST" target="_blank">
        <div class="apartamento">
            <input type="hidden" name="id_apartamento" value="<?=$filas['id_apartamento']?>">

            <div class="nomImg">

                <img class="imgApt" src="<?=$filas['imagen_portada']?>">

                <div class="desc">
                    <div class="titVal">
                        <button type="submit"><h4><?=$filas['nombre']?></h4></button>
                        <?php 
                        $consulta = "SELECT ROUND(IFNULL(AVG(puntuacion), 0), 1) as media FROM valoraciones WHERE id_apartamento = {$filas['id_apartamento']}";

                        $datosVal = $conn->query($consulta);

                        $totalFilas = $datosVal->num_rows;

                        $puntuacion = 0;
                        if ($datos && $datosVal->num_rows > 0) {
                            $fila = $datosVal->fetch_assoc();
                            $puntuacion = $fila['media'] ?? 0;
                        } else {
                            $puntuacion = 0;
                        }
                        ?>
                        <?= $puntuacion > 0 ?  "<span class='valoracion'>$puntuacion ⭐</span>" :"<span class='nuevo'>Nuevo</span>" ?>
                    </div>

                    <div class="detalles">
                        <p><?=$filas['descripcion']?></p>
                    </div>
                    <div><h5><?=$filas['precio_noche']?>€</h5></div>
            </div>

                
            </div>
            
        </div>
    </form>
    <?php
    }?>
    </section>
</div>