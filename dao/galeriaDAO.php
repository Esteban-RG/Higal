<?php
require_once 'Database.php';

class GaleriaDAO
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    public function insertarImagen($nombre, $ruta)
    {
        try {
            $sql = "INSERT INTO galeria (nombre, ruta) 
            VALUES (:nombre, :ruta)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':ruta', $ruta);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


    public function actualizarImagen($idImagen,$nombre, $ruta)
    {
        try {
            $sql = "UPDATE galeria SET ruta = :ruta, nombre = :nombre
            WHERE idImagen = :idImagen";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':ruta', $ruta);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':idImagen', $idImagen);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


    public function eliminarImagen($idImagen)
    {
        try {
            $sql = "DELETE FROM galeria  WHERE idImagen = :idImagen";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':idImagen', $idImagen);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function obtenerImagenes()
    {
        try {
            $sql = "SELECT * FROM galeria";
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
