<?php
session_start();
if (!isset($_SESSION['idAdministrador'])) {
    header("Location: admPanel.php");
    exit();
}
?>

<?php
$insert = isset($_GET['insert']) ? $_GET['insert'] : 'Desconocido';
$delete = isset($_GET['delete']) ? $_GET['delete'] : 'Desconocido';
$update = isset($_GET['update']) ? $_GET['update'] : 'Desconocido';

include 'controller/conexion.php'; 

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
    <title>Administración de la Base de Datos</title>
    <link rel="stylesheet" href="assets/css/adminPanel.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script>
        var insert = <?php echo json_encode($insert); ?>;
        var delet = <?php echo json_encode($delete); ?>;
        var update = <?php echo json_encode($update); ?>;

        if (insert === 'true') {
            Swal.fire({
                icon: "success",
                text: "El elemento se inserto correctamente"
            }).then(() => {
                window.location.href='admReservacion.php';
            });
        }else if(insert === 'false'){
            Swal.fire({
                icon: "error",
                text: "Ocurrió un error al insertar el elemento"
            }).then(() => {
                window.location.href='admReservacion.php';
            });
        }

        if (delet  === 'true') {
            Swal.fire({
                icon: "success",
                text: "El elemento se elimino correctamente"
            }).then(() => {
                window.location.href='admReservacion.php';
            });
        }else if(delet === 'false'){
            Swal.fire({
                icon: "error",
                text: "Ocurrió un error al eliminar el elemento"
            }).then(() => {
                window.location.href='admReservacion.php';
            });
        }
        
        if (update  === 'true') {
            Swal.fire({
                icon: "success",
                text: "El elemento se actualizo correctamente"
            }).then(() => {
                window.location.href='admReservacion.php';
            });
        }else if(update  === 'false'){
            Swal.fire({
                icon: "error",
                text: "Ocurrió un error al actualizar el elemento"
            }).then(() => {
                window.location.href='admReservacion.php';
            });
        }
    </script>
    <div class="container">
        <aside class="sidebar">
            <h2>Tablas</h2>
            <ul>
                <li><a href="admReservacion.php" style="color:blue;">Reservaciones</a></li>
                <li><a href="admPlatillo.php">Platillos</a></li>
                <li><a href="admCliente.php">Clientes</a></li>
                <li><a href="admCategoria.php">Categorias</a></li>
                <li><a href="admMesa.php">Mesas</a></li>
                <li><a href="admAdmin.php">Administradores</a></li>
                <li><a href="controller/sesionKiller.php" style="color:#ff0000;" >Cerrar Sesion</a></li>

            </ul>
        </aside>
        <main class="content">
            <h1>Registro de Reservaciones</h1>
            <button onclick="mostrarFormulario()">Nuevo</button>
            <div class="new" style="display:none;">
                <form action="controller/reservacionesDAO.php" method="POST">
                    <div class="row mb-5">
                        <div class="col-sm-6 col-md-3 col-xs-12 my-2">
                            <input type="text" name="name" class="form-control form-control-lg custom-form-control" placeholder="Nombre" required>
                        </div>
                        <div class="col-sm-6 col-md-3 col-xs-12 my-2">
                            <input type="email" name="email" class="form-control form-control-lg custom-form-control" placeholder="Email" required>
                        </div>
                        <div class="col-sm-6 col-md-3 col-xs-12 my-2">
                            <input type="number" name="cantPersonas" class="form-control form-control-lg custom-form-control" placeholder="Cantidad de invitados" max="20" min="0" >
                        </div>
                        <div class="col-sm-6 col-md-3 col-xs-12 my-2">
                            <input type="datetime-local" name="fecha" class="form-control form-control-lg custom-form-control" placeholder="Fecha y Hora" >
                        </div>
                        <input type="hidden" id="action" name="action" value="insert" >
                    </div>
                    <button type="submit" class="btn btn-lg btn-primary" id="rounded-btn">Agendar cita</button>
                </form>
            </div>
            <table>
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
                                    <form action='controller/reservacionesDAO.php' class='insert' method='post' style='display:inline;'>
                                        <input type='hidden' name='idReservacion' value='" . $row["idReservacion"] . "'>
                                        <input type='hidden' name='estado' value='confirmar'>
                                        <input type='hidden' name='action' value='update'>
                                        <input type='submit' style='margin:10px; background-color: #4caf50; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;' value='Confirmar'>
                                    </form>
                                    <form action='controller/reservacionesDAO.php' class='action' method='post' style='display:inline;'>
                                        <input type='hidden' name='idReservacion' value='" . $row["idReservacion"] . "'>
                                        <input type='hidden' name='action' value='delete'>
                                        <input type='submit' style='background-color: #e22121; margin:10px; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;' value='Eliminar'>
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
        </main>
    </div>

    <script>
        function mostrarFormulario() {
            var formulario = document.querySelector('.new'); // Selecciona el primer elemento con la clase 'new'
            if (formulario.style.display === 'none' || formulario.style.display === '') {
                formulario.style.display = 'block'; // Muestra el formulario
            } else {
                formulario.style.display = 'none'; // Oculta el formulario
            }
        }

    </script>
</body>
</html>
