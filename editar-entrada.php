<?php require_once __DIR__ . '/includes/redireccion.php'; ?>
<?php require_once __DIR__ . '/includes/conexion.php'; ?>
<?php require_once __DIR__ . '/includes/helpers.php'; ?>

<?php
$entrada_actual = conseguirEntradaSlug($bd, $_GET['slug']);

if(empty($entrada_actual)){
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
            <a href="">Editar Entrada</a>
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
    <h1>Editar Entrada</h1>
    <p class="text-dark text-center">
        Edita tu entrada <?= $entrada_actual['titulo'] ?>
    </p>
    <br>
    <div class="row justify-content-lg-center">
        <div class="col-10 col-m-6 col-lg-4 m-3">
            <form action="guardar-entrada.php?editar=<?= $entrada_actual['entrada_id'] ?>" method="POST">
                <label for="titulo" class="col-form-label">Titulo:</label>
                <input type="text" class="form-control" name="titulo" value="<?= $entrada_actual['titulo'] ?>">
                <?= isset($_SESSION['errores_entrada']) ? mostrarError($_SESSION['errores_entrada'], 'titulo') : '' ?>

                <label for="contenido" class="col-form-label">Descripcion:</label>
                <textarea name="contenido" id="" class="form-control"><?= $entrada_actual['contenido'] ?></textarea>
                <?= isset($_SESSION['errores_entrada']) ? mostrarError($_SESSION['errores_entrada'], 'contenido') : '' ?>

                <label for="categoria" class="col-form-label">Categoria:</label>
                <select name="categoria" id="" class="form-select">
                    <option selected disabled>Categorias</option>
                        <?php
                        $categorias = conseguirCategorias($bd);
                        if(!empty($categorias)):
                            while($categoria = mysqli_fetch_assoc($categorias)):
                        ?>
                        <option value="<?= $categoria['categoria_id'] ?>" <?= ($categoria['categoria_id'] == $entrada_actual['categoria_id']) ? 'selected' : ''  ?> >
                            <?= $categoria['nombre']  // igualando lo id de las categorias pongo el enfoque en la categoria actual y selected me selecciona el elemento?> 
                        </option>
                        <?php
                            endwhile;
                        endif;
                        ?>
                    
                </select>
                <?= isset($_SESSION['errores_entrada']) ? mostrarError($_SESSION['errores_entrada'], 'categoria') : ''  ?>
                <input type="submit" class="btn btn-primary mt-3" value="Guardar">
            </form>
            <?php borrarErrores(); ?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>