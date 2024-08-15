<?php
require_once 'Database.php';

class ReservacionDAO {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance();
    }

    public function insertarReservacion($fecha, $cantPersonas, $idMesa, $idCliente) {
        try {
            $sql = "INSERT INTO reservacion (fecha, cantPersonas, idMesa, idCliente) VALUES (:fecha, :cantPersonas, :idMesa, :idCliente)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':fecha', $fecha);
            $stmt->bindParam(':cantPersonas', $cantPersonas);
            $stmt->bindParam(':idMesa', $idMesa);
            $stmt->bindParam(':idCliente', $idCliente);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function actualizarReservacion($idReservacion,$fecha,$cantPersonas,$idMesa,$idCliente) {
        try {
            $sql = "UPDATE reservacion SET fecha = :fecha, cantPersonas = :cantPersonas, idMesa = :idMesa, idCliente = :idCliente WHERE idReservacion = :idReservacion";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':fecha', $fecha);
            $stmt->bindParam(':cantPersonas', $cantPersonas);
            $stmt->bindParam(':idMesa', $idMesa);
            $stmt->bindParam(':idCliente', $idCliente);
            $stmt->bindParam(':idReservacion', $idReservacion);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function eliminarReservacion($idReservacion) {
        try {
            $sql = "DELETE FROM reservacion WHERE idReservacion = :idReservacion";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':idReservacion', $idReservacion);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function obtenerReservaciones() {
        try {
            $sql = "SELECT r.idReservacion, r.fecha, r.cantPersonas, r.estado, m.idMesa, c.nombre AS cliente, r.idCliente
                      FROM reservacion r
                      JOIN mesa m ON r.idMesa = m.idMesa
                      JOIN cliente c ON r.idCliente = c.idCliente";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(); 
            $reservaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $reservaciones;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function obtenerMesaDisponible($cantPersonas,$fecha) {
        try {
            $sql = "SELECT idMesa 
            FROM mesa 
            WHERE asientos >= :cantPersonas 
            AND idMesa NOT IN (
                SELECT idMesa 
                FROM reservacion 
                WHERE :fecha BETWEEN DATE_SUB(fecha, INTERVAL 2 HOUR) 
                AND DATE_ADD(fecha, INTERVAL 2 HOUR)
            )
            ORDER BY asientos ASC 
            LIMIT 1;";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':cantPersonas', $cantPersonas);
            $stmt->bindParam(':fecha', $fecha);
            $stmt->execute(); 
            $mesa = $stmt->fetch(PDO::FETCH_ASSOC);

            return $mesa;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

}
?>