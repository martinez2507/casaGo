<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel='stylesheet' type='text/css' media='screen' href='./css/estilos.css'>
</head>
<body>
    <?php include('cabecera.html');
    
    session_start();

    if(isset($_SESSION['usuario'])) {
        echo "<h1>Usuario: " .$_SESSION['usuario'] . "</h1>";
    }
    
    ?>
    <div class="contLogin">
        <div class="contF">
            <h1>Registrese</h1>
            <form action="registrarseF.php" method="post">
                <label>Introduzca nombre:</label>
                <input type="text" name="nombre" id="nombre" required><br></br>
                <label>Introduzca correo:</label>
                <input type="email" name="correo" id="correo" required><br></br>
                <label>Introduzca contraseña</label>s
                <input type="password" name="contraseña" id="contraseña" required><br>
                <button type="submit" class="formu">Registrarse</button>
            </form>
        </div>
    </div>
    
</body>
</html>