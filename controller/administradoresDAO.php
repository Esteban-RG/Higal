
<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $action = $_POST['action'];

    if($action == 'insert'){

        $nombre = $_POST['nombre'];
        $apPaterno = $_POST['apPaterno'];
        $apMaterno = $_POST['apMaterno'];
        $contrasenha = password_hash($_POST['contrasenha'], PASSWORD_DEFAULT); // Encriptar la contraseña
    
        $sql_insert = "INSERT INTO Administrador (nombre, apPaterno, apMaterno, contrasenha) VALUES (?, ?, ?, ?)";
        if ($stmt = $conn->prepare($sql_insert)) {
            $stmt->bind_param("ssss", $nombre, $apPaterno, $apMaterno, $contrasenha);
            if ($stmt->execute()) {
                echo "Administrador registrado correctamente.";
            } else {
                echo "Error al registrar el administrador: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error al preparar la consulta: " . $conn->error;
        }

    }else if ($action == 'update') {
        echo "Accion no implementada";
       
    }else if ($action == 'delete') {

        $idAdministrador = intval($_POST['idAdministrador']);

        $conn->begin_transaction();

        try {
            $sql_eliminar = "DELETE FROM Administrador WHERE idAdministrador=?";
            $stmt = $conn->prepare($sql_eliminar);
            if ($stmt) {
                $stmt->bind_param("i", $idAdministrador);
                if ($stmt->execute()) {
                    echo "Administrador eliminada correctamente.";
                    $conn->commit(); 
                } else {
                    throw new Exception("Error al eliminar la Administrador: " . $stmt->error);
                }
                $stmt->close();
            } else {
                throw new Exception("Error al preparar la consulta: " . $conn->error);
            }
        } catch (Exception $e) {
            $conn->rollback(); // Revertir la transacción
            if ($conn->errno == 1451) {
                echo "No se puede eliminar el Administrador porque está siendo referenciada en otra tabla.";
            } else {
                echo "Esta Administrador no puede ser eliminada ".$e->getMessage();
            }
        }
    }

    

    $conn->close();
} else {
    echo "Método de solicitud no permitido.";
}
?>
