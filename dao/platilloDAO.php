<?php
require_once 'Database.php';

class PlatilloDAO
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    public function insertarPlatillo($nombre, $descripcion, $precio, $idCategoria, $imagen, $visibilidad)
    {
        try {
            $sql = "INSERT INTO platillo (nombre, descripcion, precio, idCategoria, imagen, visibilidad) 
            VALUES (:nombre, :descripcion, :precio, :idCategoria, :imagen, :visibilidad)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':idCategoria', $idCategoria);
            $stmt->bindParam(':imagen', $imagen);
            $stmt->bindParam(':visibilidad', $visibilidad);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function actualizarPlatillo($idPlatillo, $nombre, $descripcion, $precio, $idCategoria, $visibilidad)
    {
        try {
            $sql = "UPDATE platillo SET nombre = :nombre, descripcion = :descripcion, precio = :precio, idCategoria = :idCategoria, visibilidad = :visibilidad
            WHERE idPlatillo = :idPlatillo";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':idCategoria', $idCategoria);
            $stmt->bindParam(':visibilidad', $visibilidad);
            $stmt->bindParam(':idPlatillo', $idPlatillo);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function actualizarImagen($idPlatillo, $imagen)
    {
        try {
            $sql = "UPDATE platillo SET imagen = :imagen
            WHERE idPlatillo = :idPlatillo";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':imagen', $imagen);
            $stmt->bindParam(':idPlatillo', $idPlatillo);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


    public function eliminarPlatillo($idPlatillo)
    {
        try {
            $sql = "DELETE FROM platillo WHERE idPlatillo = :idPlatillo";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':idPlatillo', $idPlatillo);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function obtenerPlatillos()
    {
        try {
            $sql = "SELECT * FROM platillo";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $datos;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function obtenerPlatillosVisibles()
    {
        try {
            $sql = "SELECT nombre, descripcion, precio, imagen FROM platillo WHERE visibilidad = 1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $datos;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function obtenerPlatillosPCat($nombre)
    {
        try {
            $sql = "SELECT p.imagen,p.nombre,p.descripcion,p.precio,c.nombre as categoria FROM platillo p JOIN categoria c ON p.idCategoria = c.idCategoria WHERE c.nombre = :nombre";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->execute();
            $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $datos;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
