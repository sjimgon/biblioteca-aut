<?php

require_once 'libros.php';
require_once '../../config/conexion.php';
require_once '../../config/seguridad.php';
require_once 'autores.php';

$conexion = conexion();
$seguridad = new seguridad($conexion);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de libros</title>
</head>
<body>
    
    <nav id='menu'>
        <a href="">Listado de libros</a>
        <a href="listarAutores.php">Listado de autores</a>
        
        <?php if ($_SESSION['rol'] === 'admin'): ?>
                <a href="../gestBooks/insertarLibro.php">Gestionar libros</a>
                <a href="../gestBooks/insertarAutor.php">Gestionar autores</a>
                <a href="../gestUsers/gestUser.php">Gestionar usuarios</a>
        <?php endif; ?>

        <?php if ($_SESSION['rol'] === 'bibliotecario'): ?>
            <a href="../gestBooks/insertarLibro.php">Gestionar libros</a>
            <a href="../gestBooks/insertarAutor.php">Gestionar autores</a>
        <?php endif; ?>

    </nav>

<h2>Listado</h2>
<table>
    <tr>
        <th>Titulo</th>
        <th>Genero</th>
        <th>Autor</th>
        <th>Número de páginas</th>
        <th>Número de ejemplares</th>
        <th>Modificar</th>
    </tr>

    <?php
    
    $libros = new libros($conexion, 'libros');
    $autores = new autores($conexion, 'autores');
    $listado = $libros->listar();
    foreach($listado as $libro){
        $autor = $autores->getAutor($libro['idAutor']);
        echo "<tr>";
        echo "<td>".$libro['Titulo']."</td>";
        echo "<td>".$libro['Genero']."</td>";
        echo "<td>$autor[Nombre] $autor[Apellidos]</td>";
        echo "<td>".$libro['NumeroPaginas']."</td>";
        echo "<td>".$libro['NumeroEjemplares']."</td>";
        echo "<td><a href='actualizarLibro.php?id=".$libro['id']."'>Actualizar</a></td>";
        echo "<td><a href='borrarLibro.php?id=".$libro['id']."'>Borrar</a></td>";
        echo "</tr>";
    }

    ?>
    
    <form method="post" action="../../index.php">
            <button type="submit" name="volver">Volver a Inicio</button>
    </form>

</table>
<footer>
    <p>Desarrollado por: <a href="">@sjimgon</a></p>    
</footer>
</body>
