<?php
    session_start();
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de <?= $_SESSION['usuario']; ?></title>
    <link rel='stylesheet' type='text/css' media='screen' href='./css/registro.css'>
    <link rel="stylesheet" href="./librerias/alertifyjs/css/alertify.min.css">
    <link rel="stylesheet" href="./librerias/alertifyjs/css/themes/default.min.css">
    <link rel="stylesheet" href="./css/perfil.css.css">
</head>
<body>
    <div class="contenedorPerfil">
         <div class="">
            <h1>Perfil de usuario</h1>
            <p>Bienvenido, <?= $_SESSION['usuario']; ?>. Este es tu perfil.</p>
            <!-- Aquí puedes agregar más información del perfil, como reservas, favoritos, etc. -->