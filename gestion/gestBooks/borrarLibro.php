<?php
if(isset($_GET['id'])){
    require_once '../../config/conexion.php';
    require_once '../../config/seguridad.php';
    require_once 'libros.php';
    $libros = new libros(conexion(),'libros');
    $libros->borrar($_GET['id']);
    header('Location: listadoLibros.php');
}
?>