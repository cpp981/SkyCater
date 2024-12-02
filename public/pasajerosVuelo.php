<?php
require_once '../src/session.php';
require_once '../src/timeSince.php';


if (!isset($_SESSION['nombre'])) {
    header('Location:index.html');
    exit();
}
// Si no hay parámetro id redirigimos
if (!isset($_GET['id'])) {
    header('Location:listaVuelos.php');
    exit();
}

// Si no hay parámetro id redirigimos
if (!isset($_GET['id'])) {
    header('Location:listaVuelos.php');
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
        <script type="text/javascript" src="../js/pasajeros.js"></script>
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
                            <?php if (basename($_SERVER['PHP_SELF']) == 'pasajerosVuelo.php') { ?>
                                <li class="nav-item mt-2">
                                    <a class="nav-link active" href="pasajerosVuelo.php?id=<?php echo $_GET['id']; ?>">
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
                <div class="container-fluid">
                    <!-- Título y botones -->
                    <div class="text-center mb-4">
                        <h2>Gestión del Vuelo <?php echo $_GET['id']; ?></h2>
                        <div class="btn-group mt-1" role="group" aria-label="Botones de navegación">
                            <button type="button" class="btn btn-primary rounded-pill me-4" id="detallesBtn"><i
                                    class="fas fa-circle-info me-2"></i>Detalles</button>
                            <button type="button" class="btn btn-light rounded-pill" id="pasajerosBtn"><i
                                    class="fas fa-person me-2"></i>Pasajeros</button>
                            <a href="listaVuelos.php" class="btn btn-light rounded-pill ms-4"><i
                                    class="fas fa-arrow-left-long me-2"></i>Volver</a>
                        </div>
                    </div>
                    <!-- Contenedor dividido en dos y centrado -->
                    <div class="row justify-content-center custom-row">
                        <!-- Columna de la tabla (contenedor izquierdo) -->
                        <div class="col-md-5 text-center d-flex flex-column custom-left-container">
                            <h4>Listado de pasajeros</h4>
                            <table id="tablaPasajeros"
                                class="table table-bordered table-hover table-striped rounded shadow">
                                <thead>
                                    <tr class="small">
                                        <th>Pasajero</th>
                                        <th>Intolerancias</th>
                                        <th>Preferencias</th>
                                        <th>Asiento</th>
                                        <th>Plato 1</th>
                                        <th>Plato 2</th>
                                        <th>Bebida</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Los datos se cargarán dinámicamente aquí -->
                                </tbody>
                            </table>
                        </div>

                        <!-- Barra Vertical -->
                        <div class="col-md-1 d-flex justify-content-center align-items-center custom-vertical-bar">
                            <div class="vr"></div>
                        </div>

                        <!-- Columna de gestión (contenedor derecho) -->
                        <div class="col-md-5 text-center gestion-col d-flex flex-column custom-right-container">
                            <h4>Gestión menú por pasajero</h4>
                            <div id="fichaPasajero"></div>
                            <div id="gestionMenuPasajero">
                                <div class="loading-message">
                                    <i class="fas fa-cogs fa-spin fa-3x"></i>
                                    <p>Seleccione un pasajero para gestionar su menú.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botón de guardar vuelo al final de la lista de pasajeros -->
                    <div class="row justify-content-center guarda-vuelo mt-3">
                        <button class="btn btn-success w-25 shadow rounded" id="guardarVueloBtn">
                            <i class="me-1 fas fa-save"></i>Guardar vuelo
                        </button>
                    </div>
                </div>

                <!-- Scripts de Bootstrap y DataTables -->
                <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
                <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
                <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
    </body>
    <div class="foot d-flex justify-content-center align-items-end mt-5">
        <footer class="fixed-bottom text-center">
            <p>© 2024 SkyCater. Todos los derechos reservados.</p>
        </footer>
    </div>

    <?php
} else {
    header('Location: listaVuelos.php');
    //echo "No se ha especificado un vuelo.";
}
?>