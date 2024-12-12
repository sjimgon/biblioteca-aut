<?php
    require_once 'libros.php';
    require_once '../../config/conexion.php';
    require_once '../../config/seguridad.php';
    require_once 'autores.php';
    $conexion = conexion();
    $seguridad = new Seguridad($conexion);
    $libros = new libros($conexion, 'libros');
    $autores = new autores($conexion, 'autores');
    
    
    if(isset($_POST['Insertar'])){
        $titulo = $_POST['titulo'];
        $idAutor = $_POST['autor'];
        $genero = $_POST['genero'];
        $nPaginas = $_POST['nPaginas'];
        $nEjemplares = $_POST['nEjemplares'];
        $idLibro=$libros->insertar($titulo, $genero, $idAutor, $nPaginas, $nEjemplares);
        
        echo 'El libro se ha insertado con éxito. Compruebalo en el <a href="listarLibros.php">listado de libros</a>';
    }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Libro</title>
    <link rel="stylesheet" href="../ejercicios.css">
</head>
<body>
<h1>Bienvenido a la biblioteca</h1>
    <h2>Insertar libro</h2>
    <nav id='menu'>
        <a href="listarLibros.php">Listado de libros</a>
        <a href="listarAutores.php">Listado de autores</a>
        
        <?php if ($_SESSION['rol'] === 'admin'): ?>
                <a href="">Gestionar libros</a>
                <a href="../gestBooks/insertarAutor.php">Gestionar autores</a>
                <a href="../gestUsers/gestUser.php">Gestionar usuarios</a>
        <?php endif; ?>

        <?php if ($_SESSION['rol'] === 'bibliotecario'): ?>
            <a href="../gestBooks/insertarLibro.php">Gestionar libros</a>
            <a href="../gestBooks/insertarAutor.php">Gestionar autores</a>
        <?php endif; ?>

    </nav> 
    <form action="" method="post">
        <label for="titulo">Título</label>
        <input type="text" name="titulo" id="titulo">
        <label for="autor">Autor</label>
        <select id="autor" name="autor" style="display: inline;">
            <?php
            $listado = $autores->listar();
            foreach($listado as $autor){
                echo "<option value='".$autor['idAutor']."'>".$autor['Nombre']." ".$autor['Apellidos']."</option>";
            }
        ?>
        </select><button style="display:inline;"><a  href="insertarAutor.php">*</a></button>
        <label for="genero">Genero</label>
        <select id="genero" name="genero">
            <option value="Narrativa">Narrativa</option>
            <option value="Lírica">Lírica</option>
            <option value="Teatro">Teatro</option>
            <option value="Científico-Técnico">Científico-Técnico</option>
        </select>
      
        <label for="nPaginas">Número de páginas</label>
        <input type="number" name="nPaginas" id="nPaginas">
        <label for="nEjemplares">Número de ejemplares</label>
        <input type="number" name="nEjemplares" id="nEjemplares">
        <input type="submit" name="Insertar" value="Insertar">
    
    </form>

    <form method="post" action="../../index.php">
            <button type="submit" name="volver">Volver a Inicio</button>
    </form>

        <p>Desarrollado por: <a href="">@sjimgon</a></p>
    </footer>
    
</body>
</html>