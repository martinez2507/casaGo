<?php
include("./php/conexionBD.php");

$idApartamento = $_POST['id_apartamento'];

session_start();

$consulta = "SELECT * FROM apartamentos  WHERE id_apartamento = '$idApartamento'";

$datos = $conn->query($consulta);

$filas = $datos->num_rows;
if ($datos && $datos->num_rows > 0) {
    $fila = $datos->fetch_assoc();
} else {
    header("Location: ./php/errorApartamento.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio CasaGo</title>

    <link rel="stylesheet" href="./librerias/bootstrap5.3.8/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/apartamento.css">
    <link rel="shortcut icon" href="./img/logoCasaGo.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/3b89af0a27.js" crossorigin="anonymous"></script>
    <script src="./librerias/bootstrap5.3.8/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="./css/apartamento.css">
</head>
<body>
    <div class="principal">
        <div class="titulo">
            <h2><?=$fila['nombre']?></h2>;
            <h5><?=$fila['direccion']?></h5>;
            
        </div>
        <div class="galeria">
            <?php
                $consulta2 = "SELECT * FROM imagenes_apartamento WHERE id_apartamento = '$idApartamento'";
                $datos2 = $conn->query($consulta2);
            ?>
        </div>
        <?php
            $noches = (strtotime($_SESSION['salida']) - strtotime($_SESSION['llegada'])) / 86400;
            $total = $noches * $fila['precio_noche'];
        ?>
        <div class="debajoGaleria">
            
            <div class="izquierda">
                <div class="detalles">
                    <p><?=$fila['descripcion']?></p>
                </div>
                <div class="servicios"></div>
                <div class="valoracion">
                    <div class="puntuacion"></div>
                    <div class="comentarios"></div>
                </div>
            </div>
            <div class="reservar">
                <div class="fondoForm">
                    <form action="./php/reservar.php" method="POST">
                        <h4><?= $total?>€ en total</h4>

                        

                        <div class="fechas">
                            <div class="field" id="llegadaCampo">
                                <label>Llegada</label>
                                <input type="date" name="llegada" value="<?=$_SESSION['llegada'] ?? ''; ?>">
                            </div>

                            <div class="field">
                                <label>Salida</label>
                                <input type="date" name="salida" value="<?=$_SESSION['salida'] ?? ''; ?>">
                            </div>
                        </div>
                        
                        <div class="viajeros">
                            <div class="field">
                                <label>Viajeros</label>
                                <input type="number" placeholder="Número de viajeros" name="viajeros" min="1" value="<?=$_SESSION['huespedes'] ?? '1'; ?>">
                            </div>
                        </div>
                        
                        <!-- <input type="hidden" name="id_apartamento" value="<?=$idApartamento?>">
                        <input type="date" name="llegada" id="llegada" value="<?=$_SESSION['llegada'] ?? ''; ?>">
                        <input type="date" name="salida" id="salida" value="<?=$_SESSION['salida'] ?? ''; ?>">
                        <input type="number"> -->
                        <button class="btn-reservar">Reservar</button>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
