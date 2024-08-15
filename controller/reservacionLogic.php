<?php
include '../dao/reservacionDAO.php';
include '../dao/clienteDAO.php';

include 'validaciones.php';

$reservacionDAO = new ReservacionDAO();
$clienteDAO = new ClienteDAO();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $action = $_POST['action'];

    if($action == 'insert'){
        $fecha = $_POST['fecha'];
        $cantPersonas = intval($_POST['cantPersonas']);
        $nombre = $_POST['name'];
        $correo = $_POST['email'];
        $source = $_POST['source'];
    
        $errores = [];
    
        if (!validateName($nombre)) {
            $errores[] = "invalidName";
        }
        if (!validateEmail($correo)) {
            $errores[] = "invalidEmail";
        }
        if ($cantPersonas < 1) {
            $errores[] = "invalidNumber";
        }
        if (!validateDate($fecha)) {
            $errores[] = "invalidDate";
        }
    
        if (empty($errores)) {
            $idCliente = null;
            $idMesa = null;
    
            $mesa = $reservacionDAO->obtenerMesaDisponible($cantPersonas, $fecha);
    
            if ($mesa === false) {
                $redirectUrl = $source === 'client' ? '../index.php?error=notATable' : '../admReservacion.php?error=notATable';
                header('Location: ' . $redirectUrl);
                exit;
            }
    
            $idMesa = $mesa["idMesa"];
    
            $cliente = $clienteDAO->buscarCorreo($correo);
    
            if ($cliente === false) {
                $clienteRegistrado = $clienteDAO->insertarCliente($nombre, $correo);
                $cliente = $clienteDAO->obtenerID($correo, $nombre);
            }
    
            $idCliente = $cliente['idCliente'];
            $reservacionInsertada = $reservacionDAO->insertarReservacion($fecha, $cantPersonas, $idMesa, $idCliente);
    
            if ($reservacionInsertada) {
                $redirectUrl = $source === 'client' ? '../index.php?error=false' : '../admReservacion.php?error=false';
                header('Location: ' . $redirectUrl);
                exit;
            } else {
                // Manejo de error al insertar reservación
                $redirectUrl = $source === 'client' ? '../index.php?error=systemError' : '../admReservacion.php?error=systemError';
                header('Location: ' . $redirectUrl);
                exit;
            }
    
        } else {
            $errorString = implode(", ", $errores);
            $redirectUrl = $source === 'client' ? "../index.php?reservation=false&error=" . urlencode($errorString) : "../admReservacion.php?insert=false&error=" . urlencode($errorString);
            header('Location: ' . $redirectUrl);
            exit;
        }
    }else if ($action == 'update') {

        header('Location: ../admReservacion.php');
        exit;
       
    }else if ($action == 'delete') {
        $idReservacion = intval($_POST['idReservacion']);

        $reservacionEliminada = $reservacionDAO -> eliminarReservacion($idReservacion);

        if ($reservacionEliminada) {
            $redirectUrl = '../admReservacion.php?error=false';
            header('Location: ' . $redirectUrl);
            exit;
        } else {
            $redirectUrl = '../admReservacion.php?error=systemError';
            header('Location: ' . $redirectUrl);
            exit;
        }

    
    }

    

} else {
    echo "Método de solicitud no permitido.";
}
?>
