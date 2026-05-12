<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include_once("conexionBD.php");

$ciudad = $_REQUEST['ciudad'] ?? $_REQUEST['lugar'] ?? '';
$precio_max = $_REQUEST['precio'] ?? 2000;
$extras = $_REQUEST['extras'] ?? [];
$huespedes = $_SESSION['huespedes'] ?? 1;
$llegada = $_SESSION['llegada'] ?? '';
$salida = $_SESSION['salida'] ?? '';

$consulta = "SELECT a.* FROM apartamentos a WHERE 1=1";

if (!empty($ciudad)) {
    $consulta .= " AND (a.ciudad LIKE '%$ciudad%' OR a.direccion LIKE '%$ciudad%')";
}

$consulta .= " AND a.capacidad >= $huespedes";
$consulta .= " AND a.precio_noche <= $precio_max";
$consulta .= " AND a.activo = 0 ";

if (!empty($llegada) && !empty($salida)) {
    $consulta .= " AND a.id_apartamento NOT IN (
        SELECT r.id_apartamento FROM reservas r
        WHERE NOT (r.fecha_fin < '$llegada' OR r.fecha_inicio > '$salida')
    )";
}

if (!empty($extras)) {
    foreach ($extras as $id_serv) {
        $id = (int)$id_serv;
        $consulta .= " AND a.id_apartamento IN (SELECT id_apartamento FROM apartamento_servicios WHERE id_servicio = $id)";
    }
}

$datos = $conn->query($consulta);
$filas_count = $datos->num_rows;

if ($ciudad == '') {
    echo "<h2>Hay un total de $filas_count apartamentos en España.</h2>";
} else {
    echo "<h2>Hay un total de $filas_count apartamentos en $ciudad.</h2>";
}

if ($filas_count > 0) {
    while ($apto = $datos->fetch_assoc()) {
        $resVal = $conn->query("SELECT ROUND(IFNULL(AVG(puntuacion), 0), 1) as media FROM valoraciones WHERE id_apartamento = {$apto['id_apartamento']}");
        $puntuacion = $resVal->fetch_assoc()['media'] ?? 0;
        ?>
        <form action="apartamento.php" method="GET" target="_blank">
            <div class="apartamento">
                <input type="hidden" name="id" value="<?=$apto['id_apartamento']?>">
                <div class="nomImg">
                    <button type="submit"><img class="imgApt" src="<?=$apto['imagen_portada']?>"></button>
                    <div class="desc">
                        <div class="titVal">
                            <button type="submit">
                                <h4><?=$apto['nombre']?></h4>
                            </button>
                            <?= $puntuacion > 0 ? "<span class='valoracion'>$puntuacion ⭐</span>" : "<span class='nuevo'>Nuevo</span>" ?>
                        </div>
                        <div class="detalles"><p><?=$apto['descripcion']?></p></div>
                        <div><h5><?=$apto['precio_noche']?>€</h5></div>
                    </div>
                </div>
            </div>
        </form>
        <?php
    }
} else {
   echo "
    <div class='sin-resultados'>
        <img src='./img/sinResultados.png' alt='Sin resultados'>
        <p>No hemos encontrado apartamentos que coincidan con tus filtros.</p>
        <button type='button' onclick='window.location.reload();'>Limpiar filtros</button>
    </div>";
}