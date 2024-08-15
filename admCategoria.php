<?php
include 'dao/categoriaDAO.php';

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
$error = isset($_GET['errors']) ? $_GET['errors'] : 'Desconocido';



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
        var errors = <?php echo json_encode($error); ?>;

        if (insert === 'true') {
            Swal.fire({
                icon: "success",
                text: "El elemento se inserto correctamente"
            }).then(() => {
                window.location.href='admCategoria.php';
            });
        }

        if (insert === 'false') {
            let swalOptions = {
                icon: "error",
                title: "Error",
            };
            
            if (errors !== 'Desconocido') {
                swalOptions.text = errors;
            }
            
            Swal.fire(swalOptions).then(() => {
                window.location.href = 'admCategoria.php';
            });
        }

        if (delet  === 'true') {
            Swal.fire({
                icon: "success",
                text: "El elemento se elimino correctamente"
            }).then(() => {
                window.location.href='admCategoria.php';
            });
        }else if(delet === 'false'){
            Swal.fire({
                icon: "error",
                text: "Ocurrió un error al eliminar el elemento"
            }).then(() => {
                window.location.href='admCategoria.php';
            });
        }
        
        if (update  === 'true') {
            Swal.fire({
                icon: "success",
                text: "El elemento se actualizo correctamente"
            }).then(() => {
                window.location.href='admCategoria.php';
            });
        }else if(update  === 'false'){
            Swal.fire({
                icon: "error",
                text: "Ocurrió un error al actualizar el elemento"
            }).then(() => {
                window.location.href='admCategoria.php';
            });
        }
    </script>
    <div class="container">
        <aside class="sidebar">
            <h2>Tablas</h2>
            <ul>
                <li><a href="admReservacion.php" >Reservaciones</a></li>
                <li><a href="admPlatillo.php" >Platillos</a></li>
                <li><a href="admCliente.php"  >Clientes</a></li>
                <li><a href="admCategoria.php" style="color:blue;">Categorias</a></li>
                <li><a href="admMesa.php"  >Mesas</a></li>
                <li><a href="admAdmin.php">Administradores</a></li>
                <li><a href="controller/sesionKiller.php" style="color:#ff0000;" >Cerrar Sesion</a></li>

            </ul>
        </aside>
        <main class="content">
            <h1>Registro de Categorias</h1>
            <button onclick="mostrarFormulario()">Nuevo</button>
            <div class="new" style="display:none;">
            <form action="controller/categoriaLogic.php" method="post">
                <input type="text" id="nombre" name="nombre" placeholder="Nombre" maxlength="30" required>
                <input type="hidden" id="action" name="action" value="insert">
                <button type="submit" class="btn btn-lg btn-primary" id="rounded-btn">Agregar Categoria</button>
            </form>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>ID de Categoria</th>
                        <th>Nombres</th>
                        <th>Acciones</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $categoriaDAO = new CategoriaDAO;
                    $datos = $categoriaDAO->obtenerCategorias();
                    
                    if ($datos !== false && count($datos) > 0) {
                    foreach ($datos as $row) {
                        echo "
                        
                        <tr>
                            <form action='controller/categoriaLogic.php' method='post'>
                                <td><input type='hidden' name='idCategoria' value='" . htmlspecialchars($row["idCategoria"]) . "'>
                                    " . htmlspecialchars($row["idCategoria"]) . "
                                </td>
                                <td><input type='text' name='nombre' value='" . htmlspecialchars($row["nombre"]) . "'></td>
                                <td>
                                    <input type='hidden' name='action' value='update'>
                                    <input type='submit' style='background-color: #5058ba; margin:10px; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;' value='Actualizar'>
                                </td>
                            </form>
                            <td>
                                <form action='controller/categoriaLogic.php' method='post'>
                                    <input type='hidden' name='idCategoria' value='" . htmlspecialchars($row["idCategoria"]) . "'>
                                    <input type='hidden' name='action' value='delete'>
                                    <input type='submit' style='background-color: #e22121; margin:10px; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;' value='Eliminar'>
                                </form>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No se encontraron administradores.</td></tr>";
                }       
                
                ?>
                </tbody>
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
