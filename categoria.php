<?php require_once __DIR__ . '/includes/conexion.php'; ?>
<?php require_once __DIR__ . '/includes/helpers.php'; ?>
<?php
    $categoria_actual = conseguirCategoria($bd, $_GET['id']); //desde la cabecera me traigo el id de la categoria y con la función consigo la categoria

     if(empty($categoria_actual)){ // si no existe lo pateo por si pone cualquier id en la url
        header('Location: index.php');

     }
?>
<?php require_once 'includes/header.php'; ?>
<?php //require_once 'includes/lateral.php'; ?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
    <li class="breadcrumb-item"><a href="#">Categorias</a></li>
    <li class="breadcrumb-item"><a href="#"><?= $categoria_actual['nombre'] ?></a></li>
    
  </ol>
</nav>
      
<!-- CAJA PRINCIPAL -->
<h1>Entradas de <?= $categoria_actual['nombre'] ?></h1>
<div class="row">
    <?php
        $entradas = conseguirEntradas($bd, null, $_GET['id'], null);

        if(!empty($entradas) && mysqli_num_rows($entradas) > 0):
            while($entrada = mysqli_fetch_assoc($entradas)):
    ?>
    <div class="col-sm-6">
        <div class="card m-4">
            <img src="" alt="" class="card-img-top">
            <a href="entrada.php?slug=<?= $entrada['slug'] ?>" class="text-decoration-none">
                <div class="card-body">
                    <h5 class="card-title"><?= $entrada['titulo'] ?></h5>
                    <p class="card-text"><small class="text-dark"><?= substr($entrada['contenido'], 0, 180). "..." ?></small></p>
                    <p class="card-text"><small class="text-dark">
                        Categoria: <?= $entrada['categoria'] ?> 
                        |
                        Publicado: <?= date('d/m/Y', strtotime($entrada['fecha_registro']))?>
                        |
                        Autor: <?= $entrada['usuario'] ?>
                    </small></p>
                </div>
            </a>
        </div>
    </div>
    <?php
            endwhile;
        else:
    ?>
        <div class="alert alert-dark" role="alert">No hay entradas en esta categoria</div>
    <?php endif; ?>

</div>

<?php require_once 'includes/footer.php'; ?>