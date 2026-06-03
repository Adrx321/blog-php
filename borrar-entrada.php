<?php
require_once __DIR__ . '/includes/conexion.php';

if(isset($_SESSION['usuario']) && isset($_GET['slug'])){ /* si esque existen ambos se va recoger ambos parametros */
    $slug = $_GET['slug'];
    $usuario_id = $_SESSION['usuario']['usuario_id'];

    if(esAdmin()){
        $sql = "DELETE FROM entrada WHERE slug = $slug";
        $borrar = mysqli_query($bd, $sql);
    if($borrar){
        $_SESSION['completado'] = "Se borro exitosamente";
    }
    }else{
    $sql = "DELETE FROM entrada WHERE usuario_id = $usuario_id AND slug = '$slug'";
    $borrar = mysqli_query($bd, $sql);
    if($borrar){
        $_SESSION['completado'] = "Se borro exitosamente";
    } 
    }

}
header("Location: index.php");