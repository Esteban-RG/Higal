<?php
include 'dao/mesaDAO.php';

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
                window.location.href='admMesa.php';
            });
        }else if(insert === 'false'){
            Swal.fire({
                icon: "error",
                text: "Ocurrió un error al insertar el elemento"
            }).then(() => {
                window.location.href='admMesa.php';
            });
        }

        if (delet  === 'true') {
            Swal.fire({
                icon: "success",
                text: "El elemento se elimino correctamente"
            }).then(() => {
                window.location.href='admMesa.php';
            });
        }else if(delet === 'false'){
            Swal.fire({
                icon: "error",
                text: "Ocurrió un error al eliminar el elemento"
            }).then(() => {
                window.location.href='admMesa.php';
            });
        }
        
        if (update  === 'true') {
            Swal.fire({
                icon: "success",
                text: "El elemento se actualizo correctamente"
            }).then(() => {
                window.location.href='admMesa.php';
            });
        }else if(update  === 'false'){
            Swal.fire({
                icon: "error",
                text: "Ocurrió un error al actualizar el elemento"
            }).then(() => {
                window.location.href='admMesa.php';
            });
        }
    </script>
    <div class="container">
        <aside class="sidebar">
            <h2>Tablas</h2>
            <ul>
                <li><a href="admReservacion.php" >Reservaciones</a></li>
                <li><a href="admPlatillo.php" >Platillos</a></li>
                <li><a href="admCliente.php">Clientes</a></li>
                <li><a href="admCategoria.php">Categorias</a></li>
                <li><a href="admMesa.php" style="color:blue;" >Mesas</a></li>
                <li><a href="admAdmin.php">Administradores</a></li>
                <li><a href="controller/sesionKiller.php" style="color:#ff0000;" >Cerrar Sesion</a></li>

            </ul>
        </aside>
        <main class="content">
            <h1>Registro de Mesas</h1>
            <button onclick="mostrarFormulario()">Nuevo</button>
            <div class="new" style="display:none;">
                <form action="controller/mesaLogic.php" method="post">
                    <input type="number" id="idMesa" name="idMesa" placeholder="ID de la Mesa" required>
                    <input type="number" id="asientos" name="asientos" placeholder="Numero de asientos" required>
                    <input type="hidden" id="action" name="action" value="insert">
                    <button type="submit" class="btn btn-lg btn-primary" id="rounded-btn">Agregar Mesa</button>
                </form>
            </div>
            <table>
        <thead>
            <tr>
                <th>ID de Mesa</th>
                <th>Asientos</th>
                <th>Acciones</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
                $mesaDAO = new MesaDAO;
                $datos = $mesaDAO->obtenerMesas();
                
                if ($datos !== false && count($datos) > 0) {
                foreach ($datos as $row) {
                        echo "
                        
                        <tr>
                            <form action='controller/mesaLogic.php' method='post'>
                                <td><input type='hidden' name='idMesa' value='" . htmlspecialchars($row["idMesa"]) . "'>
                                    " . htmlspecialchars($row["idMesa"]) . "
                                </td>
                                <td><input type='number' name='asientos' value='" . htmlspecialchars($row["asientos"]) . "'></td>
                                <td>
                                    <input type='hidden' name='action' value='update'>
                                    <input type='submit' style='background-color: #5058ba; margin:10px; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;' value='Actualizar'>
                                </td>
                            </form>
                            <td>
                                <form action='controller/mesaLogic.php' method='post'>
                                    <input type='hidden' name='idMesa' value='" . htmlspecialchars($row["idMesa"]) . "'>
                                    <input type='hidden' name='action' value='delete'>
                                    <input type='submit' style='background-color: #e22121; margin:10px; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;' value='Eliminar'>
                                </form>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No se encontraron mesas registradas.</td></tr>";
                }       
            
            ?>
        </tbody>
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
