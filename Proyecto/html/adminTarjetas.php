<?php
// Incluir conexión a la base de datos
include_once '../utilsDB/db_connection.php'; 

// Obtener las plantas desde la base de datos para mostrar en la página
$query = "SELECT id_planta, nombrecomun, cantidad, visible FROM plantas WHERE cantidad >= 1";
$result = $conn->query($query);
$plantas = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $plantas[] = $row;
    }
}

// Si es una solicitud POST, procesamos las acciones de crear o eliminar tarjeta
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Procesar la creación o eliminación de tarjeta
    $idPlanta = isset($_POST['id_planta']) ? $_POST['id_planta'] : '';
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    if ($idPlanta && $action) {
        if ($action == 'crear') {
            // Actualizar la planta para hacerla visible
            $query = "UPDATE plantas SET visible = 1 WHERE id_planta = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('i', $idPlanta);
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Tarjeta creada con éxito.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al crear la tarjeta.']);
            }
        } elseif ($action == 'eliminar') {
            // Actualizar la planta para eliminarla de la lista
            $query = "UPDATE plantas SET visible = 0 WHERE id_planta = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('i', $idPlanta);
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Tarjeta eliminada con éxito.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al eliminar la tarjeta.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Acción no válida.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Datos insuficientes.']);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">    
<title>Vivero UADY - Admin Tarjetas</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="icon" href="../images/viverologo.svg">
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


    <!-- Barra de búsqueda -->
    <div class="search-container">
        <input type="text" id="searchInput" placeholder="Buscar plantas..." class="search-input">
        <button id="searchButton" class="search-button">Buscar</button>
    </div>

    <!-- Contenedor de plantas encontradas -->
    <div id="plantResultsContainer">
        <?php foreach ($plantas as $planta): ?>
            <div class="planta-card-custom">
                <h3><?php echo $planta['nombrecomun']; ?></h3>
                <p><strong>Cantidad disponible:</strong> <?php echo $planta['cantidad']; ?></p>
                <p><strong>Visible:</strong> <?php echo $planta['visible'] == 1 ? 'Sí' : 'No'; ?></p>
                <button onclick="handleCardAction(<?php echo $planta['id_planta']; ?>, '<?php echo $planta['visible'] == 1 ? 'eliminar' : 'crear'; ?>')">
                    <?php echo $planta['visible'] == 1 ? 'Eliminar tarjeta' : 'Crear tarjeta'; ?>
                </button>
            </div>
        <?php endforeach; ?>
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
    <script src="../scripts/tarjetas.js"></script>
</body>
</html>
