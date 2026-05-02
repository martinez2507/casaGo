<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="./librerias/bootstrap5.3.8/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="./css/responsivoIndex.css">
    <link rel="shortcut icon" href="./img/logoCasaGo.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/3b89af0a27.js" crossorigin="anonymous"></script>
    <script src="./librerias/bootstrap5.3.8/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.bootstrap5.min.css">

    <link rel="stylesheet" href="./librerias/alertifyjs/css/alertify.min.css">
    <link rel="stylesheet" href="./librerias/alertifyjs/css/themes/default.min.css">
    <link rel="stylesheet" href="./css/perfil.css">
</head>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'cabecera.php';
?>
<body>

    <section class="rowT">
        <h2>Apartamentos</h2>

        <div class="mx-auto w-75">
            <table id="tablaApar" class="table table-striped align-middle shadow-sm">
                <thead>
                    <tr>
                        <th class="text-center">ID Apartamento</th>
                        <th class="text-center">Nombre</th>
                        <th class="text-center">Dirección</th>
                        <th class="text-center">Precio por Noche</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody></tbody>
            </table>
        </div>
    </section>

    <?php include 'footer.php'; ?>
    <script src="./librerias/alertifyjs/alertify.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.bootstrap5.min.js"></script>
    <script>
    $(document).ready(() => {
            $("#tablaApar").DataTable({
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
                            placeholder: "Realizar busqueda...",
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
                    bottom2: {
                        // buttons: [{
                        //         extend: "copy",
                        //         title: "Apartamentos CasaGo",
                        //         exportOptions: {
                        //             columns: [0, 1, 2, 3,4]
                        //         }
                        //     },
                        //     {
                        //         extend: "excel",
                        //         title: "Apartamentos CasaGo",
                        //         exportOptions: {
                        //             columns: [0, 1, 2, 3,4]
                        //         }
                        //     },
                        //     {
                        //         extend: "csv",
                        //         title: "Apartamentos CasaGo",
                        //         exportOptions: {
                        //             columns: [0, 1, 2, 3, 4]
                        //         }
                        //     },
                        //     {
                        //         extend: "pdf",
                        //         title: "Apartamentos CasaGo",
                        //         orientation: "landscape",
                        //         exportOptions: {
                        //             columns: [0, 1, 2, 3, 4]
                        //         }
                        //     },
                        //     {
                        //         extend: "print",
                        //         title: "Apartamentos CasaGo",
                        //         exportOptions: {
                        //             columns: [0, 1, 2, 3, 4]
                        //         }
                        //     },
                        // ],
                    },
                    bottom2Start: null,
                    bottom2End: null,
                    bottomN: null,
                    bottomNStart: null,
                    bottomNEnd: null,
                },
                // Traducciones
                // language: {
                //     url: "./lang/es_ES.json",
                //     "emptyTable": "No hay apartamentos",
                // },
                // Opciones
                fixedColumns: true,
                // Consulta
                ajax: {
                    url: "./php/apartamentos.php",
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
                columns: [{
                        data: "ID_APARTAMENTO",
                        className: "text-center",
                    },
                    {
                        data: "NOMBRE",
                        width: "300px",
                        className: "text-center",
                    },
                    {
                        data: "DIRECCION",
                        width: "300px",
                        className: "text-center",
                    },
                    {
                        data: "PRECIO",
                        width: "300px",
                        className: "text-center",
                    },
                    {
                        data: "ACCIONES",
                        width: "300px",
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