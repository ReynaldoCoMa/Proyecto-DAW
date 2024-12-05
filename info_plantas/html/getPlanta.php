<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vivero";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$id = $_GET['id'];
$sql = "SELECT * FROM plantas WHERE id_planta = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$planta = $result->fetch_assoc();

header('Content-Type: application/json');
echo json_encode($planta);

$stmt->close();
$conn->close();
?>
