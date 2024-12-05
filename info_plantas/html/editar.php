
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
    <title>Gestión de Plantas</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Lato&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/styleEditar.css">
    
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
    <h1>Gestión de Plantas</h1>
    <p>¡Hola
    <?php
            if (isset($_COOKIE['user'])) {
                echo "<span>" . htmlspecialchars($_COOKIE['user']) . "</span>";
            }
         ?>! Elija con cuidado lo que desea hacer.
    </p>
    <?php
    $servername = "localhost:3308";
    $username = "root";
    $password = "";
    $dbname = "vivero";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM plantas";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<div id='plantList'>";
        while ($row = $result->fetch_assoc()) {
            echo "
            <div class='plant-card' id='plant-{$row['id_planta']}'>
                <h2>{$row['nombrecomun']}</h2>
                <p><strong>Nombre Maya:</strong> {$row['nombremaya']}</p>
                <p><strong>Nombre Científico:</strong> {$row['nombrecientifico']}</p>
                <div class='buttons'>
                    <button class='optionedit' onclick='editPlant({$row['id_planta']})'>Editar</button>
                    <button class='optionedit' onclick='deletePlant({$row['id_planta']})'>Eliminar</button>
                </div>
            </div>
            ";
        }
        echo "</div>";
    } else {
        echo "<p>No hay plantas registradas.</p>";
    }

    $conn->close();
    ?>

    

    <!-- Contenedor del formulario de edición -->
    
    <div id="editFormContainer">
    <h2>Editar Planta</h2>
        <div class="form-container">
            
            <form id="editForm" method="post" action="actualizarplanta.php">
                <div class="form-field">
                    <label for="editNombre">Nombre común:</label>
                    <input type="text" id="editNombre" name="nombre" required>
                </div>
                <div class="form-field">
                    <label for="editNombreMaya">Nombre en maya:</label>
                    <input type="text" id="editNombreMaya" name="nombremaya" required>
                </div>
                <div class="form-field">
                    <label for="editNombreCientifico">Nombre científico:</label>
                    <input type="text" id="editNombreCientifico" name="nombrecientifico" required>
                </div>
                <div class="form-field">
                    <label for="editTipo">Tipo:</label>
                    <select id="editTipo" name="tipo" required>
                        <option value="Helechos y afines">Helechos y afines</option>
                        <option value="Gimnospermas">Gimnospermas</option>
                        <option value="Angiospermas">Angiospermas</option>
                    </select>
                </div>
                <div class="form-field">
                    <label for="editDescripcion">Descripción:</label>
                    <textarea id="editDescripcion" name="descripcion" required></textarea>
                </div>
                <div class="form-field">
                    <label for="editCantidad">Cantidad disponibles:</label>
                    <input type="number" id="editCantidad" name="cantidad" required>
                </div>
                <input type="hidden" name="id_planta" id="editIdPlanta">
                <button type="submit">Guardar Cambios</button>
                <button type="button" onclick="closeEditForm()">Cancelar</button>
            </form>
        </div>
    </div>

    <script>
        // Función para abrir el formulario de edición
        function editPlant(id) {
            document.getElementById("editFormContainer").classList.add("visible");

            fetch(`getPlanta.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    // Rellenar el formulario con los datos de la planta
                    document.getElementById('editIdPlanta').value = data.id_planta;
                    document.getElementById('editNombre').value = data.nombrecomun;
                    document.getElementById('editNombreMaya').value = data.nombremaya;
                    document.getElementById('editNombreCientifico').value = data.nombrecientifico;
                    document.getElementById('editTipo').value = data.tipo;
                    document.getElementById('editDescripcion').value = data.descripcion;
                    document.getElementById('editCantidad').value = data.cantidad;
                });
        }

        function styleEditForm(form) {
            form.style.display = "block";
            form.style.backgroundColor = "red";
        }

        

        // Función para eliminar una planta
        function deletePlant(id) {
            if (confirm("¿Estás seguro de que deseas eliminar esta planta?")) {
                fetch(`eliminarplanta.php?id=${id}`, { method: 'GET' })
                    .then(response => response.text())
                    .then(result => {
                        if (result === 'success') {
                            document.getElementById(`plant-${id}`).remove();
                            alert("Planta eliminada correctamente.");
                        } else {
                            alert("Error al eliminar la planta.");
                        }
                    });
            }
        }

        function closeEditForm() {
            document.getElementById("editFormContainer").classList.remove("visible");
        }
    </script>
</body>
</html>
