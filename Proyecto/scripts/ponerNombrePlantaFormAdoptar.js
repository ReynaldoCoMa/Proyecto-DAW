// Función para obtener el valor de un parámetro en la URL
function getParameterByName(name) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(name);
}

// Obtener el nombre de la planta y asignarlo al campo de texto
const plantaNombre = getParameterByName('planta');
if (plantaNombre) {
    document.getElementById('planta').value = plantaNombre;
}