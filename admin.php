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
</head>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'cabecera.php';

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
<div class="contenedor">
        <div class="menuIzq">
            <nav class="nav flex-column">
                <span class="titSideBar"><b>Apartamentos</b></span>
                <a class="nav-link active" href="apartamentosAdmin.php"><i class="fa-solid fa-table-list"></i> Apartamentos</a>
                <a class="nav-link" href="usuarios.php"><i class="fa-solid fa-users"></i> Usuarios</a>
                <a class="nav-link" href="reservas.php"><i class="fa-solid fa-calendar-check"></i> Reservas</a>
            </nav>
        </div>
    <section class="contenido container-fluid pe-5 ps-5 mt-4">
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
                            <p class="text-muted mb-0">Activos</p>
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
                            <p class="text-muted mb-0">Pendientes</p>
                            <h3 class="fw-bold mb-0"><?php $resP = mysqli_query($conn, $consultaPendientes); echo mysqli_fetch_assoc($resP)['totalPend']; ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-xl-8">
                <div class="card shadow-sm p-4 border-0">
                    <h5 class="fw-bold mb-4"><i class="fa-solid fa-chart-line me-2 text-primary"></i>Reservas por Mes</h5>
                    <div class="chart-container">
                        <canvas id="graficoReservas"></canvas>
                    </div>
                </div>
            </div>
    </div>
    </section>
    </div>

    

    <?php include 'footer.php'; ?>
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