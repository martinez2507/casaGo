document.addEventListener('DOMContentLoaded', () => {
    // Seleccionamos los elementos del DOM
    const formulario = document.querySelector('#filtros');
    const contenedorResultados = document.querySelector('#resultadosApar');
    const inputPrecio = document.querySelector('#precio');
    const displayPrecio = document.querySelector('#precioS'); // El span que muestra el número

    /**
     * Función principal para obtener datos mediante AJAX (Fetch API)
     */
    const buscarApartamentos = () => {
        // Creamos los parámetros de búsqueda desde el formulario
        const datos = new FormData(formulario);
        const queryParams = new URLSearchParams(datos);

        // Feedback visual: bajamos la opacidad mientras carga
        contenedorResultados.style.opacity = '0.5';

        // Petición al servidor
        fetch(`../php/filtroBusqueda.php?${queryParams.toString()}`)
            .then(response => {
                if (!response.ok) throw new Error('Error en la respuesta del servidor');
                return response.json();
            })
            .then(apartamentos => {
                renderizarApartamentos(apartamentos);
            })
            .catch(error => {
                console.error('Error:', error);
                contenedorResultados.innerHTML = '<p>Error al cargar los apartamentos.</p>';
            })
            .finally(() => {
                contenedorResultados.style.opacity = '1';
            });
    };

    /**
     * Función para construir el HTML de cada apartamento
     */
    const renderizarApartamentos = (lista) => {
        // Si no hay resultados
        if (lista.length === 0) {
            contenedorResultados.innerHTML = '<p>No se han encontrado apartamentos con esos filtros.</p>';
            return;
        }

        // Limpiamos y generamos las "cards"
        contenedorResultados.innerHTML = lista.map(apt => `
            <article class="apartamento-card">
                <img src="${apt.imagen}" alt="${apt.titulo}" class="apt-img">
                <div class="apt-info">
                    <h4>${apt.titulo}</h4>
                    <p class="precio-tag">${apt.precio}€ / mes</p>
                    <p>📍 ${apt.ciudad}</p>
                    <div class="servicios-tags">
                        ${apt.extras.map(ext => `<span class="tag">${ext}</span>`).join('')}
                    </div>
                </div>
            </article>
        `).join('');
    };

    /**
     * Eventos de escucha (Listeners)
     */

    // 1. Detectar cambios en checkboxes y slider de precio
    formulario.addEventListener('change', () => {
        buscarApartamentos();
    });

    // 2. Actualizar el texto del precio dinámicamente mientras arrastras el slider
    inputPrecio.addEventListener('input', (e) => {
        displayPrecio.textContent = e.target.value;
        // Opcional: si quieres que filtre mientras arrastras (muchas peticiones), llama a buscarApartamentos() aquí
    });

    // 3. Carga inicial al entrar en la página
    buscarApartamentos();
});