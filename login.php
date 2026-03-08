<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel='stylesheet' type='text/css' media='screen' href='./css/styles.css'>
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
            <h1>Inicia sesión</h1>
            <form action="loginF.php" method="post">
                <label>Introduzca correo:</label>
                <input type="text" name="correo" id="correo" required><br></br>
                <label>Introduzca contraseña</label>
                <input type="password" name="contraseña" id="contraseña" required><br>
                <button type="submit" class="formu">Login</button>
            </form>
        </div>
    </div>
    
</body>
</html>