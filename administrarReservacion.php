<?php
include 'controller/conexion.php'; // Incluir el archivo de conexión a la base de datos

$sql_reservaciones = "SELECT r.idReservacion, r.fecha, r.cantPersonas, r.estado, m.idMesa AS mesa, c.nombre AS cliente 
                      FROM Reservacion r
                      JOIN Mesa m ON r.idMesa = m.idMesa
                      JOIN Cliente c ON r.idCliente = c.idCliente";
$result_reservaciones = $conn->query($sql_reservaciones);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista del Administrador - Reservaciones</title>
</head>
<body>
    <h2>Reservaciones</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Cantidad de Personas</th>
            <th>Mesa</th>
            <th>Cliente</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        <?php
        if ($result_reservaciones->num_rows > 0) {
            while($row = $result_reservaciones->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["idReservacion"] . "</td>
                        <td>" . $row["fecha"] . "</td>
                        <td>" . $row["cantPersonas"] . "</td>
                        <td>" . $row["mesa"] . "</td>
                        <td>" . $row["cliente"] . "</td>
                        <td>" . $row["estado"] . "</td>
                        <td>
                            <form action='controller/reservacionesDAO.php' method='post' style='display:inline;'>
                                <input type='hidden' name='idReservacion' value='" . $row["idReservacion"] . "'>
                                <input type='hidden' name='estado' value='confirmar'>
                                <input type='hidden' name='action' value='update'>
                                <input type='submit' value='Confirmar'>
                            </form>
                            <form action='controller/reservacionesDAO.php' method='post' style='display:inline;'>
                                <input type='hidden' name='idReservacion' value='" . $row["idReservacion"] . "'>
                                <input type='hidden' name='action' value='delete'>
                                <input type='submit' value='Eliminar'>
                            </form>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No hay reservaciones.</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</body>
</html>
