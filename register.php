<?php
if(isset($_POST)){

    //conexion a la base de datos
    require_once __DIR__ . '/includes/conexion.php';
    //iniciar sesion
    if(!isset($_SESSION)){
        session_start();
    }
    if(isset($_SESSION['errores'])){
        unset($_SESSION['errores']);
    }

    //Recoger los valores del formulario de registro
    //una forma de abreviar codigo


    $nombre = isset($_POST['nombre']) ? mysqli_real_escape_string($bd, $_POST['nombre']) : false; //si existe nombre la funcion quita los caracteres especiales y lo guarda en texto, sino es false(es como un if ternario)
    $apellidos = isset($_POST['apellidos']) ? mysqli_real_escape_string($bd, $_POST['apellidos']) : false;
    $username = isset($_POST['username']) ? mysqli_real_escape_string($bd, $_POST['username']) : false;
    // mysqli_real_escape_string es una funcion que se encarga de escapar los caracteres especiales de una cadena para evitar inyecciones SQL, y $bd es la conexion a la base de datos que se hizo en conexion.php
    $email = isset($_POST['email']) ? mysqli_real_escape_string($bd, $_POST['email']) : false;
    //isset es una funcion que se encarga de verificar si una variable esta definida y no es null, en este caso se verifica si el campo email del formulario de registro esta definido y no es null, si es asi se guarda en la variable $email, sino es false
    $password = isset($_POST['password']) ? mysqli_real_escape_string($bd, $_POST['password']) : false;
    // $_POST es una variable superglobal que se encarga de recoger los datos enviados por el formulario de registro, en este caso se recoge el campo password, si esta definido y no es null se guarda en la variable $password, sino es false

    //array de errores
    $errores = []; //creo un array vacio para guardar los errores que puedan surgir en el proceso de registro

    //validar los datos antes de guardarlos en la base de datos
    //validar campo nombre
if(!empty($nombre) && preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/u", $nombre)){
    $nombre_validado = true;
} else {
    $nombre_validado = false;
    $errores['nombre'] = "El nombre no es válido";
}
    //validar apellidos
    if(!empty($apellidos) && !is_numeric($apellidos) && !preg_match("/[0-9]/", $apellidos)){ // preg_match es una funcion que se encarga de verificar si una cadena contiene un patron especifico, en este caso se verifica si el campo nombre no esta vacio, no es numerico y no contiene numeros, si se cumple esta condicion se guarda en la variable $nombre_validado como true, sino es false y se guarda un mensaje de error en el array de errores
        $apellidos_validado = true;
    } else {
        $apellidos_validado = false;
        $errores['apellidos'] = "El apellidos no es válido";
    }
    if(!empty($username) && !preg_match("/[0-9]/", $username)){ // preg_match es una funcion que se encarga de verificar si una cadena contiene un patron especifico, en este caso se verifica si el campo nombre no esta vacio, no es numerico y no contiene numeros, si se cumple esta condicion se guarda en la variable $nombre_validado como true, sino es false y se guarda un mensaje de error en el array de errores
        $username_validado = true;
    } else {
        $username_validado = false;
        $errores['username'] = "El nombre de usuario no es válido";
    }

    //validar email
    if(!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)){ // preg_match es una funcion que se encarga de verificar si una cadena contiene un patron especifico, en este caso se verifica si el campo nombre no esta vacio, no es numerico y no contiene numeros, si se cumple esta condicion se guarda en la variable $nombre_validado como true, sino es false y se guarda un mensaje de error en el array de errores
        $email_validado = true;
    } else {
        $email_validado = false;
        $errores['email'] = "El email no es válido";
    }
    

    //validar password
    if(!empty($password)){ // preg_match es una funcion que se encarga de verificar si una cadena contiene un patron especifico, en este caso se verifica si el campo nombre no esta vacio, no es numerico y no contiene numeros, si se cumple esta condicion se guarda en la variable $nombre_validado como true, sino es false y se guarda un mensaje de error en el array de errores
        $password_validado = true;
    } else {
        $password_validado = false;
        $errores['password'] = "La contraseña esta vacia";
    }

    //$guardar_usuario = false;

    if(count($errores) == 0){
        //  $guardar_usuario = true;

        //cifrar la contraseña(encriptar(B_CRYPT))
        $password_segura = password_hash($password, PASSWORD_BCRYPT, ['cost'=>4]); // password_hash creara un codigo de caracteres especiales para la contraseña(la cifra la contraseña 4 veces antes de guardar en la variable )
        $sql = "INSERT INTO usuario (usuario_id, nombre, apellidos, nombre_usuario, email, contraseña, fecha_registro) ".
        "VALUES(null, '$nombre', '$apellidos','$username', '$email', '$password_segura', NOW());";
        $guardar = mysqli_query($bd, $sql); //el id null,curdate es una funcion de mysql que te da la fecha las comillas es porque sql acepta los strings con comillas

        if($guardar){
            $_SESSION['completado'] = 'El registro se ha completado con éxito';
    // Creamos la sesion
        }else{
            $_SESSION['errores']['general'] = "Fallo al guardar el usuario";
        }
    }else{
        $_SESSION['errores'] = $errores; 
    }

}


header('Location: index.php');

?>