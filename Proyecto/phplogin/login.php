<?php
include("../utilsDB/db_connection.php"); 

if(isset($_POST['submit'])){
    $username = trim($_POST['user']); 
    $password = trim($_POST['password']); 

    if(empty($username) || empty($password)){
        echo '<script>
                alert("Todos los campos son obligatorios,"); 
                window.location.href = "../html/acceder.php"; 
        </script>'; 
        exit(); 
    }

    $sql = "select * from login where username='$username' and password = '$password'"; 
    $result = mysqli_query($conn, $sql); 
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC); 
    $count = mysqli_num_rows($result); 

    if($count ==1){
        setcookie("authenticated", "true", time() + 3600, "/"); // Cookie válida por 1 hora
         // Configurar una cookie con el nombre de usuario, duración 1 día (86400 segundos)
         setcookie('user', $username, time() + 86400, '/');
        header("Location:../../info_plantas/html/dashboard.php");
    }else{
        echo '<script>
        window.location.href = "../html/acceder.php"; 
        alert("Login failed. Invalid username or password")
        </script>'; 
    }

}

?>
