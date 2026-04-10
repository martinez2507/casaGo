<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gestionar Apartamentos</title>

        <link rel="stylesheet" href="./librerias/bootstrap5.3.8/css/bootstrap.min.css">
        
        <link rel="stylesheet" href="./css/responsivoIndex.css">
        <link rel="shortcut icon" href="./img/logoCasaGo.png" type="image/x-icon">
        

        <link rel="stylesheet" href="./librerias/alertifyjs/css/alertify.min.css">
        <link rel="stylesheet" href="./librerias/alertifyjs/css/themes/default.min.css">
        <link rel="stylesheet" href="./css/styles.css">
        <link rel="stylesheet" href="./css/subirApartamento.css">
        
    </head>
    <body>

        <?php
        session_start();
        include 'cabecera.php';
        include './php/conexionBD.php';
        ?>
        <div class="container mt-5">
            <form action="./php/guardar_apartamento.php" method="POST" enctype="multipart/form-data">
    
            <div class="mb-3">
                <label>Nombre del Apartamento:</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Descripción:</label>
                <input type="text" name="descripcion" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Precio por noche:</label>
                <input type="number" name="precio_noche" class="form-control" step="0.01" required>
            </div>

            <div class="mb-3">
                <label>Ciudad:</label>
                <input type="text" name="ciudad" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Dirección:</label>
                <input type="text" name="direccion" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Capacidad:</label>
                <input type="number" name="capacidad" class="form-control" required>
            </div>

            <div class="mb-3">
                <?php
                $res = mysqli_query($conn, "SELECT * FROM servicios");
                while ($serv = mysqli_fetch_assoc($res)) {
                    echo '<label>';
                    // El nombre debe ser un array: servicios[]
                    echo '<input type="checkbox" name="servicios[]" value="' . $serv['id_servicio'] . '"> ';
                    echo $serv['nombre_servicio'];
                    echo '</label><br>';
                }?>
            </div>

            <div class="mb-3">
                <label>Selecciona varias fotos:</label>
                <input type="file" name="fotos[]" class="form-control" accept="image/*" multiple required>
                <small class="text-muted">La primera foto se usará para la portada del apartamento.</small>
            </div>

            <button type="submit" class="btn btn-primary">Publicar Apartamento</button>
    </form>
        </div>
    </body>
</html>