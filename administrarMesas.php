<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Mesa</title>
</head>
<body>
    <form action="controller/mesasDAO.php" method="post">
        <label for="asientos">Número de Asientos:</label>
        <input type="number" id="asientos" name="asientos" required>
        <input type="hidden" id="action" name="action" value="insert">
        <input type="submit" value="Agregar Mesa">
    </form>

    <h2>Lista de Mesas</h2>
    <table>
        <thead>
            <tr>
                <th>ID de Mesa</th>
                <th>Asientos</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php

                include 'controller/conexion.php';

                $sql = "SELECT idMesa, asientos FROM Mesa";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo 
                        "<tr>
                        <td>" . $row["idMesa"]. "</td>
                        <td>" . $row["asientos"]. "</td>
                        <td>
                        <form action='controller/mesasDAO.php' method='post' style='display:inline;'>
                            <input type='hidden' name='idMesa' value='" . $row["idMesa"] . "'>
                            <input type='hidden' name='action' value='delete'>
                            <input type='submit' value='Eliminar'>
                        </form>
                       </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No hay mesas disponibles</td></tr>";
                }

                $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>
