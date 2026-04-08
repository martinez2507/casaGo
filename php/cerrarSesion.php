<?php

include('cabecera.html');

session_start();

if(!isset($_SESSION['usuario'])) {
    echo "<h1>No hay sesión iniciada";
    exit;
} else {
    session_destroy();
    header("Location: ../index.php");
    exit;
}


