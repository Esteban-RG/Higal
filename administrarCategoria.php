<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Categoria</title>
</head>
<body>
    <form action="controller/categoriasDAO.php" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        <input type="hidden" id="action" name="action" value="insert">
        <input type="submit" value="Agregar Categoria">
    </form>

    <h2>Lista de Categorias</h2>
    <table>
        <thead>
            <tr>
                <th>ID de Categoria</th>
                <th>Nombres</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php

                include 'controller/conexion.php';

                $sql = "SELECT idCategoria, nombre FROM Categoria";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo 
                        "<tr>
                        <td>" . $row["idCategoria"]. "</td>
                        <td>" . $row["nombre"]. "</td>
                        <td>
                        <form action='controller/categoriasDAO.php' method='post'>
                            <input type='hidden' name='idCategoria' value='" . $row["idCategoria"] . "'>
                            <input type='hidden' name='action' value='delete'>
                            <input type='submit' value='Eliminar'>
                        </form>
                        <form action='controller/categoriasDAO.php' method='post'>
                            <input type='hidden' name='idCategoria' value='" . $row["idCategoria"] . "'>
                            <input type='hidden' name='action' value='update'>
                            <input type='submit' value='Editar'>
                        </form>
                       </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No hay categorias disponibles</td></tr>";
                }

                $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>
