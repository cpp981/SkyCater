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
    <!-- Faker CDN -->
    <script type="text/javascript" src="https://unpkg.com/faker@5.1.0/dist/faker.min.js"></script>
    <!-- css DataTables CDN -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <script type="text/javascript" src="../js/sideBar.js"></script>
    <script type="text/javascript" src="../js/pedidos.js"></script>
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
            <div class="position-relative">
                <img src="../img/SkyCaterPlane.png" class="custom-bg-image w-100"
                    style="height: 300px; object-fit: cover;">
                <div class="overlay"></div>
            </div>
            <div class="d-flex flex-column align-items-center">
                <!-- Título principal -->
                <div class="text-center mb-5" style="color: #003262;">
                    <h2>Gestión de Pedidos</h2>
                </div>
                <!-- Contenedor de los indicadores -->
                <div class="d-flex justify-content-between mb-5">
                    <!-- Card Indicador de Pedidos completados -->
                    <div class="card shadow text-center me-5" style="width: 35vh">
                        <div class="card-body">
                            <h5 class="card-title text-success">
                                <i class="fas fa-check-to-slot fa-lg"></i> Pedidos completados
                            </h5>
                            <p id="card-entregados" class="card-text fs-4 fw-bold text-dark"></p>
                        </div>
                    </div>

                    <!-- Card Indicador de Pedidos pendientes de entrega -->
                    <div class="card shadow text-center" style="width: 35vh">
                        <div class="card-body">
                            <h5 class="card-title text-warning">
                                <i class="fas fa-truck-fast fa-lg"></i> Pedidos pendientes
                            </h5>
                            </h5>
                            <p id="card-sin-entregar" class="card-text fs-4 fw-bold text-dark"></p>
                        </div>
                    </div>
                </div>
                <!-- DATATABLE -->
                <div id="contenedorDataTable" class="d-flex flex-column w-100" style="margin-top: -3vh;">
                    <div class="d-flex align-items-center" style="margin-left: 10.5vh; margin-top: -3vh;">
                        <!-- Contenedor con Flexbox para alinear los botones -->
                        <a id="addPedido" class="btn btn-success me-2 shadow">
                            <i class="fas fa-plus me-1"></i>Añadir Pedido
                        </a>
                        <a id="refreshPedido" class="btn btn-primary ms-2 me-2 shadow">
                            <i class="fas fa-redo me-1"></i>
                        </a>
                    </div>

                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12" style="width: 90%; margin-left: 10vh;">
                        <table id="tablaPedidos" class="table table-striped rounded shadow">
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
                            <tbody id="tBodyPedidos">
                                <!-- Aquí se llenará la tabla con los pedidos -->
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal para añadir pedido -->
    <div class="modal fade" id="modalPedido" tabindex="-1" aria-labelledby="modalPedidoLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPedidoLabel">Añadir Pedido</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form id="formPedido">
                        <div class="mb-3">
                            <label for="pedidoNombre" class="form-label">Nº de Pedido</label>
                            <input type="text" class="form-control" id="pedidoNum" placeholder="Número de Pedido"
                                disabled>
                        </div>
                        <div class="mb-3">
                            <?php
                            // Generamos la fecha actual en formato YYYY-MM-DD
                            $fechaHoy = date('Y-m-d'); ?>
                            <label for="pedidoFecha" class="form-label">Fecha de Entrega</label>
                            <input type="date" class="form-control" id="pedidoFecha" min=<?php echo $fechaHoy ?>>
                        </div>
                        <div class="mb-3">
                            <label for="proveedor" class="form-label">Proveedor</label>
                            <select class="form-control" id="proveedor">
                                <option value="">Seleccione una opción</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="producto" class="form-label">Producto</label>
                            <select class="form-control" id="producto">
                                <option value="">Seleccione una opción</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="pedidoCantidad" class="form-label">Cantidad</label>
                            <input type="number" class="form-control" id="pedidoCantidad" placeholder="Cantidad">
                        </div>
                        <div class="mb-3">
                            <label for="pedidoObservaciones" class="form-label">Observaciones</label>
                            <textarea class="form-control" id="pedidoObservaciones" rows="3"
                                style="resize: none;"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"></i>Cerrar</button>
                            <button type="submit" id="guardarEditProducto" class="btn btn-success"><i
                                    class="fas fa-save me-1"></i>Grabar Pedido</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript de Bootstrap -->
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- JS DataTables CDN -->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
</body>

</html>