<?php 

header('Content-Type: application/json'); // Indicar que se enviará JSON
$servername = "localhost:3308";
$username = "root";
$password = "";
$dbname = "vivero";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Error de conexión: " . $conn->connect_error]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_planta = $_POST['id_planta'];
    $nombre = $_POST['nombre'];
    $nombremaya = $_POST['nombremaya'];
    $nombrecientifico = $_POST['nombrecientifico'];
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];
    $cantidad = $_POST['cantidad'];
    $ubicaciones = $_POST['ubicacion'] ?? [];

    // Actualizar tabla `plantas`
    $sql = "UPDATE plantas SET nombrecomun=?, nombremaya=?, nombrecientifico=?, tipo=?, descripcion=?, cantidad=? WHERE id_planta=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssii", $nombre, $nombremaya, $nombrecientifico, $tipo, $descripcion, $cantidad, $id_planta);

    if ($stmt->execute()) {
        // Eliminar ubicaciones actuales y agregar las nuevas
        $conn->query("DELETE FROM estado_planta WHERE id_planta=$id_planta");

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

        echo json_encode(["status" => "success", "message" => "Planta actualizada correctamente."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al actualizar la planta: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
