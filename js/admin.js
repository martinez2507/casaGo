$(document).ready(function() {

const btnHabUsu = document.getElementById('btnHabilitar');
const btnDeshabUsu = document.getElementById('btnDeshabilitar');
const btnAceptarSol = document.getElementById('btnAceptarSol');
const btnRechazarSol = document.getElementById('btnRechazarSol');
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

$('#tablaSolicitudes').on('click', '.btn-aprobarSol', function() {
    idUsu = $(this).attr('data-id');

    $('#modalConfAceptar').modal('show');

});

$('#tablaSolicitudes').on('click', '.btn-rechazarSol', function() {
    idUsu = $(this).attr('data-id');

    $('#modalConfRechazar').modal('show');

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

btnAceptarSol.addEventListener('click', function(){

    let datosEnviar = {
        id: idUsu,
        accion: "aprobar"
    };

    $.ajax({
        url: './php/hacerAnfitrion.php',
        type: 'POST',
        data: datosEnviar,
        success: function(response) {
            alertify.success('Solicitud aprobada correctamente');
            // setTimeout(function(){
            //     location.reload();
            // }, 3000);
        }
    });
});

btnRechazarSol.addEventListener('click', function(){

    let datosEnviar = {
        id: idUsu,
        accion: "rechazar"
    };

    $.ajax({
        url: './php/hacerAnfitrion.php',
        type: 'POST',
        data: datosEnviar,
        success: function(response) {
            alertify.success('Solicitud rechazada correctamente');
            // setTimeout(function(){
            //     location.reload();
            // }, 3000);
        }
    });
});
});