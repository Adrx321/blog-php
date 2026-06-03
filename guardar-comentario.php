<?php

if(empty($_POST)){
    header("Location: entrada.php?id=".$_GET['id']);
    exit();
} 

require_once __DIR__ . '/includes/conexion.php';

    $entrada_id = isset($_POST['entrada_id']) ? mysqli_real_escape_string($bd, $_POST['entrada_id']) : false; /* esta funcion quita los caracteres especiales como las comillas */
    $contenido = isset($_POST['contenido']) ? mysqli_real_escape_string($bd, $_POST['contenido']) : false;
    $usuario_id = $_SESSION['usuario']['usuario_id'];
    //Validacion
    $errores = [];

    if(empty($contenido)){
        $errores['contenido'] = "El contenido no es valido";
    }

    if(count($errores) == 0){
         if(isset($_GET['editar'])){
            $comentario_id = (int)$_GET['editar'];

            $sql = "UPDATE comentario SET contenido = '$contenido',
                    fecha_actualizacion = NOW() WHERE comentario_id = $comentario_id
                    AND usuario_id = $usuario_id;";
    }else{
        $sql = "INSERT INTO comentario VALUES (null, $entrada_id, $usuario_id, '$contenido', NOW(), NOW());";
    }
    $guardar = mysqli_query($bd, $sql);
    if(!$guardar){
    die(mysqli_error($bd));
}
    $sqlSlug = "SELECT slug FROM entrada WHERE entrada_id = $entrada_id";
    $resSlug = mysqli_query($bd, $sqlSlug);
    $datosEntrada = mysqli_fetch_assoc($resSlug);
    header("Location: entrada.php?slug=".$datosEntrada['slug']);
    }else{
    $_SESSION['errores_comentario'] = $errores;
    $sqlSlug = "SELECT slug FROM entrada WHERE entrada_id = $entrada_id";
    $resSlug = mysqli_query($bd, $sqlSlug);
    $datosEntrada = mysqli_fetch_assoc($resSlug);
    header("Location: entrada.php?slug=".$datosEntrada['slug']);
    exit();
    }