<?php
session_start();
session_unset(); 
session_destroy(); 
$error = isset($_GET['error']) ? $_GET['error'] : 'Desconocido';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administración de la Base de Datos</title>
    <link rel="stylesheet" href="assets/css/adminPanel.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script>
        var error = <?php echo json_encode($error); ?>;

        if(error  === 'true'){
            Swal.fire({
                icon: "error",
                text: "Los datos no son correctos"
            }).then(() => {
                window.location.href='admPanel.php';
            });
        }
    </script>
    <div class="container">
        <aside class="sidebar">
            <h2>Tablas</h2>
            <ul>
                <li><a href="admReservacion.php" >Reservaciones</a></li>
                <li><a href="admPlatillo.php" >Platillos</a></li>
                <li><a href="admCliente.php"  >Clientes</a></li>
                <li><a href="admCategoria.php" >Categorias</a></li>
                <li><a href="admMesa.php"  >Mesas</a></li>
                <li><a href="admAdmin.php">Administradores</a></li>
            </ul>
        </aside>
        <main class="content">
            <h1>Autenticar administrador</h1>
            <div class="new">
            <form action="controller/login.php" method="POST">
                <input type="text" name="idAdministrador" placeholder="ID de Usuario" required>
                <input type="password" name="contrasenha" placeholder="Contraseña" required>
                <button type="submit" class="btn btn-lg btn-primary" id="rounded-btn">Autenticar</button>
            </form>
            </div>
        </main>
    </div>

    <script>
        function mostrarFormulario() {
            var formulario = document.querySelector('.new'); // Selecciona el primer elemento con la clase 'new'
            if (formulario.style.display === 'none' || formulario.style.display === '') {
                formulario.style.display = 'block'; // Muestra el formulario
            } else {
                formulario.style.display = 'none'; // Oculta el formulario
            }
        }

    </script>
</body>
</html>
