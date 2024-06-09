
<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $action = $_POST['action'];

    if($action == 'insert'){

        $asientos = $_POST['asientos'];

        $sql = "INSERT INTO Mesa (asientos) VALUES (?)";

        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $asientos);
            if ($stmt->execute()) {
                echo "Mesa agregada correctamente";
                header('Location: ../admMesa.php?insert=true');
                exit;
            } else {
                echo "Error al ejecutar la consulta: " . $stmt->error;
                header('Location: ../admMesa.php?insert=false');
                exit;
            }
            $stmt->close();
        } else {
            echo "Error al preparar la consulta: " . $conn->error;
        }

    }else if ($action == 'update') {
        echo "Accion no implementada";
       
    }else if ($action == 'delete') {

        $idMesa = intval($_POST['idMesa']);

        $conn->begin_transaction();

        try {
            $sql_eliminar = "DELETE FROM Mesa WHERE idMesa=?";
            $stmt = $conn->prepare($sql_eliminar);
            if ($stmt) {
                $stmt->bind_param("i", $idMesa);
                if ($stmt->execute()) {
                    echo "Mesa eliminada correctamente.";
                    $conn->commit();
                    header('Location: ../admMesa.php?delete=true');
                    exit; 
                } else {
                    throw new Exception("Error al eliminar la mesa: " . $stmt->error);
                }
                $stmt->close();
            } else {
                throw new Exception("Error al preparar la consulta: " . $conn->error);
            }
        } catch (Exception $e) {
            $conn->rollback(); // Revertir la transacción
            if ($conn->errno == 1451) {
                echo "No se puede eliminar la mesa porque está siendo referenciada en otra tabla.";
                header('Location: ../admMesa.php?delete=false');
                exit;
            } else {
                echo "Esta mesa no puede ser eliminada ".$e->getMessage();
                header('Location: ../admMesa.php?delete=false');
                exit;
            }
        }
    }

    

    $conn->close();
} else {
    echo "Método de solicitud no permitido.";
}
?>
