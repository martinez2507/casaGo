<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="./css/styles.css">
    <link rel='stylesheet' type='text/css' media='screen' href='./css/registro.css'>
    <link rel="stylesheet" href="./librerias/alertifyjs/css/alertify.min.css">
    <link rel="stylesheet" href="./librerias/alertifyjs/css/themes/default.min.css">
</head>
<body>  
    <?php 
    if (session_status() === PHP_SESSION_NONE) { session_start(); }
    ?>

    <div class="fondoForm">
        <div class="contLogin">
            <div class="imagen">
                <div class="imagen-texto">
                    <h2>¡Bienvenido de nuevo!</h2>
                </div>
            </div>

            <div class="contF">
                <img src="./img/logoCasaGo.png" alt="logoCasaGo" width= "200px" height="200px">
                <h1>Inicia sesión</h1>
                <form action="./php/loginF.php" method="post">
                    <label>Correo electrónico</label>
                    <input type="email" name="correo" id="correo" placeholder="ejemplo@correo.com" required>
                    
                    <label>Contraseña</label>
                    <input type="password" name="contraseña" id="contraseña" placeholder="********" required>
                    
                    <button type="submit" class="formu">Entrar</button>
                </form>
                
                <p class="texto-registro">
                    ¿No tienes una cuenta? <a href="./registrarse.php">Regístrate aquí</a>
                </p>
            </div>
        </div>
    </div>
    <?php include 'footer.php';  ?>
    <script src="./librerias/alertifyjs/alertify.min.js"></script>
    <?php
    if (isset($_SESSION['mensaje'])) {
        $mensaje = $_SESSION['mensaje'];
        $tipo = $_SESSION['tipo'];
        echo "<script>
            alertify.set('notifier','position', 'top-right');
            alertify.$tipo('$mensaje');
        </script>";
        unset($_SESSION['mensaje'], $_SESSION['tipo']);
    }
    ?>
</body>
</html>