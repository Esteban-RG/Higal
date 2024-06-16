
<?php
include 'conexion.php';
include 'validaciones.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $action = $_POST['action'];

    if($action == 'insert'){

        $nombre = $_POST['nombre'];
        $apPaterno = $_POST['apPaterno'];
        $apMaterno = $_POST['apMaterno'];
        $contrasenha = password_hash($_POST['contrasenha'], PASSWORD_DEFAULT);

        $errores = [];

        if (!validateName($nombre)) {
            $errores[] = "El nombre no debe contener números.";
        }else if (!validateName($apPaterno)) {
            $errores[] = "Los apellidos no deben contener números.";
        }else if (!validateName($apMaterno)) {
            $errores[] = "Los apellidos no deben contener números.";


        }
        if (empty($errores)) {

            $sql_insert = "INSERT INTO Administrador (nombre, apPaterno, apMaterno, contrasenha) VALUES (?, ?, ?, ?)";
            if ($stmt = $conn->prepare($sql_insert)) {
                $stmt->bind_param("ssss", $nombre, $apPaterno, $apMaterno, $contrasenha);
                if ($stmt->execute()) {
                    echo "Administrador registrado correctamente.";
                    header('Location: ../admAdmin.php?insert=true');
                    exit;
                } else {
                    echo "Error al registrar el administrador: " . $stmt->error;
                    header('Location: ../admAdmin.php?insert=false');
                    exit;
                }
                $stmt->close();
            } else {
                echo "Error al preparar la consulta: " . $conn->error;
            }
        } else {
            $errorString = implode(", ", $errores);
            header("Location: ../admAdmin.php?insert=false&errors=" . urlencode($errorString));
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
                    header('Location: ../admAdmin.php?delete=true');
                    exit;
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
                header('Location: ../admAdmin.php?delete=false');
                exit;
            } else {
                echo "Esta Administrador no puede ser eliminada ".$e->getMessage();
                header('Location: ../admAdmin.php?delete=false');
                exit;
            }
        }
    }

    

    $conn->close();
} else {
    echo "Método de solicitud no permitido.";
}
?>
