<?php
// Conexion
$servidor = 'localhost';
$usuario = 'root';
$password = '';
$basedatos = 'blog';
$puerto = '3306';
$bd = mysqli_connect($servidor, $usuario, $password, $basedatos, $puerto);

mysqli_set_charset($bd, "utf8");

// Iniciar la sesion
if(!isset($_SESSION)){
    session_start();
}
?>
