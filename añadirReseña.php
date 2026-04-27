<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir reseña</title>

    <link rel="stylesheet" href="./librerias/bootstrap5.3.8/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="./css/hacerReseña.css">
    <link rel="shortcut icon" href="./img/logoCasaGo.png" type="image/x-icon">
    

    <link rel="stylesheet" href="./librerias/alertifyjs/css/alertify.min.css">
    <link rel="stylesheet" href="./librerias/alertifyjs/css/themes/default.min.css">
    
</head>
<body>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$idApartamento = $_POST['id_apartamento'];
if (!isset($_SESSION['usuario'])){
    header("Location: ./login.php");
}
include 'cabecera.php';
?>
<section class="contenedor-formulario-resena">
    <div class="formulario-card">
        <h3>Cuéntanos tu experiencia</h3>
        <p>Tu opinión ayuda a otros viajeros a elegir su estancia ideal.</p>

        <form action="./php/insertarReseña.php" method="POST" class="formulario-resena">
            

            <div class="fila-doble">
                <div class="grupo-entrada">
                    <label for="titulo">Título de tu reseña</label>
                    <input type="text" id="titulo" placeholder="Ej: ¡Estancia maravillosa!">
                </div>

                <div class="grupo-entrada">
                <label>Puntuación general sobre 10</label>
                <div class="puntuacion">
                    <input type="number" name="puntos" id="punto" value="5" max="10" min="0">
                    <input type="hidden" name="idApartamento" value="<?=$idApartamento?>">
                    <input type="hidden" name="idUsuario" value="<?php echo$_SESSION['id_usuario']?>">
                </div>
            </div>
            </div>

            <div class="grupo-entrada">
                <label for="comentario">Tu comentario</label>
                <textarea name="comentario" id="comentario" rows="4" placeholder="Cuéntanos detalles sobre la limpieza, la ubicación o el trato recibido..."></textarea>
            </div>

            <button type="submit" class="boton-enviar">Publicar reseña</button>
        </form>
    </div>
</section>
<script>
    document.addEventListener("DOMContentLoaded", function() {
    const formulario = document.querySelector(".formulario-resena");

    formulario.addEventListener("submit", function(evento) {
        const titulo = document.getElementById("titulo").value.trim();
        const comentario = document.getElementById("comentario").value.trim();
        const valoracion = document.getElementById("punto").value.trim();

        if (titulo === "" || comentario === "" ) {
            evento.preventDefault();
            alertify.set('notifier','position', 'top-right');
            alertify.error('Por favor, rellena el título y el comentario antes de publicar.');
            
            return false;
        } else if (valoracion >10 || valoracion < 0) {
            evento.preventDefault();
            alertify.set('notifier','position', 'top-right');
            alertify.error('La puntuación debe estar entre 0 y 10.');
            return false;
        }

    });
});
</script>
<script src="./librerias/alertifyjs/alertify.min.js"></script>
<script src="https://kit.fontawesome.com/3b89af0a27.js" crossorigin="anonymous"></script>
<script src="./librerias/bootstrap5.3.8/js/bootstrap.min.js"></script>
<?php include 'footer.php';  ?>
<script src="./js/script.js"></script>
