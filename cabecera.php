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
        <nav>
            <a href="./login.php"><i class="fas fa-user"></i></a>
            <?php
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            if(isset($_SESSION['usuario'])) {
                echo "<span> ". $_SESSION['usuario'] . " </span>";
                echo '<a href="./php/cerrarSesion.php"><i class="fas fa-sign-out-alt"></i></a>';
            }?>
        </nav>
    </header>
</body>
</html>