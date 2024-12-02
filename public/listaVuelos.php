<?php
require_once '../src/session.php';
require_once '../src/timeSince.php';
if (!isset($_SESSION['nombre'])) {
    header('Location:index.html');
    exit();
}
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
    <!-- css DataTables CDN -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <script type="text/javascript" src="../js/vuelos.js"></script>
    <script type="text/javascript" src="../js/sideBar.js"></script>
</head>

<body>
    <div class="super d-flex">
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
                </li>
                <li class="nav-item mt-3">
                    <a class="nav-link" href="pedido.php"><i class="fas fa-truck-fast me-1"></i><span>Pedidos</span></a>
                </li>
            </ul>
            <div class="d-flex justify-content-center align-items-end mt-5">
                <!-- <a class="nav-link text-white"><i class="fas fa-lg fa-moon"></i> Modo Oscuro</a>-->
            </div>
        </div>

        <!-- Contenido principal -->
        <div class="flex-grow-1 d-flex flex-column w-100">
            <!-- Barra superior -->
            <nav class="navbar navbar-light bg-light">
                <div>
                    <button class="btn border-light" id="sidebarToggle" style="color: #003262">
                        <i class="fas fa-lg fa-bars"></i> Menú
                    </button>
                </div>
                <div id="session" class="ms-auto d-flex align-items-center">
                    <p class="mx-2" style="color:#003262; margin-bottom: 0;">Bienvenido,</p>
                    <input type="text" class="form-control w-25" id="inputId" value="<?php echo $_SESSION['nombre']; ?>"
                        disabled>
                    <button id="close" class="btn text-white btn-danger ms-2">
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

            <div id="containerTablaVuelos" class="d-flex flex-column align-items-center p-4"
                style="width: 95%; margin: 0 auto;">
                <!-- Título -->
                <h1 class="text-center mb-4">Listado de Vuelos</h1>

                <!-- Contenedor de los indicadores -->
                <div class="d-flex justify-content-between mb-4">
                    <!-- Card Indicador de Vuelos gestionados -->
                    <div class="card shadow text-center me-5" style="width: 35vh">
                        <div class="card-body">
                            <h5 class="card-title text-success">
                                <i class="fas fa-plane-circle-check fa-lg"></i> Vuelos gestionados
                            </h5>
                            <p id="card-gestionados" class="card-text fs-4 fw-bold text-dark"></p>
                        </div>
                    </div>

                    <!-- Card Indicador de Vuelos pendientes de gestionar -->
                    <div class="card shadow text-center" style="width: 35vh">
                        <div class="card-body">
                            <h5 class="card-title text-warning">
                                <i class="fas fa-plane-arrival fa-lg"></i> Vuelos pendientes
                            </h5>
                            </h5>
                            <p id="card-sin-gestionar" class="card-text fs-4 fw-bold text-dark"></p>
                        </div>
                    </div>
                </div>

                <!-- Tabla DataTables -->
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <table id="tablaVuelos" class="table table-striped table-bordered ms-5 shadow rounded">
                        <thead>
                            <tr>
                                <th class="centered cabecera"></th>
                                <th class="centered cabecera"></th>
                                <th class="centered cabecera"></th>
                                <th class="centered cabecera"></th>
                                <th class="centered cabecera"></th>
                                <th class="centered cabecera"></th>
                                <th class="centered cabecera"></th>
                                <th class="centered cabecera"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Contenido dinámico de la tabla -->
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <footer class="fixed-bottom text-center">
        <p>© 2024 SkyCater. Todos los derechos reservados.</p>
    </footer>

    <!-- JavaScript -->
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
</body>

</html>