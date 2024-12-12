<?php
    require_once '../../config/conexion.php';
    require_once '../../config/seguridad.php';
    require_once 'autores.php';
    require_once 'libros.php';
    $conexion = conexion();
    $seguridad = new Seguridad($conexion);
    $libros = new libros($conexion, 'libros');
    $autores = new autores($conexion, 'autores');
    
    if(isset($_GET['id'])){
        $libro=$libros->getLibro($_GET['id']);
        $autor = $autores->getAutor($_GET['id']);
    }
        
    $libro=$libros->getLibro($_GET['id']);
    if(isset($_POST['Actualizar'])){
        $libros->actualizar($_POST['idAutor'], $_POST['titulo'], $_POST['genero'], $_POST['idAutor'], $_POST['nPaginas'], $_POST['nEjemplares']);
        header('Location: listarLibros.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Libro</title>
    <link rel="stylesheet" href="../ejercicios.css">
</head>
<body>
<h1>Bienvenido a la biblioteca</h1>
<nav id='menu'>
        <a href="listarLibros.php">Listado de libros</a>
        <a href="listarAutores.php">Listado de autores</a>
        
        <?php if ($_SESSION['rol'] === 'admin'): ?>
                <a href="../gestBooks/insertarLibros.php">Gestionar libros</a>
                <a href="../gestBooks/insertarAutor.php">Gestionar autores</a>
                <a href="../gestUsers/gestUser.php">Gestionar usuarios</a>
        <?php endif; ?>

        <?php if ($_SESSION['rol'] === 'bibliotecario'): ?>
            <a href="../gestBooks/insertarLibro.php">Gestionar libros</a>
            <a href="../gestBooks/insertarAutor.php">Gestionar autores</a>
        <?php endif; ?>

    </nav>

    <h2>Actualizar libro</h2>

    <form action="actualizarLibro.php?id=<?php echo $_GET['id']; ?>" method="post">
        <input type="hidden" name="idAutor" value='<?php echo $libro['idAutor'];?>'>
        <label for="titulo">Título</label>
        <input type="text" name="titulo" id="titulo" 
        value='<?php echo $libro['Titulo'];?>'>
        <label for="autor">Autor</label>
        <input type="text" name="autor" id="autor" 
        value='<?php echo $autor['Nombre'];?>'>
        <label for="genero">Genero</label>
        <select id="genero" name="genero"
        value='<?php echo $libro['Genero'];?>'>
            <option value="Narrativa">Narrativa</option>
            <option value="Lírica">Lírica</option>
            <option value="Teatro">Teatro</option>
            <option value="Científico-Técnico">Científico-Técnico</option>
        </select>
      
        <label for="nPaginas">Número de páginas</label>
        <input type="number" name="nPaginas" id="nPaginas"
        value='<?php echo $libro['NumeroPaginas'];?>'>
        <label for="nEjemplares">Número de ejemplares</label>
        <input type="number" name="nEjemplares" id="nEjemplares"
        value='<?php echo $libro['NumeroEjemplares']; ?>'>
        <input type="submit" name="Actualizar" value="Actualizar">
    
    </form>
  
    <form method="post" action="../../index.php">
            <button type="submit" name="volver">Volver a Inicio</button>
    </form>
    
    <p>Desarrollado por: <a href="">@sjimgon</a></p>

    
</body>
</html>