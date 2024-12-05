<?php
// Verificar si la cookie de autenticación está configurada
if (!isset($_COOKIE['authenticated']) || $_COOKIE['authenticated'] !== "true") {
    // Si no está autenticado, redirigir al login
    header("Location: ../../Proyecto/html/acceder.php");
    exit();
}
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "vivero";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario
    $nombre = $_POST['nombre'];
    $nombremaya = $_POST['nombremaya'];
    $nombrecientifico = $_POST['nombrecientifico'];
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];
    $cantidad = $_POST['cantidad'];
    $ubicaciones = $_POST['ubicacion']; // Array de ubicaciones (checkboxes seleccionados)

    // Insertar datos en la tabla `plantas`
    $sql = "INSERT INTO plantas (nombrecomun, nombremaya, nombrecientifico, tipo, descripcion, cantidad) 
            VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $nombre, $nombremaya, $nombrecientifico, $tipo, $descripcion, $cantidad);

    if ($stmt->execute()) {
        // Obtener el último ID insertado
        $id_planta = $conn->insert_id;

        // Insertar datos en la tabla `estado_planta`
        $sql_ubicacion = "INSERT INTO estado_planta (id_planta, num_estado, estado) VALUES (?, ?, ?)";
        $stmt_ubicacion = $conn->prepare($sql_ubicacion);

        foreach ($ubicaciones as $estado) {
            // Mapeo de estados a sus respectivos números
            $map_estado = [
                "Yucatán" => 1,
                "Campeche" => 2,
                "Quintana Roo" => 3
            ];

            $num_estado = $map_estado[$estado]; // Obtener el número del estado
            $stmt_ubicacion->bind_param("iis", $id_planta, $num_estado, $estado);
            $stmt_ubicacion->execute();
        }

        echo "Planta registrada correctamente.";
    } else {
        echo "Error al registrar la planta: " . $stmt->error;
    }

    // Cerrar conexiones
    $stmt->close();
    $conn->close();
}
?>
