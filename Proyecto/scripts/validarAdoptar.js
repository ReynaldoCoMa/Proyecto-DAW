document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById('adoptForm');
    
    form.addEventListener('submit', function(event) {
        let isValid = true;

        // Validación del nombre (sin números)
        const nombre = document.getElementById('nombre').value;
        const nombrePattern = /^[A-Za-záéíóúÁÉÍÓÚñÑ\s]+$/;  // Solo letras y espacios
        if (!nombre || !nombrePattern.test(nombre)) {
            alert("Por favor, ingresa un nombre válido (sin números).");
            isValid = false;
        }

        // Validación del correo electrónico
        const email = document.getElementById('email').value;
        const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        if (!email || !emailPattern.test(email)) {
            alert("Por favor, ingresa un correo electrónico válido.");
            isValid = false;
        }

        // Validación de la planta seleccionada
        const planta = document.getElementById('planta').value;
        if (!planta) {
            alert("Por favor, selecciona una planta.");
            isValid = false;
        }

        // Validación de la dirección (asegurarse de que esté seleccionada en el mapa)
        const direccion = document.getElementById('direccion').value;
        if (!direccion || direccion.length<10) {
            alert("Por favor, escribe una dirección más detallada.");
            isValid = false;
        }


        // Si los campos no son válidos, prevenir el envío del formulario
        if (!isValid) {
            event.preventDefault();
        }
    });
});

