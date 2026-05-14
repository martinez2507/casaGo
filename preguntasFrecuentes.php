<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centro de Ayuda | CasaGo</title>

    <link rel="stylesheet" href="./librerias/bootstrap5.3.8/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/preguntasFrecuentes.css">
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="shortcut icon" href="./img/logoCasaGo.png" type="image/x-icon">
    
    <script src="https://kit.fontawesome.com/3b89af0a27.js" crossorigin="anonymous"></script>
</head>
<body>

<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include 'cabecera.php';
?>

<main class="ayuda-container">
    <section class="ayuda-header text-center">
        <div class="container">
            <h1><i class="fa-solid fa-circle-question me-2"></i>Centro de Ayuda</h1>
            <p class="lead">¿Tienes dudas? Estamos aquí para ayudarte a resolverlas.</p>
        </div>
    </section>

    <div class="container ">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0">
                    <div class="card-body p-4">
                        <h3 class="mb-4 fw-bold text-primary">Preguntas Frecuentes</h3>
                        
                        <div class="accordion accordion-flush" id="accordionAyuda">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-1">
                                        <i class="fas fa-solid fa-euro-sign text-secondary"></i>
                                        ¿Si cancelo mi reserva me devuelven el dinero?
                                    </button>
                                </h2>
                                <div id="faq-1" class="accordion-collapse collapse" data-bs-parent="#accordionAyuda">
                                    <div class="accordion-body text-muted">
                                        Depende de la política elegida por el anfitrión. En general, si cancelas con más de 48 horas de antelación, se suele devolver el importe íntegro menos la comisión de gestión.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-2">
                                        <i class="fas fa-solid fa-house-medical me-3 text-secondary"></i>
                                        ¿Cuesta dinero subir un apartamento?
                                    </button>
                                </h2>
                                <div id="faq-2" class="accordion-collapse collapse" data-bs-parent="#accordionAyuda">
                                    <div class="accordion-body text-muted">
                                        Publicar tu alojamiento en CasaGo es totalmente <b>**gratis**</b>. Solo cobramos una pequeña comisión cuando confirmes una reserva con éxito.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-3">
                                        <i class=" fas fa-solid fa-comments me-3 text-secondary"></i>
                                        ¿Los apartamentos incluyen sábanas y toallas?
                                    </button>
                                </h2>
                                <div id="faq-3" class="accordion-collapse collapse" data-bs-parent="#accordionAyuda">
                                    <div class="accordion-body text-muted">
                                        Eso dependerá del anfitrión de cada alojamiento, si es un imprescindible para usted asegurese de que en la pestaña servicios del apartamento lo incluya.
                                    </div>
                                </div>
                            </div>
                        </div> </div>
                </div>

                <div class="text-center mt-5">
                    <p class="text-muted">¿No encuentras lo que buscas?</p>
                    <a href='https://mail.google.com/mail/?view=cm&fs=1&to=casagoof@gmail.com' target='_blank' title='Mandar correo a soporte' class="btn btn-outline-primary">
                        Contactar con soporte
                    </a>
                    <br>
                    <small class="text-muted d-block mt-2">O escribe a: <b>casagoof@gmail.com</b></small>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
include 'footer.php';
?>
<script src="./librerias/bootstrap5.3.8/js/bootstrap.bundle.min.js"></script>
</body>
</html>