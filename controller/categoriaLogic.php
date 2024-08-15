
<?php
include '../dao/categoriaDAO.php';
include 'validaciones.php';

$categoriaDAO = new CategoriaDAO();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $action = $_POST['action'];

    if($action == 'insert'){

        $nombre = $_POST['nombre'];

        $errores = [];

        if (!validateName($nombre)) {
            $errores[] = "nameInvalid";
        }

        if (empty($errores)) {

            $categoriaInsertada = $categoriaDAO -> insertarCategoria($nombre);

            if ($categoriaInsertada) {
                header('Location: ../admCategoria.php?error=false'); //acceso
            } else {
                header('Location: ../admCategoria.php?error=systemError'); //usuario o contraseña incorrecto
            }


        } else {
            $errorString = implode(", ", $errores);
            header("Location: ../admCategoria.php?insert=false&errors=" . urlencode($errorString));
        }

    }else if ($action == 'update') {

        $idCategoria = $_POST['idCategoria'];
        $nombre = $_POST['nombre'];

        $errores = [];

        if (!validateName($nombre)) {
            $errores[] = "nameInvalid";
        }

        if (empty($errores)) {

            $categoriaActualizada = $categoriaDAO -> actualizarCategoria($idCategoria,$nombre);

            if ($categoriaActualizada) {
                header('Location: ../admCategoria.php?error=false'); //acceso
            } else {
                header('Location: ../admCategoria.php?error=systemError'); //usuario o contraseña incorrecto
            }


        } else {
            $errorString = implode(", ", $errores);
            header("Location: ../admCategoria.php?insert=false&errors=" . urlencode($errorString));
        }

        
    }else if ($action == 'delete') {

        $idCategoria = intval($_POST['idCategoria']);

        $categoriaEliminado = $categoriaDAO -> eliminarCategoria($idCategoria);

        if ($categoriaEliminado) {
            header('Location: ../admCategoria.php?error=false'); //acceso
        } else {
            header('Location: ../admCategoria.php?error=notPossible'); //usuario o contraseña incorrecto
        }
    }

    

} else {
    echo "Método de solicitud no permitido.";
}
?>
