
<?php
include '../dao/galeriaDAO.php';

$galeriaDAO = new GaleriaDAO();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $action = $_POST['action'];

    if ($action == 'insert') {

        $nombre = $_POST['nombre'];

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $nombreArchivo = $_FILES['imagen']['name'];
            $tipoArchivo = $_FILES['imagen']['type'];
            $tamanioArchivo = $_FILES['imagen']['size'];
            $tempArchivo = $_FILES['imagen']['tmp_name'];
            $rutaSubida = 'assets/imgs/galeria/' . basename($nombreArchivo);

            if (!file_exists('../assets/imgs/galeria')) {
                mkdir('../assets/imgs/galeria', 0777, true);
            }

            if (move_uploaded_file($tempArchivo, "../" . $rutaSubida)) {


                $imagenInsertada = $galeriaDAO->insertarImagen($nombre, $rutaSubida);

                if ($imagenInsertada) {
                    header('Location: ../admGaleria.php?error=false');
                } else {
                    echo $imagenInsertada;
                    header('Location: ../admGaleria.php?error=systemError');
                }
            } else {
                echo "Error al mover el archivo subido.";
            }
        } else {
            echo "Error en la subida del archivo.";
        }
    } else if ($action == 'update') {

        $idImagen = $_POST['idImagen'];
        $nombre = $_POST['nombre'];
        $oldImage = $_POST['oldImagen'];

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {

            $nombreArchivo = basename($_FILES['imagen']['name']);
            $rutaSubida = 'assets/imgs/galeria/' . $nombreArchivo;
            $tempArchivo = $_FILES['imagen']['tmp_name'];

            if (!file_exists('../assets/imgs/galeria')) {
                mkdir('../assets/imgs/galeria', 0777, true);
            }

            if (move_uploaded_file($tempArchivo, "../" . $rutaSubida)) {

                $imagenActualizada = $galeriaDAO->actualizarImagen($idImagen, $nombre, $rutaSubida);

                if (!$imagenActualizada) {
                    header('Location: ../admGaleria.php?error=systemError');
                    exit;
                } else {
                    unlink("../" . $oldImage);
                    header('Location: ../admGaleria.php?error=false');
                    exit;
                }
            } else {
                echo "Error al mover el archivo subido.";
                exit;
            }
        } else {
            echo "Error en la subida del archivo.";
        }
    } else if ($action == 'delete') {

        $idImagen = intval($_POST['idImagen']);
        $oldImage = $_POST['oldImagen'];


        $platilloEliminado = $galeriaDAO->eliminarImagen($idImagen);

        if ($platilloEliminado) {
            unlink("../" . $oldImage);
            header('Location: ../admGaleria.php?error=false');
        } else {
            echo $imagenInsertada;
            header('Location: ../admGaleria.php?error=systemError');
        }
    }
} else {
    echo "Método de solicitud no permitido.";
}
?>