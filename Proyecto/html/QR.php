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
    <title>Generar o Descargar QR de Planta</title>
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
                <li class="nav-item active"><a href="index.html">Inicio</a></li>
                <li class="nav-item"><a href="catalogoPlantas.php">Plantas</a></li>
                <li class="nav-item"><a href="adoptar.php">Adopta una planta</a></li>
                <li class="nav-item"><a href="acceder.html">Ingresar</a></li>
            </ul>
        </div>
     </nav>

    <!-- Sección principal para la generación o descarga del QR -->
    <div class="form-container">
        <div class="adoption-form">
            <h1>Generar o Descargar Código QR de Planta</h1>
            <p>Selecciona una planta para generar o descargar su código QR.</p>

            <!-- Formulario para generar QR -->
            <h2>Generar QR para Planta</h2>
            <form action="generarQR.php" method="POST">
                <label for="planta_generar">Selecciona una planta para generar el QR:</label>
                <select name="id_planta" id="planta_generar" required>
                    <?php
                    // Consulta para obtener plantas sin QR
                    $conn = new mysqli('localhost', 'root', '', 'vivero');
                    if ($conn->connect_error) {
                        die("Conexión fallida: " . $conn->connect_error);
                    }

                    $sql = "SELECT id_planta, nombrecomun FROM plantas WHERE qr IS NULL OR qr = ''";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Mostrar las plantas sin QR
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id_planta'] . "'>" . $row['nombrecomun'] . "</option>";
                        }
                    } else {
                        echo "<option disabled>No hay plantas disponibles sin QR</option>";
                    }
                    ?>
                </select>
                <input type="submit" value="Generar QR">
            </form>

            <!-- Formulario para descargar QR -->
            <h2>Descargar QR de Planta Existente</h2>
            <form action="descargarQR.php" method="POST">
                <label for="planta_descargar">Selecciona una planta para descargar su QR:</label>
                <select name="id_planta" id="planta_descargar" required>
                    <?php
                    // Consulta para obtener plantas con QR
                    $sql = "SELECT id_planta, nombrecomun, qr FROM plantas WHERE qr IS NOT NULL AND qr != ''";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Mostrar las plantas con QR
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id_planta'] . "'>" . $row['nombrecomun'] . "</option>";
                        }
                    } else {
                        echo "<option disabled>No hay plantas con QR disponibles</option>";
                    }

                    $conn->close();
                    ?>
                </select>
                <input type="submit" value="Descargar QR">
            </form>
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
<script src="../scripts/menu.js"></script>
</html>
