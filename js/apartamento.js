const formulario = document.getElementById('formReserva');
const fechaLlegada = document.getElementById('fechaLlegada');
const fechaSalida = document.getElementById('fechaSalida');
const precioNocheInput = document.getElementsByName('precioNoche')[0];
const precioTotalInput = document.getElementsByName('precioT')[0]; 
const visualTotal = document.querySelector('#totalPrecio'); 

formulario.addEventListener('submit', function(event) {
    // 1. DETENEMOS el envío automático
    event.preventDefault();

    let fechaSalida = document.getElementById('fechaSalida');
    let fechaLlegada = document.getElementById('fechaLlegada');

    // 2. HACEMOS LAS COMPROBACIONES
    if (fechaLlegada.value === "" || fechaSalida.value === "") {
        alertify.error("Debes rellenar las fechas");
        return; // Salimos de la función para que no siga
    } else if(new Date(fechaLlegada.value) >= new Date(fechaSalida.value)) {
        alertify.error("La fecha de salida debe ser posterior");
        return;
    }
    
    // Esperamos un segundo para que se vea el mensaje de éxito y enviamos
    setTimeout(() => {
        this.submit(); 
    }, 1000);
});



function actualizarPrecio() {
    const f1 = new Date(fechaLlegada.value);
    const f2 = new Date(fechaSalida.value);
    const precioNoche = parseFloat(precioNocheInput.value);

    // Verificamos que ambas fechas sean válidas y la salida sea posterior
    if (f1 && f2 && f2 > f1) {
        const diferenciaMilisegundos = f2 - f1;
        const dias = diferenciaMilisegundos / (1000 * 60 * 60 * 24);
        const total = dias * precioNoche;

        // Actualizamos el texto visual
        visualTotal.innerText = total + "€ en total";
        
        // ¡IMPORTANTE! Actualizamos el value del input hidden para que al enviar el form sea correcto
        precioTotalInput.value = total.toFixed(2);
    } else {
        visualTotal.innerText = "Añade fechas de instancia";
        precioTotalInput.value = 0;
    }
}

// Escuchamos el evento 'change' en ambos inputs
fechaLlegada.addEventListener('change', actualizarPrecio);
fechaSalida.addEventListener('change', actualizarPrecio);