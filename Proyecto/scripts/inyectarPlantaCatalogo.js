document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById('inyectarPlanta');
    
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        const nombre = document.getElementById("nombre").value;
        addPlant(nombre);
        console.log("Se intentó insertar")
    });
});

function addPlant(nombre){
    //obteniendo el contenedor donde se agregará el div 
    const contenedor = document.querySelector(".plant-list");
    
    if(contenedor){
        const cadena = `<div class="plant-card">
                    <img src="../images/prueba.jpeg" alt="${nombre}">
                    <h3>${nombre}</h3>
                    <p>Descripción breve de la planta ${'"' + nombre +'"' }. Esta planta es ideal para interiores y se adapta bien a la luz moderada.</p>
                    <a href="descripcionPlanta.html">Más información</a>
                </div>
                `;
        contenedor.innerHTML += cadena; //añadiendo el div al contenedor
        alert("Se ha añadido la planta " + nombre + "con éxito");
    }
    else{
        console.log("Contenedor 'plant-list' no encontrado.");
    }
    
    
}
