<?php
include("./php/conexionBD.php");
include("cabecera.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$idApartamento = $_GET['id'] ?? $_GET['id_apartamento'] ?? $_POST['id_apartamento'] ?? $_SESSION['id_apartamento_actual'] ?? null;

if (!$idApartamento) {
    header("Location: index.php");
    exit();
}

$_SESSION['id_apartamento_actual'] = $idApartamento;

// 2. CAPTURAR DATOS DE VUELTA (GET) O DE SESIÓN EXISTENTE
$fechaLlegada = $_GET['llegada']  ?? ($_SESSION['llegada'] ?? '');
$fechaSalida  = $_GET['salida']   ?? ($_SESSION['salida'] ?? '');
$viajeros     = $_GET['viajeros'] ?? ($_SESSION['huespedes'] ?? '1');

// Actualizamos sesión para que el formulario los use
$_SESSION['llegada'] = $fechaLlegada;
$_SESSION['salida'] = $fechaSalida;
$_SESSION['huespedes'] = $viajeros;

$consulta = "SELECT * FROM apartamentos WHERE id_apartamento = '$idApartamento' AND activo = 0";
$datos = $conn->query($consulta);

if ($datos && $datos->num_rows > 0) {
    $fila = $datos->fetch_assoc();
} else {
    header("Location: ./php/errorApartamento.php");
    exit();
}

// Calcular noches para el precio inicial
$noches = 0;
if (!empty($fechaLlegada) && !empty($fechaSalida)) {
    $noches = (strtotime($fechaSalida) - strtotime($fechaLlegada)) / 86400;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$fila['nombre']?></title>

    <link rel="stylesheet" href="./librerias/bootstrap5.3.8/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/apartamento.css">
    <link rel="shortcut icon" href="img/logoCasaGo.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/3b89af0a27.js" crossorigin="anonymous"></script>
    <script src="./librerias/bootstrap5.3.8/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./librerias/alertifyjs/css/alertify.min.css">
    <link rel="stylesheet" href="./librerias/alertifyjs/css/themes/default.min.css">

    <link rel="stylesheet" href="./css/apartamento.css">
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
    <div class="principal">
        <div class="titulo">
            <h2><?=$fila['nombre']?></h2>
            <h5><?=$fila['direccion']?></h5>
            
        </div>
        <div class="galeria">
            <?php
                $consulta2 = "SELECT * FROM imagenes_apartamento WHERE id_apartamento = '$idApartamento'";
                $datos2 = $conn->query($consulta2); 
                if ($datos2 && $datos2->num_rows > 0) {
                    while ($fila2 = $datos2->fetch_assoc()) {
                        ?>
                        <div class="item">
                            <img src="<?=$fila2['url_imagen']?>" alt="Imagen del apartamento">
                        </div>
                        <?php
                    }
                } else {
                    echo "<p>No hay imágenes disponibles para este apartamento.</p>";
                }
            ?>  

        </div>
        <?php
        
            $noches = (strtotime($_SESSION['salida'] ?? '') - strtotime($_SESSION['llegada'] ?? '')) / 86400;


        ?>
        <div class="debajoGaleria">
            
            <div class="izquierda">
                <div class="detalles fila">
                    <p><?=$fila['descripcion']?></p>
                </div>
                <div class="servicios fila">
                    <h4>Servicios de este apartamento</h4>
                    <?php
                    $sqlServicios = "SELECT s.nombre_servicio 
                                    FROM apartamentos a
                                    JOIN apartamento_servicios asoc ON a.id_apartamento = asoc.id_apartamento
                                    JOIN servicios s ON asoc.id_servicio = s.id_servicio
                                    WHERE a.id_apartamento = '$idApartamento'";
                    $resultadoServicios = $conn->query($sqlServicios);
                    if ($resultadoServicios && $resultadoServicios->num_rows > 0) {
                        while ($filaServicio = $resultadoServicios->fetch_assoc()) {
                            echo "<p>- " . $filaServicio['nombre_servicio'] . "</p>";
                        }
                    } else {
                        echo "<p>No hay servicios disponibles para este apartamento.</p>";
                    }
                    ?>
                </div>
                <div class="valoracion">
                    <h4>Valoración de este apartamento</h4>
                    
                    <?php

                        // PUNTUACION
                        $sqlPuntuacion = "SELECT 
                            ROUND(AVG(puntuacion), 1) AS puntuacion_media,
                            COUNT(*) AS total_valoraciones
                            FROM valoraciones 
                            WHERE id_apartamento = '$idApartamento'";

                        $resultadoPuntuacion = $conn->query($sqlPuntuacion);
                        $filaPuntuacion = $resultadoPuntuacion->fetch_assoc();

                        if ($filaPuntuacion['total_valoraciones'] == 0) {
                            echo "No tiene valoraciones aún";
                        } else {
                            echo "<span class='puntuacion'>".$filaPuntuacion['puntuacion_media']." ⭐</span>";
                            echo "<span class='totalPuntuacion'>".$filaPuntuacion['total_valoraciones']." valoraciones</span>";
                        }
                        ?>

                        <?php
                        // COMENTARIOS
                        $sqlValoracion = "SELECT valoraciones.*, usuarios.nombre FROM valoraciones JOIN usuarios ON valoraciones.id_usuario = usuarios.id_usuario WHERE id_apartamento = '$idApartamento'";
                        $resultadoValoracion = $conn->query($sqlValoracion);

                        $filasV = $resultadoValoracion->num_rows;
                    ?>
                    
                    <div class="comentarios">
                        <?php
                        if ($resultadoValoracion && $resultadoValoracion->num_rows > 0) {
                            while ($filaValoracion = $resultadoValoracion->fetch_assoc()) {
                                ?>
                                <div class='comentario'>
                                    <div class="usuario">
                                        <i class='fa-solid fa-user'></i>
                                        <p><?=$filaValoracion['nombre']?></p>
                                    </div>
                                    <div class="fechaVal">
                                        <div class="puntIndividual"><?=$filaValoracion['puntuacion']?> / 10</div>
                                        <p><?=$filaValoracion['fecha']?></p>
                                    </div>
                                    <div class="comentario-text">
                                        <p><?=$filaValoracion['comentario']?></p>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="reservar">
                <div class="fondoForm">
                    <form onsubmit="return false;" id="formReserva">
                        <?php

                            $totalNumerico = ($noches > 0) ? ($noches * $fila['precio_noche']) : 0;

                            $textoMostrar = ($totalNumerico <= 0) ? "Precio por noche: " . $fila['precio_noche'] . "€" : $totalNumerico . "€ en total";
                        ?>
                        <h4 id="totalPrecio"><?php echo $textoMostrar; ?></h4>
                        <div class="fechas">
                            <div class="field" id="llegadaCampo">
                                <label>Llegada</label>
                                <input type="date" name="llegada" id="fechaLlegada" value="<?=$_SESSION['llegada'] ?? ''; ?>">
                            </div>

                            <div class="field">
                                <label>Salida</label>
                                <input type="date" name="salida" id="fechaSalida" value="<?=$_SESSION['salida'] ?? ''; ?>">
                            </div>
                        </div>
                        
                        <div class="viajeros">
                            <div class="field">
                                <label>Viajeros</label>
                                <input id="viajeros" type="number" placeholder="Número de viajeros" name="viajeros" min="1" value="<?=$_SESSION['huespedes'] ?? '1'; ?>">
                            </div>
                        </div>

                        <div id="modal" class="modal-personalizado" style="display:none; position:fixed; z-index:1000; left:0; top:50; width:100%; height:100%; background-color:rgba(0,0,0,0.9); text-align:center; padding-top:50px;">
                            <span class="cerrar" style="position:absolute; top:20px; right:35px; color:white; fontSize:40px; cursor:pointer;">&times;</span>
                            <img id="imgGrande" style="max-width:80%; max-height:80%; margin:auto; display:block;">
                        </div>
                        
                        <input type="hidden" name="precioT" value="<?=$totalNumerico?>">
                        <input type="hidden" name="precioNoche" value="<?=$fila['precio_noche']?>">
                        <input type="hidden" id="idApartamento" name="idApartamento" value="<?=$idApartamento?>">
                        <input type="hidden" name="noches" value="<?=$noches?>">

                        <div class="boton">
                            <button type="button" class="btnFormu" id="btnReservar">Reservar</button>
                        </div>
                            <small style="text-align: center; display: block; margin-top: 10px;">Aún no se te cobrará nada</small>
                        </div>
                    </form>
                    
            </div>
        </div>
        
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="./librerias/alertifyjs/alertify.min.js"></script>
    <script src="./js/modalImagenes.js"></script>
    <script src="./js/apartamento.js"></script>
    
    <?php include 'footer.php';  ?>