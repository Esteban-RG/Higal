
<?php
include 'conexion.php';
include 'validaciones.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $action = $_POST['action'];

    if($action == 'insert'){

        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];

        $errores = [];

        if (!validateName($nombre)) {
            $errores[] = "El nombre no debe contener números.";
        }else if (!validateEmail($correo)) {
            $errores[] = "Por favor, introduce un email válido.";
        }
    

        if (empty($errores)) {
           
            $sql_insert = "INSERT INTO Cliente (nombre, correo) VALUES (?, ?)";
            if ($stmt = $conn->prepare($sql_insert)) {
                $stmt->bind_param("ss", $nombre,$correo);
                if ($stmt->execute()) {
                    echo "Cliente registrado correctamente.";
                    header('Location: ../admCliente.php?insert=true');
                    exit;
                } else {
                    echo "Error al registrar el cliente: " . $stmt->error;
                    header('Location: ../admCliente.php?insert=false');
                    exit;
                }
                $stmt->close();
            } else {
                echo "Error al preparar la consulta: " . $conn->error;
            }
        } else {
            $errorString = implode(", ", $errores);
            header("Location: ../admCliente.php?insert=false&errors=" . urlencode($errorString));
        }

    }else if ($action == 'update') {
        echo "Accion no implementada";
       
    }else if ($action == 'delete') {

        $idCliente = intval($_POST['idCliente']);

        $conn->begin_transaction();

        try {
            $sql_eliminar = "DELETE FROM Cliente WHERE idCliente=?";
            $stmt = $conn->prepare($sql_eliminar);
            if ($stmt) {
                $stmt->bind_param("i", $idCliente);
                if ($stmt->execute()) {
                    echo "Cliente eliminada correctamente.";
                    $conn->commit(); 
                    header('Location: ../admCliente.php?delete=true');
                    exit;
                } else {
                    throw new Exception("Error al eliminar la Cliente: " . $stmt->error);
                }
                $stmt->close();
            } else {
                throw new Exception("Error al preparar la consulta: " . $conn->error);
            }
        } catch (Exception $e) {
            $conn->rollback(); 
            if ($conn->errno == 1451) {
                echo "No se puede eliminar el Cliente porque está siendo referenciada en otra tabla.";
                header('Location: ../admCliente.php?delete=false');
                exit;
            } else {
                echo "Esta Cliente no puede ser eliminada ".$e->getMessage();
                header('Location: ../admCliente.php?delete=false');
                exit;
            }
        }
    }

    

    $conn->close();
} else {
    echo "Método de solicitud no permitido.";
}
?>
