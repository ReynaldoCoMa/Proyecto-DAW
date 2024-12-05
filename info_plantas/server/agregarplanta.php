<?php

$servername = "localhost:3308";
$username = "root";
$password = "";
$dbname = "database1";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars($_POST['nombre'], ENT_QUOTES, 'UTF-8');
    $nombremaya = htmlspecialchars($_POST['nombremaya'], ENT_QUOTES, 'UTF-8');
    $nombrecientifico = htmlspecialchars($_POST['nombrecientifico'], ENT_QUOTES, 'UTF-8');
    $tipo = htmlspecialchars($_POST['tipo'], ENT_QUOTES, 'UTF-8');
    $descripcion = htmlspecialchars($_POST['descripcion'], ENT_QUOTES, 'UTF-8');
    $cantidad = intval($_POST['cantidad']);
    $ubicaciones = $_POST['ubicacion'];

    $sql = "INSERT INTO plantas (nombrecomun, nombremaya, nombrecientifico, tipo, descripcion, cantidad) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $nombre, $nombremaya, $nombrecientifico, $tipo, $descripcion, $cantidad);

    if ($stmt->execute()) {
        $id_planta = $conn->insert_id;
        $sql_ubicacion = "INSERT INTO estado_planta (id_planta, num_estado, estado) VALUES (?, ?, ?)";
        $stmt_ubicacion = $conn->prepare($sql_ubicacion);

        $map_estado = [
            "Yucatán" => 1,
            "Campeche" => 2,
            "Quintana Roo" => 3
        ];

        foreach ($ubicaciones as $estado) {
            $num_estado = $map_estado[$estado];
            $stmt_ubicacion->bind_param("iis", $id_planta, $num_estado, $estado);
            $stmt_ubicacion->execute();
        }

        echo "Planta registrada correctamente.";
    } else {
        echo "Error al registrar la planta: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
