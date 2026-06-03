<?php require_once __DIR__ . '/includes/redireccion.php'; ?>
<?php require_once __DIR__ . '/includes/header.php'; ?>
<?php require_once __DIR__ . '/includes/conexion.php'; ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="index.php">Inicio</a>
        </li>
        <li class="breadcrumb-item disabled">
            <a href="#">Crear Categoria</a>
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
    <h1>Crear Categoria</h1>
    
    <p class="text-dark text-center">
        Añade nuevas categorias para que los usuarios puedan usarlas al crear sus entradas
    </p>
    <br>
    <form action="guardar-categoria.php" method="POST">
        <label for="nombre" class="col-form-label">Nombre de la categoria:</label>
        <input type="text" name="nombre" class="form-control" style="font-size: 24px; color: black;">
        <?= isset($_SESSION['errores_categoria']) ? mostrarError($_SESSION['errores_categoria'], 'nombre') : '' ?>
        <label for="descripcion" class="col-form-label">Descripcion:</label>
        <input type="text" name="descripcion" class="form-control" style="font-size: 24px; color: black;">
        <?= isset($_SESSION['errores_categoria']) ? mostrarError($_SESSION['errores_categoria'], 'descripcion') : '' ?>
        <input type="submit" class="btn btn-primary mt-3" value="Guardar">
    </form>
    <?php borrarErrores(); ?>
</div> <!-- FIN PRINCIPAL -->

<?php require_once __DIR__ . '/includes/footer.php'; ?>