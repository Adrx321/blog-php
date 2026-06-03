<?php
if(!isset($_POST['busqueda'])){
    header("Location: index.php");
    exit();
}
?>
<?php require_once __DIR__ . '/includes/conexion.php'; ?>
<?php require_once __DIR__ . '/includes/header.php'; ?>
<? // require_once 'includes/nav.php' ?>
<nav arial-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
        <li class="breadcrumb-item"><a href="#">Busqueda</a></li>
    </ol>
</nav>

<h1>Busqueda: <?= htmlspecialchars($_POST['busqueda']) ?></h1>
<!-- CAJA PRINCIPAL -->
<div class="row">

    <?php
    $entradas = conseguirEntradas($bd, null, null, $_POST['busqueda']);

    if(!empty($entradas) && mysqli_num_rows($entradas) >= 1): //si es diferente a vacio y hay mas de una
        while($entrada = mysqli_fetch_assoc($entradas)): // lo hacemos array asociativo
            ?>
    <div class="col-sm-6">
        <div class="card m-4">
        <?php if(!empty($entrada['imagen'])): ?>
        <img
        src="uploads/entradas/<?= $entrada['imagen'] ?>"
        alt="<?= $entrada['titulo'] ?>"
        style="height: 250px; object-fit: cover;"
        >
        <?php endif; ?>
            <a href="entrada.php?slug=<?= $entrada['slug'] ?>" class="text-decoration-none"><?php // me lleva a ver el detalle de la entrada y poder hacer abm de ella ?>
            <div class="card-body">
                <h5 class="card-tittle"><?= $entrada['titulo'] ?></h5>
                <p class="card-text"><small class="text-dark"><?= substr($entrada['contenido'], 0, 180). "..." ?><?php // substr es una funcion que me limita los caracteres que yo quiera de 0 a 180?></small></p>
                <p class="card-text"><small class="text-muted">
                Categoria: <?= $entrada['categoria'] ?> 
                |
                Publicado: <?= date('d/m/Y', strtotime($entrada['fecha_registro']))?>
                |
                Autor: <?= $entrada['usuario'] ?></small></p>
            </div>
            </a>
        </div>
    </div>
        <?php
        endwhile;
    else: // si no hay entradas que mostrar
        ?>
        <div class="alert alert-dark" role="alert">No hay entradas en esta busqueda</div>
    <?php endif; ?>
</div> <!-- fin principal -->

<?php require_once __DIR__ . '/includes/footer.php'; ?>