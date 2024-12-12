<?php
include_once "config.php";
include_once "seguridad.php";
function conexion(){
    $conexion = new mysqli(HOST,USUARIO,PASSWORD,NAMEDB,PUERTO);
    
    if($conexion->connect_errno){
        echo "Error al conectar con la base de datos";
        exit();
    }
    return $conexion;
}
?>