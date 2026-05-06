<!DOCTYPE html>
<html lang="en">
<head>
    <title>Usuarios Registrados</title>
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
                                        <h2>Usuarios Registrados</h2>
                                
                                        <div class="mx-auto w-75">
                                            <table id="tablaUsu" class="table tablas table-striped align-middle shadow-sm">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">ID Usuario</th>
                                                        <th class="text-center">Nombre</th>
                                                        <th class="text-center">Correo</th>
                                                        <th class="text-center">Rol</th>
                                                        <th class="text-center">Gestionar</th>
                                                    </tr>
                                                </thead>

                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </section>
                <div class="modal fade" id="modalDeshabUsu" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">¿Seguro que quieres deshabilitar a este usuario?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p>Escribe un motivo para deshabilitar al usuario.</p>
                            <textarea class="form-control" id="motivoDes" placeholder="Motivo de deshabilitación"></textarea>

                            <br>
                            <button type="button" class="btn btn-success" id="btnDeshabilitar">Deshabilitar</button>
                            
                        </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modalHabUsu" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">¿Seguro que quieres habilitar a este usuario?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p>Escribe un motivo para habilitar al usuario.</p>
                            <textarea class="form-control" id="motivoHab" placeholder="Motivo de habilitación"></textarea>

                            <br>
                            <button type="button" class="btn btn-success" id="btnHabilitar">Habilitar</button>
                        </div>
                        
                        </div>
                    </div>
                </div>
            </div>
        </main>
        </div>
</div>
    <script src="./librerias/alertifyjs/alertify.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.bootstrap5.min.js"></script>
    <script src="./js/admin.js"></script>
<script>
 $(document).ready(() => {
            $("#tablaUsu").DataTable({
                // DistribuciÃ³n
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
                            placeholder: "Realizar bÃºsqueda...",
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
                    "emptyTable": "No hay telÃ©fonos libres",
                },
                // Opciones
                fixedColumns: true,
                // Consulta
                ajax: {
                    url: "./php/usuariosRegistrados.php",
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
                        data: "ID_USUARIO",
                        className: "text-center",
                    },
                    {
                        data: "NOMBRE",
                        width: "300px",
                        className: "text-center",
                    },
                    {
                        data: "CORREO",
                        width: "300px",
                        className: "text-center",
                    },
                    {
                        data: "ROL",
                        width: "300px",
                        className: "text-center",
                    },
                    {
                        data: "GESTIONAR",
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