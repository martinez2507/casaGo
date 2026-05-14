const formulario = document.getElementById('formReserva');
const fechaLlegada = document.getElementById('fechaLlegada');
const fechaSalida = document.getElementById('fechaSalida');
const precioNocheInput = document.getElementsByName('precioNoche')[0];
const precioTotalInput = document.getElementsByName('precioT')[0]; 
const visualTotal = document.querySelector('#totalPrecio'); 

const btnReservar = document.getElementById('btnReservar');

btnReservar.addEventListener('click', function(event) {
    // 1. Paramos todo
    event.preventDefault();
    event.stopPropagation(); 

    // 2. Obtener valores
    let fSalida = document.getElementById('fechaSalida').value;
    let fLlegada = document.getElementById('fechaLlegada').value;
    let viajeros = document.getElementById('viajeros').value;
    let id = document.getElementById('idApartamento').value;
    let precioNoche = document.getElementsByName('precioNoche')[0].value;
    // IMPORTANTE: precioT también es útil enviarlo para evitar recálculos
    let precioT = document.getElementsByName('precioT')[0].value;
    alertify.set('notifier','position', 'top-right');
    if (fLlegada === "" || fSalida === "") {
        alertify.error("Debes rellenar las fechas");
        return; 
    }

    if (fSalida <= fLlegada) {
        alertify.error("La fecha de salida debe ser posterior a la de llegada");
        return;
    };

    if(fLlegada < new Date().toISOString().split('T')[0]) {
        alertify.error("La fecha de llegada no puede ser en el pasado");
        return;
    }

    // 3. AJAX
    $.ajax({
        url: "./php/verDisponibilidadApartamento.php",
        type: "GET",
        data: {
            idApartamento: id,
            fechaEntrada: fLlegada,
            fechaSalida: fSalida 
        },
        success: function (data) {
            if(data.trim() === "libre") {
                // Construimos la URL con el precio total ya calculado en el JS
                const url = `./hacerReserva.php?llegada=${fLlegada}&salida=${fSalida}&viajeros=${viajeros}&idApartamento=${id}&precioNoche=${precioNoche}&precioT=${precioT}`;
                
                alertify.success("¡Disponible! Redirigiendo...");
                
                // Usamos replace en lugar de href si quieres que el usuario 
                // no pueda "volver" al estado de carga, pero href suele ser mejor:
                setTimeout(() => {
                    window.location.href = url; 
                }, 800);
            } else {
                alertify.error("El apartamento no está disponible");
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