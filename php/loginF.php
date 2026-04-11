<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('../cabecera.php');

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
        $_SESSION['tipo'] = "error";
        $_SESSION['mensaje'] = "Usuario no encontrado";
    } else {

        $filas = $consultaUsu->fetch_assoc();
        if(password_verify($contraseñaUsu,$filas['contraseña'])) {
            $_SESSION['credenciales_correctas'] = true;
            $_SESSION['usuario'] = $filas['nombre'];
            $_SESSION['id_usuario'] = $filas['id_usuario'];
            $_SESSION['email'] = $filas['correo_electronico'];
            $_SESSION['rol'] = $filas['rol'];
            $_SESSION['mensaje'] = "Inicio de sesión exitoso";
            $_SESSION['tipo'] = "success";
        } else {
            $_SESSION['credenciales_correctas'] = false;
            $_SESSION['tipo'] = "error";
            $_SESSION['mensaje'] = "Contraseña incorrecta";
        }

    }
            
        
    if ($_SESSION['credenciales_correctas'] != true){
        header("Location: ../login.php");
        exit();
        
    } else {
        $_SESSION['usuario'] = $filas['nombre'];
        header("Location: ../index.php");
        exit();

    }
$conn->close();
    

