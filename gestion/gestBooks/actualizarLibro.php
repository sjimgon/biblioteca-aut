<?php
    require_once '../../config/conexion.php';
    require_once '../../config/seguridad.php';
    require_once 'libros.php';
    $libros = new libros(conexion(), 'libros');
    if(isset($_GET['id'])){
        $libro=$libros->getLibro($_GET['id']);
    }
        
    $libro=$libros->getLibro($_GET['id']);
    if(isset($_POST['Actualizar'])){
        $libros->actualizar($_POST['id'], $_POST['titulo'], $_POST['genero'], $_POST['autor'], $_POST['nPaginas'], $_POST['nEjemplares']);
        header('Location: listadoLibros.php');
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
    <h1>Actualizar libro</h1>
    <nav id='menu'>
        <a href="listadoLibros.php">Listado de libros</a>
        <a href="listadoAutores.php">Listado de autores</a>
        <a href="insertarLibro.php">Insertar libro</a>
   
        </nav>
    <form action="actualizarLibro.php" method="post">
        <input type="hidden" name="id" value='<?php echo $libro['id'];?>'>
        <label for="titulo">Título</label>
        <input type="text" name="titulo" id="titulo" 
        value='<?php echo $libro['Titulo'];?>'>
        <label for="autor">Autor</label>
        <input type="text" name="autor" id="autor" 
        value='<?php echo $libro['idAutor'];?>'>
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
    <?php 
    if(isset($mensaje))
      echo "<p class='error'>".$mensaje."</p>";  
    ?>
    <footer>
        <p>Desarrollado por: <a href="">@mvaronc</a></p>
    </footer>
    
</body>
</html>