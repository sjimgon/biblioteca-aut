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
    
    <h1>Bienvenido a la Biblioteca</h1>

    <nav id='menu'>
        <a href="listarLibros.php">Listado de libros</a>
        <a href="">Listado de autores</a>
        
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
        <th>Nombre</th>
        <th>Apellidos</th>
        <th>Nacionalidad</th>
        <th>Modificar</th>
    </tr>

    <?php
    $autores = new autores($conexion, 'autores');
    $listado = $autores->listar();
    foreach($listado as $autor){
        $autor = $autores->getAutor($autor['idAutor']);
        echo "<tr>";
        echo "<td>$autor[Nombre]</td>";
        echo "<td> $autor[Apellidos]</td>";
        echo "<td>".$autor['Pais']."</td>";
        echo "<td><a href='autores.php?id=".$autor['idAutor']."'>Actualizar</a> </br> <a href='autores.php?id=".$autor['idAutor']."'>Borrar</a></td>";
        echo "</tr>";
    }

    ?>
    </table>

    <form method="post" action="../../index.php">
            <button type="submit" name="volver">Volver a Inicio</button>
    </form>

<footer>
    <p>Desarrollado por: <a href="">@sjimgon</a></p>    
</footer>
</body>
