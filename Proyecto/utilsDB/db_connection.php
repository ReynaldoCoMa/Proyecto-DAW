<?php
$servername = "localhost";//"localhost:3307";
$username = "root"; // Cambia esto si tu usuario no es root
$password = ""; // Cambia esto si tienes una contraseña
$dbname = "database1"; // Nombre de tu base de datos

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
