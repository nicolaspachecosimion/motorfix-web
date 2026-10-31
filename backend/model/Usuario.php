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
}
?>