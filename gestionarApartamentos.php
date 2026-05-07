<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Apartamentos</title>

    <link rel="stylesheet" href="./librerias/bootstrap5.3.8/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="./css/apartamento.css">
    <link rel="shortcut icon" href="./img/logoCasaGo.png" type="image/x-icon">
    

    <link rel="stylesheet" href="./librerias/alertifyjs/css/alertify.min.css">
    <link rel="stylesheet" href="./librerias/alertifyjs/css/themes/default.min.css">
    
</head>
<body>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario'])){
    header("Location: ./login.php");
}
include 'cabecera.php';
?>
<div class="principal">
    <div class="container mt-5">
    <h1>Gestionar Apartamentos</h1>
    <p>Aquí puedes ver, editar o eliminar tus apartamentos publicados.</p>

    <?php
    include './php/conexionBD.php';
    $sql = "SELECT * FROM apartamentos WHERE id_anfitrion = '$_SESSION[id_usuario]' AND activo NOT LIKE 1";
    $consulta = $conn->query($sql);
    if($consulta->num_rows > 0) {
        while($apartamento = $consulta->fetch_assoc()) {
            ?>
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="<?= $apartamento['imagen_portada']; ?>" class="img-fluid rounded-start" alt="<?= $apartamento['nombre']; ?>" width="500" height="400">
                        </div>
                        <div class="col-md-8">
                            <?php if($apartamento['activo'] == 0): ?>
                                <span class="badge bg-success">Habilitado</span>
                            <?php elseif($apartamento['activo'] == 1): ?>
                                <span class="badge bg-danger">Deshabilitado</span>
                            <?php elseif($apartamento['activo'] == 2): ?>
                                <span class="badge bg-warning">Pendiente de aprobación</span>
                            <?php elseif($apartamento['activo'] == 3): ?>
                                <span class="badge bg-danger">Rechazado</span>
                            <?php endif; ?>
                            <div class="card-body">
                                    <h5 class="card-title"><?= $apartamento['nombre']; ?></h5>
                                    <p class="card-text"><?= $apartamento['descripcion']; ?></p>
                                    <button class="btn btn-primary" data-id="<?= $apartamento['id_apartamento']; ?>">Editar</button>
                                    <button class="btn btn-danger btn-borrar" data-id="<?= $apartamento['id_apartamento']; ?>">Eliminar</button>
                                
                            </div>
                        </div>
                    </div>
                </div>
            <?php
        }
    } else {
        ?>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="bi bi-house-add"></i>
                        </div>
                        
                        <h2 class="fw-bold">Aún no tienes apartamentos</h2>
                        <p class="text-muted mb-5">
                            Parece que todavía no has publicado ningún alojamiento. 
                            ¡Empieza ahora y llega a miles de viajeros!
                        </p>

                        <a href="subirApartamento.php" class="btn btn-primary btn-lg btn-lg-custom shadow">
                            <i class="bi bi-plus-lg me-2"></i> Subir mi primer apartamento
                        </a>
                    </div>

                </div>
            </div>
        </div>
<?php
    }
    ?>
</div>
</div>

        <div class="modal fade" id="modalEditar" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Apartamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                   <b><label>Nombre del Apartamento</label></b>
                    <input type="text" id="nombre" class="form-control">
                    
                    <b><label>Descripción</label></b>
                    <textarea id="descripcion" class="form-control" rows="4"></textarea>

                    <b><label for="precioNoche">Precio x Noche:</label></b>
                    <input type="number" id="precioNoche" class="form-control">

                    <b><label for="ciudad">Ciudad:</label></b>
                    <input type="text" id="ciudad" class="form-control">

                    <b><label for="direccion">Dirección:</label></b>
                    <input type="text" id="direccion" class="form-control">

                    <b><label for="capacidad">Capacidad:</label></b>
                    <input type="number" id="capacidad" class="form-control">

                    <br>
                    <button type="button" class="btn btn-success" id="btnGuardar">Guardar</button>
                    
                </div>
                
                </div>
            </div>
        </div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="./librerias/bootstrap5.3.8/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/3b89af0a27.js" crossorigin="anonymous"></script>
<script src="./librerias/alertifyjs/alertify.min.js"></script>
<script src="./js/gestionarApartamento.js"></script>

</body>
</html>
