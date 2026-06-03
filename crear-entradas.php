<?php require_once __DIR__ . '/includes/redireccion.php'; ?>
<?php require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/conexion.php';
//require_once __DIR__ . '/includes/navbar.php';
?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="index.php">Inicio</a>
        </li>
        <li class="breadcrumb-item">
            <a href="" class="">Crear Entrada</a>
        </li>
    </ol>
</nav>

<!-- CAJA PRINCIPAL -->
<div id="principal">
    <?php if(isset($_SESSION['completado'])): ?>
        <div class="alert alert-success" role="alert">
            <?= $_SESSION['completado'] ?>
        </div>
        <?php elseif(isset($_SESSION['errores']['general'])): ?>
            <div class="alert alert-danger" role="alert">
                <?= $_SESSION['errores']['general'] ?>
            </div>
    <?php endif; ?>
    <h1>Crear Entradas</h1>
    <p class="text-dark text-center">Añade nuevas entradas al blog para que los usuarios puedean leerlas y disfrutar de nuestro contenido</p>
    <br>
    <div class="row justify-content-lg-center"> <!-- ESTO VA CENTRAR EL CONTENIDO EN EL MEDIO -->
        <div class="col-10 col-m-6 col-lg-4 m-3">
            <form action="guardar-entrada.php" method="POST" enctype="multipart/form-data">
                <label for="titulo" class="col-form-label">Titulo</label>
                <input type="text" class="form-control" name="titulo">
            
                <?= isset($_SESSION['errores_entrada']) ? mostrarError($_SESSION['errores_entrada'], 'titulo') : '' ?>
                
                <label for="contenido" class="col-form-label">Contenido</label>
                <textarea name="contenido" id="" class="form-control"></textarea>
                <?= isset($_SESSION['errores_entrada']) ? mostrarError($_SESSION['errores_entrada'], 'contenido') : '' ?> <!-- Si existe la session errores mostramos lo que dice con la funcion mostrarErrores -->

                <label for="categoria" class="col-form-label">Categoria</label>
                <select name="categoria" id="" class="form-select">
                    <option selected disabled>Selecciona una categoria</option>
                    <?php
                    $categorias = conseguirCategorias($bd);
                    if(!empty($categorias)):
                        while($categoria = mysqli_fetch_assoc($categorias)):
                    ?>
                    <option value="<?= $categoria['categoria_id'] ?>"><?= $categoria['nombre'] ?></option>   
                    <?php
                        endwhile;
                    endif;
                    ?>
                </select>
                <?= isset($_SESSION['errores_entrada']) ? mostrarError($_SESSION['errores_entrada'], 'categoria') : '' ?>
                
                <label for="imagen" class="col-form-label">Imagen</label>
                <input type="file" class="form-control" name="imagen" accept="image/*">
            
                <?= isset($_SESSION['errores_entrada']) ? mostrarError($_SESSION['errores_entrada'], 'imagen') : '' ?>

                <input type="submit" class="btn btn-dark mt-3" value="Guardar" >

            </form>
            <?php borrarErrores(); // borra los errores despues de mostrarlos para que no se queden ahi ?> 
        </div>
    </div>
</div> 
<!-- FIN CAJA PRINCIPAL -->
 <?php require_once __DIR__ . '/includes/footer.php'; ?>