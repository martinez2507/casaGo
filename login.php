<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel='stylesheet' type='text/css' media='screen' href='./css/registro.css'>
    <link rel="stylesheet" href="./librerias/alertifyjs/css/alertify.min.css">
    <link rel="shortcut icon" href="./img/logoCasaGo.png" type="image/x-icon">
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
                    
                    <div class="contraseña">
                        <label>Contraseña</label>
                        <div class="input-group">
                            <input type="password" name="contraseña" id="contraseña" placeholder="********" required>

                            <button type="button" id="mostrarContrasenha"><i class="fas fa-eye"></i></button>
                        </div>
                    </div>
                    
                    
                    
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

    <script>

        const btnContrasenha = document.getElementById("mostrarContrasenha");
        btnContrasenha.addEventListener("mousedown", () => {
            hacerVisibleContrasenha("contraseña");
            console.log("Se esta mostrando la contra");
        });

        btnContrasenha.addEventListener("mouseup", () => {
            ocultarContrasenha("contraseña");
            console.log("No se ve la contra");
        });

        function hacerVisibleContrasenha(objetivo) {
            let $campo = document.getElementById(objetivo);
            $campo.type = "text";
        }

        function ocultarContrasenha(objetivo) {
            let $campo = document.getElementById(objetivo);
            $campo.type = "password";
        }
    </script>
</body>
</html>