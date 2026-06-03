<?php require_once __DIR__ .'/includes/conexion.php'; ?>
<?php require_once __DIR__ .'/includes/header.php'; ?>


<?php // require_once 'includes/lateral.php'; ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="">Inicio</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="">Entradas</a>
        </li>
    </ol>
</nav>

<!-- CAJA PRINCIPAL -->

<h1>Todas las entradas</h1>
    <div class="row">
        <?php
        $entradas = conseguirEntradas($bd);
        if(!empty($entradas)):
        while($entrada = mysqli_fetch_assoc($entradas)):
        ?>
        <div class="col-sm-6">
            <div class="card m-4">
                <a href="entrada.php?id=<?= $entrada['slug']?>" class="text-decoration-none"> <!-- me lleva aver el detalle de la entrada y poder hacer abm de ella -->
                    <div class="card-body">
                        <h5 class="card-tittle"><?= $entrada['titulo'] ?></h5>
                        <p class="card-text"><small class="text-dark"><?= substr($entrada['contenido'], 0,180). "..." ?></small></p>
                        <p class="card-text">
                            <small class="text-muted">                  
                        Categoria: <?= $entrada['categoria'] ?> 
                        |
                        Publicado: <?= date('d/m/Y', strtotime($entrada['fecha_registro']))?>
                        |
                        Autor: <?= $entrada['usuario'] ?>
                            </small>
                        </p>
                    </div>
                </a>
            </div>
        </div>
    
        <?php
        endwhile;
        endif;
        ?>
    </div>

    <?php require_once 'includes/footer.php';?>

