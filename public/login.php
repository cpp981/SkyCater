<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SkyCater</title>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <!--CSS Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!--JS Bootstrap CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!--CSS FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!--JSDelivr CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <script rel="text/js" src="../js/login.js"></script>
</head>

<body class="d-flex flex-column">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="d-flex flex-column align-items logoLogin">
            <a href="#" class="text-dark"><i style="color:#003262;" class="fas fa-2x fa-cloud"></i></a>
            <a class="navbar-brand" href="#" style="color:#003262;">SkyCater</a>

            <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button> -->
        </div>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <!-- <button id="toggle-dark-mode" class="btn btn-secondary">Modo Oscuro</button>-->
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-5 contLogin">
        <div class="d-flex justify-content-center h-100">
            <div class="card shadow" style='width:24rem;'>
                <div class="card-header">
                    <h3 class="loginTittle">Login</h3>
                </div>
                <div class="card-body">
                    <form id="loginForm">
                        <div class="input-group form-group mt-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text h-100"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="Usuario" id='username'>
                        </div>
                        <div class="input-group form-group mt-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text h-100"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" class="form-control" placeholder="Contraseña" id='password'>
                        </div>
                        <div class="form-group text-center">
                            <button id="btn-login" type="submit" class="btn w-100 btn-block mt-5 text-white"><i
                                    class="fas fa-sign-in "></i>Iniciar Sesión</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center mt-auto align-items-end text-center"
        style="height: 300px; margin-top: 100px; resize: both;">
        <footer class="fixed-bottom">
            <p>© 2024 SkyCater. Todos los derechos reservados.</p>
        </footer>
    </div>
</body>

</html>