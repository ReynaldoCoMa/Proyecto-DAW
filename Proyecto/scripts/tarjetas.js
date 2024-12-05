// Función para manejar la acción de crear o eliminar tarjeta
function handleCardAction(idPlanta, action) {
    const formData = new FormData();
    formData.append('id_planta', idPlanta);
    formData.append('action', action);

    fetch('../html/adminTarjetas.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();  // Recargar la página después de la acción
        } else {
            alert('Error al procesar la acción.');
        }
    })
    .catch(() => alert('Error en la petición.'));
}