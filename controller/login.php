<?php
include '../dao/administradorDAO.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $idAdministrador = $_POST['idAdministrador'];
    $pass = $_POST['pass'];



    $administradorDAO = new AdministradorDAO();

    $admin = $administradorDAO->autenticarAdministrador($idAdministrador, $pass);

    if ($admin) {
        header('Location: ../admReservacion.php'); //acceso
    } else {
        header('Location: ../admPanel.php?error=badAuentication'); //usuario o contraseña incorrecto
    }
} else {
    echo "Método de solicitud no permitido.";
}
