<?php
require_once 'Database.php';

class MesaDAO
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    public function insertarMesa($idMesa, $asientos)
    {
        try {
            $sql = "INSERT INTO mesa (idMesa, asientos) VALUES (:idMesa, :asientos)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':idMesa', $idMesa);
            $stmt->bindParam(':asientos', $asientos);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function actualizarMesa($idMesa, $asientos)
    {
        try {
            $sql = "UPDATE mesa SET asientos = :asientos WHERE idMesa = :idMesa";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':asientos', $asientos);
            $stmt->bindParam(':idMesa', $idMesa);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


    public function eliminarMesa($idMesa)
    {
        try {
            $sql = "DELETE FROM mesa WHERE idMesa = :idMesa";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':idMesa', $idMesa);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function obtenerMesas()
    {
        try {
            $sql = "SELECT * FROM mesa";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $datos;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
