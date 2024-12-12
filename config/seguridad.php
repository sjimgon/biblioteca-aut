<?php
/** Clase para implementar la seguridad de acceso a partes de una AW
 *haremos uso de sesiones php, Credenciales de BD, y Roles de sistema.
 *
 */
  class Seguridad{
    private $session;
    private $user;
    private $conexion;
    private $rol;

    public function __construct($conexion) {
        $this->conexion = $conexion;
        $this->session = false;//Controlamos si existe una sesion abierta
        $this->user = "";
        $this->rol = "";

    session_start();

    }

    public function login($usernameParam, $passwordParam) {
        $username = $this->conexion->real_escape_string($usernameParam);
        $password = $this->conexion->real_escape_string($passwordParam);
    
        $sql = "SELECT * FROM usuarios WHERE login = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $username);  
        $stmt->execute();
        $result = $stmt->get_result(); 
        $user = $result->fetch_assoc();
    
        if ($user) {
            if (password_verify($password.$user['salt'], $user['password'])) { // Comprobamos si la contraseña introducida más el salt almacenado es igual a la contraseña almacenada
                $this->session = true;//Si son correctos, creamos la sesion y le damos los valores
                $this->user = $user['login'];
                $this->rol = $user['rol'];
                $_SESSION['user'] = $user['login'];
                $_SESSION['rol'] = $user['rol'];
                return true;
            } else {
                echo "Contraseña incorrecta.";
            }
        } else {
            echo "Usuario no encontrado.";
        }
        return false;
    }

     public function getUser(){
        return $this->user;
    }

    public function isLogged() {
        return isset($_SESSION['user']);//Comprobamos que dentro de la Sesion existe el usuario/ por lo tanto estará registrado
    }

    public function logout(){
        $this->session = false;
        $this->user = "";
        foreach ($_SESSION as $variable => $valor) {
            unset($_SESSION[$variable]);
        }
    }

    public function isUserAdmin(){
        if($this->isLogged()){
            $userID = $_SESSION['user'];

            // Consultar el rol del usuario desde la base de datos
            $sql = "SELECT * FROM usuarios WHERE id = ? ";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("s",$userID);
            $result = $stmt->execute();

            $users = $result->fetch_assoc();

            foreach($users as $user){
                if($user['rol'] === 'admin'){
                    return true;
                }
                return false;
            }
        }
    }

  }
?>
