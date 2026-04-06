<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel='stylesheet' type='text/css' media='screen' href='./css/registro.css'>
    <link rel="stylesheet" href="./librerias/alertifyjs/css/alertify.min.css">
    <link rel="stylesheet" href="./librerias/alertifyjs/css/themes/default.min.css">
</head>
<body>
    <?php 
    session_start();
    
    if(isset($_SESSION['usuario'])) {
        echo "<h1>Usuario: " .$_SESSION['usuario'] . "</h1>";
    }
    
    ?>
    <div class="fondoForm">
        <div class="contLogin">
            <div class="contF">
                <h1>Inicia sesión</h1>
                <form action="./php/loginF.php" method="post">
                    <label>Introduzca correo:</label>
                    <input type="text" name="correo" id="correo" required><br></br>
                    <label>Introduzca contraseña</label>
                    <input type="password" name="contraseña" id="contraseña" required><br>
                    <button type="submit" class="formu">Login</button>
                    <a href="./registrarse.php"><button type="button" class="formu">Registrarse</button></a>
                </form>
            </div>
        </div>
    </div>
    <script src="./librerias/alertifyjs/alertify.min.js"></script>
    <?php
     if (isset($_SESSION['mensaje'])) {

        $mensaje = $_SESSION['mensaje'];
        $tipo = $_SESSION['tipo'];

        echo "<script>
            alertify.set('notifier','position', 'top-right');
            alertify.$tipo('$mensaje');
        </script>";

        unset($_SESSION['mensaje']);
        unset($_SESSION['tipo']);
    }
    ?>
    
</body>
</html>