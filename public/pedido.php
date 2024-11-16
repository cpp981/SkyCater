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
    <script type="text/javascript" src="../js/pedido.js"></script>
</head>

<body class="d-flex flex-column">
    <div class="super d-flex flex-grow-1">
        <div class="sidebar rounded-bottom shadow" id="sidebar">
            <div class="d-flex justify-content-center mt-3">
                <!-- Logo de la aplicación -->
                <a class="navbar-brand">
                    <img src="../img/LogoMenu.png" alt="Logo" class="rounded img-fluid logo-menu">
                    <p class="text-white text-center mt-2"><i
                            class="fas fa-user text-white me-1"></i><?php echo $_SESSION['nombre'] ?></p>
                </a>
            </div>
            <ul class="nav flex-column mt-5 justify-content-center align-content-between">
                <li class="nav-item mt-5">
                    <a class="nav-link" href="index.php"><i class="fas fa-dashboard"></i> Dashboard</a>
                </li>
                <li class="nav-item mt-3">
                    <a class="nav-link" href="listaVuelos.php"><i class="fas fa-plane-departure"></i> Vuelos</a>
                </li>
                <li class="nav-item mt-3">
                    <a class="nav-link" href="inventario.php"><i class="fas fa-clipboard-list"></i> Inventario</a>
                </li>
                <li class="nav-item mt-3">
                    <a class="nav-link" href="pedido.php"><i class="fas fa-truck-fast"></i> Pedidos</a>
                </li>
            </ul>
            <div class="d-flex justify-content-center align-items-end mt-5">
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
            <div class="d-flex flex-column">
                <!-- Título principal -->
                <div class="text-center mb-5" style="color: #003262;">
                    <h2>Gestión de Pedidos</h2>
                </div>

                <!-- Primer contenedor de tarjetas (pedidos completados y pendientes) -->
                <div class="d-flex align-items-center justify-content-center mb-4">
                    <div class="card bg-success me-2 p-3 mb-5 indi-pedidos text-center rounded shadow">
                        <p><i class="fas fa-truck-fast me-1"></i>Pedidos Completados</p>
                        <p class="text-center fw-bold" style="font-size: 2.5em;">50</p>
                    </div>
                    <div class="card bg-warning p-3 me-2 mb-5 indi-pedidos text-center rounded shadow">
                        <p><i class="fas fa-circle-exclamation me-1"></i>Total Pedidos Pendientes</p>
                        <p class="text-center fw-bold" style="font-size: 2.5em;">20</p>
                    </div>
                </div>

                <!-- Botones encima de las cards (se colocan fuera de las tarjetas) -->
                <div class="d-flex justify-content-center mb-4 me-5">
                    <!-- Botones "Añadir Pedido" y "Exportar PDF" -->
                    <div>
                        <button class="btn btn-success" style="max-width: 250px;"><i class="fas fa-plus me-1"></i>Añadir Pedido</button>
                        <button class="btn btn-danger me-5" style="max-width: 250px;"><i class="fas fa-file-pdf me-1"></i>Exportar PDF</button>
                    </div>
                    <!-- Botón "Refrescar" -->
                    <button class="btn btn-primary " style="max-width: 250px;"><i class="fas fa-redo me-1"></i>Refrescar</button>

                </div>

                <!-- Segundo contenedor de tarjetas (listados de pedidos completados y pendientes) -->
                <div class="d-flex justify-content-center mb-4">
                    <!-- Tarjeta "Listado Pedidos Completados" -->
                    <div class="card me-3 p-2 text-center rounded shadow" style="max-width: 250px;">
                        Listado Pedidos Completados
                    </div>

                    <!-- Tarjeta "Listado Pedidos Pendientes" -->
                    <div class="card p-2 text-center rounded shadow" style="max-width: 250px;">
                        Listado Pedidos Pendientes
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
        <script src="js/bootstrap.bundle.min.js"></script>
        <!-- JS DataTables CDN -->
        <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
</body>

</html>