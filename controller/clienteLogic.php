
<?php
include '../dao/clienteDAO.php';
include 'validaciones.php';

$clienteDAO = new ClienteDAO();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $action = $_POST['action'];

    if($action == 'insert'){

        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];

        $errores = [];

        if (!validateName($nombre)) {
            $errores[] = "invalidName";
        }
    

        if (empty($errores)) {
           
            $clienteInsertado = $clienteDAO -> insertarCliente($nombre,$correo);            

            if ($clienteInsertado) {
                header('Location: ../admCliente.php?error=false'); 
            } else {
                header('Location: ../admCliente.php?error=systemError'); 
            }

        } else {
            $errorString = implode(", ", $errores);
            header("Location: ../admCliente.php?insert=false&errors=" . urlencode($errorString));
        }

    }else if ($action == 'update') {

        $idCliente = $_POST['idCliente'];
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];

        $errores = [];

        if (!validateName($nombre)) {
            $errores[] = "invalidName";
        }

        if (empty($errores)) {
            $clienteActualizado = $clienteDAO -> actualizarCliente($idCliente,$nombre,$correo);            

            if ($clienteActualizado) {
                header('Location: ../admCliente.php?error=false'); 
            } else {
                header('Location: ../admCliente.php?error=systemError'); 
            }

        } else {
            $errorString = implode(", ", $errores);
            header("Location: ../admCliente.php?insert=false&errors=" . urlencode($errorString));
        }
       
    }else if ($action == 'delete') {

        $idCliente = intval($_POST['idCliente']);

        $clienteEliminado = $clienteDAO -> eliminarCliente($idCliente);

        if ($clienteEliminado) {
            header('Location: ../admCliente.php?error=false'); //acceso
        } else {
            header('Location: ../admCliente.php?error=notPossible'); //usuario o contraseña incorrecto
        }
    }

    

} else {
    echo "Método de solicitud no permitido.";
}





?>
