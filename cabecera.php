
<header id="header">
    <a href="./index.php">
        <div class="logo">CasaGo</div>
    </a>
    <nav class="user-menu">
        <?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if(isset($_SESSION['usuario']) ) {
            if($_SESSION['rol'] !== 'anfitrion' && $_SESSION['rol'] !== 'admin') {
                echo "<a href='./hazteAnfitrion.php'><button class='btn btn-primary yaIniciado'>Hazte anfitrión</button></a>";
            }  
            
            echo '<a href="./preguntasFrecuentes.php"><i class="fa-regular fa-circle-question"></i></a>';
            echo "<a href='./perfil.php'><i class='fas fa-user'></i></a>";
            echo "<span class='user-name'> ". $_SESSION['usuario'] . " </span>";
            echo '<a href="./php/cerrarSesion.php"><i class="fas fa-sign-out-alt"></i></a>';
            
        } else {
            echo '<a href="./preguntasFrecuentes.php"><i class="fa-regular fa-circle-question"></i></a>';
            echo "<a href='./login.php'><button class='btn btn-primary iniciarSesion'>Iniciar sesión</button></a>";
            echo "<a href='./registrarse.php'><button class='btn btn-primary registrarse'>Registrarse</button></a>";
        }
        
        ?>
    </nav>
</header>