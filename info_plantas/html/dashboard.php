<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <title>Gestión plantas</title>
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

     <div class="content">
        <div class="welcome"><h1>¡Bienvenido de nuevo!</h1></div>
        <div>
            <button class="agregar opcion" id="btnAgregar">Agregar planta</button>
        </div>
        <div>
            <button class="editar opcion" id="btnEditar">Editar o eliminar planta</button>
        </div>
     </div>
    





     <script>
        // Asignar eventos de clic a cada botón
        document.getElementById("btnAgregar").addEventListener("click", function() {
            window.location.href = "agregar.html"; // Página para agregar planta
        });
    
        document.getElementById("btnEditar").addEventListener("click", function() {
            window.location.href = "editar.php"; // Página para editar planta
        });
    
        document.getElementById("btnEliminar").addEventListener("click", function() {
            window.location.href = "eliminar.html"; // Página para eliminar planta
        });
    </script>
</body>
</html>
