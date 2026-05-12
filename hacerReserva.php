<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar apartamento</title>

    <link rel="stylesheet" href="./librerias/bootstrap5.3.8/css/bootstrap.min.css">
    <link rel="shortcut icon" href="./img/logoCasaGo.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/3b89af0a27.js" crossorigin="anonymous"></script>
    <script src="./librerias/bootstrap5.3.8/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="./librerias/alertifyjs/css/alertify.min.css">
    <link rel="stylesheet" href="./librerias/alertifyjs/css/themes/default.min.css">
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="./css/reservar.css">
    
</head>
<body>
    <?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    include 'cabecera.php'; 

    if (!empty($_GET)) {
        $_SESSION['datos_reserva_activa'] = $_GET;
        $datos = $_GET; 
    } 
    // Si no hay GET pero hay sesión, usamos la sesión
    elseif (isset($_SESSION['datos_reserva_activa'])) {
        $datos = $_SESSION['datos_reserva_activa'];
    } 
    else {
        header("Location: index.php");
        exit();
    }

    if (!isset($_SESSION['id_usuario'])) {
        $_SESSION['url_previa'] = "hacerReserva.php";
        header("Location: login.php");
        exit();
    }

    $idUsuario = $_SESSION['id_usuario'];
    $idApartamento = $datos['idApartamento'] ?? null;
    $precioNoche = $datos['precioNoche'] ?? 0;
    $viajeros = $datos['viajeros'] ?? 1;

    // Procesamos fechas con seguridad
    $llegada_raw = $datos['llegada'] ?? 'today';
    $salida_raw  = $datos['salida'] ?? 'today';

    $llegada = date("d-m-Y", strtotime($llegada_raw));
    $salida  = date("d-m-Y", strtotime($salida_raw));

    $f_llegada = strtotime($llegada);
    $f_salida = strtotime($salida);
    $noches = ($f_salida - $f_llegada) / 86400;

    $total = (isset($datos['precioT']) && $datos['precioT'] > 0) ? $datos['precioT'] : ($noches * $precioNoche);

    include("php/conexionBD.php");
    $consulta = "SELECT * FROM apartamentos where id_apartamento = '$idApartamento'";
    $resultado = mysqli_query($conn, $consulta);
    $apartamento = mysqli_fetch_assoc($resultado);
    ?>
    <main>
       
    <div class="resumen">
        <div class="cabecera-resumen">
            <h3>Resumen de la reserva</h3>
            <!-- <a href="apartamento.php"><button class="btn-volver">Volver a apartamento</button></a> -->
            <a href="apartamento.php??id=<?= $idApartamento ?>&llegada=<?= $datos['llegada'] ?>&salida=<?= $datos['salida'] ?>&viajeros=<?= $viajeros ?>" class="btn-volver-link">
                 &larr; Volver al apartamento
            </a>
        </div>
        <div class="dentroResumen">
            <img src="<?= $apartamento['imagen_portada']?>" alt="Imagen Apartamento">
            <h3><?=$apartamento['nombre']?></h3>
            <h5 class="direccion"><?=$apartamento['direccion']?></h5>
            
            <div class="fila">
                <div class="dato">
                    <h5>Noches en total:</h5>
                    <span><?=$noches?> noches del</span><br>
                    <span id="llegada"><?=$llegada?></span>
                    <span> al </span>
                    <span id="salida"><?=$salida?></span>
                </div>
                <div class="dato">
                    <h5>Viajeros en total:</h5>
                    <span id="numPersonas"><?=$viajeros?></span>
                </div>
            </div>

            <div class="fila">
                <div class="dato">
                    <h5>Comisión de plataforma:</h5>
                    <span>20€</span>
                </div>
                <div class="dato">
                    <h5>Precio total:</h5>
                    <span id="precioT"><?=$total + 20?></span>
                    <span>€</span>
                    <div id="idApartamento"style="display: none;"><?=$apartamento['id_apartamento'];?></div>
                </div>
            </div>
        </div>
    </div>

    <?php
    
    $consulta2 = "SELECT * FROM datos_bancarios where id_usuario = '$idUsuario'";
    $resultado2 = mysqli_query($conn, $consulta2);
    $row = mysqli_fetch_assoc($resultado2);
    ?>
    <div class="pagos">
        <h3>Datos de pago</h3>
        <div class="filaTarjeta">
            <span>Pago con Tarjeta:</span>
            <img src="./img/visa.png" alt="visa">
            <img src="./img/mastercard.png" alt="mastercard">
        </div>
        
        <p class="subtitulo-pago">Datos de la tarjeta</p>
        
        <div class="datosT">
            <div class="izqTarjeta">
                <label for="titularCuenta">Titular de la tarjeta</label>
                <input type="text" placeholder="titular" id="titularCuenta" name="titular" value="<?php echo !empty($row['titular']) ? $row['titular'] : ''; ?>" >
                <input type="hidden" id="idUsuario" name="idUsuario" value="<?=$_SESSION['id_usuario']?>">

                <label for="numTarjeta">Número de tarjeta</label>
                <input type="number" placeholder="Número de tarjeta" id="numTarjeta" name="numTarjeta" value="<?php echo !empty($row['num_tarjeta']) ? $row['num_tarjeta'] : ''; ?>" >
            </div>
            
            <div class="derTarjeta">
                <label for="CCV">CVV</label>
                <input type="number" placeholder="CVV" id="CCV" name="ccv" value="<?php echo !empty($row['numero_encriptado']) ? $row['numero_encriptado'] : ''; ?>" >

                <label for="caducidad">Caducidad</label>
                <input type="month" id="caducidad" name="caducidad" value="<?php echo !empty($row['fecha_expiracion']) ? $row['fecha_expiracion'] : ''; ?>" >
            </div>
        </div>

        <p class="texto-legal">He leído y acepto los Términos y Condiciones, la Política de Privacidad y las condiciones de cancelación de esta reserva.</p>
        
        <div class="fila-confirmar">
            <label for="checkCondiciones">Aceptar las condiciones</label>
            <input type="checkbox" id="checkCondiciones"><br>
            
        </div>

        <div class="botones">
            <button class="boton-pagar" id ="btn-pagar">Pagar</button>
            <button class='boton-guardar' id='btn-guardar'>Guardar Datos de pago</button>

        </div>
        
        
    </div>
</main>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="./js/reservar.js"></script>
<script src="./librerias/alertifyjs/alertify.min.js"></script>
<?php include 'footer.php';  ?>