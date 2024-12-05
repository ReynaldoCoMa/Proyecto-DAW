
<?php
// Incluir la conexión a la base de datos
include_once '../utilsDB/db_connection.php';

// Comprobar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $plantaId = $_POST['planta'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $direccion = $_POST['direccion'];

    $imagenPath = null; 
    if(!empty($_FILES['imagen']['name'])){
        $uploadDir = '../images'; 
        $imagenPath = $uploadDir . basename($_FILES['imagen']['name']); 

        // Validar el archivo (tamaño y tipo)
        $fileType = strtolower(pathinfo($imagenPath, PATHINFO_EXTENSION));
        if ($_FILES['imagen']['size'] > 5000000) { // Tamaño máximo 5MB
            die("El archivo es demasiado grande.");
        }
        if (!in_array($fileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            die("Solo se permiten imágenes (JPG, JPEG, PNG, GIF).");
        }

        // Mover el archivo subido
        if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $imagenPath)) {
            die("Error al subir la imagen.");
        }

    }

    // Guardar los datos de la adopción en la base de datos (sin necesidad de id_adopcion)
    $query = "INSERT INTO adopciones (id_planta, nombre_adoptador, email, direccion, imagen) 
              VALUES ('$plantaId', '$nombre', '$email', '$direccion', '$imagenPath')";
    if ($conn->query($query) === TRUE) {
        // Si la adopción fue exitosa, actualizar la cantidad de la planta
        $updateQuery = "UPDATE plantas SET cantidad = cantidad - 1 WHERE id_planta = '$plantaId'";
        $conn->query($updateQuery);

        header("Location:../phpComprobante/comprobante.php?planta=$plantaId&nombre=" . urlencode($nombre) . "&email=" . urlencode($email) . "&direccion=" . urlencode($direccion));
        exit();

        // Redirigir a una página de agradecimiento o mostrar mensaje de éxito
        /*echo "<script>
                alert('¡Gracias por adoptar! La planta ha sido reservada para ti.');
                window.location.href = 'adoptar.php'; //Redirigir a otra página
              </script>";*/
    } else {
        echo "<script>
                alert('Error al procesar la adopción: " . $conn->error . "');
              </script>";
    }
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
    <title>Vivero UADY - Adopción de Planta</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="icon" href="../images/viverologo.svg">

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

    <!-- Sección del formulario de adopción de planta -->
    <div class="form-container">
        <div class="adoption-form">
            <h1>¡Ya casi es tuya!</h1>
            <p>Completa el formulario para adoptar una planta del vivero.</p>
            <form action="#" method="post" id="adoptForm" enctype="multipart/form-data">
                <!-- Campo para el nombre -->
                <div class="form-field">
                    <label for="nombre">Nombre Completo:</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>

                <!-- Campo para el correo -->
                <div class="form-field">
                    <label for="email">Correo Electrónico:</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <!-- Campo para seleccionar la planta -->
                <div class="form-field">
                    <label for="planta">Planta Seleccionada:</label>
                    <input type="text" id="planta" name="planta" required readonly>
                </div>

                <!-- Campo para la dirección -->
                <div class="form-field">
                    <label for="direccion">Dirección de Entrega:</label>
                    <input type="text" id="direccion" name="direccion" required>
                </div>

                 <!-- Campo para subir una imagen (documento) -->
                 <div class="form-field">
                    <label for="imagen">Sube una imagen de tu identificación:</label>
                    <input type="file" id="imagen" name="imagen" accept="image/*" required>
                </div>


                <!-- Botón de envío -->
                <div class="form-field">
                    <input type="submit" value="Adoptar Planta">
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
    <script src="../scripts/ponerNombrePlantaFormAdoptar.js"></script>
    <script src="../scripts/menu.js"></script>
    <script src="../scripts/validarAdoptar.js"></script>
</body>
</html>
