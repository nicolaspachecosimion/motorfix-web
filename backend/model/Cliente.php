<?php
require_once 'Conexion.php';

class Cliente {
    private $conexion;
    
    private $id_cliente;
    private $dni;
    private $nombre;
    private $telefono;
    private $id_usuario;

    public function __construct() {
        $this->conexion = Conexion::getInstancia();
    }

    // Método para registrar un nuevo cliente vinculado a su cuenta de usuario
    public function registrar($dni, $nombre, $telefono, $id_usuario) {
        $sql = "INSERT INTO Cliente (dni, nombre, telefono, id_usuario) VALUES (:dni, :nombre, :telefono, :id_usuario)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':dni', $dni);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':id_usuario', $id_usuario);
        
        return $stmt->execute();
    }

    // Método para obtener los datos de un cliente específico por su ID
    public function obtenerCliente($id_cliente) {
        $sql = "SELECT id_cliente, dni, nombre, telefono, id_usuario FROM Cliente WHERE id_cliente = :id_cliente";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para actualizar los datos personales de un cliente
    public function actualizar($id_cliente, $dni, $nombre, $telefono) {
        $sql = "UPDATE Cliente SET dni = :dni, nombre = :nombre, telefono = :telefono WHERE id_cliente = :id_cliente";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':dni', $dni);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':id_cliente', $id_cliente);
        
        return $stmt->execute();
    }

    // Método para eliminar un cliente
    public function borrar($id_cliente) {
        $sql = "DELETE FROM Cliente WHERE id_cliente = :id_cliente";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id_cliente', $id_cliente);
        
        return $stmt->execute();
    }
}
?>