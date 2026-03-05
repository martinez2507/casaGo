<?php

session_start();
include('cabecera.html');

    $nombreUsu = $_POST['nombre'];
    $correoUsu = $_POST['correo'];
    $contraseñaUsu = $_POST['contraseña'];

    $servidor = "localhost";
    $username= "casago";
    $contraseña = "casago";
    $database ="casago";


    $conn = new mysqli($servidor, $username, $contraseña,$database);

    $sql = "SELECT nombre,id_usuario from usuarios where correo_electronico = '$correoUsu'";

    $consultaUsu = $conn->query($sql);
    $filas = $consultaUsu->num_rows;

    if ($filas == 1) {
        header('Location: yaRegistrado.php?error='. $nombreUsu);
    } else {
        // hacemos hash y guardamos en bd siempre y cuando el hash no este hecho ya
        $hash_passwd = password_hash($contraseñaUsu, PASSWORD_DEFAULT);
        $actualizarCon = "INSERT into usuarios (nombre,correo_electronico,contraseña,rol) values ('$nombreUsu','$correoUsu','$hash_passwd','usuario')";
        $contraseñas = $conn->query($actualizarCon);

        echo "<h1>Usuario $nombreUsu, registrado correctamente</h1>";

        // cogemos id, ya que al ser autoincrementado no lo asignamos a la variable de sesion id_usuario, esto nos vale para que al registrarlo se inicie sesion auitomaticamente y puede añadir eventos  favoritos
        $cogerId = "SELECT id from usuarios where correo_electronico = '$correoUsu'";
        $consultaId = $conn->query($sql);
        $filas = $consultaId->fetch_assoc();

        $_SESSION['credenciales_correctas'] = true;
        $_SESSION['usuario'] = $nombreUsu;
        $_SESSION['id_usuario'] = $filas['id_usuario'];
    }

$conn->close();