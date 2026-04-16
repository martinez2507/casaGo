const inputFotos = document.querySelector('input[name="fotos[]"]');

// Creamos un "contenedor" que guardará todos los archivos acumulados
const listaMaestra = new DataTransfer();

inputFotos.addEventListener('change', function() {
    // 1. Recorremos los archivos que acabas de seleccionar/arrastrar ahora
    for (let i = 0; i < this.files.length; i++) {
        const archivo = this.files[i];
        
        // Opcional: Evitar duplicados por nombre
        const yaExiste = Array.from(listaMaestra.files).some(f => f.name === archivo.name);
        
        if (!yaExiste) {
            listaMaestra.items.add(archivo);
        }
    }

    // 2. Sincronizamos el input con nuestra lista acumulada
    // Esto hace que el input "crea" que tiene todos los archivos a la vez
    this.files = listaMaestra.files;

    // 3. Verificación en consola (para que veas cómo crece la lista)
    console.log("Total de fotos acumuladas:", this.files.length);
});