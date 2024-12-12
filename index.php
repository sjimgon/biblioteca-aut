<?php      
    if(!file_exists("./config/config.php")){
        header("Location: install/install.php");
    }else{
    require_once './config/config.php';
    require_once './config/seguridad.php';
    require_once './config/conexion.php';
    $conexion = conexion();
    $seguridad= new seguridad($conexion);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca</title>
    <link rel="stylesheet" href="./css/estilo.css">
</head>
<body>
    <?php
        if($seguridad->isLogged()){?>
        
            <h4>Bienvenido a la biblioteca</h4>

    <nav id='menu'>
        <a href="./gestion/gestBooks/listarLibros.php">Listado de libros</a>
        <a href="./gestion/gestBooks/listarAutores.php">Listado de autores</a>
        
        <?php if ($_SESSION['rol'] === 'admin'): ?>
                <a href="./gestion/gestBooks/insertarLibro.php">Gestionar libros</a>
                <a href="./gestion/gestBooks/insertarAutor.php">Gestionar autores</a>
                <a href="./gestion/gestUsers/gestUser.php">Gestionar usuarios</a>
        <?php endif; ?>

        <?php if ($_SESSION['rol'] === 'bibliotecario'): ?>
            <a href="./gestion/gestBooks/insertarLibro.php">Gestionar libros</a>
            <a href="./gestion/gestBooks/insertarAutor.php">Gestionar autores</a>
        <?php endif; ?>

    </nav>

    
    <footer>
         <p>Desarrollado por: <a href="">@sjimgon</a></p>
    </footer>
            
        <?php }else{
            header("Location: gestion/login/login.php");  
        }
    }?>
  

</body>
</html>