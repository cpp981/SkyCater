<?php
require_once '../src/session.php';
require_once '../src/timeSince.php';
setlocale(LC_TIME, 'es_ES.UTF-8');

if (!isset($_SESSION['nombre'])) {
    header('Location: login.html');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img/favicon.ico" type="image/x-icon">
    <title>Dashboard - SkyCater</title>
    <!-- jQuery -->
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <!-- Chart.js -->
    <script src="../node_modules/chart.js/dist/chart.umd.js"></script>
    <!--JSDelivr SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- css Font Awesome -->
    <link href="../node_modules/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <!-- CSS de Bootstrap -->
    <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- JavaScript de Bootstrap -->
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!--Js y Css -->
    <script src="../js/charts.js"></script>
    <script src="../js/sideBar.js"></script>
    <script src="../js/colorUtils.js"></script>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/responsive.css">
</head>

<body class="d-flex flex-column">
    <div class="super d-flex flex-grow-1">
        <div class="sidebar rounded-bottom shadow" id="sidebar">
            <div class="d-flex justify-content-center mt-3">
                <!-- Logo de la aplicación -->
                <a class="navbar-brand">
                    <img src="../img/LogoMenu2.png" alt="Logo" class="rounded img-fluid logo-menu">
                    <hr class="hr-custom w-75 mx-auto mt-3">
                </a>
            </div>
            <!-- Sección del usuario -->
            <div class="user-info d-flex justify-content-center align-items-center">
                <i class="fas fa-user text-white me-1 user-icon" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="left"
                    title="Usuario: <?php echo $_SESSION['nombre'];?> Conectado desde: <?php echo time_since($_SESSION['session_start_time']); ?>"></i>
                <p class="text-white text-center mt-2 mb-0 user-name"><?php echo $_SESSION['nombre']; ?></p>
            </div>
            <ul class="nav flex-column mt-5 justify-content-center align-content-between">
                <li class="nav-item mt-5">
                    <a class="nav-link" href="index.php"><i class="fas fa-dashboard me-1"></i><span>Dashboard</span></a>
                </li>
                <li class="nav-item mt-3">
                    <a class="nav-link" href="inventario.php"><i
                            class="fas fa-clipboard-list me-1"></i><span>Inventario</span></a>
                </li>
                <li class="nav-item mt-3">
                    <a class="nav-link" href="listaVuelos.php"><i
                            class="fas fa-plane-departure me-1"></i><span>Vuelos</span></a>
                </li>
                <li class="nav-item mt-3">
                    <a class="nav-link" href="pedido.php"><i class="fas fa-truck-fast me-1"></i><span>Pedidos</span></a>
                </li>
            </ul>
            </ul>
            <div class="d-flex justify-content-center align-items-end mt-3" style="height: 270px; margin-left: -25px;">
                <!-- <a class="nav-link text-white"><i class="fas fa-lg fa-moon"></i> Modo Oscuro</a>-->
            </div>
        </div>
        <div class="flex-grow-1">
            <nav class="navbar navbar-light bg-light">
                <div class="">
                    <button class="btn border-light" id="sidebarToggle" style="color: #003262"><i
                            class="fas fa-lg fa-bars"></i> Menú</button>
                </div>
                <div id="session" class="ms-auto d-flex justify-content-center align-items-center">
                    <p class="mx-2" style="color:#003262; line-height: 2.5; margin-bottom: 0;">Bienvenido,</p>
                    <input type="text" class="form-control d-inline-block w-25" id="inputId"
                        value="<?php echo $_SESSION['nombre']; ?>" disabled>
                    <button id="close" class="btn text-white btn-danger">
                        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                    </button>
                </div>
            </nav>
             <!-- Contenedor de fondo con imagen -->
             <div class="position-relative">
                <img src="../img/SkyCaterPlane.png" class="custom-bg-image w-100"
                    style="height: 300px; object-fit: cover;">
                <div class="overlay"></div>
            </div>
            <div class="dash text-center mb-3" style="color: #003262;">
                <h2>Dashboard</h2>
            </div>
            <div cass="container-flex mt-5">
                <div class="d-flex flex-wrap align-content-between justify-content-center">
                    <div class="d-flex flex-column" style="margin-top: 37px;" id="indicativo1">

                        <div class="card shadow" style="height: 184px; width: 334px; margin-top: -27px;">
                            <div class="indi card-body">
                                <p class="text-center"><i class="fas fa-utensils me-2"></i></i>Productos sin alérgenos
                                    en stock</p>
                                <h1 class="text-center" id="prodNoAlergenos" style="font-size: 4.5em;"></h1>
                                <p class="text-end"><?php echo strftime('%d %b %Y'); ?></p>
                            </div>
                        </div>
                        <div class="card shadow" style="height: 334px;">
                            <div class="card-body">
                                <canvas id="chart5" style="height: 300px; width: 300px;"></canvas>
                            </div>
                        </div>

                    </div>
                    <div class="d-flex flex-column">
                        <div class="card shadow">
                            <div class="card-body ">
                                <canvas id="chart3"></canvas>
                            </div>
                        </div>

                        <div class="card shadow">
                            <div class="card-body ">
                                <canvas id="chart1"></canvas>
                            </div>
                        </div>

                    </div>
                    <div class="d-flex flex-wrap">
                        <div class="d-flex flex-column">
                            <div class="card shadow">
                                <div class="card-body ">
                                    <canvas id="chart4"></canvas>
                                </div>
                            </div>

                            <div class="card shadow">
                                <div class="card-body ">
                                    <canvas id="chart2"></canvas>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="d-flex flex-column mb-5" style="margin-top: 37px;">
                        <div class="card shadow" style="height: 184px; width: 334px; margin-top: -27px;">
                            <div class="indi card-body ">
                                <p class="text-center"><i class="fas fa-users me-2"></i>Personas con
                                    intolerancias este mes</p>
                                <h1 class="text-center" id="intolerancias" style="font-size: 4.5em;"></h1>
                                <p class="text-end"><?php echo date('d M Y'); ?></p>
                            </div>
                        </div>
                        <div class="card shadow mb-5" style="height: 334px;">
                            <div class="card-body" style="margin-top: -5px;">
                                <canvas id="chart6" style="height: 280px; width: 275px;"></canvas>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="foot d-flex justify-content-center align-items-end mt-5">
        <footer class="fixed-bottom text-center">
            <p>© 2024 SkyCater. Todos los derechos reservados.</p>
        </footer>
    </div>
</body>

</html>