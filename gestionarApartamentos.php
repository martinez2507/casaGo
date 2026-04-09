<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Apartamentos</title>

    <link rel="stylesheet" href="./librerias/bootstrap5.3.8/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="./css/responsivoIndex.css">
    <link rel="shortcut icon" href="./img/logoCasaGo.png" type="image/x-icon">
    

    <link rel="stylesheet" href="./librerias/alertifyjs/css/alertify.min.css">
    <link rel="stylesheet" href="./librerias/alertifyjs/css/themes/default.min.css">
    
</head>
<body>

<?php
session_start();
include 'cabecera.php';
?>
<div class="container mt-5">
    <h1>Gestionar Apartamentos</h1>
    <p>Aquí puedes ver, editar o eliminar tus apartamentos publicados.</p>

    <?php
    include './php/conexionBD.php';
    $sql = "SELECT * FROM apartamentos WHERE id_anfitrion = '$_SESSION[id_usuario]'";
    $consulta = $conn->query($sql);
    if($consulta->num_rows > 0) {
        while($apartamento = $consulta->fetch_assoc()) {
            ?>
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="<?= $apartamento['imagen_portada']; ?>" class="img-fluid rounded-start" alt="<?= $apartamento['nombre']; ?>" width="500" height="400">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <form action="actualizarApartamento.php" method="post">
                                <h5 class="card-title"><?= $apartamento['nombre']; ?></h5>
                                <p class="card-text"><?= $apartamento['descripcion']; ?></p>
                                <button class="btn btn-primary" data-id="<?= $apartamento['id_apartamento']; ?>">Editar</button>
                                <button class="btn btn-danger" data-id="<?= $apartamento['id_apartamento']; ?>">Eliminar</button>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
    ?>
</div>
