<?php

if(!isset($_POST)){
    header("Location: crear-categoria.php");
    exit();
}

require_once __DIR__ . '/includes/conexion.php';

$nombre = isset($_POST['nombre']) ? mysqli_real_escape_string($bd, $_POST['nombre']) : false;
$descripcion = isset($_POST['descripcion']) ?  mysqli_real_escape_string($bd, $_POST['descripcion']): false;
//Array de errores
$errores = [];

if(!empty($nombre) && !is_numeric($nombre) && !preg_match("/[0-9]/", $nombre)){
    $nombre_validado = true;
}else{
    $nombre_validado = false;
    $errores['nombre'] = "El nombre no es válido";
}
if(!empty($descripcion)){
    $descripcion_validado = true;
}else{
    $descripcion_validado = false;
    $errores['descripcion'] = "No hay ninguna descripcion";
}

if(count($errores) == 0){
    $sql = "INSERT INTO categoria VALUES(null, '$nombre', '$descripcion');"; // el valor del id va ser null porque es autoincrementable
    $guardar = mysqli_query($bd, $sql);
     if($guardar){
            $_SESSION['completado'] = "Se ha creado con exito la categoria";
        }else{
            $_SESSION['errores']['general'] = "Fallo al crear";
        }
    header("Location: crear-categoria.php");
}else{
    $_SESSION['errores_categoria'] = $errores;
    header("Location: crear-categoria.php");
}


