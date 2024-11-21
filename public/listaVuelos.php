<?php
require_once '../src/session.php';
if (!isset($_SESSION['nombre'])) {
    header('Location:login.html');
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

<body style="background-color: #EDEAE0;">
    <div class="d-flex">
        <div class="sidebar rounded-bottom shadow" id="sidebar">
            <div class="d-flex justify-content-center mt-3">
                <!-- Logo de la aplicación -->
                <a class="navbar-brand">
                    <img src="../img/LogoMenu2.png" alt="Logo" class="rounded img-fluid logo-menu">
                    <hr class="hr-custom w-75 mx-auto mt-3">
                    <p class="text-white text-center mt-2"><i
                            class="fas fa-user text-white me-1"></i><?php echo $_SESSION['nombre'] ?></p>
                </a>
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
            <div class="d-flex justify-content-center align-items-end mt-5" style="height: 270px; margin-left: -25px;">
                <!-- <a class="nav-link text-white"><i class="fas fa-lg fa-moon"></i> Modo Oscuro</a>-->
            </div>
        </div>
        <div class="flex-grow-1 d-flex flex-column">
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
            
            <div class="custom-container-fondo position-relative">
               <img src="../img/SkyCaterPlane.png" class="custom-bg-image">
                <div id="containerTablaVuelos" class="d-flex flex-column align-items-center position-relative">
                    <div class="text-center" style="color: #003262;">
                        <h2>Listado de Vuelos</h2>
                        <div class="d-flex align-items-center justify-content-center mb-4">
                            <div class="card me-2 mb-5 indi-vuelos text-center rounded shadow">
                                <p><i class="fas fa-tasks me-1"></i>Vuelos Completados</p>
                                <p id="card-gestionados" class="text-center fw-bold valor-indi-vuelo">50</p>
                            </div>
                            <div class="card me-2 mb-5 indi-vuelos text-center rounded shadow">
                                <p><i class="fas fa-hourglass-half me-1"></i>Vuelos Pendientes</p>
                                <p id="card-sin-gestionar" class="text-center fw-bold valor-indi-vuelo">20</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-center mb-4">
                            <div class="card me-2 mb-4 indi-vuelos text-center rounded shadow">
                                <p><i class="fas fa-plane-departure me-1"></i>Próximo Vuelo</p>
                                <p id="card-gestionados" class="text-center fw-bold valor-indi-vuelo">50</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Contenedor de la tabla -->
            <div class="custom-contenedor-dataTable flex-grow-1 w-75">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <table id="tablaVuelos" class="table table-striped rounded shadow custom-table">
                        <thead>
                            <tr>
                                <th class="centered cabecera"></th>
                                <th class="centered cabecera"></th>
                                <th class="centered cabecera"></th>
                                <th class="centered cabecera"></th>
                                <th class="centered cabecera"></th>
                                <th class="centered cabecera"></th>
                                <th class="centered cabecera"></th>
                            </tr>
                        </thead>
                        <tbody id="tBodyVuelos">
                            <!-- Datos de ejemplo -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>
    <div class="foot d-flex justify-content-center align-items-end mt-5">
        <footer class="fixed-bottom text-center">
            <p>© 2024 SkyCater. Todos los derechos reservados.</p>
        </footer>
    </div>
    <!-- JavaScript de Bootstrap -->
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- JS DataTables CDN -->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
</body>

</html>