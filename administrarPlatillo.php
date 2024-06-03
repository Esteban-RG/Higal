<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Platillo</title>

</head>
<body>
    <h1>Registro de Platillo</h1>
    <form action="controller/platillosDAO.php" method="post" enctype="multipart/form-data">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required></textarea>

        <label for="precio">Precio:</label>
        <input type="number" step="0.01" id="precio" name="precio" required>

        <label for="idCategoria">Categoría:</label>
        <select id="idCategoria" name="idCategoria" required>
            <option value="">Seleccione una categoría</option>
            <?php
            include 'controller/conexion.php';
            $sql = "SELECT idCategoria, nombre FROM Categoria";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["idCategoria"] . "'>" . $row["nombre"] . "</option>";
                }
            } else {
                echo "<option value=''>No hay categorías disponibles</option>";
            }
            $conn->close();
            ?>
        </select>

        <label for="imagen">Imagen:</label>
        <input type="file" id="imagen" name="imagen" accept="image/*" required>

        <input type="hidden" name="action" value="insert">
        <input type="submit" value="Registrar Platillo">
    </form>

    <h2>Lista de Platillos</h2>
    <table>
        <thead>
            <tr>
                <th>ID de Platillo</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Categoría</th>
                <th>Administrador</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
                include 'controller/conexion.php';

                $sql = "SELECT p.idPlatillo, p.nombre, p.descripcion, p.precio, c.nombre AS categoria, a.nombre AS administrador, p.imagen 
                        FROM Platillo p
                        JOIN Categoria c ON p.idCategoria = c.idCategoria
                        JOIN Administrador a ON p.idAdministrador = a.idAdministrador";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo 
                        "<tr>
                            <td>" . $row["idPlatillo"]. "</td>
                            <td>" . $row["nombre"]. "</td>
                            <td>" . $row["descripcion"]. "</td>
                            <td>" . $row["precio"]. "</td>
                            <td>" . $row["categoria"]. "</td>
                            <td>" . $row["administrador"]. "</td>
                            <td><img src='" . $row["imagen"] . "' alt='Imagen de " . $row["nombre"] . "' style='width: 100px;'></td>
                            <td>
                                <form action='controller/platillosDAO.php' method='post'>
                                    <input type='hidden' name='idPlatillo' value='" . $row["idPlatillo"] . "'>
                                    <input type='hidden' name='action' value='delete'>
                                    <input type='submit' value='Eliminar'>
                                </form>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No hay platillos disponibles</td></tr>";
                }

                $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>
