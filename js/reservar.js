document.addEventListener('DOMContentLoaded', function() {
    const btnGuardar = document.getElementById('btn-guardar');
    const btnPagar = document.getElementById('btn-pagar');

    // document.ready rellenamos campos de input tarjeta con un get al ichero del ajax
    let idUsuario = document.getElementById('idUsuario').value;

    $.ajax({
            url: "./php/datosTarjeta.php",
            type: "GET",
            data: { 
                idUsuario: idUsuario
             },
            success: function(respuesta){
                if (respuesta) {
                    $("#titularCuenta").val(respuesta.titular);
                    $("#numTarjeta").val(respuesta.num_tarjeta);
                    $("#CCV").val(respuesta.numero_encriptado);

                    let mesAño = respuesta.fecha_expiracion.substring(0, 7);
        
            
                    console.log(mesAño)
                    $("#caducidad").val(mesAño);
                }
            },
            error: function() {
                alertify.error("Error ajaax");
            }
        });

    btnGuardar.addEventListener('click', function() {

        let idUsuario = document.getElementById('idUsuario').value;
        let titular = document.getElementById('titularCuenta').value;
        let numTarjeta = document.getElementById('numTarjeta').value;
        let ccv = document.getElementById('CCV').value;
        let caducidad = document.getElementById('caducidad').value;

        if(idUsuario == "" || titular == "" || numTarjeta =="" || ccv == ""|| caducidad == "") {
            alertify.error("Debes rellenar todos los campos");
            return;
        }
        let datosEnviar = {
            idUsuario: idUsuario,
            titular: titular,
            numTarjeta: numTarjeta,
            ccv:ccv,
            caducidad:caducidad,
        }
        $.ajax({
            url: "./php/datosTarjeta.php",
            type: "POST",
            data: datosEnviar,
            success: function(){
                alertify.success("Datos de tarjeta guardados");
            },
            error: function() {
                alertify.error("Error al guardar datos de tarjeta");
            }
        });
    });

    btnPagar.addEventListener('click', function() {

        let check = document.getElementById('checkCondiciones').checked;


        let idUsuario = document.getElementById('idUsuario').value;
        let precioT = document.getElementById('precioT').innerText.trim();
        let numPersonas = document.getElementById('numPersonas').innerText.trim();
        let llegada = document.getElementById('llegada').innerText.trim();
        let salida = document.getElementById('salida').innerText.trim();
        let idApartamento = document.getElementById('idApartamento').innerText.trim();

        if(!check) {
            alertify.error("Debes aceptar los términos y las condiciones.");
            return;
        }
        let datosEnviar = {
            idUsuario: idUsuario,
            precioT: precioT,
            numPersonas: numPersonas,
            llegada:llegada,
            salida:salida,
            idApartamento,idApartamento
        }
        
        $.ajax({
            url: "./php/confirmarReserva.php",
            type: "POST",
            data: datosEnviar,
            success: function(){
                alertify.success("Reserva realizada con éxito");
            },
            error: function() {
                alertify.error("Error al realizar la reserva");
            }
        });
    });
});