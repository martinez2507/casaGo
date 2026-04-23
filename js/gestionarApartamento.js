$(document).ready(function () {

    // EDITAR
    $('.container.mt-5').on('click', '.btn-primary', function () {

        let id = $(this).data('id');

        $("#btnGuardar").data("id", id);

        $.ajax({
            url: "./php/gestionarUnApartamento.php",
            type: "GET",
            data: {
                idApartamento: id
            },

            success: function (datos) {

                if (datos) {

                    $("#nombre").val(datos.nombre);
                    $("#descripcion").val(datos.descripcion);
                    $("#precioNoche").val(datos.precio_noche);
                    $("#ciudad").val(datos.ciudad);
                    $("#direccion").val(datos.direccion);
                    $("#capacidad").val(datos.capacidad);

                    const modal = new bootstrap.Modal(
                        document.getElementById('modalEditar')
                    );

                    modal.show();

                } else {
                    alertify.error("No se encontraron datos");
                }
            }
        });

    });


    // BORRAR
    $('.container.mt-5').on('click', '.btn-borrar', function () {

        let id = $(this).data('id');
        let tarjeta = $(this).closest('.card');

        alertify.confirm(
            "¿Eliminar?",
            "Esta acción no se puede deshacer.",

            function () {

                $.ajax({
                    url: "./php/gestionarUnApartamento.php",
                    type: "POST",
                    data: {
                        idApartamento: id,
                        motivo: "borrar"
                    },

                    success: function () {
                        alertify.success("Eliminado correctamente");
                        tarjeta.fadeOut();
                    }
                });

            },
        );

    });


    // GUARDAR CAMBIOS
    $("#btnGuardar").click(function () {

        let id = $(this).data("id");

        $.ajax({
            url: "./php/gestionarUnApartamento.php",
            type: "POST",

            data: {
                idApartamento: id,
                motivo: "guardar",
                nombre: $("#nombre").val(),
                descripcion: $("#descripcion").val(),
                precioNoche: $("#precioNoche").val(),
                ciudad: $("#ciudad").val(),
                direccion: $("#direccion").val(),
                capacidad: $("#capacidad").val()
            },

            success: function () {

                alertify.success("Datos actualizados");

                let modal =
                    bootstrap.Modal.getInstance(
                        document.getElementById('modalEditar')
                    );

                modal.hide();

                setTimeout(function(){
                    location.reload();
                }, 2000);
            }
        });

    });

});