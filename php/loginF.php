<?php
session_start();
include('cabecera.html');

    $correoUsu = $_POST['correo'];
    $contraseñaUsu = $_POST['contraseña'];

    $servidor = "localhost";
    $username= "casago";
    $contraseña = "casago";
    $database ="casago";


    $conn = new mysqli($servidor, $username, $contraseña,$database);

    $sql = "SELECT * from usuarios where correo_electronico = '$correoUsu'";

    $consultaUsu = $conn->query($sql);


    $filas = $consultaUsu->num_rows;
    if ($filas == 0) {
        $_SESSION['credenciales_correctas'] = false;
        unset($_SESSION['usuario']);
    } else {

        $filas = $consultaUsu->fetch_assoc();
        if(password_verify($contraseñaUsu,$filas['contraseña'])) {
            $_SESSION['credenciales_correctas'] = true;
            $_SESSION['usuario'] = $correoUsu;
            $_SESSION['id_usuario'] = $filas['id'];
        } else {
            $_SESSION['credenciales_correctas'] = false;
            
        }

    }
            
        
    if ($_SESSION['credenciales_correctas'] != true){
        include('./credenciales_incorrectas.php');
    } else {
        $_SESSION['usuario'] = $correoUsu;
        include('./credenciales_correctas.php');

    }
$conn->close();
    

