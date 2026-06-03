<?php require_once __DIR__ . '/conexion.php'?>
<?php require_once __DIR__ . '/helpers.php'?> 

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Blog de videojuegos y Anime</title>
    <link rel="stylesheet" href="./css/style.css" />
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css" />
  </head>
  <body>
    <div class="container">
      <header class="col-md-12 mt-2">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
          <div class="container-fluid">
            <a href="#" class="navbar-brand">
              <div id="logo">
                <a href="index.php">Games Anime</a>
              </div>
            </a>
            <button
              class="navbar-toggler"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#navbarSupportedContent"
              aria-controls="navbarSupportedContent"
              aria-expanded="false"
              aria-label="Toggle navigation"
            >
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                </li>
                <li class="nav-item dropdown">
                  <a
                    class="nav-link dropdown-toggle"
                    href="#"
                    role="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                  >
                    Categorias
                  </a>
                  <ul class="dropdown-menu">
<!--                     <li><a class="dropdown-item" href="#">Action</a></li>-->     
                    <?php 
                    $categorias = conseguirCategorias($bd);
                    if(!empty($categorias)):
                        while($categoria = mysqli_fetch_assoc($categorias)): //saco el array asociativo del querry que hice en helpers.php
                    ?> 
                    <li><a class="dropdown-item" href="categoria.php?id=<?=$categoria['categoria_id']?>"><?= $categoria['nombre'] ?></a></li>
                    <?php  /* aca muestro el nombre y cuando toco se lleva el id de la categoria */
                    endwhile;
                  endif;
                  ?>           
                  </ul>
                </li>

                <?php if(!isset($_SESSION['usuario'])): // si no existe la variable de sesion usuario muestro el inicio de sesion y registro ?>

                <li class="nav-item">
                  <a
                    class="nav-link active"
                    data-bs-toggle="modal"
                    data-bs-target="#Inicio-sesion"
                    href="#"
                  >
                    Inicio de Sesion
                  </a>
                </li>
                <li class="nav-item">
                  <a
                    class="nav-link active"
                    data-bs-toggle="modal"
                    data-bs-target="#registro"
                    href="#"
                  >
                    Registro
                  </a>
                </li>

                <?php endif; ?>
                <?php if(isset($_SESSION['usuario'])): // si existe la variable de sesion usuario es porque se logeo correctamente y me muestra esto ?>

                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Bienvenido!!, <?= $_SESSION['usuario']['nombre'].' '.$_SESSION['usuario']['apellidos'] ?></a> <!-- es un array asociativo el $_SESSION[usuario][nombre] -->
                
                <!-- Botones -->
                 <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="crear-entradas.php">Crear entrada</a></li>
                    <?php if(esAdmin()): ?>

                    <li><a class="dropdown-item" href="crear-categoria.php">Crear categoria</a></li>
                    <?php endif; ?>
                    <li><a class="dropdown-item" href="mis-datos.php">Mis datos</a></li>
                    <li><a class="dropdown-item" href="cerrar.php">Cerrar sesion</a></li>
                 </ul>
                 </li>
                <?php endif; ?>

              </ul>
              <form action="buscar.php" method="POST" class="d-flex" role="search">
                <input name="busqueda"
                  class="form-control me-2"
                  type="search"
                  placeholder="Buscar"
                  aria-label="Search"
                />
                <button class="btn btn-outline-success" type="submit">
                  Buscar
                </button>
              </form>
            </div>
            <?php if(!isset($_SESSION['usuario'])): // si no existe esta session no me muestra todo esto?>
            
            <!-- Modal inicio de sesion -->
            <div
              class="modal fade"
              id="Inicio-sesion"
              tabindex="-1"
              aria-labelledby="Inicio-sesion"
              aria-hidden="true"
            >
              <div class="modal-dialog">
                <div class="modal-content">
                  <form action="login.php" method="POST">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="Inicio-sesion">
                        Identificate
                      </h1>
                      <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                      ></button>
                    </div>
                    <div class="modal-body">
                      <label for="login" class="form-label">Usuario o Email</label>
                      <input
                        type="text"
                        class="form-control"
                        id="login"
                        name="login"
                      />
                      <label for="password" class="form-label"
                        >Contraseña</label
                      >
                      <input
                        type="password"
                        class="form-control"
                        id="password"
                        name="password"
                      />
                    </div>
                    <div class="modal-footer">
                      <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                      >
                        Cancelar
                      </button>
                      <button type="submit" class="btn btn-primary">
                        Entrar
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- fin de inicio de sesion -->
             <?php endif; ?>
            <!-- Modal registro -->
            <div
              class="modal fade"
              id="registro"
              tabindex="-1"
              aria-labelledby="registro"
              aria-hidden="true"
            >
              <div class="modal-dialog">
                <div class="modal-content">
                  -<form action="register.php" method="POST">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="registro">Registrate</h1>
                      <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                      ></button>
                    </div>
                    <div class="modal-body">
                      <label for="nombre" class="form-label">Nombre</label>
                      <input
                        type="text"
                        class="form-control"
                        id="nombre"
                        name="nombre"
                      />
                      <?php echo isset($_SESSION['errores']) ? mostrarError($_SESSION['errores'], 'nombre') : ''; ?>
                      <!-- si existe la session errores mostramos lo que dice con la funcion mostrarerrores -->
                      <label for="apellidos" class="form-label"
                        >Apellidos</label
                      >
                      <input
                        type="text"
                        class="form-control"
                        id="apellidos"
                        name="apellidos"
                      />
                      <?php echo isset($_SESSION['errores']) ? mostrarError($_SESSION['errores'], 'apellidos') : ''; ?>
                      <!-- si existe la session errores mostramos lo que dice con la funcion mostrarerrores -->
                      <label for="username" class="form-label">Nombre de Usuario</label>
                      <input
                        type="text"
                        class="form-control"
                        id="username"
                        name="username"
                      />
                      <?php echo isset($_SESSION['errores']) ? mostrarError($_SESSION['errores'], 'username') : ''; ?>
                      <label for="email" class="form-label">Email</label>
                      <input
                        type="email"
                        class="form-control"
                        id="email"
                        name="email"
                      />
                      <?php echo isset($_SESSION['errores']) ? mostrarError($_SESSION['errores'], 'email') : ''; ?>
                      <!-- si existe la session errores mostramos lo que dice con la funcion mostrarerrores -->
                      <label for="password" class="form-label"
                        >Contraseña</label
                      >
                      <input
                        type="password"
                        class="form-control"
                        id="password"
                        name="password"
                      />
                      <?php echo isset($_SESSION['errores']) ? mostrarError($_SESSION['errores'], 'password') : ''; ?>
                      <!-- si existe la session errores mostramos lo que dice con la funcion mostrarerrores -->
                    </div>
                    <div class="modal-footer">
                      <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                      >
                        Cancelar
                      </button>
                      <button type="submit" class="btn btn-primary">
                        Registrarse
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- Fin de registro -->
          </div>
        </nav>
      </header>
