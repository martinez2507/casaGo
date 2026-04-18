document.addEventListener("DOMContentLoaded", () => {
    const formFiltros = document.getElementById("filtros");
    const contenedor = document.getElementById("resultadosApar");
    const precio = document.getElementById('precio');

    // Evitar envío por defecto (si hubiera botón submit)
    formFiltros.addEventListener("submit", (e) => e.preventDefault());

    const cargarApartamentos = () => {
        const formData = new FormData(formFiltros);
        const params = new URLSearchParams(formData).toString();

        contenedor.style.opacity = "0.5";

        fetch("./php/filtroBusqueda.php?" + params)
            .then(response => response.text())
            .then(html => {
                contenedor.innerHTML = html;
                contenedor.style.opacity = "1";
            })
            .catch(error => {
                console.error("Error al filtrar:", error);
                contenedor.style.opacity = "1";
            });
    };

    // Cambios inmediatos
    formFiltros.addEventListener("change", cargarApartamentos);
    
    // Ciudad: filtrar mientras escribes (opcional, si prefieres esperar a perder el foco usa 'change')
    document.getElementById("ciudad").addEventListener("input", cargarApartamentos);
    
    // Slider de precio
    const slider = document.getElementById("precio");
    slider.addEventListener("input", () => {
        document.getElementById("precioS").innerText = slider.value;
        // Opcional: cargarApartamentos() aquí si quieres que filtre mientras arrastras
    });
});

precio.addEventListener("change", function(){
    let precioActual = precio.value;

    precioS.innerHTML = precioActual;
})