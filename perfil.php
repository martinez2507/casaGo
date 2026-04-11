<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="./librerias/bootstrap5.3.8/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="./css/responsivoIndex.css">
    <link rel="shortcut icon" href="./img/logoCasaGo.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/3b89af0a27.js" crossorigin="anonymous"></script>
    <script src="./librerias/bootstrap5.3.8/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="./librerias/alertifyjs/css/alertify.min.css">
    <link rel="stylesheet" href="./librerias/alertifyjs/css/themes/default.min.css">
    <link rel="stylesheet" href="./css/perfil.css">
</head>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'cabecera.php';
?>
<body>
    <div class="cabeceraPerfil">
        <h1>Perfil de usuario</h1>
        <h3>Bienvenido, <?= $_SESSION['usuario']; ?>. Este es tu perfil.</h3>
        <!-- Aquí puedes agregar más información del perfil, como reservas, favoritos, etc. -->
    </div>
    <div class="contenedorPerfil">
        <div class="cajaPerfil">
            <h2>Información del usuario</h2>
            <p><strong>Nombre:</strong> <?= $_SESSION['usuario']; ?></p>
            <p><strong>Correo electrónico:</strong> <?= $_SESSION['email']; ?></p>
            <p><strong>Estado actual:</strong> <?= $_SESSION['rol']; ?></p>
        </div>

        <div class="cajaPerfil">
            <h2>Sube tu apartamento</h2>
            <?php
            if($_SESSION['rol'] === 'anfitrion' || $_SESSION['rol'] === 'admin') {
                echo "<form action='subirApartamento.php' method='post'>";
            } else {
                echo "<form action='hazteAnfitrion.php' method='post'>";
            }?>
            <button type="submit" class="subApartamento">Sube tu apartamento y deja que otros lo disfruten <i class="fa-solid fa-arrow-right"></i></button>
        </form>
        </div>

        <?php
        include './php/conexionBD.php';
            $sql = "SELECT * FROM apartamentos WHERE id_anfitrion = '$_SESSION[id_usuario]'";
            $consulta = $conn->query($sql);
            if($consulta->num_rows > 0) {
                ?>
                    <div class="cajaPerfil">
                        <h2>Tus apartamentos</h2>
                        <a href="./gestionarApartamentos.php"><div class="subApartamento">Gestiona tus apartamentos <i class="fa-solid fa-arrow-right"></i></div></a>
                    </div>
                <?php
            } 
        ?>

        <div class="cajaPerfil">
            <h2>Configuración</h2>
            <a href="./configuracion.php"><div class="subApartamento">Edita tu perfil <i class="fa-solid fa-arrow-right"></i></div></a>
        </div>

        <div class="cajaPerfil">
            <h2>Reservas</h2>
            <a href="./reservas.php"><div class="subApartamento">Consulta tus reservas <i class="fa-solid fa-arrow-right"></i></div></a>
        </div>

        <!-- Agrega más detalles del perfil según sea necesario -->
    </div>
         
