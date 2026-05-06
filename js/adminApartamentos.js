const btnHabApar = document.getElementById('btnHabApar');
const btnDeshabApar = document.getElementById('btnDeshabApar');
const btnAprobar = document.getElementById('btnAprobar');
const btnRechazar = document.getElementById('btnRechazar');

let idApartamento = "";



// MODALES APARTAMENTOS
$('#tablaApar').on('click', '.btn-habilitarApar', function() {
    idApartamento = $(this).attr('data-id');

    $('#modalHabApar').modal('show');
});

$('#tablaApar').on('click', '.btn-deshabilitarApar', function() {

    idApartamento = $(this).attr('data-id');

    $('#modalDesApar').modal('show');

});

$('#tablaAparSinAprobar').on('click', '.btn-aprobar', function() {
    idApartamento = $(this).attr('data-id');

    $('#modalAprob').modal('show');

});

$('#tablaAparSinAprobar').on('click', '.btn-rechazar', function() {
    idApartamento = $(this).attr('data-id');

    $('#modalRechazar').modal('show');

});


// --------------------------APARTAMENTOS--------------------------
btnHabApar.addEventListener('click', function(){

    let datosEnviar = {
        id: idApartamento,
        accion: "habilitar"
    };

    $.ajax({
        url: './php/apartamentos.php',
        type: 'POST',
        data: datosEnviar,
        success: function(response) {
            alertify.success('Apartamento habilitado correctamente');
            setTimeout(function(){
                location.reload();
            }, 3000);
        }
    });
});

btnDeshabApar.addEventListener('click', function(){

    let motivo  = document.getElementById('motivoDesApar').value;
    
    if (motivo.trim() === "") {
        alertify.error('Por favor, ingresa un motivo para deshabilitar el apartamento.');
        return;
    }

    let datosEnviar = {
        id: idApartamento,
        accion: "deshabilitar",
        motivo: motivo
    };

    $.ajax({
        url: './php/apartamentos.php',
        type: 'POST',
        data: datosEnviar,
        success: function(response) {
            alertify.success('Apartamento deshabilitado correctamente');
            setTimeout(function(){
                location.reload();
            }, 3000);
        }
    });
});

btnAprobar.addEventListener('click', function(){

    let datosEnviar = {
        idApartamento: idApartamento,
        accion: "aprobar",
    };

    $.ajax({
        url: './php/apartamentosSinAprobar.php',
        type: 'POST',
        data: datosEnviar,
        success: function(response) {
            alertify.success('Apartamento aprobado correctamente');
            setTimeout(function(){
                location.reload();
            }, 3000);
        }
    });
});

btnRechazar.addEventListener('click', function(){

    let motivo  = document.getElementById('motivoRechazar').value;
    
    if (motivo.trim() === "") {
        alertify.error('Por favor, ingresa un motivo para rechazar el apartamento.');
        return;
    }

    let datosEnviar = {
        idApartamento: idApartamento,
        accion: "rechazar",
        motivo: motivo
    };

    $.ajax({
        url: './php/apartamentosSinAprobar.php',
        type: 'POST',
        data: datosEnviar,
        success: function(response) {
            alertify.success('Apartamento rechazado correctamente');
            setTimeout(function(){
                location.reload();
            }, 3000);
        }
    });
});