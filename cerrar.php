<?php

session_start();

if(isset($_SESSION['usuario'])) {
    // Destruir la sesión
    session_destroy();
}

// Redirigir a la página de inicio o a donde desees
header("Location: index.php");
exit(); // Asegúrate de salir después de redirigir


