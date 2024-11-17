<?php
header('Content-Type: application/json');
require_once './include/Producto.php';
require_once './include/Messages.php';
session_start();

try {
    // Esto debe de venir desde el front
    if (isset($_POST['nombreProd'])) {
        $nombre = $_POST['nombreProd'];
    } else {
        throw new Exception(Messages::MISSING_ARGUMENTS);
    }

    $producto = new Producto();
    $resul = $producto->getIdProductoByName($nombre);

    if (!empty($resul)) {
        $idProducto = $resul[0]['Id_Producto'];

        // Llamada a la función de borrado
        $deleteSuccess = $producto->borraProductoById($idProducto);

        if ($deleteSuccess) {
            echo json_encode(['status' => 'success', 'message' => Messages::DELETE_PRODUCT_SUCCESS]);
        } else {
            echo json_encode(['status' => 'error', 'message' => Messages::DELETE_PRODUCT_FAILED]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => Messages::PRODUCT_NOT_FOUND]);
    }
} catch (Exception $e) {
    
    echo json_encode(['status' => 'error', 'message' => Messages::LOAD_DATA_ERROR]);
}
