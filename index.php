<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio CasaGo</title>

    <link rel="stylesheet" href="./librerias/bootstrap5.3.8/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="./css/responsivoIndex.css">
    <link rel="shortcut icon" href="./img/logoCasaGo.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/3b89af0a27.js" crossorigin="anonymous"></script>
    <script src="./librerias/bootstrap5.3.8/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="./librerias/alertifyjs/css/alertify.min.css">
    <link rel="stylesheet" href="./librerias/alertifyjs/css/themes/default.min.css">
    
</head>
<body>
    <?php
     if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    include 'cabecera.php'; 
    ?>
    <main>
        <div class="buscador">
            <div id="carouselExampleSlidesOnly" class="carousel slide carousel-fade" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="./img/playaTarragona.jpg" class="d-block w-100" alt="Playa Tarragona">
                    </div>
                    <div class="carousel-item">
                        <img src="./img/cudillero2.jpg" class="d-block w-100" alt="Cudillero">
                    </div>
                    <div class="carousel-item">
                        <img src="./img/granada.jpg" class="d-block w-100" alt="Granada">
                    </div>
                </div>
            </div>

            <div class="dentroBuscador">
                <h1>Reserva unas vacaciones de ensueño</h1>
                <form action="busqueda.php" method="REQUEST" id="formulario">
                    <div class="search-bar">
                        <div class="field" style="position: relative;">
                            <label>¿A dónde vas?</label>
                            <input type="text" placeholder="Destino" name="lugar" id="input-destino" autocomplete="off">
                        </div>
                        <div class="field">
                            <label>Llegada</label>
                            <input type="date" name="llegada">
                        </div>
                        <div class="field">
                            <label>Salida</label>
                            <input type="date" name="salida">
                        </div>
                        <div class="field">
                            <label>Huéspedes</label>
                            <input type="number" min="1" placeholder="Personas" name="huespedes">
                        </div>
                        <button class="btn-buscar" type="submit">Buscar</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="destinosDestacados">
            <form class="destPopForm"action="./busqueda.php" method="GET">
                <h3>Destinos populares</h3>
                <div class="cartas">
                    <button type="submit" name="lugar" value="Asturias" class="card-btn">
                        <div class="card " style="width: 18rem;">
                            <img src="./img/cudillero2.jpg" class="card-img-top" alt="Cudillero" height="200">
                        <div class="card-body">
                            <p class="card-text">Asturias</p>
                        </div>
                        </div>
                    </button>
                    <button type="submit" name="lugar" value="Galicia" class="card-btn">
                    <div class="card card1" style="width: 18rem;">
                        <a href="./apartamento.php"><img src="./img/galicia.jpeg" class="card-img-top" alt="Galicia" height="200"></a>
                    <div class="card-body">
                        <p class="card-text">Galicia</p>
                    </div>
                    </div>
                    </button>
                    <button type="submit" name="lugar" value="Cataluña" class="card-btn">
                    <div class="card" style="width: 18rem;" >
                        <img src="./img/valdaran3.jpg" class="card-img-top" alt="Val d ´Aran" height="200">
                    <div class="card-body">
                        <p class="card-text">Cataluña</p>
                    </div>
                    </div>
                    </button>
                    <button type="submit" name="lugar" value="Aragón    " class="card-btn">
                    <div class="card card1" style="width: 18rem;">
                        <img src="./img/huesca.jpg" class="card-img-top" alt="Huesca" height="200"> 
                    <div class="card-body">
                        <p class="card-text">Aragón</p>
                        
                    </div>
                </div>
                </button>
            </form>
            
            </div>
            
        </div>
        <div class="ultimosApartamentos">
            <h3>Últimos apartamentos añadidos</h3>
            
            <div class="cartas">
                <?php
                include("php/conexionBD.php");
                $consulta = "SELECT * FROM apartamentos where activo = '0' ORDER BY id_apartamento DESC LIMIT 4 ";
                $resultado = mysqli_query($conn, $consulta);
                while ($apartamento = mysqli_fetch_assoc($resultado)) {

                    echo '<div class="card" style="width: 18rem;">';
                    echo '<form action="./apartamento.php" method="GET">';
                    echo '<input type="hidden" name="id" value="' . $apartamento['id_apartamento'] . '">';
                    echo '<input type="image" src="' . $apartamento['imagen_portada'] . '" class="card-img-top" alt="' . $apartamento['nombre'] . '" height="200" style="display:block;">';
                    echo '<div class="card-body">';
                    echo '<p class="card-text">' . $apartamento['nombre'] . '</p>';
                    echo '</div>';
                    echo '</form>';
                    echo '</div>';
                }
            ?>
            </div>
        </div>
        <div class="funcionamiento">
            <h3>¿Por qué elegirnos?</h3>
            <div class="pasos">
                <div class="paso">
                    <i class="fa-solid fa-calendar-check fa-2x azul" ></i>
                    <h4>Reserva fácil</h4>
                    <p>En pocos clics.</p>
                </div>
                <div class="paso">
                    <i class="fa-solid fa-tag fa-2x naranja"></i>
                    <h4>Mejores precios</h4>
                    <p>Encuentra las mejores ofertas para tu próxima escapada.</p>
                </div>
                <div class="paso">
                    <i class="fa-solid fa-phone-volume fa-2x azul"></i>
                    <h4>Soporte 24 horas</h4>
                    <p>Estamos aquí para ayudarte en cualquier momento.</p>
                </div>
            </div>
        </div>
    </main>
    <?php include 'footer.php';  ?>
    <script src="./js/script.js"></script>
    <script src="./librerias/alertifyjs/alertify.min.js"></script>
    <script>
        
    </script>
    <?php
     if (isset($_SESSION['mensaje'])) {

        $mensaje = $_SESSION['mensaje'];
        $tipo = $_SESSION['tipo'];

        echo "<script>
            alertify.set('notifier','position', 'top-right');
            alertify.$tipo('$mensaje');
        </script>";

        unset($_SESSION['mensaje']);
        unset($_SESSION['tipo']);
    }
    ?>
</body>
</html>
