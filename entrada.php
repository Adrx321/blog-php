<?php require_once __DIR__ . '/includes/conexion.php'; ?>
<?php 
require_once __DIR__ . '/includes/helpers.php'; 

$entrada_actual = conseguirEntradaSlug($bd, $_GET['slug']);

if(empty($entrada_actual)){ //si no hay nada pues me devuelve al inicio
    header("Location: index.php");
    exit();
} 
require_once __DIR__ . '/includes/header.php'; 
//require_once __DIR__ . '/includes/sidebar.php';
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="index.php">Inicio</a>
        </li>
        <li class="breadcrumb-item">
            <a href=""><?= $entrada_actual['titulo'] ?></a>
        </li>
    </ol>
</nav>

<!-- CAJA PRINCIPAL --> <!-- GRACIAS A LA QUERY MUESTRO ESTO -->
<div class="card-group m-4">
    <div class="card m-1">
         <?php if(!empty($entrada_actual['imagen'])): ?>
    <img
        src="uploads/entradas/<?= $entrada_actual['imagen'] ?>"
        class="card-img-top"
        alt="<?= $entrada_actual['titulo'] ?>"
        style="height: 400px; object-fit: cover;"
    >
<?php endif; ?>
        <div class="card-body">
            <h1 class="card-title"><?= $entrada_actual['titulo'] ?></h1>
            <h2>
                <a href="categoria.php?id=<?= $entrada_actual['categoria_id'] ?>" class="text-success">
                    <?= $entrada_actual['categoria'] ?>
                </a>
            </h2>
            <h4>Publicado el <?= date('d/m/Y', strtotime($entrada_actual['fecha_registro']))?> por <?= $entrada_actual['usuario'] ?></h4>
                <p class="card-text"><small class="text-dark"><?= nl2br($entrada_actual['contenido']) ?></small>
                </p>
        </div>

        <?php if(isset($_SESSION['usuario']) && $_SESSION['usuario']['usuario_id'] == $entrada_actual['usuario_id']): // si estoy logeado y si soy yo igual al usuario actual de la entrada
        ?>
        <br>
        <a href="editar-entrada.php?slug=<?= $entrada_actual['slug'] ?>" type="button" class="btn btn-outline-dark">Editar Entrada</a>
        <a href="borrar-entrada.php?slug=<?= $entrada_actual['slug'] ?>" type="button" class="btn btn-outline-dark">Eliminar Entrada</a>
        <?php endif; ?>
    </div>
    
    


</div> <!-- FIN PRINCIPAL -->

<div class="mt-4">
        <h3>Comentarios</h3>
        <?php 
        $comentarios = conseguirComentarios($bd, $entrada_actual['entrada_id']);

        while($comentario = mysqli_fetch_assoc($comentarios)): ?>
        <div class="card mt-3">
            <div class="card-body">
                <h6>
                    <?= $comentario['nombre_usuario'] ?>
                </h6>
                <p><?= nl2br($comentario['contenido']) ?></p>
                <small>
                    <?= $comentario['fecha_creacion'] ?>
                </small>
                <?php if(isset($_SESSION['usuario']) && $_SESSION['usuario']['usuario_id'] == $comentario['usuario_id']):
                ?>
                <br>
                <a href="editar-comentario.php?id=<?= $comentario['comentario_id'] ?>" type="button" class="btn btn-outline-dark">Editar Comentario</a>
                <a href="borrar-comentario.php?id=<?= $comentario['comentario_id'] ?>&slug=<?= $entrada_actual['slug'] ?>" type="button" class="btn btn-outline-dark">Eliminar Comentario</a>
                <?php endif; ?>
            </div>
        </div>
        <?php endwhile; ?>

        <div class="mt-4">
        <?php if(isset($_SESSION['usuario'])): ?>
        <h4>Agregar comentario</h4>
        <form action="guardar-comentario.php" method="POST">
        <br>
        <input
            type="hidden"
            name="entrada_id"
            value="<?= $entrada_actual['entrada_id'] ?>"
        >
        <textarea
            name="contenido"
            class="form-control"
        ></textarea>
        <?= isset($_SESSION['errores_comentario']) ? mostrarError($_SESSION['errores_comentario'], 'contenido'): '' ?>
        <input
            type="submit"
            class="btn btn-dark mt-2"
            value="Comentar"
        >
        </form>
        <?php else: ?>
            <div class="alert alert-warning">
                Debes iniciar sesion para comentar.
            </div>
        <?php endif; ?>
        </div>
    </div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
