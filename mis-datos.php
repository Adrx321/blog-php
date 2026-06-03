<?php require_once __DIR__ . '/includes/conexion.php'; ?>
<?php require_once __DIR__ . '/includes/header.php'; ?>
<?php //require_once __DIR__ . '/includes/sidebar.php'; ?>

<nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">Inicio</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#">Mis datos</a>
            </li>
        </ol>
</nav>

<!-- CAJA PRINCIPAL -->
<div id="principal">
    <h1>Mis datos</h1>
    <?php if(isset($_SESSION['completado'])): ?>
        <div class="alert alert-success" role="alert">
            <?= $_SESSION['completado'] ?>
        </div>
        <?php elseif(isset($_SESSION['errores']['general'])): ?>
            <div class="alert alert-danger" role="alert">
                <?= $_SESSION['errores']['general'] ?>
            </div>
    <?php endif; ?>
    
    <div class="row justify-content-lg-center">
        <div class="col-10 col-m-6 col-lg-4 m-3">
            <?php if(!empty($_SESSION['usuario']['avatar'])): ?>
            <img
            src="uploads/avatars/<?= $_SESSION['usuario']['avatar'] ?>"
            width="150px"
            class="img-thumbnail mb-3"
            >
            <?php endif; ?>
            <form action="actualizar-usuario.php" method="post" enctype="multipart/form-data">
                <label for="nombre" class="col-form-label">Nombre:</label>
                <input type="text" name="nombre" class="form-control" value="<?= $_SESSION['usuario']['nombre'] ?>">
                <?= isset($_SESSION['errores']) ? mostrarError($_SESSION['errores'], 'nombre') : '' ?>

                <label for="apellidos" class="col-form-label">Apellidos:</label>
                <input type="text" name="apellidos" class="form-control" value="<?= $_SESSION['usuario']['apellidos'] ?>">
                <?= isset($_SESSION['errores']) ? mostrarError($_SESSION['errores'], 'apellidos') : '' ?>

                <label for="username" class="col-form-label">Nombre de Usuario:</label>
                <input type="text" name="username" class="form-control" value="<?= $_SESSION['usuario']['nombre_usuario'] ?>">
                <?= isset($_SESSION['errores']) ? mostrarError($_SESSION['errores'], 'username') : '' ?>

                <label for="email" class="col-form-label">Email:</label>
                <input type="text" name="email" class="form-control" value="<?= $_SESSION['usuario']['email'] ?>">
                <?= isset($_SESSION['errores']) ? mostrarError($_SESSION['errores'], 'email') : '' ?>

                <label for="avatar" class="col-form-label">Avatar:</label>
                <input type="file" name="avatar" class="form-control" accept="image/*" >
                <?= isset($_SESSION['errores']) ? mostrarError($_SESSION['errores'], 'avatar') : '' ?>
                
                <label for="bio" class="col-form-label">Descripcion:</label>
                <input type="text" name="bio" class="form-control" value="<?= $_SESSION['usuario']['bio'] ?>">
                <?= isset($_SESSION['errores']) ? mostrarError($_SESSION['errores'], 'bio') : '' ?>

                <input type="submit" class="btn btn-dark mt-3" value="Actualizar">
            </form>
            
            <?php borrarErrores(); ?>
        </div>
    </div>
</div> <!-- fin principal -->

<?php require_once __DIR__ . '/includes/footer.php'; ?>