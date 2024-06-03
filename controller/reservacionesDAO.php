<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $action = $_POST['action'];

    if($action == 'insert'){
        $fecha = $conn->real_escape_string($_POST['fecha']);
        $cantPersonas = intval($_POST['cantPersonas']);

        // Buscar la primera mesa disponible con mayor o igual número de asientos que la cantidad de personas
        $sql_mesa = "SELECT idMesa FROM Mesa WHERE asientos >= ? AND idMesa NOT IN (
                        SELECT idMesa FROM Reservacion WHERE estado = 'confirmado'
                    ) ORDER BY asientos ASC LIMIT 1";
        $stmt_mesa = $conn->prepare($sql_mesa);
        if ($stmt_mesa) {
            $stmt_mesa->bind_param("i", $cantPersonas);
            $stmt_mesa->execute();
            $stmt_mesa->bind_result($idMesa);
            $stmt_mesa->fetch();
            $stmt_mesa->close();

            if (!$idMesa) {
                die("No hay mesas disponibles que cumplan con los requisitos.");
            }

            $stmt_reservacion = $conn->prepare("INSERT INTO Reservacion (fecha, cantPersonas, idMesa, idCliente, estado) VALUES (?, ?, ?, ?, 'Pendiente')");
            if ($stmt_reservacion) {

                $idCliente = 1; // Debes reemplazar esto con el idCliente real

                $stmt_reservacion->bind_param("siis", $fecha, $cantPersonas, $idMesa, $idCliente);

                if ($stmt_reservacion->execute()) {
                    echo "Reservación agregada correctamente.";
                } else {
                    echo "Error al agregar la reservación: " . $stmt_reservacion->error;
                }

                $stmt_reservacion->close();
            } else {
                echo "Error al preparar la consulta: " . $conn->error;
            }
        } else {
            echo "Error al preparar la consulta para buscar la mesa: " . $conn->error;
        }
            
    }else if ($action == 'update') {
        $idReservacion = intval($_POST['idReservacion']);
        $estado = $_POST['estado'];

        $sql_confirmar = "UPDATE Reservacion SET estado='Confirmado' WHERE idReservacion=?";
        $stmt = $conn->prepare($sql_confirmar);
        if ($stmt) {
            $stmt->bind_param("i", $idReservacion);
            if ($stmt->execute()) {
                echo "Reservación confirmada correctamente.";
            } else {
                echo "Error al confirmar la reservación: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error al preparar la consulta: " . $conn->error;
        }
       
    }else if ($action == 'delete') {
        $idReservacion = intval($_POST['idReservacion']);

        $sql_eliminar = "DELETE FROM Reservacion WHERE idReservacion=?";
        $stmt = $conn->prepare($sql_eliminar);
        if ($stmt) {
            $stmt->bind_param("i", $idReservacion);
            if ($stmt->execute()) {
                echo "Reservación eliminada correctamente.";
            } else {
                echo "Error al eliminar la reservación: " . $stmt->error;
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
