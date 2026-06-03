<?php 
if(!isset($_POST)){
    header("Location: mis-datos.php");
    exit();
}

require_once __DIR__ . '/includes/conexion.php';

//RECOGER LOS VALORES DEL FORMULARIO DE ACTUALIZACION
$nombre = isset($_POST['nombre']) ? mysqli_real_escape_string($bd, $_POST['nombre']) : false;
$apellidos = isset($_POST['apellidos']) ? mysqli_real_escape_string($bd, $_POST['apellidos']) : false;
$username = isset($_POST['username']) ? mysqli_real_escape_string($bd, $_POST['username']) : false;
$email = isset($_POST['email']) ? mysqli_real_escape_string($bd, trim($_POST['email'])) : false;
$bio = isset($_POST['bio']) ? mysqli_real_escape_string($bd, $_POST['bio']) : false;
$avatarImagen = NULL;

$errores = array();

//Validar el nombre
if(!empty($nombre) && !is_numeric($nombre) && !preg_match("/[0-9]/", $nombre)){
    $nombre_validado = true;
}else{
    $nombre_validado = false;
    $errores['nombre'] = "El nombre no es valido";
}

//Validar el apellido
if(!empty($apellidos) && !is_numeric($apellidos) && !preg_match("/[0-9]/", $apellidos)){
    $apellidos_validado = true;
}else{
    $apellidos_validado = false;
    $errores['apellidos'] = "Los apellidos no son válidos";
}
if(!empty($username) && !preg_match("/[0-9]/", $username)){
    $username_validado = true;
}else{
    $username_validado = false;
    $errores['username'] = "El nombre de usuario no es valido";
}

if(!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)){
    $email_validado = true;
}else{
    $email_validado = false;
    $errores['email'] = "El email no es válido";
}

if(isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0){

    $avatarImagen = time() . "-" . $_FILES['avatar']['name'];

    move_uploaded_file(
        $_FILES['avatar']['tmp_name'],
        "uploads/avatars/" . $avatarImagen
    );
}

if(count($errores) == 0){ //cuenta que no haya errores y entra a actualizar
    $usuario = $_SESSION['usuario']; // el usuario logeado
    $guardar_usuario = true;

    //Comprobar si el email ya existe en la base de datos
    $sql = "SELECT usuario_id, email FROM usuario WHERE email = '$email'";
    $isset_email = mysqli_query($bd, $sql);
    $isset_user = mysqli_fetch_assoc($isset_email);

    if($isset_user['usuario_id'] == $usuario['usuario_id'] || empty($isset_user)){
        //Actualizar el usuario
        if($avatarImagen != NULL){
        $sql = "UPDATE usuario SET nombre = '$nombre',
        apellidos = '$apellidos', 
        email = '$email',
        nombre_usuario = '$username',
        avatar = '$avatarImagen',
        bio = '$bio',
        fecha_actualizacion = NOW()
        WHERE usuario_id =
        {$usuario['usuario_id']}";
        }
        else{
        $sql = "UPDATE usuario SET
        nombre = '$nombre',
        apellidos = '$apellidos',
        email = '$email',
        nombre_usuario = '$username',
        bio = '$bio',
        fecha_actualizacion = NOW()
        WHERE usuario_id = {$usuario['usuario_id']}";
        }
 

        $guardar = mysqli_query($bd, $sql);
         
        if($guardar){
            $_SESSION['usuario']['nombre'] = $nombre;
            $_SESSION['usuario']['apellidos'] = $apellidos;
            $_SESSION['usuario']['nombre_usuario'] = $username;
            if($avatarImagen != NULL){
                $_SESSION['usuario']['avatar'] = $avatarImagen;
            }
            $_SESSION['usuario']['email'] = $email;
            $_SESSION['usuario']['bio'] = $bio;
            $_SESSION['completado'] = "Tus datos se han actualizado con éxito";
        }else{
            $_SESSION['errores']['general'] = "Fallo al actualizar tus datos!";
        }
    }else{
        $_SESSION['errores']['general'] = "El usuario ya existe!";
    }

}else{
    $_SESSION['errores'] = $errores;
}

header("Location: mis-datos.php");

