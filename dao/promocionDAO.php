<?php
require_once 'Database.php';

class PromocionDAO
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    public function insertarImagen($ruta)
    {
        try {
            $sql = "INSERT INTO promocion (ruta) 
            VALUES (:ruta)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':ruta', $ruta);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


    public function actualizarImagen($idPromocion, $ruta)
    {
        try {
            $sql = "UPDATE promocion SET ruta = :ruta
            WHERE idPromocion = :idPromocion";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':ruta', $ruta);
            $stmt->bindParam(':idPromocion', $idPromocion);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


    public function eliminarPromocion($idPromocion)
    {
        try {
            $sql = "DELETE FROM promocion  WHERE idPromocion = :idPromocion";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':idPromocion', $idPromocion);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function obtenerImagenes()
    {
        try {
            $sql = "SELECT * FROM promocion";
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
