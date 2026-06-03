<?php
require_once __DIR__ . '/includes/conexion.php';

if(isset($_SESSION['usuario']) && isset($_GET['id'])){ /* si esque existen ambos se va recoger ambos parametros */
    $entrada_id = $_GET['id'];
    $usuario_id = $_SESSION['usuario']['usuario_id'];

    $sql = "DELETE FROM entrada WHERE usuario_id = $usuario_id AND entrada_id = $entrada_id;";
    $borrar = mysqli_query($bd, $sql);

}
header("Location: index.php");