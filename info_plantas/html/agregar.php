<?php

// Verificar si la cookie de autenticación está configurada
if (!isset($_COOKIE['authenticated']) || $_COOKIE['authenticated'] !== "true") {
    // Si no está autenticado, redirigir al login
    header("Location: ../../Proyecto/html/acceder.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <title>Agregar Planta</title>
</head>
<body>
    <nav>
        <div class="navbar">
            <div class="divlogo">
                <img class="logo" src="../../Proyecto/images/logoviverouady.svg">
            </div>
            <div>
            <button class="botonsalir" onclick="window.location.href='../../Proyecto/phplogin/logout.php'">Cerrar sesión</button>
            </div>
        </div>
    </nav>
    <!-- Sección del formulario para agregar planta -->

    <div class="form-container">
        <div class="adoption-form"> <!--Clase únicamente para el estilo-->
            <h1>Agregar planta</h1>
            <p>
                ¡Hola <?php // imprimiendo el nombre por medio de la información en la Cookie
            if (isset($_COOKIE['user'])) {
                echo "<span>" . htmlspecialchars($_COOKIE['user']) . "</span>";
            }
         ?>! Gracias por actualizar el sitio. Ingresa la información de la planta para registrarla</p>
    
            <form id="registForm" action="../server/agregarplanta.php" method="POST">
                <!-- Campo para el nombre de la planta -->
                <div class="form-field">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
    
                <!-- Campo para el nombre en maya de la planta -->
                <div class="form-field">
                    <label for="nombremaya">Nombre en maya:</label>
                    <input type="text" id="nombremaya" name="nombremaya" required>
                </div>
    
                <!-- Campo para el nombre científico -->
                <div class="form-field">
                    <label for="nombrecientifico">Nombre Científico:</label>
                    <input type="text" id="nombrecientifico" name="nombrecientifico" required>
                </div>
    
                <!-- Campo para el tipo de planta -->
                <div class="form-field">
                    <label for="tipo">Tipo:</label>
                    <select id="tipo" name="tipo">
                        <option value="Helechos y afines">Helechos y afines</option>
                        <option value="Gimnospermas">Gimnospermas</option>
                        <option value="Angiospermas">Angiospermas</option>
                    </select>
                </div>
    
                <!-- Campo para la descripción -->
                <div class="form-field">
                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" required></textarea>
                </div>
    
                <!-- Campo para la ubicación (Estados disponibles) -->
                <div class="">
                    <fieldset>
                        <legend>Estados donde está disponible:</legend>
                        <label>
                            <input type="checkbox" name="ubicacion[]" value="Yucatán"> Yucatán
                        </label>
                        <label>
                            <input type="checkbox" name="ubicacion[]" value="Campeche"> Campeche
                        </label>
                        <label>
                            <input type="checkbox" name="ubicacion[]" value="Quintana Roo"> Quintana Roo
                        </label>
                    </fieldset>
                </div>
    
                <!-- Campo para la cantidad disponible -->
                <div class="form-field">
                    <label for="cantidad">Cantidad disponible:</label>
                    <input type="number" id="cantidad" name="cantidad" required>
                </div>
    
                <!-- Botón de envío -->
                <div class="form-field">
                    <input type="submit" value="Agregar">
                </div>
            </form>
        </div>
    </div>
    
</body>
</html>