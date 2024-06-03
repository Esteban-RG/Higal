<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Administradores</title>
    
</head>
<body>
    <h1>Registro de Administradores</h1>
    <form action="controller/administradoresDAO.php" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="apPaterno">Apellido Paterno:</label>
        <input type="text" id="apPaterno" name="apPaterno" required>

        <label for="apMaterno">Apellido Materno:</label>
        <input type="text" id="apMaterno" name="apMaterno" required>

        <label for="contrasenha">Contraseña:</label>
        <input type="password" id="contrasenha" name="contrasenha" required>

        <input type="hidden" name="action" value="insert">
        <input type="submit" value="Registrar Admin">
    </form>

    <h2>Lista de Administradores</h2>
    <table>
        <thead>
            <tr>
                <th>ID de Administrador</th>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
                include 'controller/conexion.php';

                $sql = "SELECT idAdministrador, nombre, apPaterno, apMaterno FROM Administrador";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo 
                        "<tr>
                            <td>" . $row["idAdministrador"]. "</td>
                            <td>" . $row["nombre"]. "</td>
                            <td>" . $row["apPaterno"]. "</td>
                            <td>" . $row["apMaterno"]. "</td>
                            <td>
                                <form action='controller/administradoresDAO.php' method='post'>
                                    <input type='hidden' name='idAdministrador' value='" . $row["idAdministrador"] . "'>
                                    <input type='hidden' name='action' value='delete'>
                                    <input type='submit' value='Eliminar'>
                                </form>
                                <form action='controller/administradoresDAO.php' method='post'>
                                    <input type='hidden' name='idAdministrador' value='" . $row["idAdministrador"] . "'>
                                    <input type='hidden' name='action' value='update'>
                                    <input type='submit' value='Editar'>
                                </form>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No hay administradores disponibles</td></tr>";
                }

                $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>
