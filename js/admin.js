$(document).ready(function() {

const btnHabUsu = document.getElementById('btnHabilitar');
const btnDeshabUsu = document.getElementById('btnDeshabilitar');
let idUsu = "";


// MODALES USUARIOS
$('#tablaUsu').on('click', '.btn-habilitar', function() {
    idUsu = $(this).attr('data-id');

    $('#modalHabUsu').modal('show');
});

$('#tablaUsu').on('click', '.btn-deshabilitar', function() {
    idUsu = $(this).attr('data-id');

    $('#modalDeshabUsu').modal('show');

});



btnHabUsu.addEventListener('click', function(){

    let motivo  =document.getElementById('motivoHab').value;

    if (motivo.trim() === "") {
        alertify.error('Por favor, ingresa un motivo para habilitar al usuario.');
        return;
    }
    
    let datosEnviar = {
        id: idUsu,
        motivo: motivo,
        accion: "habilitar"
    };

    $.ajax({
        url: './php/usuariosRegistrados.php',
        type: 'POST',
        data: datosEnviar,
        success: function(response) {
            alertify.success('Usuario habilitado correctamente');
            setTimeout(function(){
                location.reload();
            }, 3000);
        }
    });
});

btnDeshabUsu.addEventListener('click', function(){

    let motivo  = document.getElementById('motivoDes').value;
    
    if (motivo.trim() === "") {
        alertify.error('Por favor, ingresa un motivo para deshabilitar al usuario.');
        return;
    }

    let datosEnviar = {
        id: idUsu,
        motivo: motivo,
        accion: "deshabilitar"
    };

    $.ajax({
        url: './php/usuariosRegistrados.php',
        type: 'POST',
        data: datosEnviar,
        success: function(response) {
            alertify.success('Usuario deshabilitado correctamente');
            setTimeout(function(){
                location.reload();
            }, 3000);
        }
    });
});

});