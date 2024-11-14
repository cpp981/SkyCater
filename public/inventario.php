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
    <title>Gestión de Catering de Aerolínea</title>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <!-- CSS de DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS de Buttons para DataTables -->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
    <!-- css Fontawesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!--JSDelivr SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Estilos de Notyf -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css">
    <!-- Script de Notyf -->
    <script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>
    <link rel="stylesheet" href="../css/styles.css">
    <script type="text/javascript" src="../js/inventario.js"></script>
</head>

<body class="d-flex flex-column"> <!--style="height: 100vh;" -->
    <div class="super d-flex flex-grow-1">
        <div class="sidebar rounded-bottom shadow" id="sidebar">
        <div class="d-flex justify-content-center mt-3">
                <!-- Logo de la aplicación -->
                <a  class="navbar-brand">
                    <img src="../img/LogoMenu.png" alt="Logo" class="rounded img-fluid logo-menu">
                    <p class="text-white text-center mt-2"><i class="fas fa-user text-white me-1"></i><?php echo $_SESSION['nombre']?></p>
                </a>
            </div>
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
                    <a class="nav-link text-white" href="pedido.php"><i class="fas fa-truck-fast"></i> Pedidos</a>
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
                    <p class="mx-2" style="color:#003262; margin-bottom: 0;">Bienvenido,</p>
                    <input type="text" class="form-control d-inline-block w-25" id="inputId"
                        value="<?php echo $_SESSION['nombre']; ?>" disabled>
                    <button id="close" class="btn text-white shadow btn-danger">
                        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                    </button>
                </div>
            </nav>
            <div id="containerTablaProducto"
                class="container-fluid flex-grow-1 d-flex flex-column justify-content-center mt-4">
                <div class="text-center  mb-5" style="color: #003262;">
                    <h2>Gestión de Productos</h2>
                </div>
                <div id="contenedorDataTable" class="flex-grow-1">
                    <a id="addProd" class="btn btn-success shadow rounded" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">
                        <i class="fas fa-plus"></i> Añadir Producto
                    </a>
                    <a id="exportPdf" class="btn btn-refresh btn-danger shadow me-4 rounded">
                        <i class="fas fa-file-pdf"></i> Exportar a PDF</a>
                    <a id="refrescarTabla" class="btn btn-primary shadow rounded">
                        <i class="fas fa-redo"></i></a>
                    <!-- Modal -->
                    <div class="modal fade shadow" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Añadir Producto</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Formulario para añadir producto -->
                                    <form id="formularioProducto">
                                        <!-- Nombre del producto (Obligatorio) -->
                                        <div class="mb-3">
                                            <label for="nombreProducto" class="form-label">Nombre del Producto <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control border border-secondary"
                                                id="nombreProducto" required>
                                        </div>
                                        <!-- Descripción del producto (Opcional) -->
                                        <div class="mb-3">
                                            <label for="descripcionProducto" class="form-label">Descripción del
                                                Producto</label>
                                            <textarea class="form-control border border-secondary"
                                                id="descripcionProducto" rows="2" style="resize: none;"></textarea>
                                        </div>
                                        <!-- Categoría del producto (Obligatorio) -->
                                        <div class="mb-3">
                                            <label for="categoriaProducto" class="form-label">Categoría <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select border border-secondary" id="categoriaProducto"
                                                required>
                                                <option value="">Seleccione una categoría</option>
                                                <option value="Bebida">Bebida</option>
                                                <option value="Entrante">Entrante</option>
                                                <option value="Primer Plato">Primer Plato</option>
                                                <option value="Segundo Plato">Segundo Plato</option>
                                                <option value="Postre">Postre</option>
                                            </select>
                                        </div>
                                        <!-- Alérgenos (Obligatorio) -->
                                        <div class="mb-3">
                                            <label for="alergenosProducto" class="form-label">Alérgenos <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control border border-secondary"
                                                id="alergenosProducto" required>
                                        </div>
                                        <!-- Valor Nutricional (Opcional) -->
                                        <div class="mb-3">
                                            <label for="valorNutricional" class="form-label">Valor Nutricional</label>
                                            <input type="number" class="form-control border border-secondary"
                                                id="valorNutricional" rows="2" style="resize: none;"></input>
                                        </div>
                                        <!-- Id Proveedor (Opcional) -->
                                        <div class="mb-3">
                                            <label for="idProveedor" class="form-label">Id Proveedor</label>
                                            <input type="number" class="form-control border border-secondary"
                                                id="idProveedor" rows="2" style="resize: none;" disabled></input>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger"
                                        data-bs-dismiss="modal"></i>Cerrar</button>
                                    <button type="submit" id="guardarProducto" form="formularioProducto"
                                        class="btn btn-success"><i class="fas fa-save me-1"></i>Grabar
                                        Producto</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- DataTables para productos -->
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 ">
                        <table id="tablaProductos" class="table table-striped rounded shadow" style="width: 100%;">
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
                            <tbody id="tBodyProductos">
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
    <!-- Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <!-- PDFMake (necesario para la exportación a PDF en DataTables) -->
    <script type="text/javascript" charset="utf8"
        src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

    <!-- Exportación a HTML5 y Print (para PDF) -->
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
</body>
<div class="foot d-flex justify-content-center align-items-end mt-5">
    <footer class="fixed-bottom text-center">
        <p>© 2024 SkyCater. Todos los derechos reservados.</p>
    </footer>
</div>

</html>