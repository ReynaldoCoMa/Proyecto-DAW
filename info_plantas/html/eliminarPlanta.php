<?php


// Verificar si la cookie de autenticación está configurada
if (!isset($_COOKIE['authenticated']) || $_COOKIE['authenticated'] !== "true") {
    // Si no está autenticado, redirigir al login
    header("Location: ../../Proyecto/html/acceder.php");
    exit();
}


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vivero";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$id = $_GET['id'];
$sql = "DELETE FROM plantas WHERE id_planta = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "error";
}

$stmt->close();
$conn->close();
?>
