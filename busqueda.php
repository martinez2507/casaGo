<?php

include("php/conexionBD.php");

$ciudad = $_POST['lugar'];

$consulta = "SELECT * FROM apartamentos where ciudad LIKE '%$ciudad%' OR direccion LIKE '%$ciudad%'";

$datos = $conn->query($consulta);

$filas = $datos->num_rows;
?>

<div class="main-container">
    <aside class="sidebar">
        <h3>Filtros</h3>
        <form id="filtros">

            <label>Ciudad:</label>
                <input type="text" name="ciudad" id="ciudad" value="<?php echo $ciudad ?? ''; ?>">
            <label>Precio Máximo:</label>
            <input type="range" id="precio" name="precio" min="0" max="2000" step="100">
            <span id="precioS">2000</span>€

            <label>Servicios:</label>
            <div class="filtro-serv">
                <label><input type="checkbox" name="extras[]" value="wifi"> Wi-Fi</label><br>
                <label><input type="checkbox" name="extras[]" value="parking"> Parking</label><br>
                <label><input type="checkbox" name="extras[]" value="piscina"> Piscina</label><br>
                <label><input type="checkbox" name="extras[]" value="mascotas"> Admite mascotas</label>
            </div>
        </form>
    </aside>

    <section class="apartamentos" id="resultadosApar">
        <p>Cargando apartamentos...</p>
    </section>
</div>
<script src="./js/filtroBusqueda.js"></script>
<script>
        function cargarApartamentos() {

            let city = document.getElementById("city").value;
            let precio = document.getElementById("precio").value;

            // recoger checkboxes
            let extras = [];
            document.querySelectorAll('input[name="extras[]"]:checked')
                .forEach(el => extras.push(el.value));

            fetch("filtrar.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `city=${city}&precio=${precio}&extras=${JSON.stringify(extras)}`
            })
            .then(res => res.text())
            .then(data => {
                document.getElementById("resultadosApar").innerHTML = data;
            });
        }

        // 🔥 eventos
        document.getElementById("city").addEventListener("input", cargarApartamentos);
        document.getElementById("precio").addEventListener("input", function(){
            document.getElementById("precioS").innerText = this.value;
            cargarApartamentos();
        });

        // checkboxes
        document.querySelectorAll('input[name="extras[]"]')
            .forEach(el => el.addEventListener("change", cargarApartamentos));

        // 🔥 primera carga automática
        window.onload = cargarApartamentos;
</script>
