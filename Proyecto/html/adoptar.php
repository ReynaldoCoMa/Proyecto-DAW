<?php
// Incluir conexión a la base de datos
include_once '../utilsDB/db_connection.php'; 

// Obtener las plantas visibles para adopción desde la base de datos
$query = "SELECT id_planta, nombrecomun, cantidad FROM plantas WHERE visible = 1 AND cantidad > 0";
$result = $conn->query($query);
$plantas = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $plantas[] = $row;
    }
} else {
    $plantas = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vivero UADY - Adoptar Planta</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> 
</head>
<body class="no-disable">

    <!-- Barra de navegación -->
    <nav>
        <div class="navbar">
            <button class="hamburger-menu" onclick="toggleMenu()">&#9776;</button>
            <ul class="nav-links">
                <li class="logo"><a href="index.html"><img src="../images/logoviverouady.svg" alt="logo vivero uady"></a></li>
                <li class="nav-item"><a href="index.html">Inicio</a></li>
                <li class="nav-item"><a href="catalogoPlantas.php">Plantas</a></li>
                <li class="nav-item active"><a href="adoptar.php">Adopta una planta</a></li>
                <li class="nav-item"><a href="acceder.php">Ingresar</a></li>
            </ul>
        </div>
    </nav>

    <!-- Título principal -->
    <div class="new-header"><h2>Plantas Disponibles para Adopción</h2></div>

    <!-- Contenedor de plantas disponibles -->
    <div id="adoption-cont" class="adoption-container">
        <!-- Este contenedor se llenará dinámicamente con las plantas -->
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
    <script>
        // Declarar la variable 'plantas' en el contexto global
        var plantas = <?php echo json_encode($plantas); ?>;
    </script>

    <!-- Incluir el archivo JavaScript externo -->
    <script src="../scripts/menu.js"></script>
    <script src="../scripts/adoptar.js"></script>

</body>
</html>
