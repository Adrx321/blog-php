<?php
require_once __DIR__ . '/includes/conexion.php';
require_once __DIR__ . '/includes/helpers.php';

$slug = conseguirEntradaSlug($bd, $_GET['slug']);
if(isset($_SESSION['usuario']) && isset($_GET['id'])){ /* si esque existen ambos se va recoger ambos parametros */
    $comentario_id = $_GET['id'];
    $usuario_id = $_SESSION['usuario']['usuario_id'];
    if(esAdmin()){
        $sql = "DELETE from comentario WHERE comentario_id = $comentario_id;";
    }else{
        $sql = "DELETE FROM comentario WHERE usuario_id = $usuario_id AND comentario_id = $comentario_id;";
    }
    
    $borrar = mysqli_query($bd, $sql);

}
header("Location: entrada.php?slug=".$_GET['slug']);
exit();