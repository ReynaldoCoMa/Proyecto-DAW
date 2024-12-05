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

    <!-- Sección del formulario para agregar planta -->
    <div class="form-container">
        <div class="adoption-form">
            <h1>Agregar planta</h1>
            <p>Ingresa la información de la planta para registrarla</p>

            <form id="registForm">
                <div class="form-field">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                <div class="form-field">
                    <label for="nombremaya">Nombre en maya:</label>
                    <input type="text" id="nombremaya" name="nombremaya" required>
                </div>
                <div class="form-field">
                    <label for="nombrecientifico">Nombre Científico:</label>
                    <input type="text" id="nombrecientifico" name="nombrecientifico" required>
                </div>
                <div class="form-field">
                    <label for="tipo">Tipo:</label>
                    <select id="tipo" name="tipo">
                        <option value="Helechos y afines">Helechos y afines</option>
                        <option value="Gimnospermas">Gimnospermas</option>
                        <option value="Angiospermas">Angiospermas</option>
                    </select>
                </div>
                <div class="form-field">
                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" required></textarea>
                </div>
                <div>
                    <fieldset>
                        <legend>Estados donde está disponible:</legend>
                        <label><input type="checkbox" name="ubicacion[]" value="Yucatán"> Yucatán</label>
                        <label><input type="checkbox" name="ubicacion[]" value="Campeche"> Campeche</label>
                        <label><input type="checkbox" name="ubicacion[]" value="Quintana Roo"> Quintana Roo</label>
                    </fieldset>
                </div>
                <div class="form-field">
                    <label for="cantidad">Cantidad disponible:</label>
                    <input type="number" id="cantidad" name="cantidad" required>
                </div>
                <div class="form-field">
                    <input type="submit" value="Agregar">
                </div>
            </form>
        </div>
    </div>

    <script>
        // Script para manejar el formulario con AJAX
        document.getElementById('registForm').addEventListener('submit', function (e) {
            e.preventDefault(); // Prevenir recarga de la página

            const form = e.target;
            const formData = new FormData(form);

            fetch('../server/agregarplanta.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text()) // Recibir respuesta como texto
            .then(data => {
                if (data.includes("correctamente")) {
                    alert("Planta registrada exitosamente.");
                    form.reset(); // Limpiar formulario
                } else {
                    alert("Error: " + data); // Mostrar error devuelto por PHP
                }
            })
            .catch(error => {
                console.error('Error al enviar el formulario:', error);
                alert("Ocurrió un error al registrar la planta.");
            });
        });
    </script>
</body>
</html>
