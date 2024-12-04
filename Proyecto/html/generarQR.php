<?php
require_once '../phpqrcode/phpqrcode-master/qrlib.php';  // Incluye la librería PHP QR Code
require_once '../php/db_connection.php';  // Incluye el archivo de conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_planta = $_POST['id_planta'];

    // Consulta para obtener la información de la planta seleccionada
    $sql = "SELECT * FROM plantas WHERE id_planta = $id_planta";
    $result = $conn->query($sql);
    $planta = $result->fetch_assoc();

    if ($planta && empty($planta['qr'])) {
        // Generar la URL de la página de descripción de la planta
        $base_url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
        $url_planta = $base_url . '/descripcionPlanta.php?id=' . $id_planta; // URL dinámica

        // Generar el QR con la URL
        ob_start();  // Inicia el buffer de salida
        QRcode::png($url_planta);  // Genera el QR directamente en la salida
        $qr_image = ob_get_contents();  // Captura el contenido generado
        ob_end_clean();  // Limpia el buffer de salida

        // Convertir la imagen a base64
        $base64_qr = base64_encode($qr_image);

        // Guardar la codificación base64 en la base de datos
        $update_sql = "UPDATE plantas SET qr = '$base64_qr' WHERE id_planta = $id_planta";
        if ($conn->query($update_sql) === TRUE) {
            echo "El código QR se ha generado y almacenado correctamente. <br>";
            echo "<p><a href='QR.php'>Volver al inicio</a></p>";
        } else {
            echo "Error al actualizar el código QR: " . $conn->error;
        }
    } else {
        echo "Esta planta ya tiene un QR o no existe.";
    }
}

$conn->close();
?>
