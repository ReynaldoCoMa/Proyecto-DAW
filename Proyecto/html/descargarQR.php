<?php
require_once '../utilsDB/db_connection.php';  // Incluye el archivo de conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_planta = $_POST['id_planta'];

    // Consulta para obtener la información de la planta seleccionada
    $sql = "SELECT * FROM plantas WHERE id_planta = $id_planta";
    $result = $conn->query($sql);
    $planta = $result->fetch_assoc();

    if ($planta && !empty($planta['qr'])) {
        // Decodificar la imagen base64
        $base64_qr = $planta['qr'];
        $qr_image = base64_decode($base64_qr);

        // Crear el archivo de la imagen QR y enviarlo al navegador
        header('Content-Type: image/png');
        header('Content-Disposition: attachment; filename="qr_planta_' . $id_planta . '.png"');
        echo $qr_image;  // Enviar la imagen al navegador
        exit();
    } else {
        echo "Planta no encontrada o no tiene un QR generado.";
    }
}

$conn->close();
?>
