<?php
require_once "../config/conexion.php";
if(isset($_POST['host']) && isset($_POST['usuario']) && isset($_POST['password']) && isset($_POST['nombreBaseDatos']) && isset($_POST['puerto']) && isset($_POST['instalar'])){
    $contenido = '<?php
    define("HOST","'.$_POST['host'].'");
    define("USUARIO","'.$_POST['usuario'].'");
    define("PASSWORD","'.$_POST['password'].'");
    define("NAMEDB","'.$_POST['nombreBaseDatos'].'");
    define("PUERTO","'.$_POST['puerto'].'");
    ?>';
    
    if (!file_exists("../config/config.php")) {
    $config = fopen("../config/config.php","w");
    fwrite($config,$contenido);
    fclose($config);
    }
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalacion de biblioteca</title>
</head>
<body>
    <h1>Instalacion de la Aplicación Biblioteca</h1>
    
    <?php

if(!file_exists("../config/config.php")){       
    ?><p>Para una correcta instalación vamos a necesitar los siguientes datos:</p><?php
    ?> 
                
                <h3>Credenciales de la Base de Datos</h3>

                    <form action="" method="post">
                        <label for="host">Host: </label>
                        <input type="text" name="host" id="host" required>
                        <br><label for="usuario">Usuario: </label>
                        <input type="text" name="usuario" id="usuario" required>
                        <br><label for="password">Password: </label>
                        <input type="password" name="password" id="password" required>
                        <br><label for="nombreBaseDatos">Nombre Base de Datos: </label>
                        <input type="text" name="nombreBaseDatos" id="nombreBaseDatos" required>
                        <br><label for="puerto">Puerto: </label>
                        <input type="text" name="puerto" id="puerto" required>
                        <br><br><input type="submit" value="Instalar" name="instalar">
                
                
    <?php
            
     }else{
        include_once '../config/config.php';

        $conexion = new mysqli(HOST, USUARIO, PASSWORD, '', PUERTO);

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }
        
        $sql = "CREATE DATABASE IF NOT EXISTS `".NAMEDB."` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
        if ($conexion->query($sql) === TRUE) {
            echo "Base de datos creada correctamente.";
        } else {
            echo "Error al crear la base de datos: " . $conexion->error;
        }

        $conexion->select_db(NAMEDB);

        $sql = "CREATE TABLE IF NOT EXISTS autores (
            idAutor INT AUTO_INCREMENT PRIMARY KEY,
            Nombre VARCHAR(255) NOT NULL,
            Apellidos VARCHAR(255) NOT NULL,
            Pais VARCHAR(255) NOT NULL
        ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;";
        $conexion->query($sql);

        $sql = "CREATE TABLE IF NOT EXISTS libros (
            Titulo VARCHAR(255) NOT NULL,
            Genero VARCHAR(255) NOT NULL,
            idAutor INT NOT NULL,
            NumeroPaginas INT NOT NULL,
            NumeroEjemplares INT NOT NULL,
            FOREIGN KEY (idAutor) REFERENCES autores(idAutor)
        ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;";
        $conexion->query($sql);

        $sql = "CREATE TABLE IF NOT EXISTS usuarios (
            login VARCHAR(255) NOT NULL,
            nombre VARCHAR(255) NOT NULL,
            salt VARCHAR(512) NOT NULL,
            password VARCHAR(512) NOT NULL,
            rol ENUM('admin', 'user') NOT NULL,
            PRIMARY KEY (login)
        ) ENGINE = InnoDB;";
        $conexion->query($sql);
        $conexion->close();

        ?>

        <p>También vamos a necesitar estos datos para la creación del primer usuario Administrador</p>

        <h3>Credenciales del Primer Administrador</h3>

                    <form action="" method="post">
                        <br><label for="nombreAdmin">Nombre: </label>
                        <input type="text" name="nombreAdmin" id="nombreAdmin" required>
                        <br><label for="userAdmin">Usuario: </label>
                        <input type="text" name="userAdmin" id="userAdmin" required>
                        <br><label for="passwordAdmin">Password: </label>
                        <input type="password" name="passwordAdmin" id="passwordAdmin" required>
                        <br><br><input type="submit" value="Crear" name="crear">
                    </form>
            <?php

            if (isset($_POST['crear']) && isset($_POST['nombreAdmin']) && isset($_POST['userAdmin']) && isset($_POST['passwordAdmin'])) {

                $conexion = conexion();
                
                $stmt = $conexion->prepare("INSERT INTO usuarios (login, nombre, salt, password, rol) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $login, $nombre, $salt, $passwordHash, $rol);
                $login = htmlspecialchars($_POST['userAdmin']);
                $nombre = htmlspecialchars($_POST['nombreAdmin']);
                $salt = rand(0,1000000); 
                $passwordHash = password_hash($_POST['passwordAdmin'].$salt, PASSWORD_BCRYPT);
                $rol = 'admin';


                if ($stmt->execute()) {
                    echo "Se ha creado el usuario correctamente, ya puedes borrar el archivo install.php";
                } else {
                    echo "Error al crear el usuario";
                }
                $stmt->close();
                $conexion->close();
                header("Location: ../gestion/login/login.php");

            }
            }

             
     ?>
</body>
</html>
