<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - CasaGo</title>
    <link rel='stylesheet' type='text/css' media='screen' href='./css/registro.css'>
    <link rel="stylesheet" href="./librerias/alertifyjs/css/alertify.min.css">
    <link rel="stylesheet" href="./librerias/alertifyjs/css/themes/default.min.css">
    <link rel="shortcut icon" href="./img/logoCasaGo.png" type="image/x-icon">
</head>
<body>
    <?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    ?>
    
    <div class="fondoForm">
        <div class="contLogin registro-modo">
            
            <div class="contF">
                <img src="./img/logoCasaGo.png" alt="logoCasaGo" class="logo-registro" width= "150px" height="150px">
                <h1>Crea tu cuenta</h1>
                
                <form action="./php/mandarCorreo.php" method="post">
                    <label>Nombre completo</label>
                    <input type="text" name="nombre" id="nombre" placeholder="Tu nombre" required>
                    
                    <label>Correo electrónico</label>
                    <input type="email" name="correo" id="correo" placeholder="correo@ejemplo.com" required>
                    
                    <div class="contraseña">
                        <label>Contraseña</label>
                        <div class="input-group">
                            <input type="password" name="contraseña" id="contraseña" placeholder="Mínimo 8 caracteres" required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$">

                            <button type="button" id="mostrarContrasenha"><i class="fas fa-eye"></i></button>
                        </div>
                        <small>La contraseña debe incluir una minúscula, una mayúscula, un número y un caracter especial</small>
                    </div>

                    <button type="submit" class="formu">Unirse ahora</button>
                </form>

                <p class="texto-inferior">
                    ¿Ya tienes cuenta? <a href="./login.php">Inicia sesión aquí</a>
                </p>
            </div>

            <div class="imagen">
                <div class="imagen-texto">
                    <h2>Únete a la comunidad</h2>
                    <p>Encuentra el apartamento que siempre soñaste con CasaGo en solo unos clics.</p>
                </div>
            </div>

        </div>
    </div>

    <script src="./librerias/alertifyjs/alertify.min.js"></script>
    <?php
    if(isset($_SESSION['usuario'])) {
        echo "<h1 style='position:fixed; bottom:10px; left:10px; font-size:1rem;'>Usuario: " .$_SESSION['usuario'] . "</h1>";
    }


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
    <?php include 'footer.php';  ?>
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