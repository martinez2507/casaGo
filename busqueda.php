<?php

include("./php/conexionBD.php");

$ciudad = $_POST['lugar'];

$consulta = "SELECT* FROM apartamentos WHERE ciudad LIKE  '%$ciudad%' OR direccion LIKE '%$ciudad%'";

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
    <title>Búsquedas en <?php echo $ciudad ?></title>

    <link rel="stylesheet" href="./librerias/bootstrap5.3.8/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="./css/responsivoIndex.css">
    <link rel='stylesheet' type='text/css' media='screen' href='./css/busqueda.css'>
    <link rel="shortcut icon" href="./img/logoCasaGo.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/3b89af0a27.js" crossorigin="anonymous"></script>
    <script src="./librerias/bootstrap5.3.8/js/bootstrap.min.js"></script>
</head>
<body>
    <?php include("./header.php"); ?>
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
        echo "<h2>Hay un total de $filas apartamentos en $ciudad.</h2>";

        while ($filas = $datos->fetch_assoc()) {
    ?>
    <form action="inicio.php" method="POST">
        <div class="apartamento">
            <input type="hidden" name="id_apartamento" value="<?=$filas['id_apartamento']?>">

            <div class="nomImg">

                <img width="300px" height="200px" src="<?=$filas['imagen_portada']?>">

                <div class="desc">
                    <h4><?=$filas['nombre']?></h4>

                    <div class="detalles">
                        <?=$filas['descripcion']?>
                        <h5><?=$filas['precio_noche']?>€</h5>
                    </div>
            </div>

                
            </div>
            
        </div>
    </form>
    <?php
    }?>
    </section>
</div>