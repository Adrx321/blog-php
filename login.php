<?php

if(isset($_POST)){


    require_once __DIR__ . '/includes/conexion.php';


    //Borrar error antiguo
    if(isset($_SESSION['error_login'])){
    //session_unset() -> Libera todas las variables y no espera argumento
    //unset() -> Elimina una variable especifica, en este caso la variable de sesion error_login
    unset($_SESSION['error_login']); //elemina session para limpiar
    }

    //Recoger datos del formulario
    $login = trim($_POST['login']); // trim para que no guarde espacios
    $password = $_POST['password'];

    // Consulta para comprobar las credenciales del usuario
    $sql = "SELECT * FROM usuario WHERE email = '$login' OR nombre_usuario = '$login'";
    $enter = mysqli_query($bd, $sql);

    if($enter && mysqli_num_rows($enter) == 1){ // si login existe y tiene una fila
        $usuario = mysqli_fetch_assoc($enter); // convierte el resultado de la consulta en un array asociativo

        // Verificar la contraseña
        if(password_verify($password, $usuario['contraseña'])){ // password_verify es una funcion que se encarga de verificar si una contraseña coincide con un hash(cifrado), en este caso se verifica si la contraseña ingresada por el usuario coincide con el hash almacenado en la base de datos, si es asi se guarda en la variable de sesion usuario el array asociativo con los datos del usuario, sino es false y se guarda un mensaje de error en la variable de sesion error_login
            $_SESSION['usuario'] = $usuario; // guardamos en la variable de sesion usuario el array asociativo con los datos del usuario
            $_SESSION['completado'] = "Se ha ingresado con exito";
        } else {
            $_SESSION['errores']['login'] = "usuario o contraseña incorrectos"; // guardamos un mensaje de error en la variable de sesion error_login
        }
    } else {
        $_SESSION['errorres']['login'] = "usuario o contraseña incorrectos"; // guardamos un mensaje de error en la variable de sesion error_login
    }
}

//Redirigir al index.php
header('Location: index.php');


?>