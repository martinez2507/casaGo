<?php

// echo "
//         <form action='comprobarCorreo.php'>
//             <input type='text' name='codigo'>
//             <button type='submit'></button>
//         </form>
        
//     ";

//     if
?>
<?php
session_start();
if (!isset($_SESSION['reg_email'])) {
    header("Location: registro.php");
    exit();
}?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Verifica tu cuenta | Airbnb Clone</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f7f7f7; }
        .card { background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; width: 100%; max-width: 400px; }
        h2 { margin-top: 0; color: #222; }
        p { color: #717171; font-size: 14px; }
        input[type="number"] { 
            width: 80%; padding: 12px; margin: 20px 0; border: 1px solid #ccc; border-radius: 8px; 
            font-size: 24px; text-align: center; letter-spacing: 5px; 
        }
        button { 
            background-color: #FF385C; color: white; border: none; padding: 12px 24px; 
            border-radius: 8px; font-weight: bold; cursor: pointer; width: 100%; font-size: 16px;
        }
        button:hover { background-color: #E31C5F; }
        .error-msg { color: #d93025; font-size: 13px; margin-bottom: 10px; }
        .email-highlight { font-weight: bold; color: #222; }
    </style>
</head>
<body>

<div class="card">
    <h2>Confirma tu identidad</h2>
    <p>Hemos enviado un código de 6 dígitos a:<br> 
       <span class="email-highlight"><?php echo htmlspecialchars($_SESSION['reg_email']); ?></span>
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