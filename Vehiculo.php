<?php
require_once 'Conexion.php';

class Vehiculo {
    private $conexion;
    
    private $id_vehiculo;
    private $matricula;
    private $marca;
    private $modelo;
    private $id_cliente;

    public function __construct() {
        $this->conexion = Conexion::getInstancia();
    }

    // Método para registrar un nuevo vehículo asociado a un cliente
    public function registrar($matricula, $marca, $modelo, $id_cliente) {
        $sql = "INSERT INTO Vehiculo (matricula, marca, modelo, id_cliente) VALUES (:matricula, :marca, :modelo, :id_cliente)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':matricula', $matricula);
        $stmt->bindParam(':marca', $marca);
        $stmt->bindParam(':modelo', $modelo);
        $stmt->bindParam(':id_cliente', $id_cliente);
        
        return $stmt->execute();
    }

    // Método para listar todos los vehículos asociados a un cliente
    public function listarVehiculosPorCliente($id_cliente) {
        $sql = "SELECT id_vehiculo, matricula, marca, modelo FROM Vehiculo WHERE id_cliente = :id_cliente";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para modificar los datos de un vehículo
    public function actualizar($id_vehiculo, $matricula, $marca, $modelo) {
        $sql = "UPDATE Vehiculo SET matricula = :matricula, marca = :marca, modelo = :modelo WHERE id_vehiculo = :id_vehiculo";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':matricula', $matricula);
        $stmt->bindParam(':marca', $marca);
        $stmt->bindParam(':modelo', $modelo);
        $stmt->bindParam(':id_vehiculo', $id_vehiculo);
        
        return $stmt->execute();
    }

    // Método para eliminar un vehículo
    public function borrar($id_vehiculo) {
        $sql = "DELETE FROM Vehiculo WHERE id_vehiculo = :id_vehiculo";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id_vehiculo', $id_vehiculo);
        
        return $stmt->execute();
    }
}
?>