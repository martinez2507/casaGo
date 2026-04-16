<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hazte Anfitrión - CasaGo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/hazteAnfitrion.css">
</head>
<body>

<section class="anfitrion-hero text-white text-center d-flex align-items-center">
    <div class="container">
        <h1 class="display-3 fw-bold">Tu casa puede ser tu próxima gran inversión</h1>
        <p class="lead">Únete a miles de personas que ya ganan dinero con CasaGo.</p>
        <a href="subirApartamento.php" class="btn btn-lg btn-light fw-bold px-5 py-3 mt-3">Empezar a publicar</a>
    </div>
</section>

<section class="container my-5 py-5">
    <div class="row align-items-center bg-white shadow rounded-4 p-4 p-md-5">
        <div class="col-lg-6">
            <h2 class="fw-bold mb-4">¿Cuánto podrías ganar?</h2>
            <p class="text-muted">Ajusta los controles para ver una estimación de tus ingresos mensuales basados en el mercado actual.</p>
            
            <div class="mb-4">
                <label class="form-label fw-bold">Noches al mes: <span id="nochesValor" class="text-danger">15</span></label>
                <input type="range" class="form-range" min="1" max="30" value="15" id="rangoNoches">
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Precio por noche estimado (€)</label>
                <input type="number" class="form-control" id="precioNoche" value="80">
            </div>
        </div>
        
        <div class="col-lg-6 text-center border-start">
            <h3 class="text-muted">Ganancia estimada al mes</h3>
            <div class="display-2 fw-bold text-danger">
                <span id="resultadoGanancia">1200</span>€
            </div>
            <p class="text-secondary small">*Basado en una ocupación del <span id="porcentajeOcupacion">50</span>%</p>
            <a href="subirApartamento.php" class="btn btn-outline-danger mt-3">Publicar ahora</a>
        </div>
    </div>
</section>

<section class="bg-light py-5">
    <div class="container text-center">
        <h2 class="mb-5 fw-bold">¿Por qué ser anfitrión en CasaGo?</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="p-3">
                    <div class="fs-1 mb-3">🛡️</div>
                    <h4>Protección total</h4>
                    <p class="text-muted">Cuidamos tu hogar con seguros de daños incluidos en cada reserva.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="p-3">
                    <div class="fs-1 mb-3">📞</div>
                    <h4>Soporte 24/7</h4>
                    <p class="text-muted">Nuestro equipo está disponible para ayudarte con cualquier duda o problema.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="p-3">
                    <div class="fs-1 mb-3">⚡</div>
                    <h4>Pagos rápidos</h4>
                    <p class="text-muted">Recibe tu dinero 24 horas después de que el huésped llegue a tu casa.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
const rangoNoches = document.getElementById('rangoNoches');
const nochesValor = document.getElementById('nochesValor');
const precioNoche = document.getElementById('precioNoche');
const resultadoGanancia = document.getElementById('resultadoGanancia');
const porcentajeOcupacion = document.getElementById('porcentajeOcupacion');

function calcular() {
    const noches = parseInt(rangoNoches.value);
    const precio = parseFloat(precioNoche.value) || 0;
    const total = noches * precio;
    const ocupacion = Math.round((noches / 30) * 100);

    nochesValor.innerText = noches;
    resultadoGanancia.innerText = total.toLocaleString();
    porcentajeOcupacion.innerText = ocupacion;
}

rangoNoches.addEventListener('input', calcular);
precioNoche.addEventListener('input', calcular);    


</script>

</body>
</html>