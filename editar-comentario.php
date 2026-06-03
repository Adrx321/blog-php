<?php require_once __DIR__ . '/includes/redireccion.php'; ?>
<?php require_once __DIR__ . '/includes/conexion.php'; ?>
<?php require_once __DIR__ . '/includes/helpers.php'; ?>

<?php
$comentario = conseguirComentario($bd, $_GET['id']);

if(empty($comentario)){
    header("Location: index.php");
    exit();
}
?>

<?php require_once __DIR__ . '/includes/header.php'; ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="index.php">Inicio</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#">Entrada</a>
        </li>
        <li class="breadcrumb-item">
            <a href="">Editar Comentario</a>
        </li>
    </ol>
</nav>

<!-- CAJA PRINCIPAL -->
<div id="principal">
    <h1>Editar Comentario</h1>
    <p class="text-dark text-center">
        Edita tu comentario
    </p>
    <br>
    <div class="row justify-content-lg-center">
        <div class="col-10 col-m-6 col-lg-4 m-3">
            <form action="guardar-comentario.php?editar=<?= $comentario['comentario_id'] ?>" method="POST">
                <input
                type="hidden"
                name="entrada_id"
                value="<?= $comentario['entrada_id'] ?>"
                >
                <label for="contenido" class="col-form-label">Contenido:</label>
                <textarea name="contenido" class="form-control"><?= $comentario['contenido'] ?></textarea>
                <?= isset($_SESSION['errores_comentario']) ? mostrarError($_SESSION['errores_comentario'], 'contenido') : '' ?>
                <input type="submit" class="btn btn-primary mt-3" value="Guardar">
            </form>
            <?php borrarErrores(); ?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>