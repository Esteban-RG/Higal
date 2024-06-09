<?php
session_start();
session_unset(); // Destruir todas las variables de sesión
session_destroy(); // Destruir la sesión
header("Location: ../admPanel.php"); // Redirigir al formulario de inicio de sesión
exit();
?>
