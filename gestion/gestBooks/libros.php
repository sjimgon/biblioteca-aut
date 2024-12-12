<?php
class libros{
    protected $conexion;
    protected $tabla;
    
 public function __construct($conexion, $tabla){
     $this->conexion = $conexion;
     $this->tabla = $tabla;
   
 }   
    public function insertar($titulo, $genero, $autor, $nPaginas, $nEjemplares){
        $sql = "INSERT INTO $this->tabla (Titulo, Genero, idAutor, NumeroPaginas, NumeroEjemplares) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('ssiii', $titulo, $genero, $autor, $nPaginas, $nEjemplares);
        if ($stmt->execute() === false) {
            echo "Error al insertar el libro: " . $stmt->error;
            return false;
        }
        $last_id = $stmt->insert_id;
        return $last_id;
    }
    public function borrar($id){
        $sql = "DELETE FROM $this->tabla WHERE idAutor = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }

    public function actualizar($id, $titulo, $genero, $autor, $nPaginas, $nEjemplares){
        $sql = "UPDATE $this->tabla SET Titulo = ?, Genero = ?, idAutor = ?, NumeroPaginas = ?, NumeroEjemplares = ? WHERE idAutor = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('ssiiii', $titulo, $genero, $id, $nPaginas, $nEjemplares, $id);
        if ($stmt->execute() === false) {
            echo "Error al actualizar el libro";
        }
        $stmt->close();
    }

    public function listar(){
        $sql = "SELECT * FROM $this->tabla";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $rows;
    }
    
    public function getLibro($id){
        $sql = "SELECT * FROM $this->tabla WHERE idAutor = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $libro = $result->fetch_assoc();
        $stmt->close();
        return $libro;
    }
}
?>
