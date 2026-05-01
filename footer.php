<?php

if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>

<script src="https://kit.fontawesome.com/3b89af0a27.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="./css/footer.css">

<footer class="main-footer">
    <div class="footer-container">
        <div class="footer-section about">
            <h2 class="footer-logo">Casa<span>Go</span></h2>
            <p>Tu próximo destino a un solo clic. Reserva los mejores apartamentos para tus vacaciones de ensueño.</p>
        </div>

        <div class="footer-section links">
            <h3>Explorar</h3>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <?php if (isset($_SESSION['id_usuario'])): ?>
                    <li><a href="reservas.php">Mis Reservas</a></li>
                <?php endif; ?>
                <li><a href="#">Sobre nosotros</a></li>
                <li><a href='https://mail.google.com/mail/?view=cm&fs=1&to=casagoof@gmail.com' target='_blank' title='Mandar correo a soporte'>Contacto</a></li>
            </ul>
        </div>

        <div class="footer-section social">
            <h3>Síguenos</h3>
            <div class="social-icons">
                <a href="#"><i class="fa-brands fa-facebook"></i></a>
                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                <a href="#"><i class="fa-brands fa-x-twitter"></i></a>
                <a href="#"><i class="fa-brands fa-linkedin"></i></a>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; <?php echo date("Y"); ?> <strong>CasaGo</strong> - Todos los derechos reservados.</p>
        <p class="tfg-tag">Proyecto realizado para <strong>TFG</strong> (Trabajo Fin de Grado)</p>
    </div>
</footer>