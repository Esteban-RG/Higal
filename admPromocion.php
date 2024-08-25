<?php
include 'dao/promocionDAO.php';

$error = isset($_GET['error']) ? $_GET['error'] : 'Desconocido';



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
                <li><a href="admReservacion.php">Reservaciones</a></li>
                <li><a href="admGaleria.php">Galeria</a></li>
                <li><a href="admPromocion.php" style="color:blue;">Promocion</a></li>
                <li><a href="admPlatillo.php">Platillos</a></li>
                <li><a href="admCliente.php">Clientes</a></li>
                <li><a href="admCategoria.php">Categorias</a></li>
                <li><a href="admMesa.php">Mesas</a></li>
                <li><a href="admAdmin.php">Administradores</a></li>
                <li><a href="controller/sesionKiller.php" style="color:#ff0000;">Cerrar Sesion</a></li>
            </ul>
        </aside>
        <main class="content">
            <h1>Registro de Promociones</h1>
            <button onclick="mostrarFormulario()">Nuevo</button>
            <div class="new" style="display:none;">
                <form action="controller/promocionLogic.php" method="post" enctype="multipart/form-data">
                    <div class="row mb-5">
                        <div class="col-sm-6 col-md-3 col-xs-12 my-2">
                            <input type="file" id="imagen" name="imagen" accept="image/*" required>
                        </div>
                        <input type="hidden" id="action" name="action" value="insert">
                    </div>
                    <button type="submit" class="btn btn-lg btn-primary" id="rounded-btn">Agregar imagen</button>
                </form>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>ID de Promocion</th>
                        <th>Promocion</th>
                        <th>Acciones</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    $promocionDAO = new PromocionDAO();
                    $datos = $promocionDAO->obtenerImagenes();

                    if ($datos !== false && count($datos) > 0) {
                        foreach ($datos as $row) {
                            echo "
                    
                    <tr>
                        <form action='controller/promocionLogic.php' method='post' enctype='multipart/form-data'>
                            <td><input type='hidden' name='idPromocion' value='" . htmlspecialchars($row["idPromocion"]) . "'>
                                " . htmlspecialchars($row["idPromocion"]) . "
                            </td>
                            
                            <td>
                                <img src='" . $row["ruta"] . "' alt='Imagen de promocion' style='width: 100px;'>
                                <input type='hidden' name='oldImagen' value='" . $row["ruta"] . "'>
                                <input type='file' name='imagen' accept='image/*' required>
                            </td>

                            <td>
                                <input type='hidden' name='action' value='update'>
                                <input type='submit' style='background-color: #5058ba; margin:10px; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;' value='Actualizar'>
                            </td>
                        </form>
                        <td>
                            <form action='controller/promocionLogic.php' method='post'>
                                <input type='hidden' name='idPromocion' value='" . htmlspecialchars($row["idPromocion"]) . "'>
                                <input type='hidden' name='oldImagen' value='" . $row["ruta"] . "'>
                                <input type='hidden' name='action' value='delete'>
                                <input type='submit' style='background-color: #e22121; margin:10px; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;' value='Eliminar'>
                            </form>
                        </td>
                    </tr>
                    
                    ";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No se encontraron imagenes.</td></tr>";
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