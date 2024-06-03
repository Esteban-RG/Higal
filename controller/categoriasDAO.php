
<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $action = $_POST['action'];

    if($action == 'insert'){

        $nombre = $_POST['nombre'];

        $sql = "INSERT INTO Categoria (nombre) VALUES (?)";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $nombre);
            if ($stmt->execute()) {
                echo "Categoria agregada correctamente";
                exit();
            } else {
                echo "Error al ejecutar la consulta: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error al preparar la consulta: " . $conn->error;
        }

    }else if ($action == 'update') {
        echo "Accion no implementada";
       
    }else if ($action == 'delete') {

        $idCategoria = intval($_POST['idCategoria']);

        $conn->begin_transaction();

        try {
            $sql_eliminar = "DELETE FROM Categoria WHERE idCategoria=?";
            $stmt = $conn->prepare($sql_eliminar);
            if ($stmt) {
                $stmt->bind_param("i", $idCategoria);
                if ($stmt->execute()) {
                    echo "Categoria eliminada correctamente.";
                    $conn->commit(); 
                } else {
                    throw new Exception("Error al eliminar la categoria: " . $stmt->error);
                }
                $stmt->close();
            } else {
                throw new Exception("Error al preparar la consulta: " . $conn->error);
            }
        } catch (Exception $e) {
            $conn->rollback(); // Revertir la transacción
            if ($conn->errno == 1451) {
                echo "No se puede eliminar la categoria porque está siendo referenciada en otra tabla.";
            } else {
                echo "Esta categoria no puede ser eliminada ".$e->getMessage();
            }
        }
    }

    

    $conn->close();
} else {
    echo "Método de solicitud no permitido.";
}
?>
