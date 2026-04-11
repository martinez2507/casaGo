<?php

include("conexionBD.php");
if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
$precioMax = $_GET['precio'] ?? 2000;
$extras = $_GET['extras'] ?? []; // Esto es un array gracias a name="extras[]"

// 3. Construir la consulta SQL dinámicamente
$ciudad = $_GET['city'] ?? '';
$precioMax = $_GET['precio'] ?? 2000;

$sql = "SELECT * FROM apartamentos WHERE precio <= :precio";
$params = [':precio' => $precioMax];

if ($ciudad !== '') {
    $sql .= " AND ciudad LIKE :ciudad";
    $params[':ciudad'] = "%$ciudad%";
}

// Si el usuario marcó checkboxes de extras
if (!empty($extras)) {
    foreach ($extras as $indice => $extra) {
        // Suponiendo que en tu DB los extras son columnas booleanas (0 o 1)
        // O podrías usar una tabla relacional, pero para este ejemplo:
        $sql .= " AND $extra = 1"; 
    }
}

// 4. Ejecutar y devolver JSON
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$resultados = $stmt->fetchAll();

// Importante: Decirle al navegador que esto es JSON
header('Content-Type: application/json');

// IMPORTANTE: Si tus "extras" en la DB no son un array, 
// puedes "simularlo" antes de enviar para que el JS no falle
foreach ($resultados as &$apt) {
    // Ejemplo: convertimos columnas de la DB a un array para el JS
    $apt['extras'] = [];
    if (isset($apt['wifi']) && $apt['wifi']) $apt['extras'][] = 'WiFi';
    if (isset($apt['piscina']) && $apt['piscina']) $apt['extras'][] = 'Piscina';
    if (isset($apt['parking']) && $apt['parking']) $apt['extras'][] = 'Parking';
}

echo json_encode($resultados);