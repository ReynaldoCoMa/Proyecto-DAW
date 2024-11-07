document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById('inyectarPlantaAdopcion');
    
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        const nombre = document.getElementById("nombre").value;
        addPlant(nombre);
        console.log("Se hizo el proceso para insertar");
    });
});

function addPlant(nombre){
    //obteniendo el contenedor donde se agregará el div 
    const contenedor = document.querySelector(".adoption-container");
    
    if(contenedor){
        const cadena = `
                <div class="adoption-card">
                    <img src="../images/prueba.jpeg" alt="${nombre}">
                    <h2>${nombre}</h2>
                    <a href="formularioAdopcion.html?planta=${nombre}"><strong>Adoptar</strong></a>
                </div>
                `;
        contenedor.innerHTML += cadena; //añadiendo el div al contenedor
        alert("Se ha añadido la planta " + nombre + " con éxito");
    }
    else{
        console.log("Contenedor 'adoption-container' no encontrado.");
    }
    
    
}
