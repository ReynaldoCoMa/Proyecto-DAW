document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById('registForm');
    
    form.addEventListener('submit', function(event) {
        let isValid = true;

        
        //validar nombre ¡Faltaría revisar si ya existe en la base de datos!
        const nombre = document.getElementById('nombre').value;
        const nombrePattern = /^[A-Za-záéíóúÁÉÍÓÚñÑ\s]+\d*$/;  // Solo letras, espacios y 0 o más números al final
        if( !nombre || !nombrePattern.test(nombre)){
            alert("Por favor, ingresa un nombre válido (sin caráctres especiales y números sólo al final.")
            document.getElementById('nombre').focus();
            isValid = false;
        }
        /*
        else if( condicion ){
            alert("Ya existe una planta con ese nombre")
        }
        */

        //validar categoria
        const categoria = document.getElementById('categoria').value;
        const categoriaPattern = /^[A-Za-záéíóúÁÉÍÓÚñÑ\s]+$/; //solo letras y espacios
        if(!categoria || !categoriaPattern.test(categoria)){
            alert("Por favor, ingresa una catería correcta (solo letras).");
            document.getElementById('categoria').focus();
            isValid = false;
        }

        //validar cantidad disponibles (0 o más)
        const cantidad = parseInt(document.getElementById("cantidad").value,10);
        alert(cantidad);
        if(isNaN(cantidad) || cantidad<0){
            alert("Por favor, ingrese una cantidad válida.")
            document.getElementById("cantidad").focus();
            isValid = false;
        }

        //validar descripción (mínimo de palabras = 10)
        const descripcion = document.getElementById("descripcion").value.trim();
        const palabras = descripcion.split(/\s+/) //dividir por cualquier cantidad de espacios en blanco, saltos de línea...
        if(palabras.length < 10){
            alert("Por favor, ingrese una descripción más grande (10 o más palabras).")
            document.getElementById("descripcion").focus();
            isValid = false;
        }


        // Si los campos no son válidos, prevenir el envío del formulario
        if (!isValid) {
            event.preventDefault();
        }
        else{

            //logica para registrar en la base de datos.
            alert("¡Se ha registrado con éxito!");

        }
    });
});


