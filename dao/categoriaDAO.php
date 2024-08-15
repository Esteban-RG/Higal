<?php
require_once 'Database.php';

class CategoriaDAO
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    public function insertarCategoria($nombre)
    {
        try {
            $sql = "INSERT INTO categoria (nombre) VALUES (:nombre)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function actualizarCategoria($idCategoria, $nombre)
    {
        try {
            $sql = "UPDATE categoria SET nombre = :nombre WHERE idCategoria = :idCategoria";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':idCategoria', $idCategoria);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


    public function eliminarCategoria($idCategoria)
    {
        try {
            $sql = "DELETE FROM categoria WHERE idCategoria = :idCategoria";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':idCategoria', $idCategoria);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function obtenerCategorias()
    {
        try {
            $sql = "SELECT * FROM categoria";
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
