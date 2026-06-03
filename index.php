<?php require_once __DIR__ . '/includes/conexion.php'; ?>
<?php  require_once __DIR__ . '/includes/header.php'; ?>

<div class="row justify-content-center">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="">Inicio</a></li>
            </li>
          </ol>
        </nav>
     <?php if(isset($_SESSION['completado'])): ?>
        <div class="alert alert-success" role="alert">
            <?= $_SESSION['completado'] ?>
        </div>
        <?php elseif(isset($_SESSION['errores']['login'])): ?>
            <div class="alert alert-danger" role="alert">
                <?= $_SESSION['errores']['login'] ?>
            </div>
            <?php endif; 
            borrarErrores();
            ?>
        <!-- Slider -->
        <div class="slider col-lg-6 col-md-4 col-sm-6 col-xs-12 m-3">
          <!-- imagenes -->
          <div id="carouselExampleCaptions" class="carousel slide">
            <div class="carousel-indicators">
              <button
                type="button"
                data-bs-target="#carouselExampleCaptions"
                data-bs-slide-to="0"
                class="active"
                aria-current="true"
                aria-label="Slide 1"
              ></button>
              <button
                type="button"
                data-bs-target="#carouselExampleCaptions"
                data-bs-slide-to="1"
                aria-label="Slide 2"
              ></button>
              <button
                type="button"
                data-bs-target="#carouselExampleCaptions"
                data-bs-slide-to="2"
                aria-label="Slide 3"
              ></button>
            </div>
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="./img/lizza.gif" class="d-block w-100" alt="..." />
                <div class="carousel-caption d-none d-md-block">
                  <h5>Bienvenido a mi Blog</h5>
                  <p>
                    Comparte ideas, experiencias y contenido interesante.
                  </p>
                </div>
              </div>
              <div class="carousel-item">
                <img src="./img/gif9.gif" class="d-block w-100" alt="..." />
                <div class="carousel-caption d-none d-md-block">
                  <h5>Nuevas Entradas</h5>
                  <p>
                   Descubre artículos publicados recientemente.
                  </p>
                </div>
              </div>
              <div class="carousel-item">
                <img src="./img/gif2.gif" class="d-block w-100" alt="rico" />
                <div class="carousel-caption d-none d-md-block">
                  <h5>Explora Categorias</h5>
                  <p>
                    Navega por las distintas categorias y encuentra contenido de tu interes.
                  </p>
                </div>
              </div>
            </div>
            <button
              class="carousel-control-prev"
              type="button"
              data-bs-target="#carouselExampleCaptions"
              data-bs-slide="prev"
            >
              <span
                class="carousel-control-prev-icon"
                aria-hidden="true"
              ></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button
              class="carousel-control-next"
              type="button"
              data-bs-target="#carouselExampleCaptions"
              data-bs-slide="next"
            >
              <span
                class="carousel-control-next-icon"
                aria-hidden="true"
              ></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
          <!-- imagenes -->
        </div>

</div>

      <!-- cards -->
      <h1>Ultimas entradas</h1>
    <div class="card-group m-4">
        <?php
        $entradas = conseguirEntradas($bd, true); // true para limitar a 4 entradas
        if(!empty($entradas)):
            while($entrada = mysqli_fetch_assoc($entradas)): // lo hacemos array asociativo para acceder a los campos por su nombre
        ?>

        <div class="card m-1 shadow-sm">
          <?php if(!empty($entrada['imagen'])): ?>
          <img
          src="uploads/entradas/<?= $entrada['imagen'] ?>"
          class="card-img-top"
          alt="<?= $entrada['titulo'] ?>"
          style="height: 250px; object-fit: cover;"
          >
        <?php endif; ?>
           <a href="entrada.php?slug=<?= $entrada['slug'] ?>"
           class="text-decoration-none text-lightblue">
            <div class="card-body">
              <h5 class="card-title"><?=$entrada['titulo'] ?></h5>

              <p class="card-text text-black">
                <?=substr($entrada['contenido'],0, 180)."..."?> <!-- substr para mostrar solo los primeros 180 caracteres de la descripcion -->
              </p>

              <p class="card-text">
                <small class="text-body-secondary">
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
        <?php
        endwhile;
        endif;
    ?>
    </div>

    <div id="ver-todas">
      <a href="entradas.php">Ver todas las entradas</a>
    </div>


<?php require_once 'includes/footer.php';?>

