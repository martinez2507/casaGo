<?php
?>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['reg_email'])) {
    header("Location: ../index.php");
    exit();
}?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Verifica tu cuenta | Airbnb Clone</title>
    <link rel="stylesheet" href="../css/comprobarCorreo.css">
</head>
<body>

<div class="card">
    <h2>Confirma tu identidad</h2>
    <p>Hemos enviado un código de 6 dígitos a:<br> 
       <span class="email"><?php echo htmlspecialchars($_SESSION['reg_email']); ?></span>
    </p>
    <form action="registrarseF.php" method="POST">
        <input type="number" 
               name="codigo" 
               placeholder="000000" 
               required 
               oninput="if(this.value.length > 6) this.value = this.value.slice(0,6);">
        <button type="submit">Verificar y finalizar</button>
    </form>

    <p style="margin-top: 20px; font-size: 12px;">
        ¿No recibiste el correo? Revisa la carpeta de spam.
    </p>
</div>

</body>
</html>