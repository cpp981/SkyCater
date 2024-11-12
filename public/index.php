<?php
require_once '../src/session.php';

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
    <title>Dashboard - SkyCater</title>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <!-- css Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- css Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="../js/charts.js"></script>
    <script src="../js/dash.js"></script>
    <link rel="stylesheet" href="../css/styles.css">
    <!-- Bootstrap CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!--JSDelivr CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <div class="d-flex">
        <div class="sidebar rounded-bottom shadow" id="sidebar">
            <i id="cloud-logo" class="fas fa-2x fa-cloud mt-3"></i>
            <h4 class="text-white text-center mt-2">SkyCater</h4>
            <ul class="nav flex-column mt-5 justify-content-center align-content-between">
                <li class="nav-item mt-5"></li>
                <a class="nav-link text-white" href="#"><i class="fas fa-dashboard"></i> Dashboard</a>
                </li>
                <li class="nav-item mt-3">
                    <a class="nav-link text-white" href="listaVuelos.php"><i class="fas fa-plane-departure"></i>
                        Vuelos</a>
                </li>
                <li class="nav-item mt-3">
                    <a class="nav-link text-white" href="inventario.php"><i class="fas fa-clipboard-list"></i>
                        Inventario</a>
                </li>
                <li class="nav-item mt-3"></li>
                <a class="nav-link text-white" href="pedido.php"><i class="fas fa-truck-fast"></i> Pedidos</a>
                </li>
                <!-- Añadir más elementos del menú aquí -->
            </ul>
            <div class="d-flex justify-content-center align-items-end mt-3" style="height: 270px; margin-left: -25px;">
                <a class="nav-link text-white"><i class="fas fa-lg fa-moon"></i> Modo Oscuro</a>
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
                    <button id="close" class="btn text-white" style="background-color: #003262;">
                        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                    </button>
                </div>
            </nav>
            <div class="dash text-center mb-3" style="color: #003262;">
                <h2>Dashboard</h2>
            </div>
            <div cass="container-flex mt-5">
                <div class="d-flex flex-wrap align-content-between justify-content-center">
                    <div class="d-flex flex-column" style="margin-top: 37px;" id="indicativo1">

                    <div class="card shadow"
                            style="height: 184px; width: 334px; margin-top: -27px;"> <!-- background-color:#29AB87; -->
                            <div class="indi card-body">
                                <p class="text-center">Productos sin alérgenos en stock</p>
                                <h1 class="text-center" id="prodNoAlergenos" style="font-size: 4.5em;"></h1>
                            </div>
                        </div>
                        <div class="card shadow" style="height: 334px;">
                            <div class="card-body">
                                <!--<p class="text-center">Vuelos pendientes hoy</p>
                                <h1 class="text-center" style="font-size: 4em;">5</h1>
                                <p class="text-danger"><i class="fas fa-2x fa-arrow-trend-down"></i></p>-->
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
                                <p class="text-center">Personas a bordo con intolerancias<br>este mes</p>
                                <h1 class="text-center" id="intolerancias" style="font-size: 4.5em;">21</h1>
                            </div>
                        </div>
                        <div class="card shadow mb-5" style="height: 334px;">
                            <div class="card-body" style="margin-top: -5px;">
                                <!--<p class="text-center">Vuelos pendientes hoy</p>
                                <h1 class="text-center" style="font-size: 4em;">5</h1>
                                <p class="text-success"><i class="fas fa-2x fa-arrow-trend-up"></i></p>-->
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