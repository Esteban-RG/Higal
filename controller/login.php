<?php
session_start();
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idAdministrador = $_POST['idAdministrador'];
    $contrasenha = $_POST['contrasenha'];

    $sql = "SELECT * FROM Administrador WHERE idAdministrador = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $idAdministrador);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($contrasenha, $row['contrasenha'])) {
                // Usuario autenticado correctamente
                $_SESSION['idAdministrador'] = $idAdministrador;
                header("Location: ../admReservacion.php");  // Redirigir al panel de administración
                exit();
            } else {
                // Contraseña incorrecta
                header("Location: ../admPanel.php?error=true");
                exit();
            }
        } else {
            // Usuario no encontrado
            header("Location: ../admPanel.php?error=true");
            exit();
        }
    } else {
        echo "Error en la consulta: " . $conn->error;
    }
}
?>
