<?php
include 'dao/platilloDAO.php';
include 'dao/categoriaDAO.php';


$platilloDAO = new PlatilloDAO();
$categoriaDAO = new CategoriaDAO();




$galeria = $platilloDAO->obtenerPlatillosVisibles();
$categorias = $categoriaDAO->obtenerCategorias();


$error = isset($_GET['error']) ? $_GET['error'] : 'Desconocido';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Start your development with FoodHut landing page.">
    <meta name="author" content="Devcrud">

    <title>Higal Restaurante Jardin</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- Incluye JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Incluye WOW.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>

    <!-- font icons -->
    <link rel="stylesheet" href="assets/vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="assets/vendors/animate/animate.css">

    <!-- Bootstrap + FoodHut main styles -->
    <link rel="stylesheet" href="assets/css/foodhut.css">
    <script src="assets/js/foodhut.js"></script>

    <link rel="stylesheet" href="assets/css/higal.css">


</head>

<body data-spy="scroll" data-target=".navbar" data-offset="40" id="home">
    <script>
        var error = <?php echo json_encode($error); ?>;
    </script>

    <!-- Navbar -->
    <nav class="custom-navbar navbar navbar-expand-lg navbar-dark fixed-top" data-spy="affix" data-offset-top="10">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse text-center" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#home">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">Sobre nosotros</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#gallary">Menu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#book-table">Reservaciones</a>
                </li>
            </ul>
            <a class="navbar-brand m-auto" href="#">
                <span class="brand-txt">Higal</span>
            </a>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#testmonial">Reseñas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">Contacto</a>
                </li>

            </ul>
        </div>
    </nav>



    <!-- Header -->

    <header id="home" class="header">
        <div class="overlay text-white text-center">
            <h1 class="display-2 font-weight-bold my-3">Higal</h1>
            <h2 class="display-4 mb-5">Restaurante Jardín</h2>
            <a class="btn btn-lg btn-primary" href="#gallary">Nuestro Menú</a>
        </div>
    </header>



    <!-- Promotions -->
    <div class="promotions container-fluid  ">
        PROMOCIONES
    </div>



    <!--  gallary Section  -->


    <div class="gallary row">
        <?php


        if ($galeria !== false && count($galeria) > 0) {
            foreach ($galeria as $row) {
                echo "
                <div class='col-4 col-lg-2 gallary-item wow fadeIn'>
                <img src='" . $row["imagen"] . "'alt='" . $row["nombre"] . "' class='gallary-img'>
                </div>";
            }
        } else {
            echo "<p>NO HAY PLATILLOS DISPONIBLES</p>";
        }
        ?>

    </div>



    <!-- book a table Section  -->
    <div class="has-height-xl has-bg-overlay text-center text-light middle-items" id="book-table">

        <h2 class="section-title mb-5">Reservaciones</h2>
        <form action="controller/reservacionLogic.php" method="POST">
            <div class="row mb-5">
                <div class="col-sm-6 col-md-3 my-2">
                    <input type="text" name="name" class="form-control form-control-lg custom-form-control"
                        placeholder="Nombre" maxlength="50" autocomplete="given-name" required>
                </div>
                <div class="col-sm-6 col-md-3 my-2">
                    <input type="email" name="email" class="form-control form-control-lg custom-form-control"
                        placeholder="Email" maxlength="30" autocomplete="family-name" required>
                </div>
                <div class="col-sm-6 col-md-3 my-2">
                    <input type="number" name="cantPersonas" class="form-control form-control-lg custom-form-control"
                        placeholder="Cantidad de invitados" max="20" min="1" required>
                </div>
                <div class="col-sm-6 col-md-3 my-2">
                    <input type="datetime-local" name="fecha" class="form-control form-control-lg custom-form-control"
                        placeholder="Fecha y Hora" required>
                </div>
            </div>

            <input type="hidden" id="action" name="action" value="insert">
            <input type="hidden" id="source" name="source" value="client">

            <button type="submit" class="btn btn-lg btn-primary" id="rounded-btn">Agendar cita</button>
        </form>

    </div>






    <!-- BLOG Section  -->

    <div id="gallary" class="container-fluid bg-dark text-light py-5 text-center wow fadeIn">



        <h2 class="section-title py-5">Nuestro menú</h2>
        <div class='row justify-content-center'>
            <div class='col-12 mb-5'>
                <ul class='nav nav-pills nav-justified mb-3' id='pills-tab' role='tablist'>

                    <?php
                    echo "
                    <li class='nav-item'>
                        <a class='nav-link active' id='pills-home-tab' data-toggle='pill' href='#" . $categorias[0]['nombre'] . "' role='tab'
                            aria-controls='pills-home' aria-selected='true'>" . $categorias[0]['nombre'] . "</a>
                    </li>
                ";

                    for ($i = 1; $i < count($categorias); $i++) {
                        echo "
                    <li class='nav-item'>
                        <a class='nav-link' id='pills-profile-tab' data-toggle='pill' href='#" . $categorias[$i]['nombre'] . "' role='tab'
                            aria-controls='pills-profile' aria-selected='false'>" . $categorias[$i]['nombre'] . "</a>
                    </li>
                    ";
                    }

                    ?>
                </ul>
            </div>
        </div>

        <div class="tab-content" id="pills-tabContent">

            <?php

            echo "<div class='tab-pane show active' id='" . $categorias[0]['nombre'] . "' role='tabpanel' aria-labelledby='pills-home-tab'>
                <div class='row'>
            ";

            $platillosCategoria = $platilloDAO->obtenerPlatillosPCat($categorias[0]['nombre']);

            if ($platillosCategoria !== false && count($platillosCategoria) > 0) {
                foreach ($platillosCategoria as $row) {
                    echo "
                <div class=' col-md-3'>
                    <div class='card bg-transparent border my-3 my-md-0'>
                        <img src='" . $row["imagen"] . "' alt='" . $row["nombre"] . "'
                            class='rounded-0 card-img-top mg-responsive' width='500'>
                        <div class='card-body'>
                            <h1 class='text-center mb-4'><a href='#" . $row["categoria"] . "' class='badge badge-primary'>$" . $row["precio"] . "</a></h1>
                            <h4 class='pt20 pb20'>" . $row["nombre"] . "</h4>
                            <p class='text-white'>" . $row["descripcion"] . "</p>
                        </div>
                    </div>
                </div>
                ";
                }
            } else {
                echo "<p>NO HAY CATEGORIAS DISPONIBLES</p>";
            }

            echo "</div>
            </div>";

            for ($i = 1; $i < count($categorias); $i++) {
                echo "
                <div class='tab-pane' id='" . $categorias[$i]['nombre'] . "' role='tabpanel' aria-labelledby='pills-profile-tab'>
                    <div class='row'>
                ";



                $platillosCategoria = $platilloDAO->obtenerPlatillosPCat($categorias[$i]['nombre']);

                if ($platillosCategoria !== false && count($platillosCategoria) > 0) {
                    foreach ($platillosCategoria as $row) {
                        echo "
                        <div class='col-md-3'>
                            <div class='card bg-transparent border my-3 my-md-0'>
                                <img src='" . $row["imagen"] . "' alt='" . $row["nombre"] . "'
                                    class='rounded-0 card-img-top mg-responsive' width='500'>
                                <div class='card-body'>
                                    <h1 class='text-center mb-4'><a href='#" . $row["categoria"] . "' class='badge badge-primary'>$" . $row["precio"] . "</a></h1>
                                    <h4 class='pt20 pb20'>" . $row["nombre"] . "</h4>
                                    <p class='text-white'>" . $row["descripcion"] . "</p>
                                </div>
                            </div>
                        </div>
                    ";
                    }
                } else {
                    echo "<p>NO HAY CATEGORIAS DISPONIBLES</p>";
                }
                echo "
                </div>
                </div>
                ";
            }

            ?>

        </div>


    </div>

    <!-- about -->


    <div class=" about row has-height-md" id="about">

        <div class="container col-md-4">
            <div class="card">
                <img class="card-img-top" src="assets/imgs/chef.jpg" alt="">
                <div class="card-body">
                    <p class="card-text">Chef Aldo Buendia</p>
                </div>

            </div>
        </div>

        <div class="container-fluid col-md-8 d-flex align-items-center">

            <div class="text-center">
                <div class="text-center bg-dark text-light has-height-sm middle-items wow fadeIn">
                    <h2 class="section-title">¿Quienes somos?</h2>
                </div>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent nec tempus magna, vitae malesuada sem.
                    Fusce ut faucibus nisl, quis imperdiet erat. Nam nibh magna, imperdiet eget sollicitudin eget,
                    condimentum ac odio. Nullam justo libero, condimentum sed nisl eu, lobortis eleifend tellus. Quisque
                    congue sit amet enim eget dictum. Sed vehicula est nulla, non laoreet turpis rhoncus ac. Maecenas sit
                    amet felis eu libero varius viverra. Ut vitae bibendum nulla.
                </p>
            </div>

        </div>

    </div>

    <!-- REVIEWS Section  -->
    <div id="testmonial" class="container-fluid wow fadeIn bg-dark text-light has-height-lg middle-items">
        <h2 class="section-title my-5 text-center">Que dicen nuestros clientes</h2>
        <div class="row mt-3 mb-5">
            <div class="col-md-4 my-3 my-md-0">
                <div class="testmonial-card">
                    <h3 class="testmonial-title">Elizabeth Aguilar</h3>
                    <h6 class="testmonial-subtitle"></h6>
                    <div class="testmonial-body">
                        <p>Hermosos lugar, la comida muy sabrosa y el servicio maravillosos. Un lugar muy recomendable con ambiente familiar</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 my-3 my-md-0">
                <div class="testmonial-card">
                    <h3 class="testmonial-title">Alexa Rodriguez</h3>
                    <h6 class="testmonial-subtitle"></h6>
                    <div class="testmonial-body">
                        <p>Esta muy bonito el lugar, es uno de los mejpres lugares en Chimalhuacán</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 my-3 my-md-0">
                <div class="testmonial-card">
                    <h3 class="testmonial-title">Geovany Díaz</h3>
                    <h6 class="testmonial-subtitle"></h6>
                    <div class="testmonial-body">
                        <p>Las comidas estan muy ricas y la cocteleria no esta nada mal</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CONTACT Section  -->
    <div id="contact" class="container-fluid bg-dark text-light border-top wow fadeIn">
        <div class="row">
            <div class="col-md-6 px-0">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3762.721334410449!2d-98.94986442478584!3d19.42444268185324!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85d1e3d71cf164d1%3A0x2a077eeb5ff8ce30!2sHigal!5e0!3m2!1ses!2smx!4v1720071426892!5m2!1ses!2smx" width="600" height="450" style="width: 100%; height: 100%; min-height: 400px; border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="col-md-6 px-5 has-height-lg middle-items">
                <h3>Visitanos</h3>
                <p>Te invitamos a conocer nuestro restaurante, un lugar donde podrás disfrutar de una experiencia gastronómica única. Nuestra misión es ofrecerte los mejores platillos con ingredientes frescos y de alta calidad. Ven y disfruta de un ambiente acogedor y familiar.</p>
                <div class="text-muted">
                    <p><span class="ti-location-pin pr-3"></span><a href="https://maps.app.goo.gl/wYkKMsbZnxC9fTiu5">Cda. Cognahuac 9, San Pedro, 56334 Chimalhuacán, Méx.</a></p>
                    <p><span class="ti-instagram pr-3"></span><a href="https://www.instagram.com/higal_restaurante_jardin">Instagram</a></p>
                    <p><span class="ti-facebook pr-3"></span><a href="https://www.facebook.com/p/HigAl-Restaurante-Jard%C3%ADn-100083409247341/">Facebook</a></p>
                </div>
            </div>
        </div>
    </div>

    <!-- page footer  -->
    <div class="container-fluid bg-dark text-light has-height-md middle-items border-top text-center wow fadeIn">
        <div class="row">
            <div class="col-sm-4">
                <h3>EMAIL</h3>
                <P class="text-muted">elhigalrestaurante@gmail.com</P>
            </div>
            <div class="col-sm-4">
                <h3>TELÉFONO</h3>
                <P class="text-muted">55 2078 8985</P>
            </div>
            <div class="col-sm-4">
                <h3>DIRECCIÓN</h3>
                <P class="text-muted">Cda. Cognahuac 9, San Pedro, 56334 Chimalhuacán, Méx.</P>
            </div>
        </div>
    </div>

    <!-- end of page footer -->

    <!-- core  -->
    <script src="assets/vendors/jquery/jquery-3.4.1.js"></script>
    <script src="assets/vendors/bootstrap/bootstrap.bundle.js"></script>

    <!-- bootstrap affix -->
    <script src="assets/vendors/bootstrap/bootstrap.affix.js"></script>

    <!-- wow.js -->
    <script src="assets/vendors/wow/wow.js"></script>



</body>

</html>