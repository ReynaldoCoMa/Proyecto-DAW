<?php
// Incluir la conexión a la base de datos
include_once '../utilsDB/db_connection.php'; // Asegúrate de tener el archivo 'db_connection.php' que se encargue de la conexión.

// Consulta SQL para obtener todas las plantas disponibles para adopción
$query = "SELECT id_planta, nombrecomun, descripcion FROM plantas WHERE cantidad >= 1"; 
$result = $conn->query($query);

// Verificar si se obtuvieron resultados
if ($result->num_rows > 0) {
    // Si hay resultados, obtener todas las plantas en un arreglo
    $plantas = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $plantas = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="icon" href="../images/viverologo.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Vivero UADY - Adoptar</title>
</head>
<body>

    <!-- Barra de navegación -->
    <nav>
        <div class="navbar">
            <button class="hamburger-menu" onclick="toggleMenu()">&#9776;</button>
            <ul class="nav-links">
                <li class="logo"><a href="index.html"><img src="../images/logoviverouady.svg" alt="logo vivero uady"></a></li>
                <li class="nav-item"><a href="index.html">Inicio</a></li>
                <li class="nav-item"><a href="catalogoPlantas.php">Plantas</a></li>
                <li class="nav-item active"><a href="adoptar.php">Adopta una planta</a></li>
                <li class="nav-item"><a href="acceder.html">Ingresar</a></li>
            </ul>
        </div>
    </nav>

    <!-- Título principal -->
    <div class="new-header"><h2>Plantas Disponibles</h2></div>

    <!-- Barra de búsqueda -->
    <div class="search-container">
        <input type="text" placeholder="Buscar plantas..." class="search-input">
        <button type="submit" class="search-button">Buscar</button>
    </div>

    <!-- Contenedor dinámico de adopción de plantas -->
    <div class="adoption-container">
        <?php if (count($plantas) > 0): ?>
            <!-- Iterar sobre las plantas disponibles y crear una tarjeta por cada planta -->
            <?php foreach ($plantas as $planta): ?>
                <div class="adoption-card">
                    <img src="../images/prueba.jpeg"> <!-- Cambiar por la imagen de la planta -->
                    <h2><?php echo htmlspecialchars($planta['nombrecomun']); ?></h2>
                    <a href="formularioAdopcion.php?planta=<?php echo $planta['id_planta']; ?>"><strong>Adoptar</strong></a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay plantas disponibles para adopción en este momento.</p>
        <?php endif; ?>
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
