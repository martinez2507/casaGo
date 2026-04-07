<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./librerias/bootstrap5.3.8/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/responsivoIndex.css">
    <link rel="shortcut icon" href="./img/logoCasaGo.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/3b89af0a27.js" crossorigin="anonymous"></script>
    <script src="./librerias/bootstrap5.3.8/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./css/styles.css">

    <link rel="stylesheet" href="alertify/css/alertify.min.css">
    <link rel="stylesheet" href="alertify/css/themes/default.min.css">

    <script src="alertify/alertify.min.js"></script>
</head>
<body>
    <header id="header">
        <div class="logo">CasaGo</div>
        <nav class="user-menu">
            <?php
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            if(isset($_SESSION['usuario'])) {
                echo "<button class='btn btn-primary yaIniciado'>Hazte anfitrión</button>";
                echo "<a href='./perfil.php'><i class='fas fa-user'></i></a>";
                echo "<span class='user-name'> ". $_SESSION['usuario'] . " </span>";
                echo '<a href="./php/cerrarSesion.php"><i class="fas fa-sign-out-alt"></i></a>';
            } else {
                echo "<a href='./login.php'><button class='btn btn-primary iniciarSesion'>Iniciar sesión</button></a>";
                echo "<a href='./registrarse.php'><button class='btn btn-primary registrarse'>Registrarse</button></a>";
            }
            
            ?>
        </nav>
    </header>
</body>
</html>