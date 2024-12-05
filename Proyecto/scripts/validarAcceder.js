function validarForm(){
    var username = document.getElementById("user").value; 
    var password = document.getElementById("password").value;

    if(username === "" || password === ""){
        alert("Todos los campos son obligatorios.");
        return false; 
    }

    if(password.length < 4){
        alert("La contraseña debe tener al menos 6 caracteres.");
        return false;
    }

    return true; 
}