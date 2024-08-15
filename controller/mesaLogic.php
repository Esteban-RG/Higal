
<?php
include '../dao/mesaDAO.php';

$mesaDAO = new MesaDAO();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $action = $_POST['action'];
    $idMesa = intval($_POST['idMesa']);


   
    if($action == 'insert'){

        $asientos = $_POST['asientos'];

        $mesaInsertada = $mesaDAO -> insertarMesa($idMesa,$asientos);

        if ($mesaInsertada) {
            header('Location: ../admMesa.php?error=false');
        } else {
            header('Location: ../admMesa.php?error=systemError'); 
        }

        

    }else if ($action == 'update') {
        $asientos = $_POST['asientos'];

        $mesaActualizada = $mesaDAO -> actualizarMesa($idMesa,$asientos);

        if ($mesaActualizada) {
            header('Location: ../admMesa.php?error=false');
        } else {
            header('Location: ../admMesa.php?error=systemError'); 
        }

       
    }else if ($action == 'delete') {

        $mesaEliminada = $mesaDAO -> eliminarMesa($idMesa);

        if ($mesaEliminada) {
            header('Location: ../admMesa.php?error=false');
        } else {
            header('Location: ../admMesa.php?error=systemError'); 
        }
       
    }

    

} else {
    echo "Método de solicitud no permitido.";
}
?>
