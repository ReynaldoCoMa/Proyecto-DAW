<?php 
    include("../utilsDB/db_connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="icon" href="../images/viverologo.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Acceder</title>

    <script src="../scripts/validarAcceder.js" defer></script>
</head>
<body>
    <nav>
        <div class="navbar">
            <button class="hamburger-menu" onclick="toggleMenu()">&#9776;</button>
            <ul class="nav-links">
                <li class="logo"><a href="index.html"><img src="../images/logoviverouady.svg" alt="logo vivero uady"></a></li>
                <li class="nav-item "><a href="index.html">Inicio</a></li>
                <li class="nav-item"><a href="catalogoPlantas.php">Plantas</a></li>
                <li class="nav-item"><a href="adoptar.php">Adopta una planta</a></li>
                <li class="nav-item active"><a href="acceder.php">Ingresar</a></li>
            </ul>
        </div>
     </nav>

     <div class="form-container">
        <div class="adoption-form">
            <h1>Acceso administradores</h1>
            <p>Bienvenido de nuevo</p>
            <form action="../phplogin/login.php" method="POST" onsubmit="return validarForm()">
                
                <!-- Campo para el correo -->
                <div class="form-field">
                    <label>Usuario:</label>
                    <input type="text" id="user" name="user" required>
                </div>

                <div class="form-field">
                    <label>Contraseña:</label>
                    <input type="password" id="password" name="password" required>
                </div>



                <!-- Botón de envío -->
                <div class="form-field">
                    <input type="submit" name="submit" value="Acceder">
                </div>


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
    <script src="../scripts/menu.js"></script>
</body>
</html>