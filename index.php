<?php
$reservation = isset($_GET['reservation']) ? $_GET['reservation'] : 'Desconocido';
$error = isset($_GET['errors']) ? $_GET['errors'] : 'Desconocido';

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
</head>

<body data-spy="scroll" data-target=".navbar" data-offset="40" id="home">
    <script>
        var reservation = <?php echo json_encode($reservation); ?>;
        var errors = <?php echo json_encode($error); ?>;

        if (reservation === 'true') {
            Swal.fire({
                icon: "success",
                title: "Tu reservacion se almaceno correctamente",
                text: "Recibiras un correo confirmando tu reservacion"
            }).then(() => {
                window.location.href='index.php';
            });
        }

        if (errors != 'Desconocido') {
            Swal.fire({
                icon: "error",
                text: errors,
            }).then(() => {
                window.location.href='index.php';
            });
        }
    </script>

    <!-- Navbar -->
    <nav class="custom-navbar navbar navbar-expand-lg navbar-dark fixed-top" data-spy="affix" data-offset-top="10">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
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
                    <a class="nav-link" href="#blog">Blog<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#testmonial">Reviews</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">Contact Us</a>
                </li>
                
            </ul>
        </div>
    </nav>

    <!-- header -->

    <header id="home" class="header">
        <div class="overlay text-white text-center">
            <h1 class="display-2 font-weight-bold my-3">Higal</h1>
            <h2 class="display-4 mb-5">Restaurante Jardin</h2>
            <a class="btn btn-lg btn-primary" href="#gallary">Nuestro menu</a>
        </div>
    </header>

    <section>

        <div>
            <div id="about" class="text-center bg-dark text-light has-height-md middle-items wow fadeIn">
                <h2 class="section-title" >¿Quienes somos?</h2>
            </div>
            <table class="sobreNostros" >

                <tr>
                    <td><img src="assets/imgs/HigalComida2.png" alt="" width="800" height="500"></td>
                    <td>
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Voluptas hic vero placeat corrupti
                            est ut laudantium quibusdam repudiandae sit qui! At dignissimos iste necessitatibus omnis
                            iure voluptas tenetur optio aliquid.</p>
                    </td>
                </tr>
            </table>
        </div>


    </section>

    <!--  gallary Section  -->
    <div id="gallary" class="text-center bg-dark text-light has-height-md middle-items wow fadeIn">
        <h2 class="section-title">Nuestro Menu</h2>
    </div>


    <div class="gallary row">
    <?php

        include 'controller/conexion.php';

        $sql = "SELECT nombre, descripcion, precio, imagen FROM Platillo ";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "
                <div class='col-sm-6 col-lg-3 gallary-item wow fadeIn'>
                <img src=".$row["imagen"]." alt=".$row["nombre"]." class='gallary-img'>
                <div href='#'class='gallary-overlay'>
                <p class='name'>".$row["nombre"]."</p><br>
                <p>".$row["descripcion"]."</p><br>
                <p class='price'>$".$row["precio"]."</p>
                </div>
                </div>";
            }
        } else {
            echo "<p>NO HAY PLATILLOS DISPONIBLES</p>";
        }

        $conn->close();
    ?>

    </div>

    <!-- book a table Section  -->
    <div class="container-fluid has-bg-overlay text-center text-light has-height-lg middle-items" id="book-table">
        <div class="">
            <h2 class="section-title mb-5">Reservaciones</h2>
            <form action="controller/reservacionesDAO.php" method="POST">
                <div class="row mb-5">
                    <div class="col-sm-6 col-md-3 col-xs-12 my-2">
                        <input type="text" name="name" class="form-control form-control-lg custom-form-control" placeholder="Nombre" maxlength="50" required>
                    </div>
                    <div class="col-sm-6 col-md-3 col-xs-12 my-2">
                        <input type="email" name="email" class="form-control form-control-lg custom-form-control" placeholder="Email"  maxlength="30" required>
                    </div>
                    <div class="col-sm-6 col-md-3 col-xs-12 my-2">
                        <input type="number" name="cantPersonas" class="form-control form-control-lg custom-form-control" placeholder="Cantidad de invitados" max="20" min="1" required>
                    </div>
                    <div class="col-sm-6 col-md-3 col-xs-12 my-2">
                        <input type="datetime-local" name="fecha" class="form-control form-control-lg custom-form-control" placeholder="Fecha y Hora" required >
                    </div>
                    <input type="hidden" id="action" name="action" value="insert" >
                    <input type="hidden" id="source" name="source" value="client" >

                </div>
                <button type="submit" class="btn btn-lg btn-primary" id="rounded-btn">Agendar cita</button>
            </form>
        </div>
    </div>

    <!-- BLOG Section  -->

    <div id="blog" class="container-fluid bg-dark text-light py-5 text-center wow fadeIn">
        <h2 class="section-title py-5">Nuestro menu para eventos</h2>
        <div class="row justify-content-center">
            <div class="col-sm-7 col-md-4 mb-5">
                <ul class="nav nav-pills nav-justified mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#foods" role="tab"
                            aria-controls="pills-home" aria-selected="true">Foods</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#juices" role="tab"
                            aria-controls="pills-profile" aria-selected="false">Juices</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="foods" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card bg-transparent border my-3 my-md-0">
                            <img src="assets/imgs/blog-1.jpg" alt="template by DevCRID http://www.devcrud.com/"
                                class="rounded-0 card-img-top mg-responsive" width="500">
                            <div class="card-body">
                                <h1 class="text-center mb-4"><a href="#" class="badge badge-primary">$5</a></h1>
                                <h4 class="pt20 pb20">Reiciendis Laborum</h4>
                                <p class="text-white">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa
                                    provident illum officiis fugit laudantium voluptatem sit iste delectus qui ex. </p>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="card bg-transparent border my-3 my-md-0">
                            <img src="assets/imgs/blog-2.jpg" alt="template by DevCRID http://www.devcrud.com/"
                                class="rounded-0 card-img-top mg-responsive">
                            <div class="card-body">
                                <h1 class="text-center mb-4"><a href="#" class="badge badge-primary">$12</a></h1>
                                <h4 class="pt20 pb20">Adipisci Totam</h4>
                                <p class="text-white">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa
                                    provident illum officiis fugit laudantium voluptatem sit iste delectus qui ex. </p>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="card bg-transparent border my-3 my-md-0">
                            <img src="assets/imgs/blog-3.jpg" alt="template by DevCRID http://www.devcrud.com/"
                                class="rounded-0 card-img-top mg-responsive">
                            <div class="card-body">
                                <h1 class="text-center mb-4"><a href="#" class="badge badge-primary">$8</a></h1>
                                <h4 class="pt20 pb20">Dicta Deserunt</h4>
                                <p class="text-white">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa
                                    provident illum officiis fugit laudantium voluptatem sit iste delectus qui ex. </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="juices" role="tabpanel" aria-labelledby="pills-profile-tab">
                <div class="row">
                    <div class="col-md-4 my-3 my-md-0">
                        <div class="card bg-transparent border">
                            <img src="assets/imgs/blog-4.jpg" alt="template by DevCRID http://www.devcrud.com/"
                                class="rounded-0 card-img-top mg-responsive">
                            <div class="card-body">
                                <h1 class="text-center mb-4"><a href="#" class="badge badge-primary">$15</a></h1>
                                <h4 class="pt20 pb20">Consectetur Adipisicing Elit</h4>
                                <p class="text-white">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa
                                    provident illum officiis fugit laudantium voluptatem sit iste delectus qui ex. </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 my-3 my-md-0">
                        <div class="card bg-transparent border">
                            <img src="assets/imgs/blog-5.jpg" alt="template by DevCRID http://www.devcrud.com/"
                                class="rounded-0 card-img-top mg-responsive">
                            <div class="card-body">
                                <h1 class="text-center mb-4"><a href="#" class="badge badge-primary">$29</a></h1>
                                <h4 class="pt20 pb20">Ullam Laboriosam</h4>
                                <p class="text-white">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa
                                    provident illum officiis fugit laudantium voluptatem sit iste delectus qui ex. </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 my-3 my-md-0">
                        <div class="card bg-transparent border">
                            <img src="assets/imgs/blog-6.jpg" alt="template by DevCRID http://www.devcrud.com/"
                                class="rounded-0 card-img-top mg-responsive">
                            <div class="card-body">
                                <h1 class="text-center mb-4"><a href="#" class="badge badge-primary">$3</a></h1>
                                <h4 class="pt20 pb20">Fugit Ipsam</h4>
                                <p class="text-white">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa
                                    provident illum officiis fugit laudantium voluptatem sit iste delectus qui ex. </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- REVIEWS Section  -->
    <div id="testmonial" class="container-fluid wow fadeIn bg-dark text-light has-height-lg middle-items">
        <h2 class="section-title my-5 text-center">Que dicen nuestros clientes</h2>
        <div class="row mt-3 mb-5">
            <div class="col-md-4 my-3 my-md-0">
                <div class="testmonial-card">
                    <h3 class="testmonial-title">John Doe</h3>
                    <h6 class="testmonial-subtitle">Web Designer</h6>
                    <div class="testmonial-body">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Earum nobis eligendi, quaerat
                            accusamus ipsum sequi dignissimos consequuntur blanditiis natus. Aperiam!</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 my-3 my-md-0">
                <div class="testmonial-card">
                    <h3 class="testmonial-title">Steve Thomas</h3>
                    <h6 class="testmonial-subtitle">UX/UI Designer</h6>
                    <div class="testmonial-body">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laborum minus obcaecati cum
                            eligendi perferendis magni dolorum ipsum magnam, sunt reiciendis natus. Aperiam!</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 my-3 my-md-0">
                <div class="testmonial-card">
                    <h3 class="testmonial-title">Miranda Joy</h3>
                    <h6 class="testmonial-subtitle">Graphic Designer</h6>
                    <div class="testmonial-body">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, nam. Earum nobis eligendi,
                            dignissimos consequuntur blanditiis natus. Aperiam!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CONTACT Section  -->
    <div id="contact" class="container-fluid bg-dark text-light border-top wow fadeIn">
        <div class="row">
            <div class="col-md-6 px-0">
                <div id="map" style="width: 100%; height: 100%; min-height: 400px"></div>
            </div>
            <div class="col-md-6 px-5 has-height-lg middle-items">
                <h3>FIND US</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sit, laboriosam doloremque odio delectus,
                    sunt magnam laborum impedit molestiae, magni quae ipsum, ullam eos! Alias suscipit impedit et,
                    adipisci illo quam.</p>
                <div class="text-muted">
                    <p><span class="ti-location-pin pr-3"></span> 12345 Fake ST NoWhere, AB Country</p>
                    <p><span class="ti-support pr-3"></span> (123) 456-7890</p>
                    <p><span class="ti-email pr-3"></span>info@website.com</p>
                </div>
            </div>
        </div>
    </div>

    <!-- page footer  -->
    <div class="container-fluid bg-dark text-light has-height-md middle-items border-top text-center wow fadeIn">
        <div class="row">
            <div class="col-sm-4">
                <h3>EMAIL US</h3>
                <P class="text-muted">info@website.com</P>
            </div>
            <div class="col-sm-4">
                <h3>CALL US</h3>
                <P class="text-muted">(123) 456-7890</P>
            </div>
            <div class="col-sm-4">
                <h3>FIND US</h3>
                <P class="text-muted">12345 Fake ST NoWhere AB Country</P>
            </div>
        </div>
    </div>
    <div class="bg-dark text-light text-center border-top wow fadeIn">
        <p class="mb-0 py-3 text-muted small">&copy; Copyright
            <script>document.write(new Date().getFullYear())</script> Made with <i class="ti-heart text-danger"></i> By
            <a href="http://devcrud.com">DevCRUD</a>
        </p>
    </div>
    <!-- end of page footer -->

    <!-- core  -->
    <script src="assets/vendors/jquery/jquery-3.4.1.js"></script>
    <script src="assets/vendors/bootstrap/bootstrap.bundle.js"></script>

    <!-- bootstrap affix -->
    <script src="assets/vendors/bootstrap/bootstrap.affix.js"></script>

    <!-- wow.js -->
    <script src="assets/vendors/wow/wow.js"></script>

    <!-- google maps -->
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCtme10pzgKSPeJVJrG1O3tjR6lk98o4w8&callback=initMap"></script>

  

</body>

</html>