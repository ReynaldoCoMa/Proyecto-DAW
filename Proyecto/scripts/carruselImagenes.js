let currentIndex = 0; // Índice de la imagen actual

function showImage(index) {
    const images = document.querySelectorAll('#image-slider img'); // Selecciona todas las imágenes del slider
    if (index >= images.length) currentIndex = 0; // Reinicia al inicio si sobrepasa el último índice
    else if (index < 0) currentIndex = images.length - 1; // Vuelve al último índice si es menor a 0
    else currentIndex = index;

    // Remueve la clase 'active' de todas las imágenes
    images.forEach(image => image.classList.remove('active'));
    // Añade la clase 'active' a la imagen actual
    images[currentIndex].classList.add('active');
}

function nextImage() {
    showImage(currentIndex + 1);
}

function prevImage() {
    showImage(currentIndex - 1);
}
