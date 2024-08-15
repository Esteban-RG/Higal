<?php
include 'dao/platilloDAO.php';
include 'dao/categoriaDAO.php';


session_start();
if (!isset($_SESSION['idAdministrador'])) {
    header("Location: admPanel.php");
    exit();
}

$categoriaDAO = new CategoriaDAO();
$categorias = $categoriaDAO->obtenerCategorias();
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
                window.location.href='admPlatillo.php';
            });
        }else if(insert === 'false'){
            Swal.fire({
                icon: "error",
                text: "Ocurrió un error al insertar el elemento"
            }).then(() => {
                window.location.href='admPlatillo.php';
            });
        }

        if (delet  === 'true') {
            Swal.fire({
                icon: "success",
                text: "El elemento se elimino correctamente"
            }).then(() => {
                window.location.href='admPlatillo.php';
            });
        }else if(delet === 'false'){
            Swal.fire({
                icon: "error",
                text: "Ocurrió un error al eliminar el elemento"
            }).then(() => {
                window.location.href='admPlatillo.php';
            });
        }
        
        if (update  === 'true') {
            Swal.fire({
                icon: "success",
                text: "El elemento se actualizo correctamente"
            }).then(() => {
                window.location.href='admPlatillo.php';
            });
        }else if(update  === 'false'){
            Swal.fire({
                icon: "error",
                text: "Ocurrió un error al actualizar el elemento"
            }).then(() => {
                window.location.href='admPlatillo.php';
            });
        }
    </script>
    <div class="container">
        <aside class="sidebar">
            <h2>Tablas</h2>
            <ul>
                <li><a href="admReservacion.php" >Reservaciones</a></li>
                <li><a href="admPlatillo.php" style="color:blue;" >Platillos</a></li>
                <li><a href="admCliente.php">Clientes</a></li>
                <li><a href="admCategoria.php">Categorias</a></li>
                <li><a href="admMesa.php">Mesas</a></li>
                <li><a href="admAdmin.php">Administradores</a></li>
                <li><a href="controller/sesionKiller.php" style="color:#ff0000;" >Cerrar Sesion</a></li>
            </ul>
        </aside>
        <main class="content">
            <h1>Registro de Platillos</h1>
            <button onclick="mostrarFormulario()">Nuevo</button>
            <div class="new" style="display:none;">
                <form action="controller/platilloLogic.php" method="post" enctype="multipart/form-data">
                    <div class="row mb-5">
                        <div class="col-sm-6 col-md-3 col-xs-12 my-2">
                            <input type="text" name="nombre" class="form-control form-control-lg custom-form-control" placeholder="Nombre" maxlength="50" required>
                        </div>
                        <div class="col-sm-6 col-md-3 col-xs-12 my-2">
                            <textarea name="descripcion" class="form-control form-control-lg custom-form-control" placeholder="Descripcion" maxlength="255" required ></textarea>
                        </div>
                        <div class="col-sm-6 col-md-3 col-xs-12 my-2">
                            <input type="number" name="precio" class="form-control form-control-lg custom-form-control" placeholder="Precio" required >
                        </div>
                        <div class="col-sm-6 col-md-3 col-xs-12 my-2">
                            <select name="idCategoria" class="form-control form-control-lg custom-form-control" required>
                                <option value="">Seleccione una categoría</option>
                                <?php

                                if ($categorias !== false && count($categorias) > 0) {
                                    foreach($categorias as $row)  {
                                        echo "<option value='" . $row["idCategoria"] . "'>" . $row["nombre"] . "</option>";
                                    }
                                }else{
                                        echo "<option value=''>No hay categorías disponibles</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-6 col-md-3 col-xs-12 my-2">
                            <input type="file" id="imagen" name="imagen" accept="image/*">
                        </div>
                        <input type="hidden" id="action" name="action" value="insert" >
                    </div>
                    <button type="submit" class="btn btn-lg btn-primary" id="rounded-btn">Agregar platillo</button>
                </form>
            </div>
    <table>
        <thead>
            <tr>
                <th>ID de Platillo</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Categoría</th>
                <th>Visibilidad</th>
                <th>Imagen</th>
                <th>Acciones</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            
            <?php

                $platilloDAO = new PlatilloDAO();
                $datos = $platilloDAO->obtenerPlatillos();

                if ($datos !== false && count($datos) > 0) {
                foreach ($datos as $row) {
                    echo "
                    
                    <tr>
                        <form action='controller/platilloLogic.php' method='post' enctype='multipart/form-data'>
                            <td><input type='hidden' name='idPlatillo' value='" . htmlspecialchars($row["idPlatillo"]) . "'>
                                " . htmlspecialchars($row["idPlatillo"]) . "
                            </td>
                            <td><input type='text' name='nombre' value='" . htmlspecialchars($row["nombre"]) . "'></td>
                            <td><textarea name='descripcion' >" . htmlspecialchars($row["descripcion"]) . "</textarea></td>
                            <td><input type='number' name='precio' value='" . htmlspecialchars($row["precio"]) . "'></td>
                            <td>
                            <select name='idCategoria' class='form-control form-control-lg custom-form-control' required>
                                <option >Seleccione una categoría</option>
                    ";
                            foreach($categorias as $categoria)  {
                                echo "<option value='" . $categoria["idCategoria"] . "' " . 
                                ($row["idCategoria"] == $categoria["idCategoria"] ? "selected" : "") . 
                                ">" . htmlspecialchars($categoria["nombre"]) . "</option>";
                            }
                    echo "
                            </select>

                            </td>
                            
                            <td><input type='checkbox' name='visibilidad' value='1' " . ($row["visibilidad"] ? "checked" : "") . "></td>
                            <td>
                                <img src='" . $row["imagen"] . "' alt='Imagen de " . $row["nombre"] . "' style='width: 100px;'>
                                <input type='hidden' name='oldImagen' value='".$row["imagen"]."'>
                                <input type='file' name='imagen' accept='image/*'>
                            </td>

                            <td>
                                <input type='hidden' name='action' value='update'>
                                <input type='submit' style='background-color: #5058ba; margin:10px; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;' value='Actualizar'>
                            </td>
                        </form>
                        <td>
                            <form action='controller/platilloLogic.php' method='post'>
                                <input type='hidden' name='idPlatillo' value='" . htmlspecialchars($row["idPlatillo"]) . "'>
                                <input type='hidden' name='oldImagen' value='".$row["imagen"]."'>
                                <input type='hidden' name='action' value='delete'>
                                <input type='submit' style='background-color: #e22121; margin:10px; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;' value='Eliminar'>
                            </form>
                        </td>
                    </tr>
                    
                    ";
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
