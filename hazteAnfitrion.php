<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CasaGo - Hazte Anfitrión</title>
    <style>
        :root {
            --naranja: #FF5722;
            --azul: #2196F3;   
            --fondo: #f8f9fa;
            --texto: #333;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            background-color: var(--fondo);
            color: var(--texto);
            line-height: 1.6;
            margin-top: 80px;
        }

        
        header {
            background-color: var(--naranja);
            padding: 15px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
        }

        .contenedor {
            margin-top: 80px;
        }

        
        .hero {
            background-color: var(--azul);
            color: white;
            text-align: center;
            padding: 60px 20px;
        }

        .hero h1 {
            font-size: 2.5rem;
            margin: 0;
        }

       
        .container {
            max-width: 1000px;
            margin: -40px auto 40px;
            padding: 0 20px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            text-align: center;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h3 {
            color: var(--azul);
            margin-top: 0;
        }

        
        .cta-section {
            text-align: center;
            margin: 50px 0;
        }

        .btn-anfitrion {
            background-color: var(--naranja);
            color: white;
            padding: 15px 40px;
            border: none;
            border-radius: 8px;
            font-size: 1.2rem;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.3s;
        }

        .btn-anfitrion:hover {
            background-color: #e64a19;
        }

        footer {
            text-align: center;
            padding: 20px;
            font-size: 0.9rem;
            color: #777;
        }
    </style>
    <link rel="stylesheet" href="./librerias/bootstrap5.3.8/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="shortcut icon" href="./img/logoCasaGo.png" type="image/x-icon">
    

    <link rel="stylesheet" href="./librerias/alertifyjs/css/alertify.min.css">
    <link rel="stylesheet" href="./librerias/alertifyjs/css/themes/default.min.css">
</head>
<body>

    <?php include 'cabecera.php'; ?>
    <div class="contenedor">
    <section class="hero">
        <h1>Gana dinero compartiendo tu espacio</h1>
        <p>Únete a nuestra comunidad de anfitriones y empieza a recibir huéspedes.</p>
    </section>

    <main class="container">
        <div class="grid">
            <div class="card">
                <h3>Tú tienes el control</h3>
                <p>Elige tus propios horarios, precios y requisitos para los huéspedes.</p>
            </div>

            <div class="card">
                <h3>Pagos seguros</h3>
                <p>Recibe tu dinero de forma rápida y transparente tras cada estancia.</p>
            </div>

            <div class="card">
                <h3>Soporte 24/7</h3>
                <p>Estamos aquí para ayudarte en cada paso del camino, de día o de noche.</p>
            </div>
        </div>

        <div class="cta-section">
            <a href="#" class="btn-anfitrion" id="btn-empezar" data-id="<?php echo $_SESSION['id_usuario']; ?>">¡Empezar ahora!</a>
        </div>
    </main>
</div>
    <?php include 'footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="./librerias/bootstrap5.3.8/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/3b89af0a27.js" crossorigin="anonymous"></script>
    <script src="./librerias/alertifyjs/alertify.min.js"></script>
<script>
    const btnEmpezar = document.getElementById('btn-empezar');

    btnEmpezar.addEventListener('click', (e) => {
        e.preventDefault();
        const userId = btnEmpezar.getAttribute('data-id');
        
        let datosEnviar = {
            id: userId,
            accion: "solicitar"
        };

        btnEmpezar.innerText = "Enviando...";
        btnEmpezar.style.pointerEvents = "none";
        btnEmpezar.style.opacity = "0.7";

        $.ajax({
            url: './php/hacerAnfitrion.php',
            type: 'POST',
            data: datosEnviar,
            success: function(response) {
                alertify.success('Solicitud de anfitrión enviada. Nuestro equipo la revisará pronto.');
                // setTimeout(function(){
                //     location.reload();
                // }, 3000);
            },
                error: function() {
                    alertify.error('Hubo un error al enviar la solicitud.');
                    btnEmpezar.innerText = "¡Empezar ahora!";
                    btnEmpezar.style.pointerEvents = "auto";
                }
        });
    });
</script>
</body>

</html>