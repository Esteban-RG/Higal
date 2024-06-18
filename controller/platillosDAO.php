
<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $action = $_POST['action'];

    if($action == 'insert'){

        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $precio = floatval($_POST['precio']);
        $idCategoria = intval($_POST['idCategoria']);
    
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $nombreArchivo = $_FILES['imagen']['name'];
            $tipoArchivo = $_FILES['imagen']['type'];
            $tamanioArchivo = $_FILES['imagen']['size'];
            $tempArchivo = $_FILES['imagen']['tmp_name'];
            $rutaSubida = 'uploads/' . basename($nombreArchivo);
    
            if (!file_exists('../uploads')) {
                mkdir('../uploads', 0777, true);
            }
    
            if (move_uploaded_file($tempArchivo, "../".$rutaSubida)) {
                $sql_insert = "INSERT INTO Platillo (nombre, descripcion, precio, idCategoria, idAdministrador, imagen, visibilidad) VALUES (?, ?, ?, ?, 1, ?,0)";
                if ($stmt = $conn->prepare($sql_insert)) {
                    $stmt->bind_param("ssdis", $nombre, $descripcion, $precio, $idCategoria, $rutaSubida);
                    if ($stmt->execute()) {
                        echo "Platillo registrado correctamente.";
                        header('Location: ../admPlatillo.php?insert=true');
                        exit;
                    } else {
                        echo "Error al registrar el platillo: " . $stmt->error;
                        header('Location: ../admPlatillo.php?insert=false');
                        exit;
                    }
                    $stmt->close();
                } else {
                    echo "Error al preparar la consulta: " . $conn->error;
                }
            } else {
                echo "Error al mover el archivo subido.";
            }
        } else {
            echo "Error en la subida del archivo.";
        }
        

    }else if ($action == 'update') {
        echo "Accion no implementada";
       
    }else if ($action == 'delete') {

        $idPlatillo = intval($_POST['idPlatillo']);

        $conn->begin_transaction();

        try {
            $sql_eliminar = "DELETE FROM Platillo WHERE idPlatillo=?";
            $stmt = $conn->prepare($sql_eliminar);
            if ($stmt) {
                $stmt->bind_param("i", $idPlatillo);
                if ($stmt->execute()) {
                    echo "Platillo eliminada correctamente.";
                    $conn->commit();
                    header('Location: ../admPlatillo.php?delete=true');
                    exit; 
                } else {
                    throw new Exception("Error al eliminar la Platillo: " . $stmt->error);
                }
                $stmt->close();
            } else {
                throw new Exception("Error al preparar la consulta: " . $conn->error);
            }
        } catch (Exception $e) {
            $conn->rollback(); // Revertir la transacción
            if ($conn->errno == 1451) {
                echo "No se puede eliminar el Platillo porque está siendo referenciada en otra tabla.";
                header('Location: ../admPlatillo.php?delete=false');
                exit;
            } else {
                echo "Esta Platillo no puede ser eliminada ".$e->getMessage();
                header('Location: ../admPlatillo.php?delete=false');
                exit;
            }
        }
    }else if ($action == 'update_visibility') {

        $idPlatillo = intval($_POST['idPlatillo']);
        $visibility = isset($_POST['visibilidad']) ? 1 : 0;
        
        $sql_confirmar = "UPDATE Platillo SET visibilidad=? WHERE idPlatillo=?";
        $stmt = $conn->prepare($sql_confirmar);
        if ($stmt) {
            $stmt->bind_param("ii",$visibility,$idPlatillo);
            if ($stmt->execute()) {
                echo "Se cambio la visibilidad correctamente";
                header('Location: ../admPlatillo.php?update=true');
                exit;
            } else {
                echo "Se cambio la visibilidad correctamente" . $stmt->error;
                header('Location: ../admPlatillo.php?update=flase');
                exit;
            }
            $stmt->close();
        } else {
            echo "Error al preparar la consulta: " . $conn->error;
        }
    }

    

    $conn->close();
} else {
    echo "Método de solicitud no permitido.";
}
?>
