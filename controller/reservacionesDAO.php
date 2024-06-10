<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $action = $_POST['action'];

    if($action == 'insert'){
        // Obtener datos del formulario
        $fecha = $conn->real_escape_string($_POST['fecha']);
        $cantPersonas = intval($_POST['cantPersonas']);
        $nombre = $conn->real_escape_string($_POST['name']);
        $correo = $conn->real_escape_string($_POST['email']);

        $idCliente = null;

        // Preparar y ejecutar la consulta SQL para verificar si el correo ya está registrado
        $sql_check = "SELECT idCliente FROM Cliente WHERE correo = ?";
        if ($stmt_check = $conn->prepare($sql_check)) {
            $stmt_check->bind_param("s", $correo);
            $stmt_check->execute();
            $stmt_check->store_result();
            
            if ($stmt_check->num_rows > 0) {
                // El correo ya está registrado, obtener el ID del cliente
                $stmt_check->bind_result($idCliente);
                $stmt_check->fetch();
            } else {
                // Preparar y ejecutar la consulta SQL para insertar un nuevo cliente
                $sql_insert = "INSERT INTO Cliente (nombre, correo) VALUES (?, ?)";
                if ($stmt_insert = $conn->prepare($sql_insert)) {
                    $stmt_insert->bind_param("ss", $nombre, $correo);
                    if ($stmt_insert->execute()) {
                        // Obtener el ID del cliente recién insertado
                        $idCliente = $stmt_insert->insert_id;
                    } else {
                        echo "Error al registrar el cliente: " . $stmt_insert->error;
                        exit();
                    }
                    $stmt_insert->close();
                } else {
                    echo "Error al preparar la consulta: " . $conn->error;
                    exit();
                }
            }
            $stmt_check->close();
        } else {
            echo "Error al preparar la consulta: " . $conn->error;
            exit();
        }

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
                $stmt_reservacion->bind_param("siis", $fecha, $cantPersonas, $idMesa, $idCliente);

                if ($stmt_reservacion->execute()) {
                    echo "Reservación agregada correctamente.";
                    header('Location: ../admReservacion.php?insert=true');
                    exit;
                } else {
                    echo "Error al agregar la reservación: " . $stmt_reservacion->error;
                    header('Location: ../admReservacion.php?insert=false');
                    exit;
                }

                $stmt_reservacion->close();
                } else {
                    echo "Error al preparar la consulta: " . $conn->error;
                }
            } else {
                echo "Error al preparar la consulta para buscar la mesa: " . $conn->error;
        }
                    
    }else if($action == 'insertClient'){
        // Obtener datos del formulario
        $fecha = $conn->real_escape_string($_POST['fecha']);
        $cantPersonas = intval($_POST['cantPersonas']);
        $nombre = $conn->real_escape_string($_POST['name']);
        $correo = $conn->real_escape_string($_POST['email']);

        $idCliente = null;

        // Preparar y ejecutar la consulta SQL para verificar si el correo ya está registrado
        $sql_check = "SELECT idCliente FROM Cliente WHERE correo = ?";
        if ($stmt_check = $conn->prepare($sql_check)) {
            $stmt_check->bind_param("s", $correo);
            $stmt_check->execute();
            $stmt_check->store_result();
            
            if ($stmt_check->num_rows > 0) {
                // El correo ya está registrado, obtener el ID del cliente
                $stmt_check->bind_result($idCliente);
                $stmt_check->fetch();
            } else {
                // Preparar y ejecutar la consulta SQL para insertar un nuevo cliente
                $sql_insert = "INSERT INTO Cliente (nombre, correo) VALUES (?, ?)";
                if ($stmt_insert = $conn->prepare($sql_insert)) {
                    $stmt_insert->bind_param("ss", $nombre, $correo);
                    if ($stmt_insert->execute()) {
                        // Obtener el ID del cliente recién insertado
                        $idCliente = $stmt_insert->insert_id;
                    } else {
                        echo "Error al registrar el cliente: " . $stmt_insert->error;
                        exit();
                    }
                    $stmt_insert->close();
                } else {
                    echo "Error al preparar la consulta: " . $conn->error;
                    exit();
                }
            }
            $stmt_check->close();
        } else {
            echo "Error al preparar la consulta: " . $conn->error;
            exit();
        }

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
                $stmt_reservacion->bind_param("siis", $fecha, $cantPersonas, $idMesa, $idCliente);

                if ($stmt_reservacion->execute()) {
                    echo "Reservación agregada correctamente.";
                    header('Location: ../index.php?reservation=true');
                    exit;
                } else {
                    echo "Error al agregar la reservación: " . $stmt_reservacion->error;
                    exit;
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
                header('Location: ../admReservacion.php?update=true');
                exit;
            } else {
                echo "Error al confirmar la reservación: " . $stmt->error;
                header('Location: ../admReservacion.php?update=flase');
                exit;
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
                header('Location: ../admReservacion.php?delete=true');
                exit;
            } else {
                echo "Error al eliminar la reservación: " . $stmt->error;
                header('Location: ../admReservacion.php?delete=false');
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
