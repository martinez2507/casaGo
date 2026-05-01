<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include_once("./php/conexionBD.php");

// Recoger datos iniciales para la sesión
if(isset($_REQUEST['llegada'])) $_SESSION['llegada'] = $_REQUEST['llegada'];
if(isset($_REQUEST['salida'])) $_SESSION['salida'] = $_REQUEST['salida'];

if(isset($_REQUEST['huespedes'])) {
    $_SESSION['huespedes'] = (int)$_REQUEST['huespedes'];
}
if(!isset($_SESSION['huespedes']) || $_SESSION['huespedes'] == 0){
    $_SESSION['huespedes'] = 1;
}

$ciudad = $_REQUEST['lugar'] ?? $_REQUEST['ciudad'] ?? '';
$precio_max = $_REQUEST['precio'] ?? 2000;
$extras = $_REQUEST['extras'] ?? [];

// Validación de fechas
if (!empty($_SESSION['llegada']) && !empty($_SESSION['salida'])) {
    if ($_SESSION['salida'] <= $_SESSION['llegada']) {
        $_SESSION['mensaje'] = "La fecha de salida debe ser posterior a la de llegada";
        $_SESSION['tipo'] = "error";
        header("Location: index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ($ciudad === '') ? "Apartamentos en España" : "Búsquedas en $ciudad"; ?></title>
    
    <link rel="stylesheet" href="./librerias/bootstrap5.3.8/css/bootstrap.min.css">
    <link rel="shortcut icon" href="./img/logoCasaGo.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/3b89af0a27.js" crossorigin="anonymous"></script>
    
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="./css/responsivoIndex.css">
    <link rel="stylesheet" href="./css/busqueda.css">
</head>
<body>
    <?php include 'cabecera.php'; ?>

    <div class="main-container">
        <aside class="sidebar">
            <h3>Filtros</h3>
            <form id="filtros">
                <input type="hidden" name="llegada" value="<?php echo $_SESSION['llegada'] ?? ''; ?>">
                <input type="hidden" name="salida" value="<?php echo $_SESSION['salida'] ?? ''; ?>">
                <input type="hidden" name="huespedes" value="<?php echo $_SESSION['huespedes'] ?? 1; ?>">
                <input type="hidden" name="ciudad" value="<?php echo $ciudad; ?>">
                
                <h4>Precio Máximo:</h4>
                <input type="range" id="precio" name="precio" min="0" max="500" step="10" value="100">
                <span id="precioS">100</span>€

                <h4>Servicios:</h4>
                <div class="filtro-serv">
                <?php
                    $resServ = $conn->query("SELECT * FROM servicios");
                    while ($s = $resServ->fetch_assoc()) {
                        $checked = in_array($s['id_servicio'], $extras) ? 'checked' : '';
                        echo "<label><input type='checkbox' name='extras[]' value='{$s['id_servicio']}' $checked> {$s['nombre_servicio']}</label><br>";
                    }
                ?>
                </div>
            </form>
        </aside>

        <section class="apartamentos" id="resultadosApar">
            <?php include('./php/filtroBusqueda.php'); ?>
        </section>
    </div>

    <script src="./js/filtroBusqueda.js"></script>
</body>
</html>