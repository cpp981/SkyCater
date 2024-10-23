<?php
session_start();
if (!isset($_SESSION['nombre'])) {
    header('Location:login.php');
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Catering de Aerolínea</title>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <!-- css Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- css Fontawesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!--JSDelivr SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Estilos de Notyf -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css">
    <!-- Script de Notyf -->
    <script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>
    <!-- css DataTables CDN -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <script type="text/javascript" src="../js/inventario.js"></script>
</head>

<body class="d-flex flex-column"> <!--style="height: 100vh;" -->
    <div class="super d-flex flex-grow-1">
        <div class="sidebar rounded-bottom shadow" id="sidebar">
            <i id="cloud-logo" class="fas fa-2x fa-cloud mt-3"></i>
            <h4 class="text-white text-center mt-2">SkyCater</h4>
            <ul class="nav flex-column mt-5">
                <li class="nav-item">
                    <a class="nav-link text-white" href="index.php"><i class="fas fa-dashboard"></i> Dashboard</a>
                </li>
                <li class="nav-item mt-3">
                    <a class="nav-link text-white" href="listaVuelos.php"><i class="fas fa-plane-departure"></i>
                        Vuelos</a>
                </li>
                <li class="nav-item mt-3">
                    <a class="nav-link text-white" href="inventario.php"><i class="fas fa-clipboard-list"></i>
                        Inventario</a>
                </li>
                <li class="nav-item mt-3">
                    <a class="nav-link text-white" href="#"><i class="fas fa-truck-fast"></i> Pedidos</a>
                </li>
            </ul>
            <div class="d-flex justify-content-center align-items-end mt-5">
                <a class="nav-link text-white"><i class="fas fa-lg fa-moon"></i> Modo Oscuro</a>
            </div>
        </div>
        <div class="flex-grow-1 d-flex flex-column">
            <nav class="navbar navbar-light bg-light">
                <div class="">
                    <button class="btn border-light" id="sidebarToggle" style="color: #003262"><i
                            class="fas fa-lg fa-bars"></i> Menú</button>
                </div>
                <div id="session" class="ms-auto d-flex justify-content-center align-items-center">
                    <p class="mr-3" style="color:#003262; margin-bottom: 0;">Bienvenido,</p>
                    <input type="text" class="form-control d-inline-block w-25" id="inputId"
                        value="<?php echo $_SESSION['nombre']; ?>" disabled>
                    <button id="close" class="btn text-white shadow" style="background-color: #003262;">
                        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                    </button>
                </div>
            </nav>
            <div id="containerTablaProducto"
                class="container-fluid flex-grow-1 d-flex flex-column justify-content-center mt-4">
                <div class="text-center mt-5 mb-5" style="color: #003262;">
                    <h2>Gestión de Productos</h2>
                </div>
                <div id="contenedorDataTable" class="flex-grow-1">
                    <a id="addProd" class="btn btn-success shadow rounded" href="#"><i class="fas fa-plus"></i> Añadir
                        Producto</a>
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 ">
                        <table id="tablaProductos" class="table table-striped rounded shadow" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th class="centered cabecera">Nombre</th>
                                    <th class="centered cabecera">Categoría</th>
                                    <th class="centered cabecera">Alergenos</th>
                                    <th class="centered cabecera">Stock Actual</th>
                                    <th class="centered cabecera">Fecha última actualización</th>
                                    <th class="centered cabecera">Valor Nutricional</th>
                                    <th class="centered cabecera">Descripción</th>
                                </tr>
                            </thead>
                            <tbody id="tBodyProductos">
                                <!-- Datos de ejemplo -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- JS Bootstrap CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <!-- JS DataTables CDN -->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
</body>
<div class="foot d-flex justify-content-center align-items-end mt-5">
    <footer class="fixed-bottom text-center">
        <p>© 2024 SkyCater. Todos los derechos reservados.</p>
    </footer>
</div>

</html>