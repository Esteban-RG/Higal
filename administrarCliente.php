<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Clientes</title>

</head>
<body>
    <h2>Lista de Clientes</h2>
    <table>
        <thead>
            <tr>
                <th>ID de Cliente</th>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
                include 'controller/conexion.php';

                // Consulta SQL para obtener los clientees
                $sql = "SELECT idCliente, nombre, apPaterno, apMaterno, correo, telefono FROM Cliente";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo 
                        "<tr>
                            <td>" . $row["idCliente"]. "</td>
                            <td>" . $row["nombre"]. "</td>
                            <td>" . $row["apPaterno"]. "</td>
                            <td>" . $row["apMaterno"]. "</td>
                            <td>" . $row["correo"]. "</td>
                            <td>" . $row["telefono"]. "</td>
                            <td>
                                <form action='controller/clientesDAO.php' method='post'>
                                    <input type='hidden' name='idCliente' value='" . $row["idCliente"] . "'>
                                    <input type='hidden' name='action' value='delete'>
                                    <input type='submit' value='Eliminar'>
                                </form>

                                <form action='controller/clientesDAO.php' method='post'>
                                    <input type='hidden' name='idCliente' value='" . $row["idCliente"] . "'>
                                    <input type='hidden' name='action' value='update'>
                                    <input type='submit' value='Editar'>
                                </form>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No hay clientes disponibles</td></tr>";
                }

                $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>
