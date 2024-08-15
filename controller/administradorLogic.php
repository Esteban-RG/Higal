
<?php
include '../dao/administradorDAO.php';
include 'validaciones.php';

$administradorDAO = new AdministradorDAO();


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $action = $_POST['action'];

    if($action == 'insert'){

        $nombre = $_POST['nombre'];
        $apPaterno = $_POST['apPaterno'];
        $apMaterno = $_POST['apMaterno'];
        $contrasenha = $_POST['contrasenha'];

        $errores = [];

        if (!validateName($nombre)) {
            $errores[] = "nameInvalid";
        }else if (!validateName($apPaterno)) {
            $errores[] = "lastNameInvalid";
        }else if (!validateName($apMaterno)) {
            $errores[] = "lastNameInvalid";


        }
        if (empty($errores)) {

            $adminstradorInsertado = $administradorDAO -> insertarAdministrador($nombre,$apPaterno,$apMaterno,$contrasenha);

            if ($adminstradorInsertado) {
                header('Location: ../admAdmin.php?error=false'); //acceso
            } else {
                header('Location: ../admAdmin.php?error=systemError'); //usuario o contraseña incorrecto
            }

        } else {
            $errorString = implode(", ", $errores);
            header("Location: ../admAdmin.php?error=" . urlencode($errorString));
        }



    }else if ($action == 'update') {

        $idAdministrador = $_POST['idAdministrador'];
        $nombre = $_POST['nombre'];
        $apPaterno = $_POST['apPaterno'];
        $apMaterno = $_POST['apMaterno'];
        $pass = $_POST['pass'];


        $errores = [];

        if (!validateName($nombre)) {
            $errores[] = "nameInvalid";
        }else if (!validateName($apPaterno)) {
            $errores[] = "lastNameInvalid";
        }else if (!validateName($apMaterno)) {
            $errores[] = "lastNameInvalid";


        }


        if (empty($errores)) {

                $administradorActualizado = $administradorDAO -> actualizarAdministrador($idAdministrador,$nombre,$apPaterno,$apMaterno);

            if ($administradorActualizado) {
                header('Location: ../admAdmin.php?error=false'); //acceso
            } else {
                header('Location: ../admAdmin.php?error=systemError'); //usuario o contraseña incorrecto
            }

            if ($pass != null){
                $contrasenhaActualizada = $administradorDAO -> actualizarContraseña($idAdministrador,$pass);
            }

        } else {
            $errorString = implode(", ", $errores);
            header("Location: ../admAdmin.php?error=" . urlencode($errorString));
        }



       
    }else if ($action == 'delete') {

        $idAdministrador = intval($_POST['idAdministrador']);


        $adminstradorEliminado = $administradorDAO -> eliminarAdministrador($idAdministrador);

        if ($adminstradorEliminado) {
            header('Location: ../admAdmin.php?error=false'); //acceso
        } else {
            header('Location: ../admAdmin.php?error=notPossible'); //usuario o contraseña incorrecto
        }

    }

    

} else {
    echo "Método de solicitud no permitido.";
}
?>
