<?php
require_once './include/Proveedor.php';
require_once './include/Messages.php';
header('Content-Type: application/json');
session_start();

try {
    if (!isset($_POST['idProveedor'])) {
        echo json_encode(['status' => 'error', 'message' => Messages::ERROR_MISSING_FIELDS]);
    } else {
        $id = $_POST['idProveedor'];
    }

    $proveedor = new Proveedor();
    $productos = $proveedor->getProdByIdProveedor($id);

    // Creamos un array para almacenar los datos en formato adecuado
    $productosArray = [];

    foreach ($productos as $producto) {
        // Extraemos el nombre y el ID de cada producto
        $productosArray[] = [
            'Nombre' => $producto['Nombre'],
            'Id_Producto' => $producto['Id_Producto'],
            'Categoria' => $producto['Categoria']
        ];
    }

    // Convertimos el array en formato JSON y lo enviamos
    echo json_encode([
        'status' => 'success',
        'productos' => $productosArray // Aquí pasamos los productos correctamente
    ]);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => Messages::LOAD_DATA_ERROR]);
}