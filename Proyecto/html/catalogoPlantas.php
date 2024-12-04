<?php
// Conexión a la base de datos
include_once '../php/db_connection.php';

// Función para obtener los filtros enviados por POST
function obtenerFiltros() {
    $search_name = isset($_POST['search-name']) ? $_POST['search-name'] : '';
    $plant_type = isset($_POST['plant-type']) ? $_POST['plant-type'] : ''; // Sin valor por defecto
    $category = isset($_POST['category']) ? $_POST['category'] : ''; // Sin valor por defecto
    $availability = isset($_POST['availability']) ? $_POST['availability'] : ''; // Sin valor por defecto
    
    return [$search_name, $plant_type, $category, $availability];
}

// Función para obtener los tipos de plantas
function obtenerTiposPlantas($conn) {
    $query = "SELECT DISTINCT tipo FROM plantas"; // Consulta para obtener tipos distintos
    $result = $conn->query($query);
    
    $tipos = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tipos[] = $row['tipo'];
        }
    }
    return $tipos;
}


// Función para obtener la disponibilidad
function obtenerDisponibilidad($conn) {
    $query = "SELECT DISTINCT cantidad FROM plantas"; // Consulta para obtener disponibilidad
    $result = $conn->query($query);
    
    $disponibilidad = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $disponibilidad[] = $row['cantidad'] > 0 ? 'Disponible' : 'Agotado';
        }
    }
    return array_unique($disponibilidad); // Eliminar duplicados
}

// Función para construir la consulta SQL con los filtros dinámicos
function construirConsulta($search_name, $plant_type, $category, $availability) {
    $query = "SELECT * FROM plantas WHERE 1=1";
    
    if ($search_name) {
        $query .= " AND nombrecomun LIKE '%" . $search_name . "%'";
    }
    if ($plant_type) {
        $query .= " AND tipo = '" . $plant_type . "'"; // Solo se agrega si se selecciona un tipo específico
    }
    if ($availability == 'Disponible') {
        $query .= " AND cantidad > 0"; // Solo plantas disponibles
    } elseif ($availability == 'Agotado') {
        $query .= " AND cantidad = 0"; // Solo plantas agotadas
    }
    
    return $query;
}


// Función para ejecutar la consulta y obtener los resultados
function obtenerResultados($conn, $query) {
    return $conn->query($query);
}

// Función para mostrar las plantas obtenidas
function mostrarPlantas($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="plant-card">';
            echo '<img src="../images/prueba.jpeg" alt="Planta ' . htmlspecialchars($row['nombrecomun']) . '">';
            echo '<h3>' . htmlspecialchars($row['nombrecomun']) . '</h3>';
            echo '<p>' . htmlspecialchars(substr($row['descripcion'], 0, 80)) . '...</p>';
            echo '<a href="descripcionPlanta.php?id=' . intval($row['id_planta']) . '">Más información</a>';
            echo '</div>';
        }
    } else {
        echo '<p>No se encontraron plantas que coincidan con los filtros.</p>';
    }
}


// Obtener los filtros
list($search_name, $plant_type, $category, $availability) = obtenerFiltros();

// Obtener los valores dinámicos de la base de datos
$tipos = obtenerTiposPlantas($conn);
$disponibilidad = obtenerDisponibilidad($conn);
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Vivero UADY - Catálogo de Plantas</title>
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
                <li class="nav-item "><a href="index.html">Inicio</a></li>
                <li class="nav-item active"><a href="catalogoPlantas.html">Plantas</a></li>
                <li class="nav-item"><a href="adoptar.html">Adopta una planta</a></li>
                <li class="nav-item"><a href="acceder.html">Ingresar</a></li>
            </ul>
        </div>
     </nav>

    <!-- Sección principal para el catálogo de plantas -->
    <div class="catalogo-container">
        
        <div class="filter-panel">
            <h2>Filtrar por:</h2>
            <form method="POST" action="catalogoPlantas.php">
                <div class="filter-option">
                    <label for="search-name">Buscar por nombre:</label>
                    <input type="text" id="search-name" name="search-name" placeholder="Ej. Planta 1" value="<?php echo htmlspecialchars($search_name); ?>">
                </div>
                <div class="filter-option">
                    <label for="plant-type">Tipo de planta:</label>
                    <select name="plant-type">
                        <option value="">Cualquier tipo</option> <!-- Opción para cualquier tipo -->
                        <?php
                        // Mostrar los tipos obtenidos dinámicamente
                        foreach ($tipos as $tipo) {
                            echo '<option value="' . $tipo . '" ' . ($plant_type == $tipo ? 'selected' : '') . '>' . ucfirst($tipo) . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="filter-option">
                    <label for="availability">Disponibilidad:</label>
                    <select id="availability" name="availability">
                        <?php
                        // Mostrar las disponibilidades obtenidas dinámicamente
                        foreach ($disponibilidad as $status) {
                            echo '<option value="' . strtolower($status) . '" ' . ($availability == strtolower($status) ? 'selected' : '') . '>' . $status . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="filter-option">
                    <button type="submit" class="filter-button">Aplicar Filtros</button>
                </div>
            </form>
        </div>

        <div class="plant-catalog">
            <h1>Catálogo de Plantas</h1>
            <p>Descubre la variedad de plantas que tenemos disponibles en nuestro vivero. Elige la que más te guste y aprende más sobre ella.</p>
            <div class="plant-list">
                <?php
                $query = construirConsulta($search_name, $plant_type, $category, $availability);
                $result = obtenerResultados($conn, $query);
                mostrarPlantas($result);
                ?>
            </div>
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
