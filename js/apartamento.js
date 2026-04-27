const formulario = document.getElementById('formReserva');
const fechaLlegada = document.getElementById('fechaLlegada');
const fechaSalida = document.getElementById('fechaSalida');
const precioNocheInput = document.getElementsByName('precioNoche')[0];
const precioTotalInput = document.getElementsByName('precioT')[0]; 
const visualTotal = document.querySelector('#totalPrecio'); 

formulario.addEventListener('submit', function(event) {

    event.preventDefault();

    let fechaSalida = document.getElementById('fechaSalida');
    let fechaLlegada = document.getElementById('fechaLlegada');
    let id = document.getElementById('idApartamento');

    if (fechaLlegada.value === "" || fechaSalida.value === "") {
        alertify.error("Debes rellenar las fechas");
        return; 
    } else if(new Date(fechaLlegada.value) >= new Date(fechaSalida.value)) {
        alertify.error("La fecha de salida debe ser posterior");
        return;
    }


    $.ajax({
            url: "./php/verDisponibilidadApartamento.php",
            type: "POST",

            data: {
                idApartamento: id.value,
                fechaEntrada: fechaLlegada.value,
                fechaSalida: fechaSalida.value,
            },

            success: function (data) {

                if(data.trim() === "ocupado") {
                    alertify.error("El apartamento no está disponible en esas fechas");
                } else if(data.trim() === "libre") {

                    setTimeout(() => {
                        formulario.submit(); 
                    }, 1000);
                } 
            }
        });
});



function actualizarPrecio() {
    const f1 = new Date(fechaLlegada.value);
    const f2 = new Date(fechaSalida.value);
    const precioNoche = parseFloat(precioNocheInput.value);

    if (f1 && f2 && f2 > f1) {
        const diferenciaMilisegundos = f2 - f1;
        const dias = diferenciaMilisegundos / (1000 * 60 * 60 * 24);
        const total = dias * precioNoche;

        visualTotal.innerText = total + "€ en total";
        
        precioTotalInput.value = total.toFixed(2);
    } else {
        visualTotal.innerText = "Añade fechas de instancia";
        precioTotalInput.value = 0;
    }
}


fechaLlegada.addEventListener('change', actualizarPrecio);
fechaSalida.addEventListener('change', actualizarPrecio);