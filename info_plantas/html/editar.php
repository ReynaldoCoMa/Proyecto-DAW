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
<body class="no-disable">
    <nav>
        <div class="navbar">
            <div class="divlogo">
                <img class="logo" src="../../Proyecto/images/logoviverouady.svg">
            </div>
            <div>
                <button class="botonsalir">Cerrar sesión</button>
            </div>
        </div>
     </nav>
    <h1>Gestión de Plantas</h1>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "database1";

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
    <h2 id="editarverde">Editar Planta</h2>
        <div class="form-container">
            
            <form id="editForm" method="post" action="actualizarplanta.php" class="adoption-form">
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
                    <label for="editCantidad">Cantidad disponible:</label>
                    <input type="number" id="editCantidad" name="cantidad" required>
                </div>
                <input type="hidden" name="id_planta" id="editIdPlanta">
                <div class="form-field">
                    <button type="submit" id="decision">Guardar Cambios</button>
                    <button type="button" onclick="closeEditForm()" id="decision">Cancelar</button>
                </div>
                
            </form>
        </div>
    </div>

    <script>
// Función para cargar los datos en el formulario y editar
function editPlant(id) {
    document.getElementById("editFormContainer").classList.add("visible");

    fetch(`getPlanta.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('editIdPlanta').value = data.id_planta;
            document.getElementById('editNombre').value = data.nombrecomun;
            document.getElementById('editNombreMaya').value = data.nombremaya;
            document.getElementById('editNombreCientifico').value = data.nombrecientifico;
            document.getElementById('editTipo').value = data.tipo;
            document.getElementById('editDescripcion').value = data.descripcion;
            document.getElementById('editCantidad').value = data.cantidad;
        })
        .catch(err => alert("Error al cargar los datos: " + err.message));
}

document.getElementById('editForm').addEventListener('submit', function (event) {
    event.preventDefault();

    const formData = new FormData(this);

    fetch('actualizarplanta.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert(data.message);
            closeEditForm(); // Oculta el formulario
            location.reload(); // Opcional: refresca la lista de plantas
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Ocurrió un error inesperado.');
    });
});

function closeEditForm() {
    document.getElementById("editFormContainer").classList.remove("visible");
}


// Función para eliminar una planta
function deletePlant(id) {
            if (confirm("ATENCIÓN: Se eliminarán todos los datos de esta planta. Considera que algunas personas podrían haber generado un certificado de adopción de esta planta. ¿Deseas continuar con la eliminación? ")) {
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
