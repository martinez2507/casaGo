document.addEventListener("DOMContentLoaded", () => {
    const formFiltros = document.getElementById("filtros");
    const contenedor = document.getElementById("resultadosApar");
    const precio = document.getElementById('precio');

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

    formFiltros.addEventListener("change", cargarApartamentos);
    
    // Slider de precio
    const slider = document.getElementById("precio");
    slider.addEventListener("input", () => {
        document.getElementById("precioS").innerText = slider.value;
    });
});

precio.addEventListener("change", function(){
    let precioActual = precio.value;

    precioS.innerHTML = precioActual;
})