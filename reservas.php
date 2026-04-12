<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas</title>

    <link rel="stylesheet" href="./librerias/bootstrap5.3.8/css/bootstrap.min.css">
    
    <link rel="stylesheet" href="./css/responsivoIndex.css">
    <link rel="shortcut icon" href="./img/logoCasaGo.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/3b89af0a27.js" crossorigin="anonymous"></script>
    <script src="./librerias/bootstrap5.3.8/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="./librerias/alertifyjs/css/alertify.min.css">
    <link rel="stylesheet" href="./librerias/alertifyjs/css/themes/default.min.css">
    <link rel="stylesheet" href="./css/styles.css">
    
</head>
<body>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'cabecera.php';
include './php/conexionBD.php';

$id_usuario_logueado = $_SESSION['id_usuario'];
?>

<div class="container mt-5">
    <h2 class="mb-4">Mis Reservas</h2>
    
    <div class="reservas-lista">
        
        <?php
        $sql = "SELECT 
            r.id_reserva,
            r.fecha_inicio,
            r.fecha_fin,
            r.precio_total,
            r.num_personas,
            a.id_apartamento,
            a.nombre,
            a.descripcion,
            a.ciudad,
            a.imagen_portada
        FROM reservas r
        INNER JOIN apartamentos a ON r.id_apartamento = a.id_apartamento
        WHERE r.id_usuario = $id_usuario_logueado
        ORDER BY r.fecha_inicio DESC";

        $datosReservas = $conn->query($sql);
        $totalReservas = $datosReservas->num_rows;
        ?>

        <div class="container mt-5">
        <h2 class="mb-4">Mis Reservas</h2>

        <?php if ($totalReservas > 0): ?>
            <div class="row">
                <?php while ($res = $datosReservas->fetch_assoc()): ?>
                    <div class="col-12 mb-4">
                        <div class="card card-reserva shadow-sm">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <form action="apartamento.php" method="POST" id="form_img_<?php echo $res['id_reserva']; ?>">
                                        <input type="hidden" name="id_apartamento" value="<?php echo $res['id_apartamento']; ?>">
                                        <img src="<?php echo $res['imagen_portada']; ?>" 
                                             class="reserva-img img-fluid cursor-pointer" 
                                             alt="Apartamento" 
                                             onclick="document.getElementById('form_img_<?php echo $res['id_reserva']; ?>').submit();"
                                             style="cursor: pointer;">
                                    </form>
                                </div>

                                <div class="col-md-8">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h4 class="card-title text-primary"><?php echo $res['nombre']; ?></h4>
                                                <p class="text-muted mb-2"><i class="fas fa-map-marker-alt"></i> <?php echo $res['ciudad']; ?></p>
                                            </div>
                                            <span class="badge bg-info text-dark">Reserva #<?php echo $res['id_reserva']; ?></span>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-sm-6">
                                                <p class="mb-1"><strong>Entrada:</strong> <?php echo date("d/m/Y", strtotime($res['fecha_inicio'])); ?></p>
                                                <p class="mb-1"><strong>Salida:</strong> <?php echo date("d/m/Y", strtotime($res['fecha_fin'])); ?></p>
                                            </div>
                                            <div class="col-sm-6">
                                                <p class="mb-1"><strong>Huéspedes:</strong> <?php echo $res['num_personas']; ?></p>
                                                <p class="mb-1"><strong>Precio Total:</strong> <span class="text-success h5"><?php echo $res['precio_total']; ?>€</span></p>
                                            </div>
                                        </div>

                                        <div class="mt-4 d-flex gap-2">
                                            <form action="apartamento.php" method="POST">
                                                <input type="hidden" name="id_apartamento" value="<?php echo $res['id_apartamento']; ?>">
                                                <button type="submit" class="btn btn-outline-primary">Ver alojamiento</button>
                                            </form>

                                            <form action="nueva_resena.php" method="POST">
                                                <input type="hidden" name="id_apartamento" value="<?php echo $res['id_apartamento']; ?>">
                                                <input type="hidden" name="id_reserva" value="<?php echo $res['id_reserva']; ?>">
                                                <button type="submit" class="btn btn-warning">
                                                    ⭐ Añadir reseña
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-light text-center py-5">
                <p class="h4">Aún no tienes ninguna reserva.</p>
                <a href="index.php" class="btn btn-primary mt-3">Buscar destinos</a>
            </div>
        <?php endif; ?>
    </div>

    <script src="./librerias/bootstrap5.3.8/js/bootstrap.bundle.min.js"></script>
</body>
</html>
    