<?php
// Conexión a la base de datos
include_once '../utilsDB/db_connection.php';

// Clave y URL de la API de Perenual
const PERENUAL_API_KEY = 'sk-PWkK6750e44c521677889';
const PERENUAL_API_URL = 'https://perenual.com/api/species/details/';

// Función para obtener los filtros enviados por POST
function obtenerFiltros() {
    $search_name = isset($_POST['search-name']) ? $_POST['search-name'] : '';
    $plant_type = isset($_POST['plant-type']) ? $_POST['plant-type'] : '';
    $availability = isset($_POST['availability']) ? $_POST['availability'] : '';
    
    return [$search_name, $plant_type, $availability];
}

// Función para obtener los tipos de plantas
function obtenerTiposPlantas($conn) {
    $query = "SELECT DISTINCT tipo FROM plantas";
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
    $query = "SELECT DISTINCT cantidad FROM plantas";
    $result = $conn->query($query);
    
    $disponibilidad = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $disponibilidad[] = $row['cantidad'] > 0 ? 'Disponible' : 'Agotado';
        }
    }
    return array_unique($disponibilidad);
}

// Función para construir la consulta SQL con los filtros dinámicos
function construirConsulta($search_name, $plant_type, $availability) {
    $query = "SELECT * FROM plantas WHERE 1=1";
    
    if ($search_name) {
        $query .= " AND nombrecomun LIKE '%" . $search_name . "%'";
    }
    if ($plant_type) {
        $query .= " AND tipo = '" . $plant_type . "'";
    }
    if ($availability == 'Disponible') {
        $query .= " AND cantidad > 0";
    } elseif ($availability == 'Agotado') {
        $query .= " AND cantidad = 0";
    }
    
    return $query;
}

// Función para ejecutar la consulta y obtener los resultados
function obtenerResultados($conn, $query) {
    return $conn->query($query);
}

// Función para obtener la imagen de una planta desde la API de Perenual
function obtenerImagenPlanta($nombrecientifico) {
    if (!$nombrecientifico) {
        error_log("No se proporcionó nombre científico. Retornando imagen por defecto.");
        return '../images/default-plant.jpg';
    }

    // Crear URL de búsqueda
    $urlBusqueda = "https://perenual.com/api/species-list?key=" . PERENUAL_API_KEY . "&q=" . urlencode($nombrecientifico);
    error_log("URL de búsqueda formada: " . $urlBusqueda);

    // Realizar solicitud a la URL de búsqueda
    $respuestaBusqueda = @file_get_contents($urlBusqueda);
    if ($respuestaBusqueda === false) {
        error_log("Error al realizar la solicitud a la URL de búsqueda: " . $urlBusqueda);
        return '../images/plantaIndex.png';
    }
    error_log("Respuesta de búsqueda: " . $respuestaBusqueda);

    $datosBusqueda = json_decode($respuestaBusqueda, true);

    // Validar si hay datos
    if (!empty($datosBusqueda['data']) && isset($datosBusqueda['data'][0]['id'])) {
        $idPlanta = $datosBusqueda['data'][0]['id'];
        error_log("ID de la planta encontrada: " . $idPlanta);

        // Construir URL para obtener detalles
        $urlDetalles = PERENUAL_API_URL . $idPlanta . "?key=" . PERENUAL_API_KEY;
        error_log("URL de detalles formada: " . $urlDetalles);

        // Realizar solicitud a la URL de detalles
        $respuestaDetalles = @file_get_contents($urlDetalles);
        if ($respuestaDetalles === false) {
            error_log("Error al realizar la solicitud a la URL de detalles: " . $urlDetalles);
            return '../images/plantaIndex.png';
        }
        error_log("Respuesta de detalles: " . $respuestaDetalles);

        $datosDetalles = json_decode($respuestaDetalles, true);

        // Validar si los detalles contienen una imagen
        if (isset($datosDetalles['default_image']['original_url'])) {
            $imagen = $datosDetalles['default_image']['original_url'];
            error_log("URL de imagen obtenida: " . $imagen);
            return $imagen;
        } else {
            error_log("No se encontró una imagen en los detalles de la planta con ID: " . $idPlanta);
        }
    } else {
        error_log("No se encontraron resultados para el nombre científico: " . $nombrecientifico);
    }

    // Retornar imagen por defecto
    error_log("Retornando imagen por defecto.");
    return '../images/plantaIndex.png';
}




// Función para mostrar las plantas obtenidas
function mostrarPlantas($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $nombrecientifico = $row['nombrecientifico']; // Campo de la base de datos
            $imagen = obtenerImagenPlanta($nombrecientifico);

            echo '<div class="plant-card">';
            echo '<img src="' . htmlspecialchars($imagen) . '" alt="Planta ' . htmlspecialchars($row['nombrecomun']) . '">';
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
list($search_name, $plant_type, $availability) = obtenerFiltros();

// Obtener los valores dinámicos de la base de datos
$tipos = obtenerTiposPlantas($conn);
$disponibilidad = obtenerDisponibilidad($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="icon" href="../images/viverologo.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Vivero UADY - Catálogo de Plantas</title>
</head>
<body>
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
                        <option value="">Cualquier tipo</option>
                        <?php foreach ($tipos as $tipo): ?>
                            <option value="<?php echo $tipo; ?>" <?php echo $plant_type == $tipo ? 'selected' : ''; ?>>
                                <?php echo ucfirst($tipo); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="filter-option">
                    <label for="availability">Disponibilidad:</label>
                    <select id="availability" name="availability">
                        <?php foreach ($disponibilidad as $status): ?>
                            <option value="<?php echo strtolower($status); ?>" <?php echo $availability == strtolower($status) ? 'selected' : ''; ?>>
                                <?php echo $status; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="filter-button">Aplicar Filtros</button>
            </form>
        </div>

        <div class="plant-catalog">
            <h1>Catálogo de Plantas</h1>
            <p>Descubre la variedad de plantas que tenemos disponibles en nuestro vivero.</p>
            <div class="plant-list">
                <?php
                $query = construirConsulta($search_name, $plant_type, $availability);
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
</body>
</html>
