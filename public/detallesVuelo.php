<?php
require_once '../src/session.php';
require_once '../src/timeSince.php';
if (!isset($_SESSION['nombre'])) {
    header('Location:index.html');
    exit();
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    ?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="../img/favicon.ico" type="image/x-icon">
        <title>Gestión de Catering de Aerolínea</title>
        <!-- jQuery -->
        <script src="../node_modules/jquery/dist/jquery.min.js"></script>
        <!-- CSS de DataTables -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
        <!-- CSS de Buttons para DataTables -->
        <link rel="stylesheet" type="text/css"
            href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
        <!-- CSS de Bootstrap -->
        <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- css Font Awesome -->
        <link href="../node_modules/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
        <!--JSDelivr SweetAlert2 CDN -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- Estilos de Notyf -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css">
        <!-- Script de Notyf -->
        <script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>
        <link rel="stylesheet" href="../css/styles.css">
        <link rel="stylesheet" href="../css/responsive.css">
        <script type="text/javascript" src="../js/sideBar.js"></script>
        <script src="../js/colorUtils.js"></script>
        <script src="../js/detalleVuelos.js"></script>
        <script src="../js/mapa.js"></script>
        <script type="text/javascript" 
                src="https://www.bing.com/api/maps/mapcontrol?key=AuclIH7tjOOM0U1sN23KcivEu101gRo9PTWX5wv-CoUYf7G-ujoaBZ7bPIWy9D49&callback=initMap&setLang=es-ES" 
                async defer></script>
    </head>

    <body class="d-flex flex-column">
        <div class="super d-flex flex-grow-1">
            <!-- Sidebar -->
            <div class="sidebar rounded-bottom shadow" id="sidebar">
                <!-- Logo y contenido de usuario -->
                <div class="d-flex justify-content-center mt-3">
                    <a class="navbar-brand">
                        <img src="../img/LogoMenu2.png" alt="Logo" class="rounded img-fluid logo-menu">
                        <hr class="hr-custom w-75 mx-auto mt-3">
                    </a>
                </div>
                <div class="user-info d-flex justify-content-center align-items-center">
                    <i class="fas fa-user text-white me-1 user-icon" data-bs-toggle="tooltip" data-bs-html="true"
                        data-bs-placement="left"
                        title="Usuario: <?php echo $_SESSION['nombre']; ?> Conectado desde: <?php echo time_since($_SESSION['session_start_time']); ?>"></i>
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
                        <ul class="nav flex-column ms-3">
                            <?php if (basename($_SERVER['PHP_SELF']) == 'detallesVuelo.php') { ?>
                                <li class="nav-item mt-2">
                                    <a class="nav-link active" href="detallesVuelo.php?id=<?php echo $_GET['id']; ?>">
                                        <i class="fas fa-gear me-1"></i><span>Gestión</span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <li class="nav-item mt-3">
                        <a class="nav-link" href="pedido.php"><i class="fas fa-truck-fast me-1"></i><span>Pedidos</span></a>
                    </li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="flex-grow-1 d-flex flex-column">
                <!-- Navbar -->
                <nav class="navbar navbar-light bg-light">
                    <div class="">
                        <button class="btn border-light" id="sidebarToggle" style="color: #003262"><i
                                class="fas fa-lg fa-bars"></i> Menú</button>
                    </div>
                    <div id="session" class="ms-auto d-flex justify-content-center align-items-center">
                        <p class="mx-2" style="color:#003262; margin-bottom: 0;">Bienvenido,</p>
                        <input type="text" class="form-control d-inline-block w-25" id="inputId"
                            value="<?php echo $_SESSION['nombre']; ?>" disabled>
                        <button id="close" class="btn text-white shadow btn-danger">
                            <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                        </button>
                    </div>
                </nav>

                <!-- Contenido principal -->
                <div class="container-fluid mt-4">
                    <!-- Título y botones -->
                    <div class="text-center mb-4">
                        <h2>Gestión del Vuelo <?php echo $_GET['id']; ?></h2>
                        <div class="btn-group mt-1" role="group" aria-label="Botones de navegación">
                            <button type="button" class="btn btn-primary rounded-pill active me-4" id="detallesBtn"><i
                                    class="fas fa-circle-info me-2"></i>Detalles</button>
                            <button type="button" class="btn btn-light rounded-pill" id="pasajerosBtn"><i
                                    class="fas fa-person me-2"></i>Pasajeros</button>
                            <a href="listaVuelos.php" class="btn btn-light rounded-pill ms-4"><i
                                    class="fas fa-arrow-left-long me-2"></i>Volver</a>
                        </div>
                    </div>

                    <!-- Contenedor dividido en dos y centrado -->
                    <div class="row justify-content-center">
                        <!-- Columna de detalles -->
                        <div class="col-md-5 text-center">
                            <h4>Detalles del vuelo</h4>
                            <ul class=" list-group">
                                <li id="numVuelo" class="list-group-item disabled"><strong>Número de Vuelo:</strong> </li>
                                <li id="origen" class="list-group-item disabled"><strong>Origen:</strong> </li>
                                <li id="destino" class="list-group-item disabled"><strong>Destino:</strong> </li>
                                <li id="horaSalida" class="list-group-item disabled"><strong>Hora de salida:</strong> </li>
                                <li id="horaLlegada" class="list-group-item disabled"><strong>Hora de llegada:</strong> </li>
                                <li id="estado" class="list-group-item disabled"><strong>Estado:</strong> </li>
                            </ul>
                            <div class="row justify-content-center card shadow rounded" style="height: 38vh;">
                                <div class="card-body col-md-10 border w-100" id="mapa" style="height: 38vh;"></div>
                                <!-- Mapa con un tamaño fijo -->
                            </div>
                        </div>

                        <!-- Barra de separación (línea vertical negra) -->
                        <div class="col-md-1 d-flex justify-content-center align-items-center">
                            <div class="vr" style="height: 100%; border-left: 3px solid black;"></div>
                        </div>

                        <!-- Columna de la gráfica -->
                        <!-- Columna de la gráfica -->
                        <div class="col-md-5 text-center">
                            <h4>Indicadores y gráfica</h4>
                            <!-- Contenedor de los indicadores -->
                            <div class="d-flex justify-content-between mb-4">
                                <!-- Card Indicador 1 -->
                                <div class="card shadow text-center" style="width: 48%;">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary">Indicador 1</h5>
                                        <p class="card-text fs-4 fw-bold text-dark"></p>
                                        <p class="text-muted mb-0">Porcentaje de ocupación</p>
                                    </div>
                                </div>
                                <!-- Card Indicador 2 -->
                                <div class="card shadow text-center" style="width: 48%;">
                                    <div class="card-body">
                                        <h5 class="card-title text-success">Indicador 2</h5>
                                        <p class="card-text fs-4 fw-bold text-dark"></p>
                                        <p class="text-muted mb-0">Pasajeros con intolerancias</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Card de la gráfica -->
                            <div class="card shadow mb-2">
                                <div class="card-body">
                                    <h5 class="card-title">Nº Pasajeros por tipo de asiento</h5>
                                    <canvas id="flightChart" style="max-height: 250px;"></canvas>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Scripts de Bootstrap, jQuery y Chart.js -->
        <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Chart.js -->
        <script src="../node_modules/chart.js/dist/chart.umd.js"></script>
        <!--<script src="../js/flightDetails.js"></script> Aquí iría tu lógica de Chart.js -->
    </body>

    <?php
} else {
    header('Location: listaVuelos.php');
    echo "No se ha especificado un vuelo.";
}
?>