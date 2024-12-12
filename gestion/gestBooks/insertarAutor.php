<?php
    require_once 'autores.php';
    require_once '../../config/conexion.php';
    require_once '../../config/seguridad.php';
    $conexion = conexion();
    $seguridad = new Seguridad($conexion);
    $autores = new autores($conexion, 'autores');
    if(isset($_POST['Insertar'])){
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $nacionalidad = $_POST['nacionalidad'];
        $idAutor=$autores->insertar($nombre, $apellidos, $nacionalidad);
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar autor</title>
    <link rel="stylesheet" href="../ejercicios.css">
</head>
<body>
<h1>Bienvenido a la biblioteca</h1>
    <h2>Insertar autor</h2>
    <nav id='menu'>
        <a href="listarLibros.php">Listado de libros</a>
        <a href="listarAutores.php">Listado de autores</a>
        
        <?php if ($_SESSION['rol'] === 'admin'): ?>
                <a href="../gestBooks/insertarLibros.php">Gestionar libros</a>
                <a href="">Gestionar autores</a>
                <a href="../gestUsers/gestUser.php">Gestionar usuarios</a>
        <?php endif; ?>

        <?php if ($_SESSION['rol'] === 'bibliotecario'): ?>
            <a href="../gestBooks/insertarLibro.php">Gestionar libros</a>
            <a href="../gestBooks/insertarAutor.php">Gestionar autores</a>
        <?php endif; ?>

    </nav>
    <form action="./listarAutores.php" method="post">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" required>
        <label for="apellidos">Apellidos</label>
        <input type="text" name="apellidos" id="apellidos" required>
        <label for="nacionalidad">Nacionalidad</label>
        <input type="text" name="nacionalidad" id="nacionalidad" required>
        <input type="submit" name="insertar" value="Insertar">
    </form>

    <form method="post" action="../../index.php">
            <button type="submit" name="volver">Volver a Inicio</button>
    </form>

    <footer>
        <p>Desarrollado por: <a href="">@sjimgon</a></p>    
    </footer>
</body>