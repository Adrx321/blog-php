<?php

function conseguirCategorias($conexion){ // conexion es db que la agarro gracias al inicio
    $sql = "SELECT * FROM categoria ORDER BY categoria_id ASC";// lo ordena de forma ascendente(de menor a mayor)
    $categorias = mysqli_query($conexion, $sql);
    
    $resultado = array(); // creo un array
    if($categorias && mysqli_num_rows($categorias) >= 1){ // si categorias existe y tiene al menos 1 fila
        $resultado = $categorias; // resultado es igual a categorias
    }
    return $resultado;
}
function conseguirCategoria($conexion, $id){ //conecto y traigo el id de la categoria que quiero mostrar
    $id = intval($id);
    $sql = "SELECT * FROM categoria WHERE categoria_id = $id;";
    $categoria = mysqli_query($conexion, $sql);
    $resultado = [];
    if($categoria && mysqli_num_rows($categoria) >= 1){ //si hay algo
        $resultado = mysqli_fetch_assoc($categoria); //la pongo como array asociativo
    }
    return $resultado;
}

function mostrarError($errores, $campo){ //le paso el array errores y un campo
    $alerta = "";
    if(isset($errores[$campo]) && !empty($campo)){ //si existe el array con ese campo y el campo no esta vacio
        $alerta = "<div class= 'alert alert-danger'>".$errores[$campo]."</div>";
    }
    return $alerta;
}
function borrarErrores(){
    if(isset($_SESSION['errores'])){
        $_SESSION['errores'] = null;
        $borrado = true;
        // Opcional: unset($_SESSION['errores']);
    }

    if(isset($_SESSION['errores_entrada'])){
        $_SESSION['errores_entrada'] = null;
        $borrado = true;
    }
    
    if(isset($_SESSION['completado'])){
        $_SESSION['completado'] = null;
        $borrado = true;
    }

    if(isset($_SESSION['errores_categoria'])){
        $_SESSION['errores_categoria'] = null;
        $borrado = true;
    }

    if(isset($_SESSION['errores_comentario'])){
        $_SESSION['errores_comentario'] = null;
    }
}

function conseguirEntradas($conexion, $limit = null,$categoria = null, $busqueda = null){ // la funcion es de un parametro opcional, si no se le pasa nada, limit es null
    $sql = "SELECT e.*, c.nombre AS 'categoria', nombre_usuario as usuario FROM entrada e ".
    "JOIN categoria c ON e.categoria_id = c.categoria_id JOIN usuario u ON e.usuario_id = u.usuario_id ";

    $where = [];

    if(!empty($categoria)){
        $where[] = "e.categoria_id = $categoria ";
    }

    if(!empty($busqueda)){
        $where[] = "e.titulo LIKE '%$busqueda%'";
    }

    if(!empty($where)){
        $sql .= " WHERE ". implode(" AND ", $where); 
    }
   

    if($limit){ // si limit no es null
        $sql .= "LIMIT 4;"; // limita a 4 resultados
    }
    $entradas = mysqli_query($conexion, $sql);
    
    $resultado = array(); // creo un array
    if($entradas && mysqli_num_rows($entradas) >= 1){ // si entradas existe y tiene al menos 1 fila
        $resultado = $entradas; // resultado es igual a entradas
    }
    return $resultado; //retorna el resultado, que es un array con las entradas

}  

function conseguirEntrada($conexion, $id){
    $id = intval($id);
    $sql = "SELECT e.*, c.nombre AS 'categoria', CONCAT(u.nombre, ' ', u.apellidos) AS 'usuario' ".
            "FROM entrada e ".
            "JOIN categoria c ON e.categoria_id = c.categoria_id ".
            "JOIN usuario u ON e.usuario_id = u.usuario_id ".
            "WHERE e.entrada_id = $id";
    $entrada = mysqli_query($conexion, $sql);
    $resultado = [];
    if($entrada && mysqli_num_rows($entrada) >= 1){ //si hay filas
        $resultado = mysqli_fetch_assoc($entrada); // la pongo como array asociativo
    }
    return $resultado;
}

function conseguirComentarios($conexion, $entrada_id){
    $entrada_id = intval($entrada_id);
    $sql = "
        SELECT c.*,
        u.nombre_usuario
        FROM comentario c
        JOIN usuario u
        ON c.usuario_id = u.usuario_id
        WHERE c.entrada_id = $entrada_id
        ORDER BY c.comentario_id DESC
    ";

    return mysqli_query($conexion, $sql);
}

function conseguirComentario($conexion, $id){
    $id = intval($id);
    $sql = "SELECT * FROM comentario WHERE comentario_id = $id";
    $comentario = mysqli_query($conexion, $sql);
    $resultado = [];
    if($comentario && mysqli_num_rows($comentario) >= 1){ //si hay filas
        $resultado = mysqli_fetch_assoc($comentario); // la pongo como array asociativo
    }
    return $resultado;

}

function conseguirEntradaSlug($conexion, $slug){
    $slug = mysqli_real_escape_string($conexion, $slug);

    $sql = "SELECT e.*, c.nombre AS categoria,
    u.nombre_usuario AS usuario
    FROM entrada e JOIN categoria c
    ON e.categoria_id = c.categoria_id
    JOIN usuario u ON e.usuario_id = u.usuario_id
    WHERE e.slug = '$slug'";

    $entrada = mysqli_query($conexion, $sql);

    if($entrada && mysqli_num_rows($entrada) >= 1){
        return mysqli_fetch_assoc($entrada);
    }

    return [];
}

function esAdmin(){

    if(
        isset($_SESSION['usuario']) &&
        $_SESSION['usuario']['rol'] == 'admin'
    ){
        return true;
    }

    return false;
}