<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Plantas</title>
    <style>
        .plant-card {
            border: 1px solid #ccc;
            padding: 15px;
            margin: 10px;
            border-radius: 5px;
        }
        .buttons {
            margin-top: 10px;
        }
        .buttons button {
            margin-right: 10px;
        }
        #editFormContainer {
            display: none;
            border: 1px solid #ccc;
            padding: 15px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Gestión de Plantas</h1>

    <?php
    $servername = "localhost:3307";
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
                    <button onclick='editPlant({$row['id_planta']})'>Editar</button>
                    <button onclick='deletePlant({$row['id_planta']})'>Eliminar</button>
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
        <form id="editForm" method="post" action="actualizarplanta.php">
            <input type="hidden" name="id_planta" id="editIdPlanta">
            <label for="editNombre">Nombre común:</label>
            <input type="text" id="editNombre" name="nombre" required><br>
            <label for="editNombreMaya">Nombre en maya:</label>
            <input type="text" id="editNombreMaya" name="nombremaya" required><br>
            <label for="editNombreCientifico">Nombre científico:</label>
            <input type="text" id="editNombreCientifico" name="nombrecientifico" required><br>
            <label for="editTipo">Tipo:</label>
            <select id="editTipo" name="tipo" required>
                <option value="Helechos y afines">Helechos y afines</option>
                <option value="Gimnospermas">Gimnospermas</option>
                <option value="Angiospermas">Angiospermas</option>
            </select><br>
            <label for="editDescripcion">Descripción:</label>
            <textarea id="editDescripcion" name="descripcion" required></textarea><br>
            <label for="editCantidad">Cantidad disponibles:</label>
            <input type="number" id="editCantidad" name="cantidad" required><br>
            <button type="submit">Guardar Cambios</button>
            <button type="button" onclick="closeEditForm()">Cancelar</button>
        </form>
    </div>

    <script>
        // Función para abrir el formulario de edición
        function editPlant(id) {
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

                    // Mostrar el formulario
                    document.getElementById('editFormContainer').style.display = 'block';
                });
        }

        // Función para cerrar el formulario de edición
        function closeEditForm() {
            document.getElementById('editFormContainer').style.display = 'none';
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
    </script>
</body>
</html>
