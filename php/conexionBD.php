<?php
$servername = "127.0.1.1";
$username = "casago";
$password = "casago";
$database = "casago";
// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
  die("Conexion fallida: " . $conn->connect_error);
} else {

}