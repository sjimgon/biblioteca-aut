<?php
require_once "../../config/seguridad.php";
require_once "../../config/conexion.php";

$conexion = conexion();
$seguridad = new Seguridad($conexion);

if($_POST['inicio']){
    $username = $_POST['login'];
    $password = $_POST['password'];
    if($seguridad->login($username,$password)){
        header("Location: ");
    }else{
        echo "Usuario o contraseña incorrectos";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Biblioteca</title>
</head>
<body>
    <form action="../../index.php" method="post">
        <h2>Iniciar sesión</h2>
    <label for="login">Login</label>
    <input type="text" name="login" id="login" >
    <label for="password">Password</label>
    <input type="password" name="password" id="password" >
    <input type="submit" value="Iniciar sesión" name="inicio">
    </form>
</body>
</html>