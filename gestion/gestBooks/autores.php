<?php
class autores{
    protected $conexion;
    protected $tabla;
 public function __construct($conexion, $tabla){
     $this->conexion = $conexion;
     $this->tabla = $tabla;
   
 }   
    public function insertar($nombre, $apellidos, $nacionalidad){
        $sql = "INSERT INTO $this->tabla (Nombre, Apellidos, Pais) VALUES (?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('sss', $nombre, $apellidos, $nacionalidad);
        $stmt->execute();
        $last_id = $stmt->insert_id;
        $stmt->close();
        return $last_id;
    }

    public function borrar($id){
        $sql = "DELETE FROM $this->tabla WHERE idAutor = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }

    public function actualizar($id, $nombre, $apellidos, $nacionalidad){
        $sql = "UPDATE $this->tabla SET Nombre = ?, Apellidos = ?, Pais = ? WHERE idAutor = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('sssi', $nombre, $apellidos, $nacionalidad, $id);
        $stmt->execute();
        $stmt->close();
    }
    
    public function listar(){
        $sql = "SELECT * FROM $this->tabla";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $autores = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $autores;
    }
    
    public function getAutor($id){
        $sql = "SELECT * FROM $this->tabla WHERE idAutor = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $autor = $result->fetch_assoc();
        $stmt->close();
        return $autor;
    }

    public function getAutorIdByName($nombre){
        $sql = "SELECT idAutor FROM autores WHERE Nombre = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('s', $nombre);
        $stmt->execute();
        $result = $stmt->get_result();
        $autor = $result->fetch_assoc();
        $stmt->close();
        return $autor;
    }
}
?>