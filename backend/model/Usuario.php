<?php
require_once 'Conexion.php';

class Usuario {
    private $conexion;
    
    private $id_usuario;
    private $email;
    private $password_hash;
    private $rol;
    private $auth_key;
    private $fecha_inicio_auth;
    private $fecha_fin_auth;

    public function __construct() {
        $this->conexion = Conexion::getInstancia();
    }

    // Método para verificar credenciales y generar el token de sesión
    public function registrar($email, $password, $rol) {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO Usuario (email, password_hash, rol) VALUES (:email, :password_hash, :rol)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password_hash', $passwordHash);
        $stmt->bindParam(':rol', $rol);
        return $stmt->execute();
    }

    // Método para verificar credenciales y generar el token de sesión
    public function login($email, $password) {
        $sql = "SELECT id_usuario, password_hash, rol FROM Usuario WHERE email = :email";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // password_verify compara la contraseña con el hash de la base de datos
        if ($usuario && password_verify($password, $usuario['password_hash'])) {

            // Generamos el token y establecemos la fecha de caducidad (24 horas)
            $auth_key = bin2hex(random_bytes(32));
            $fecha_inicio = date('Y-m-d H:i:s');
            $fecha_fin = date('Y-m-d H:i:s', strtotime('+24 hours'));

            // Guardamos el token y las fechas en el registro del usuario
            $sqlUpdate = "UPDATE Usuario SET auth_key = :auth_key, fecha_inicio_auth = :fecha_inicio, fecha_fin_auth = :fecha_fin WHERE id_usuario = :id";
            $stmtUpdate = $this->conexion->prepare($sqlUpdate);
            $stmtUpdate->execute([
                ':auth_key' => $auth_key,
                ':fecha_inicio' => $fecha_inicio,
                ':fecha_fin' => $fecha_fin,
                ':id' => $usuario['id_usuario']
            ]);

            // Devolvemos el token
            return [
                'status' => true, 
                'auth_key' => $auth_key, 
                'rol' => $usuario['rol']
            ];
        }
        
        return ['status' => false];
    }

    // Método para modificar los datos de un usuario existente
    public function actualizar($id, $email, $rol) {
        $sql = "UPDATE Usuario SET email = :email, rol = :rol WHERE id_usuario = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':rol', $rol);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }

    // Método para eliminar un usuario del sistema
    public function borrar($id) {
        $sql = "DELETE FROM Usuario WHERE id_usuario = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }
}
?>