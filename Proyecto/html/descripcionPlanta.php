<?php
// Conexión a la base de datos
include_once '../utilsDB/db_connection.php';

// Obtener el id de la planta desde la URL
$id_planta = isset($_GET['id']) ? intval($_GET['id']) : 0; // Usamos intval para evitar problemas con inyección de SQL

// Verificar si el id es válido
if ($id_planta > 0) {
    // Consulta para obtener la información de la planta por su id
    $query = "SELECT nombrecomun, nombremaya, nombrecientifico, tipo, descripcion FROM plantas WHERE id_planta = $id_planta";
    $result = $conn->query($query);

    // Verificar si encontramos la planta
    if ($result->num_rows > 0) {
        $planta = $result->fetch_assoc();
    } else {
        echo '<p>No se encontró la planta.</p>';
        exit; // Detener ejecución si no se encuentra la planta
    }
} else {
    echo '<p>ID no válido.</p>';
    exit;
}

// Recuperar la imagen de la API usando cURL
$apiKey = 'sk-PWkK6750e44c521677889';
$apiUrl = "https://perenual.com/api/species-list?key=$apiKey&q=" . urlencode($planta['nombrecientifico']);

$imageUrl = '../images/default.jpg'; // Imagen por defecto
$apiResponse = file_get_contents($apiUrl);



if ($apiResponse) {
    $data = json_decode($apiResponse, true);
    if (isset($data['data'][0]['default_image']['regular_url'])) {
        $imageUrl = $data['data'][0]['default_image']['regular_url'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="icon" href="../images/viverologo.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Vivero UADY - Descripción de Planta</title>
</head>
<body>

    <!-- Barra de navegación -->
    <nav>
        <div class="navbar">
            <button class="hamburger-menu" onclick="toggleMenu()">&#9776;</button>
            <ul class="nav-links">
                <li class="logo"><a href="index.html"><img src="../images/logoviverouady.svg" alt="logo vivero uady"></a></li>
                <li class="nav-item"><a href="index.html">Inicio</a></li>
                <li class="nav-item active"><a href="catalogoPlantas.php">Plantas</a></li>
                <li class="nav-item"><a href="adoptar.php">Adopta una planta</a></li>
                <li class="nav-item"><a href="acceder.html">Ingresar</a></li>
            </ul>
        </div>
     </nav>

    <!-- Contenedor de la planta -->
    <div class="plant-detail-container">
        <div class="plant-info">
            <h1><?php echo htmlspecialchars($planta['nombrecomun']); ?></h1>
            <p><strong>Nombre maya:</strong> <?php echo htmlspecialchars($planta['nombremaya']); ?></p>
            <p><strong>Nombre científico:</strong> <?php echo htmlspecialchars($planta['nombrecientifico']); ?></p>
            <p><strong>Tipo:</strong> <?php echo htmlspecialchars($planta['tipo']); ?></p>
            <p><strong>Descripción:</strong> <?php echo nl2br(htmlspecialchars($planta['descripcion'])); ?></p>
        </div>

        <!-- Imagen de la planta -->
        <div class="plant-image">
            <img src="<?php echo htmlspecialchars($imageUrl); ?>" alt="Imagen de <?php echo htmlspecialchars($planta['nombrecomun']); ?>" class="plant-img">
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-logo">
                <img src="../images/logo.jpg" alt="logo uady">
            </div>
            <div class="footer-text">
                <p>Universidad Autónoma de Yucatán</p>
                <p>© Todos los Derechos Reservados, UADY 2024</p>
                <p>Síguenos en nuestras redes sociales</p>
                <div class="social-links">
                    <a href="https://www.facebook.com/UADY.Sustentable" target="_blank" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://x.com/UADYoficial" target="_blank" class="social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="https://www.instagram.com/uady.sustentable/" target="_blank" class="social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.linkedin.com/company/uadyinstitucional/" target="_blank" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <script src="../scripts/menu.js"></script>
</body>
</html>
