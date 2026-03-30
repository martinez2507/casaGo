<?php

$servername = "localhost";
$username = "casago";
$password = "casago";
$port = 3306;
$database = "casago";
// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// $conn = new mysqli($servername, $username, $password, port : 13306); Con esto nos saltamos el poner los parametros opcionales, sin eguir el orden

// Check connection
if ($conn->connect_error) {
  die("Conexion fallida: " . $conn->connect_error);
} else {

}


$consulta = "SELECT * FROM imagenes_apartamento where id_apartamento ='7'";

$datos = $conn->query($consulta);

$filas = $datos->num_rows;

echo "Hay " . $filas . " filas<br/>";
?>
<div class="prodDestacado"></div>
<?php
if ($datos->num_rows > 0) {
  ?>
  <div class="lineaProd">  
    <?php
  while ($filas = $datos->fetch_assoc()) {
    ?>
    <form action="inicio.php" method="POST">
      <div class="producto">
        <input type="hidden" name="idproductos" value="<?=$filas['idproductos']?>">
        <table  align="center">
          <tr>
            <td colspan="2"><img width="300px" height="300px" src="<?=$filas['url_imagen']?>"/></td>
          </tr>
          <tr>
            <td><?=$filas['nombre']?></td>
            <td text align="right"><?=$filas['precio']?>€</td>
          </tr>
          <tr>
            <td colspan="2"><?=$filas['descripcion']?></td>
          </tr>
        </table>
        <button class="añadirCarrito" type="submit" name="añadirCarrito"><img class="logoCarrito" src="./pub/img/añadirCarrito.png" width="50px" height="50px"></button>
      </div>
      </form>
    <?php
  }
}
