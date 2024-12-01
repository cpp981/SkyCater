<?php
require_once './include/Proveedor.php';
require_once './include/Pedido.php';
require_once './include/Producto.php';
require_once './include/Messages.php';
//header('Content-Type: application/json');
session_start();

try {
    // Verificar si los datos requeridos están presentes en la solicitud
    if (!isset($_POST['numeroDePedido'], $_POST['nombreProducto'], $_POST['fechaEntrega'], $_POST['productoId'], $_POST['cantidad'], $_POST['precioProducto'], $_POST['costeTotal'], $_POST['proveedorId'])) {
        echo json_encode(['status' => 'error', 'message' => Messages::ERROR_MISSING_FIELDS]);
        exit;
    }

    // Obtener los valores de la solicitud
    $numeroDePedido = $_POST['numeroDePedido']; 
    $fechaEntrega = $_POST['fechaEntrega'];
    $productoId = $_POST['productoId'];
    $nombreProducto = $_POST['nombreProducto'];
    $cantidad = $_POST['cantidad'];
    $precioProducto = $_POST['precioProducto'];
    $costeTotal = $_POST['costeTotal'];  // Recibimos el coste total
    $observaciones = $_POST['observaciones'];
    $proveedorId = $_POST['proveedorId']; 
    $idUser = $_SESSION['user_id'];  // Obtenemos el Id del Usuario conectado
    // Obtener la fecha actual en formato datetime para la base de datos
    $fechaActual = date('Y-m-d H:i:s');  // Formato: 'YYYY-MM-DD HH:MM:SS'

    // Validar el número de pedido (debe ser un número positivo)
    if (!is_numeric($numeroDePedido) || $numeroDePedido <= 0) {
        echo json_encode(['status' => 'error', 'message' => Messages::NUM_ORDER_NOT_VALID]);
        exit;
    }

    // Validar que la fecha de entrega sea una fecha válida
    if (!strtotime($fechaEntrega)) {
        echo json_encode(['status' => 'error', 'message' => Messages::DATE_ORDER_NOT_VALID]);
        exit;
    }

    // Asegurarse de que la fecha de entrega está en el formato adecuado
    // Si la hora no está incluida en la fecha de entrega, le asignamos una hora predeterminada
    $fechaEntrega = date('Y-m-d H:i:s', strtotime($fechaEntrega . ' 00:00:00'));

    // Validar que el producto ID sea un número entero válido
    if (!is_numeric($productoId) || $productoId <= 0) {
        echo json_encode(['status' => 'error', 'message' => Messages::PRODUCT_NOT_FOUND]);
        exit;
    }

    // Validar que la cantidad sea un número entero positivo
    if (!is_numeric($cantidad) || $cantidad <= 0) {
        echo json_encode(['status' => 'error', 'message' => Messages::NOT_VALID_QUANTITY]);
        exit;
    }

    // Validar que el precio del producto sea un número válido
    if (!is_numeric($precioProducto) || $precioProducto < 0) {
        echo json_encode(['status' => 'error', 'message' => Messages::PRODUCT_PRICE_NOT_VALID]);
        exit;
    }

    // Sanitizar las observaciones para prevenir XSS
    $observaciones = htmlspecialchars($observaciones, ENT_QUOTES, 'UTF-8');

    // Crear el objeto Pedido
    $pedido = new Pedido();

    // Intentamos crear el pedido
    $resultado = $pedido->crearPedido($numeroDePedido, $fechaActual, $costeTotal, $observaciones, $proveedorId, $idUser, $nombreProducto, $cantidad, $precioProducto, $fechaEntrega, $proveedorId);

    // Verificamos el resultado
    if ($resultado) {
        echo json_encode(['status' => 'success', 'message' => Messages::ORDER_CREATED_SUCCESSFULLY]);
    } else {
        echo json_encode(['status' => 'error', 'message' => Messages::ORDER_CREATED_ERROR]);
    }

} catch (Exception $e) {
    // Capturar cualquier excepción y devolver un error al frontend
    echo json_encode(['status' => 'error', 'message' => Messages::LOAD_DATA_ERROR]);
}

