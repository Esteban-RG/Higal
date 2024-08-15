<?php
require_once 'Database.php';

class ClienteDAO
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    public function insertarCliente($nombre, $correo)
    {
        try {
            $sql = "INSERT INTO cliente (nombre, correo) VALUES (:nombre, :correo)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':correo', $correo);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function actualizarCliente($idCliente, $nombre, $correo)
    {
        try {
            $sql = "UPDATE cliente SET nombre = :nombre, correo = :correo WHERE idCliente = :idCliente";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':idCliente', $idCliente);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


    public function eliminarCliente($idCliente)
    {
        try {
            $sql = "DELETE FROM cliente WHERE idCliente = :idCliente";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':idCliente', $idCliente);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function obtenerClientes()
    {
        try {
            $sql = "SELECT idCliente, nombre, correo FROM cliente";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $datos;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function buscarCorreo($correo)
    {
        try {
            $sql = "SELECT idCliente FROM cliente WHERE correo = :correo";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':correo', $correo);
            $stmt->execute();
            $datos = $stmt->fetch(PDO::FETCH_ASSOC);
            return $datos;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function obtenerID($correo, $nombre)
    {
        try {
            $sql = "SELECT idCliente FROM cliente WHERE correo = :correo AND nombre = :nombre";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->execute();
            $datos = $stmt->fetch(PDO::FETCH_ASSOC);

            return $datos;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
