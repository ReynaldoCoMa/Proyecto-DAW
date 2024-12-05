// Función para renderizar las plantas en tarjetas
function renderPlantas(plantas) {
    const container = document.getElementById('adoption-cont');
    container.innerHTML = '';  // Limpiar el contenedor antes de agregar las plantas

    if (plantas.length === 0) {
        container.innerHTML = '<p>No hay plantas disponibles para adopción.</p>';
        return;
    }

    plantas.forEach(planta => {
        const card = document.createElement('div');
        card.classList.add('adoption-card');
        card.innerHTML = `
            <img src="../images/prueba.jpeg" alt="${planta.nombrecomun}">
            <h2>${planta.nombrecomun}</h2>
            <p>Cantidad disponible: ${planta.cantidad}</p>
            <a href="formularioAdopcion.php?planta=${planta.id_planta}"><strong>Adoptar</strong></a>
        `;
        container.appendChild(card);
    });
}

// Asegúrate de que el DOM esté completamente cargado antes de ejecutar el código
document.addEventListener('DOMContentLoaded', function () {
    // Verificar si la variable plantas está definida
    if (typeof plantas !== 'undefined') {
        // Llamar a la función para renderizar las plantas
        renderPlantas(plantas);
    } else {
        console.error('No se pudo cargar la lista de plantas.');
    }
});
