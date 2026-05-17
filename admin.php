<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="./librerias/bootstrap5.3.8/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="shortcut icon" href="./img/logoCasaGo.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/3b89af0a27.js" crossorigin="anonymous"></script>
    <script src="./librerias/bootstrap5.3.8/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.bootstrap5.min.css">

    <link rel="stylesheet" href="./librerias/alertifyjs/css/alertify.min.css">
    <link rel="stylesheet" href="./librerias/alertifyjs/css/themes/default.min.css">
    <link rel="stylesheet" href="./css/admin.css">
    <title>Panel de administración - CasaGo</title>
</head>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include './php/sidebar.php';

include("./php/conexionBD.php");
$consultaActivos = "SELECT COUNT(*) as totalAct FROM apartamentos where activo = 0"; 
$resultadoAct = mysqli_query($conn, $consultaActivos);

$consultaPendientes = "SELECT COUNT(*) as totalPend FROM apartamentos where activo = 2"; 
$resultadoPend = mysqli_query($conn, $consultaPendientes);


$nombresMeses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

$datosVentas = array_fill(1, 12, 0); 

$consultaGrafica = "SELECT MONTH(fecha_inicio) as mes_num, COUNT(*) as total 
                    FROM reservas 
                    WHERE YEAR(fecha_inicio) = YEAR(CURDATE()) 
                    GROUP BY MONTH(fecha_inicio) 
                    ORDER BY MONTH(fecha_inicio) ASC";

$resultadoGrafica = mysqli_query($conn, $consultaGrafica);

if ($resultadoGrafica) {
    while($row = mysqli_fetch_assoc($resultadoGrafica)){
        $indice = (int)$row['mes_num'];
        $datosVentas[$indice] = (int)$row['total'];
    }
}

$valoresFinales = array_values($datosVentas);
?>
<body>
    <?php include 'cabecera.php'; ?>
    <div id="wrapper">
        <?php añadirSideBar(); ?>
        <div id="content-wrapper">
            <main class="w-100 flex-grow-1"> 
                <div class="contenedor">
                    <section class="contenido p-4 mt-2">
                        <div class="row mb-4">
                            <div class="col-12">
                                <h2 class="fw-bold text-dark">Panel de Control</h2>
                                <p class="text-muted">Gestión general de CasaGo</p>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="card-indicador activo shadow-sm">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-box bg-success text-white"><i class="fa-solid fa-house-circle-check"></i></div>
                                        <div class="ms-3">
                                            <p class="text-muted mb-0">Apartamentos Activos</p>
                                            <h3 class="fw-bold mb-0"><?php $res = mysqli_query($conn, $consultaActivos); echo mysqli_fetch_assoc($res)['totalAct']; ?></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card-indicador pendiente shadow-sm">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-box bg-warning text-white"><i class="fa-solid fa-clock"></i></div>
                                        <div class="ms-3">
                                            <p class="text-muted mb-0">Apartamentos Pendientes</p>
                                            <h3 class="fw-bold mb-0"><?php $resP = mysqli_query($conn, $consultaPendientes); echo mysqli_fetch_assoc($resP)['totalPend']; ?></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-12">
                                <div class="shadow-sm p-4 border-0" style="background-color: #fff; border-radius: 8px;">
                                    <h5 class="fw-bold mb-4"><i class="fa-solid fa-chart-line me-2 text-primary"></i>Reservas por Mes</h5>
                                    <div class="chart-container">
                                        <canvas id="graficoReservas"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <?php
                            $sqlTopAnfitrion = "SELECT a.nombre, COUNT(r.id_reserva) AS total_reservas
                                                FROM usuarios a
                                                JOIN apartamentos ap ON a.id_usuario = ap.id_anfitrion
                                                JOIN reservas r ON ap.id_apartamento = r.id_apartamento
                                                GROUP BY a.id_usuario
                                                ORDER BY total_reservas DESC
                                                LIMIT 1";
                            $resultTopAnfitrion = mysqli_query($conn, $sqlTopAnfitrion);
                            $topAnfitrion = mysqli_fetch_assoc($resultTopAnfitrion);
                            ?>
                            <h3>Mejor Anfitrión</h3>
                            <div class="award-card">
                                
                                <div class="medal-container">
                                    <div class="medal-ribbon"></div>
                                    <div class="medal-circle">
                                        <i class="fa-solid fa-trophy fa-2x" style="color: #876109;"></i>
                                    </div>
                                </div>
                                <h1><?php echo $topAnfitrion['nombre']; ?></h1>
                                <p style="color: #666; font-size: 0.9rem;">El anfitrión con mayor número de reservas</p>

                                <div class="stats-container">
                                    <div class="stat-box">
                                        <span class="stat-number"><?php echo $topAnfitrion['total_reservas']; ?></span>
                                        <span class="stat-desc">Reservas</span>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $sqlTopReservador = "SELECT u.nombre, COUNT(r.id_reserva) AS total_reservas
                                                FROM usuarios u
                                                JOIN reservas r ON u.id_usuario = r.id_usuario
                                                GROUP BY u.id_usuario, u.nombre
                                                ORDER BY total_reservas DESC
                                                LIMIT 1";
                            $resultTopReservador = mysqli_query($conn, $sqlTopReservador);
                            $topReservador = mysqli_fetch_assoc($resultTopReservador);
                            ?>
                            <div class="award-card">
                                <div class="medal-container">
                                    <div class="medal-ribbon"></div>
                                    <div class="medal-circle">
                                        <i class="fa-solid fa-trophy fa-2x" style="color: #876109;"></i>
                                    </div>
                                </div>
                                <h1><?php echo $topReservador['nombre']; ?></h1>
                                <p style="color: #666; font-size: 0.9rem;">El usuario con mayor número de reservas hechas</p>

                                <div class="stats-container">
                                    <div class="stat-box">
                                        <span class="stat-number"><?php echo $topReservador['total_reservas']; ?></span>
                                        <span class="stat-desc">Reservas</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </section>
                </div>
            </main>
            
        </div>
    </div>
    
            

    
    <script src="./librerias/alertifyjs/alertify.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    $(document).ready(function() {
    const ctx = document.getElementById('graficoReservas').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($nombresMeses); ?>, 
            datasets: [{
                label: 'Reservas del año <?php echo date("Y"); ?>',
                data: <?php echo json_encode($valoresFinales); ?>,
                borderColor: '#ff5733',
                backgroundColor: 'rgba(255, 87, 51, 0.1)', 
                fill: true,
                tension: 0.4,
                borderWidth: 3,
                pointRadius: 5,
                pointBackgroundColor: '#ff5733',
                pointBorderColor: '#fff',
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#333',
                    titleFont: { size: 14 },
                    bodyFont: { size: 13 },
                    displayColors: false,
                    padding: 10
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    suggestedMax: 10,
                    ticks: {
                        stepSize: 1,
                        color: '#888'
                    },
                    grid: {
                        borderDash: [5, 5],
                        color: '#e0e0e0'
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#888'
                    }
                }
            }
        }
    });
});
</script>
</body>
</html>