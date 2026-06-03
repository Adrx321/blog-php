# blog-php
Blog desarrollado con PHP, MySQL y Bootstrap con autenticación, CRUD de entradas, categorías y comentarios. Asi como la funcion de subir imagenes.

## Características

- Registro e inicio de sesión
- Gestión de usuarios
- Categorías
- Publicación de entradas
- Edición y eliminación de entradas
- Comentarios
- Subida de imágenes
- Perfil de usuario
- Slugs para uls amigables

## Tecnologías utilizadas

- PHP
- MySQL
- Bootstrap 5
- HTML5
- CSS3

## Base de datos

Importar el archivo SQL incluido en el proyecto.

## Instalación

1. Clonar el repositorio

```bash
git clone URL_DEL_REPOSITORIO
```

2. Copiar el proyecto en la carpeta de XAMPP

htdocs/

3. Crear la base de datos en phpMyAdmin.

4. Importar el archivo SQL.

5. Configurar los datos de conexión en:
   includes/conexion.php

6. Iniciar Apache y MySQL.

Respecto a subirlo a GitHub, no subas informacion o datos personales.

Luego:

```bash
git init
git add .
git commit -m "Primer commit" # puedes poner el nombre que desees. Solo es una descripcion del guardado.
```

Después creas el repositorio en GitHub ejecutas algo parecido a:

```bash
git remote add origin https://github.com/usuario/blog-php.git
git branch -M main
git push -u origin main
```
