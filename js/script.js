document.addEventListener('DOMContentLoaded', function() {
// scroll para el header
window.addEventListener("scroll", function() {
    const header = document.getElementById("header");

    if (window.scrollY > 50) {
        header.classList.add("scrolled");
    } else {
        header.classList.remove("scrolled");
    }
});

// comprobacion fechas
document.getElementById("formulario").addEventListener("submit", function(e) {

        const llegada = document.querySelector('input[name="llegada"]').value;
        const salida = document.querySelector('input[name="salida"]').value;

        if (llegada && salida) {

            if (salida <= llegada) {
                e.preventDefault();

                alertify.error("La fecha de salida debe ser posterior a la de llegada");
            }
        }
    });
});