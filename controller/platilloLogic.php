
<?php
include '../dao/platilloDAO.php';

$platilloDAO = new PlatilloDAO();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $action = $_POST['action'];

    if($action == 'insert'){

        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $precio = floatval($_POST['precio']);
        $idCategoria = intval($_POST['idCategoria']);
    
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $nombreArchivo = $_FILES['imagen']['name'];
            $tipoArchivo = $_FILES['imagen']['type'];
            $tamanioArchivo = $_FILES['imagen']['size'];
            $tempArchivo = $_FILES['imagen']['tmp_name'];
            $rutaSubida = 'uploads/' . basename($nombreArchivo);
    
            if (!file_exists('../uploads')) {
                mkdir('../uploads', 0777, true);
            }
    
            if (move_uploaded_file($tempArchivo, "../".$rutaSubida)) {


                $platilloInsertado = $platilloDAO -> insertarPlatillo($nombre,$descripcion,$precio,$idCategoria,$rutaSubida,0);

                if ($platilloInsertado) {
                    header('Location: ../admPlatillo.php?error=false');
                } else {
                    echo $platilloInsertado;
                    header('Location: ../admPlatillo.php?error=systemError'); 
                }
                
            } else {
                echo "Error al mover el archivo subido.";
            }
        } else {
            echo "Error en la subida del archivo.";
        }
        

    }else if ($action == 'update') {

        $idPlatillo = $_POST['idPlatillo'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $precio = floatval($_POST['precio']);
        $idCategoria = intval($_POST['idCategoria']);
        $visibilidad = intval($_POST['visibilidad']) === 1 ? 1 : 0;
        $oldImage = $_POST['oldImagen'];
    
        $platilloActualizado = $platilloDAO->actualizarPlatillo($idPlatillo, $nombre, $descripcion, $precio, $idCategoria, $visibilidad);
    
        if ($platilloActualizado) {

            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                
                $nombreArchivo = basename($_FILES['imagen']['name']);
                $rutaSubida = 'uploads/' . $nombreArchivo;
                $tempArchivo = $_FILES['imagen']['tmp_name'];
    
                if (!file_exists('../uploads')) {
                    mkdir('../uploads', 0777, true);
                }
    
                if (move_uploaded_file($tempArchivo, "../" . $rutaSubida)) {
                    $imagenActualizada = $platilloDAO->actualizarImagen($idPlatillo, $rutaSubida);
    
                    if (!$imagenActualizada) {
                        header('Location: ../admPlatillo.php?error=systemError');
                        exit;
                    }else{
                        unlink("../".$oldImage);
                    }
                } else {
                    echo "Error al mover el archivo subido.";
                    exit;
                }
            }

    
            header('Location: ../admPlatillo.php?error=false');
            exit;
    
        } else {
            header('Location: ../admPlatillo.php?error=systemError');
            exit;
        }
    }else if ($action == 'delete') {

        $idPlatillo = intval($_POST['idPlatillo']);
        $oldImage = $_POST['oldImagen'];


        $platilloEliminado = $platilloDAO -> eliminarPlatillo($idPlatillo);

        if ($platilloEliminado) {
            unlink("../".$oldImage);
            header('Location: ../admPlatillo.php?error=false');
        } else {
            echo $platilloInsertado;
            header('Location: ../admPlatillo.php?error=systemError'); 
        }

    }
} else {
    echo "Método de solicitud no permitido.";
}
?>