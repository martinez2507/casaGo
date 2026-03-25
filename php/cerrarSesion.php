<?php

include('cabecera.html');

session_start();

if(!isset($_SESSION['usuario'])) {
    echo "<h1>No hay sesión iniciada";
    exit;
} else {
    session_destroy();
    echo "<h1>Sesion cerrada correctamente</h1>";
}


