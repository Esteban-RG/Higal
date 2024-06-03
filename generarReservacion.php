<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Reservación</title>
</head>
<body>
    <h2>Generar Reservación</h2>
    <form action="controller/reservacionesDAO.php" method="post">
        <label for="fecha">Fecha y Hora:</label><br>
        <input type="datetime-local" id="fecha" name="fecha" required><br><br>

        <label for="cantPersonas">Cantidad de Personas:</label><br>
        <input type="number" id="cantPersonas" name="cantPersonas" min="1" required><br><br>

        <input type="hidden" id="action" name="action" value="insert" >

        <input type="submit" value="Generar Reservación">
    </form>
</body>
</html>
