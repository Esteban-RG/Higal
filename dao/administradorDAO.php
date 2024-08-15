<?php
require_once 'Database.php';

class AdministradorDAO
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    public function insertarAdministrador($nombre, $apPaterno, $apMaterno, $pass)
    {
        try {
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO administrador (nombre, apPaterno, apMaterno, contrasenha) VALUES (:nombre, :apPaterno, :apMaterno, :contrasenha)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apPaterno', $apPaterno);
            $stmt->bindParam(':apMaterno', $apMaterno);
            $stmt->bindParam(':contrasenha', $hash);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function actualizarAdministrador($idAdministrador, $nombre, $apPaterno, $apMaterno)
    {
        try {
            $sql = "UPDATE administrador SET nombre = :nombre, apPaterno = :apPaterno, apMaterno = :apMaterno WHERE idAdministrador = :idAdministrador";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apPaterno', $apPaterno);
            $stmt->bindParam(':apMaterno', $apMaterno);
            $stmt->bindParam(':idAdministrador', $idAdministrador);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function actualizarContraseña($idAdministrador, $pass)
    {
        try {
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "UPDATE administrador SET contrasenha = :contrasenha WHERE idAdministrador = :idAdministrador";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':contrasenha', $hash);
            $stmt->bindParam(':idAdministrador', $idAdministrador);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function eliminarAdministrador($idAdministrador)
    {
        try {
            $sql = "DELETE FROM administrador WHERE idAdministrador = :idAdministrador";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':idAdministrador', $idAdministrador);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function obtenerAdministradores()
    {
        try {
            $sql = "SELECT idAdministrador, nombre, apPaterno, apMaterno FROM administrador";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $administradores = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $administradores;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


    public function autenticarAdministrador($idAdministrador, $pass)
    {
        try {
            $sql = "SELECT * FROM administrador WHERE idAdministrador = :idAdministrador";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':idAdministrador', $idAdministrador);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                if (password_verify($pass, $result['contrasenha'])) {
                    session_start();
                    $_SESSION['idAdministrador'] = $idAdministrador;
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
