<?php
include 'dao/reservacionDAO.php';
include 'dao/mesaDAO.php';

$error = isset($_GET['error']) ? $_GET['error'] : 'Desconocido';



$reservacionDAO = new ReservacionDAO();
$mesaDAO = new MesaDAO();

$mesas = $mesaDAO->obtenerMesas();


session_start();
if (!isset($_SESSION['idAdministrador'])) {
    header("Location: admPanel.php");
    exit();
}
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
        var error = <?php echo json_encode($error); ?>;
    </script>

    <div class="container">
        <aside class="sidebar">
            <h2>Tablas</h2>
            <ul>
                <li><a href="admReservacion.php" style="color:blue;">Reservaciones</a></li>
                <li><a href="admGaleria.php">Galeria</a></li>
                <li><a href="admPromocion.php">Promocion</a></li>
                <li><a href="admPlatillo.php">Platillos</a></li>
                <li><a href="admCliente.php">Clientes</a></li>
                <li><a href="admCategoria.php">Categorias</a></li>
                <li><a href="admMesa.php">Mesas</a></li>
                <li><a href="admAdmin.php">Administradores</a></li>
                <li><a href="controller/sesionKiller.php" style="color:#ff0000;">Cerrar Sesion</a></li>

            </ul>
        </aside>
        <main class="content">
            <h1>Registro de Reservaciones</h1>
            <button onclick="mostrarFormulario()">Nuevo</button>
            <div class="new" style="display:none;">
                <form action="controller/reservacionLogic.php" method="POST">
                    <div class="row mb-5">
                        <div class="col-sm-6 col-md-3 col-xs-12 my-2">
                            <input type="text" name="name" class="form-control form-control-lg custom-form-control" placeholder="Nombre" maxlength="50" required>
                        </div>
                        <div class="col-sm-6 col-md-3 col-xs-12 my-2">
                            <input type="email" name="email" class="form-control form-control-lg custom-form-control" placeholder="Email" maxlength="30" required>
                        </div>
                        <div class="col-sm-6 col-md-3 col-xs-12 my-2">
                            <input type="number" name="cantPersonas" class="form-control form-control-lg custom-form-control" placeholder="Cantidad de invitados" max="20" min="1" required>
                        </div>
                        <div class="col-sm-6 col-md-3 col-xs-12 my-2">
                            <input type="datetime-local" name="fecha" class="form-control form-control-lg custom-form-control" placeholder="Fecha y Hora" required>
                        </div>
                        <input type="hidden" id="action" name="action" value="insert">
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
                    <th>Acciones</th>
                    <th></th>
                </tr>
                <?php
                $datos = $reservacionDAO->obtenerReservaciones();

                if ($datos !== false && count($datos) > 0) {
                    foreach ($datos as $row) {
                        echo "
                                
                                <tr>
                                    <form action='controller/reservacionLogic.php' method='post'>
                                        <td><input type='hidden' name='idReservacion' value='" . htmlspecialchars($row["idReservacion"]) . "'>
                                            " . htmlspecialchars($row["idReservacion"]) . "
                                        </td>
                                        <td><input type='datetime-local' name='fecha' value='" . htmlspecialchars($row["fecha"]) . "' readonly></td>
                                        <td><input type='number' name='cantPersonas' value='" . htmlspecialchars($row["cantPersonas"]) . "' readonly></td>

                                        <td>
                                        <select name='idCategoria' class='form-control form-control-lg custom-form-control' required style='pointer-events: none;'>
                                        <option >Seleccione una mesa</option>
                                        ";
                        foreach ($mesas as $mesa) {
                            echo "<option value='" . $mesa["idMesa"] . "' " .
                                ($row["idMesa"] == $mesa["idMesa"] ? "selected" : "") .
                                ">" . htmlspecialchars($mesa["idMesa"]) . "</option>";
                        }
                        echo "
                                        </select>
                                       </td> 
                                                                                
                                        <td>
                                            " . htmlspecialchars($row["cliente"]) . "
                                            <input type='hidden' name='cliente' value='" . htmlspecialchars($row["idCliente"]) . "'>
                                        </td>


                                        <td>
                                            <input type='hidden' name='action' value='update'>
                                            <input type='hidden' style='background-color: #5058ba; margin:10px; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;' value='Actualizar'>
                                        </td>
                                    </form>
                                    <td>
                                        <form action='controller/reservacionLogic.php' method='post'>
                                            <input type='hidden' name='idReservacion' value='" . htmlspecialchars($row["idReservacion"]) . "'>
                                            <input type='hidden' name='action' value='delete'>
                                            <input type='submit' style='background-color: #e22121; margin:10px; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;' value='Eliminar'>
                                        </form>
                                    </td>
                                </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No se encontraron reservaciones registradas.</td></tr>";
                }
                ?>
            </table>
        </main>
    </div>

    <script>
        function mostrarFormulario() {
            var formulario = document.querySelector('.new');
            if (formulario.style.display === 'none' || formulario.style.display === '') {
                formulario.style.display = 'block';
            } else {
                formulario.style.display = 'none';
            }
        }
    </script>
</body>

</html>