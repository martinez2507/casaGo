<!DOCTYPE html>
<html lang="en">
<head>
    <title>Apartamentos Totales</title>
    <link rel="stylesheet" href="./librerias/bootstrap5.3.8/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="shortcut icon" href="./img/logoCasaGo.png" type="image/x-icon">
    <script src="./librerias/fontawesome/css/all.min.css" crossorigin="anonymous"></script>
    <script src="./librerias/bootstrap5.3.8/js/bootstrap.min.js"></script>
    

    <link rel="stylesheet" href="./librerias/alertifyjs/css/alertify.min.css">
    <link rel="stylesheet" href="./librerias/alertifyjs/css/themes/default.min.css">
    <link rel="stylesheet" href="./css/tablas.css">
    <link rel="stylesheet" href="./css/sidebar.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="./css/admin.css">
    <link rel="stylesheet" href="./librerias/fontawesome/css/all.min.css">
</head>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include './php/sidebar.php';
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
                                <section class="rowT">
                                        <h2>Reservas realizadas</h2>
                                
                                        <div class="mx-auto w-75">
                                            <table id="tablaReservas" class="table tablas table-striped align-middle shadow-sm">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">ID reserva</th>
                                                        <th class="text-center">Anfitrión</th>
                                                        <th class="text-center">Apartamento</th>
                                                        <th class="text-center">Ubicación</th>
                                                        <th class="text-center">Precio Total</th>
                                                        <th class="text-center">Reservador</th>
                                                        <th class="text-center">Fecha Inicio</th>
                                                        <th class="text-center">Fecha Fin</th>
                                                    </tr>
                                                </thead>

                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </section>

                                </div>
                </div>
            </main>
        </div>
</div>
    <script src="./librerias/alertifyjs/alertify.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.bootstrap5.min.js"></script>
<script>

         $(document).ready(() => {
            $("#tablaReservas").DataTable({
                // Distribución
                layout: {
                    topN: null,
                    topNStart: null,
                    topNEnd: null,
                    top2: null,
                    top2Start: null,
                    top2End: null,
                    topStart: "pageLength",
                    topEnd: {
                        search: {
                            placeholder: "Realizar búsqueda...",
                        },
                    },
                    bottom: null,
                    bottomStart: "info",
                    bottomEnd: {
                        paging: {
                            type: "full_numbers",
                            numbers: 3,
                        },
                    },
                    bottom2: null,
                    bottom2Start: null,
                    bottom2End: null,
                    bottomN: null,
                    bottomNStart: null,
                    bottomNEnd: null,
                },
                // Traducciones
                language: {
                    url: "./lang/es_ES.json",
                    "emptyTable": "No hay reservas registradas",
                },
                // Opciones
                fixedColumns: true,
                // Consulta
                ajax: {
                    url: "./php/sacarReservas.php",
                    type: "GET",
                    deferRender: true,
                    dataSrc: function(data) {
                        if (data.data.error) {
                            notificarError("Error cargando datos, " + data.data.motivoError);
                            return [];
                        } else {
                            return data.data;
                        }
                    },
                },
                columns: [
                    {
                        data: "ID_RESERVA",
                        className: "text-center",
                    },
                    {
                        data: "ANFITRION",
                        className: "text-center",
                    },
                    {
                        data: "APARTAMENTO",
                        width: "250px",
                        className: "text-center",
                    },
                    {
                        data: "UBICACION",
                        width: "400px",
                        className: "text-center",
                    },
                    {
                        data: "PRECIO_TOTAL",
                        className: "text-center",
                    },
                    {
                        data: "RESERVADOR",
                        className: "text-center",
                    },
                    {
                        data: "FECHA_INICIO",
                        className: "text-center",
                    },
                    {
                        data: "FECHA_FIN",
                        className: "text-center",
                    },
                ],
                order: [0, "desc"],
                initComplete: function() {
                    $(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr('autocomplete', 'off');
                },
            });
        });
</script>
</body>
</html>