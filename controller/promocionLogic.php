
<?php
include '../dao/promocionDAO.php';

$promocionDAO = new PromocionDAO();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $action = $_POST['action'];

    if ($action == 'insert') {

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $nombreArchivo = $_FILES['imagen']['name'];
            $tipoArchivo = $_FILES['imagen']['type'];
            $tamanioArchivo = $_FILES['imagen']['size'];
            $tempArchivo = $_FILES['imagen']['tmp_name'];
            $rutaSubida = 'assets/imgs/promocion/' . basename($nombreArchivo);

            if (!file_exists('../assets/imgs/promocion')) {
                mkdir('../assets/imgs/promocion', 0777, true);
            }

            if (move_uploaded_file($tempArchivo, "../" . $rutaSubida)) {


                $promocionInsertada = $promocionDAO->insertarImagen($rutaSubida);

                if ($promocionInsertada) {
                    header('Location: ../admPromocion.php?error=false');
                } else {
                    echo $promocionInsertada;
                    header('Location: ../admPromocion.php?error=systemError');
                }
            } else {
                echo "Error al mover el archivo subido.";
            }
        } else {
            echo "Error en la subida del archivo.";
        }
    } else if ($action == 'update') {

        $idPromocion = $_POST['idPromocion'];
        $oldImage = $_POST['oldImagen'];

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {

            $nombreArchivo = basename($_FILES['imagen']['name']);
            $rutaSubida = 'assets/imgs/promocion/' . $nombreArchivo;
            $tempArchivo = $_FILES['imagen']['tmp_name'];

            if (!file_exists('../assets/imgs/promocion')) {
                mkdir('../assets/imgs/promocion', 0777, true);
            }

            if (move_uploaded_file($tempArchivo, "../" . $rutaSubida)) {

                $imagenActualizada = $promocionDAO->actualizarImagen($idPromocion, $rutaSubida);

                if (!$imagenActualizada) {
                    header('Location: ../admPromocion.php?error=systemError');
                    exit;
                } else {
                    unlink("../" . $oldImage);
                    header('Location: ../admPromocion.php?error=false');
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

        $idPromocion = intval($_POST['idPromocion']);
        $oldImage = $_POST['oldImagen'];


        $promocionEliminado = $promocionDAO->eliminarPromocion($idPromocion);

        if ($promocionEliminado) {
            unlink("../" . $oldImage);
            header('Location: ../admPromocion.php?error=false');
        } else {
            header('Location: ../admPromocion.php?error=systemError');
        }
    }
} else {
    echo "Método de solicitud no permitido.";
}
?>