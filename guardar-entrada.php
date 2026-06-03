<?php


if(empty($_POST)){
    header("Location: crear-entradas.php");
    exit();
} 

    require_once __DIR__ . '/includes/conexion.php';

    $titulo = isset($_POST['titulo']) ? mysqli_real_escape_string($bd, $_POST['titulo']) : false; /* esta funcion quita los caracteres especiales como las comillas */
    $contenido = isset($_POST['contenido']) ? mysqli_real_escape_string($bd, $_POST['contenido']) : false;
    $categoria = isset($_POST['categoria']) ? (int)$_POST['categoria'] : false; /* casteo a entero para evitar inyeccion sql */
    $usuario = $_SESSION['usuario']['usuario_id'];
    $slug = strtolower($titulo);
    $slug = str_replace(' ', '-', $slug);
    $nombreImagen = null;

    //Validacion
    $errores = [];

    if(empty($titulo)){
        $errores['titulo'] = "El titulo no es valido";
    }

    if(empty($contenido)){
        $errores['contenido'] = "El contenido no es valido";
    }

    if(empty($categoria) || !is_numeric($categoria)){
        $errores['categoria'] = "La categoria no es válida";
    }


    if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0){

        $nombreImagen = time() . "-" . $_FILES['imagen']['name'];

        move_uploaded_file(
            $_FILES['imagen']['tmp_name'],
            "uploads/entradas/" . $nombreImagen
        );
    }

    if(count($errores) == 0){
        if(isset($_GET['editar'])){
            $entrada_id = $_GET['editar'];
            $usuario_id = $_SESSION['usuario']['usuario_id']; // guardariamos el usuario id en una variable para usarlo en la consulta sql
            $sql = "UPDATE entrada SET titulo = '$titulo',slug = '$slug', contenido = '$contenido', categoria_id = $categoria, ".
            "fecha_actualizacion = NOW() WHERE entrada_id = $entrada_id AND usuario_id = $usuario_id"; 
            $guardar = mysqli_query($bd, $sql);
            $sqlSlug = "SELECT slug FROM entrada WHERE entrada_id = $entrada_id";
            $resultado = mysqli_query($bd, $sqlSlug);
            $entrada = mysqli_fetch_assoc($resultado);

            if($guardar){
                $_SESSION['completado'] = "Se ha editado con éxito la entrada";
            }else{
                $_SESSION['errores']['general'] = "Error al editar";
            }

            header("Location: editar-entrada.php?slug=".$entrada['slug']);
            exit();
        }else{
        $sql = "INSERT INTO entrada (entrada_id, usuario_id, categoria_id, titulo, slug, imagen, contenido, fecha_registro, fecha_actualizacion) VALUES (null, $usuario, $categoria, '$titulo','$slug','$nombreImagen', '$contenido', NOW(), NOW());";
        }
        $guardar = mysqli_query($bd, $sql);
        
        if($guardar && isset($_GET['slug'])){
            $_SESSION['completado'] = "Se ha editado con exito la entrada";
            header("Location: editar-entrada?slug=". $_GET['slug']);
        }else{
            $_SESSION['errores']['general'] = "Fallo al editar la entrada!";
        }
        if(empty($guardar)){
            $_SESSION['errores']['general'] = "Fallo al crear la entrada!";
        }
    }else{
    $_SESSION['errores_entrada'] = $errores; // guardamos los errores en la session para mostrarlos despues
    if(isset($_GET['editar'])){
        header("Location: editar-entrada.php?id=" . $_GET['editar']);
    } else { 
        header("Location: crear-entradas.php");
    }
    }