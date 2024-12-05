<?php
// Eliminar cookies configuradas
setcookie("authenticated", "", time() -  86400, "/"); // Invalida la cookie
setcookie("username", "", time() - 86400, "/");      // Invalida la cookie opcional

// Redirigir al login
header("Location: http://localhost/ProyectoWeb/Proyecto-DAW/Proyecto/html/acceder.php");
exit();
?>
