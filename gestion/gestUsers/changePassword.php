<?php
require_once "../../config/seguridad.php";
require_once "../../config/conexion.php";
require_once "users.php";
$conexion=conexion();
$seguridad= new seguridad($conexion);
if(!$seguridad->isUserAdmin()){
    header("Location: ./login/login.php");
}


if(isset($_POST['actualizar'])){
    
    $oldPassword = $_POST['oldPassword'];
    $newPassword1 = $_POST['newPassword'];
    $newPassword2 = $_POST['newPassword2'];
    
    if($newPassword1==$newPassword2){
        $users= new users($conexion);
        $user = $users->get_user($seguridad->getUser());
        if($user){
            if(password_verify($oldPassword.$user['salt'],$user['password'])){
               $result = $users->update_user($seguridad->getUser(),$newPassword1);
                if($result){
                    $mensaje="Contraseña actualizada";
                }else{
                    $mensaje= "Error al actualizar la contraseña";
                }
            }else{
                $mensaje="Contraseña actual incorrecta";
            }
        }
    }else{
        $mensaje="Las contraseñas no coinciden";
    }
  
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar contraseña</title>
    <link rel="stylesheet" href="../../css/estilo.css">
</head>
<body>

<h1>Bienvenido a la biblioteca 1.0</h1>
        <nav id='menu'>
        <a href="listadoLibros.php">Listado de libros</a>
        <a href="listadoAutores.php">Listado de autores</a>
        <a href="insertarLibro.php">Insertar libro</a>
        </nav>

    <form action="" method="post">
        <label for="oldPassword">Contraseña actual: </label>
        <input type="password" name="oldPassword" id="oldPassword">
        <label for="newPassword">Nueva contraseña: </label>
        <input type="password" name="newPassword" id="newPassword">
        <label for="newPassword2">Repita su nueva contraseña</label>
        <input type="password" name="newPassword2" id="newPassword2">
        <input type="submit" value="Actualizar" name="actualizar">
    </form>
    <?php
    if(isset($mensaje)){
        echo "<p>$mensaje</p>";
    }   
    ?>
    <footer>
        <p>Desarrollado por: <a href="">@sjimgon</a></p>
    </footer>
</body>
</html>