<?php
class users{
    private $conexion;
    private $table="usuarios";
    public function __construct($conexion){
        $this->conexion = $conexion;
    }
    public function get_users(){
        $sql = "SELECT * FROM $this->table";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $user = $stmt->get_result();
        $users = array();
        while($row = $user->fetch_assoc()){       
            $users[] = $row;
        }
        return $users;    
    }

    public function get_user($username){
        $sql = "SELECT * FROM $this->table WHERE login = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $user = $stmt->get_result();
        return $user->fetch_assoc();
    }

    public function insert_user($login, $password, $nombre, $apellidos, $rol){
        $login = $this->conexion->real_escape_string($login);
        $password = $this->conexion->real_escape_string($password);
        $nombre = $this->conexion->real_escape_string($nombre);
        $apellidos = $this->conexion->real_escape_string($apellidos);
        $rol = $this->conexion->real_escape_string($rol);
        if ($rol != "administrador" && $rol != "bibliotecario" && $rol != "registrado"){
            $rol = "registrado";
        }

        $salt = random_int(0, 1000000);
        $password = password_hash($password.$salt, PASSWORD_BCRYPT);
        $sql = "INSERT INTO $this->table (login, password, salt, nombre, apellidos, rol) VALUES ('$login', '$password', '$salt', '$nombre', '$apellidos', '$rol')";
        $stmt = $this->conexion->prepare($sql);
        $result = $stmt->execute();
        return $result;
    }

    public function delete_user($id){
        $id = $this->conexion->real_escape_string($id);
        $sql = "DELETE FROM $this->table WHERE login = '$id'";
        $stmt = $this->conexion->prepare($sql);
        $result = $stmt->execute();
        return $result;
    }

   
    public function update_user($login, $password = NULL, $nombre = NULL, $apellidos = NULL, $rol = NULL) {
        if ($password !== NULL && $password !== "") {
            $this->update_password($login, $password);
        }
        if ($nombre !== NULL && $nombre !== "") {
            $this->update_nombre($login, $nombre);
        }
        if ($apellidos !== NULL && $apellidos !== "") {
            $this->update_apellidos($login, $apellidos);
        }
        if ($rol !== NULL && $rol !== "") {
            $this->update_rol($login, $rol);
        }
        return true;
    }

    private function update_password($login, $password) {
        $salt = random_int(0, 1000000);
        $password = password_hash($password . $salt, PASSWORD_DEFAULT);
        $sql = "UPDATE $this->table SET password = ?, salt = ? WHERE login = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('sis', $password, $salt, $login);
        $stmt->execute();
        $stmt->close();
    }

    private function update_nombre($login, $nombre) {
        $sql = "UPDATE $this->table SET nombre = ? WHERE login = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('ss', $nombre, $login);
        $stmt->execute();
        $stmt->close();
    }

    private function update_apellidos($login, $apellidos) {
        $sql = "UPDATE $this->table SET apellidos = ? WHERE login = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('ss', $apellidos, $login);
        $stmt->execute();
        $stmt->close();
    }

    private function update_rol($login, $rol) {
        $sql = "UPDATE $this->table SET rol = ? WHERE login = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('ss', $rol, $login);
        $stmt->execute();
        $stmt->close();
    }
    
}
    ?>