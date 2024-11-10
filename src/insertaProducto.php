<?php
// Incluir el archivo de la clase Producto y la clase Messages
require './include/Producto.php';
require './include/Messages.php';

// Establecer el tipo de contenido como JSON
header('Content-Type: application/json');

// Comprobar si los datos obligatorios están presentes
if (!isset($_POST['nombre']) || !isset($_POST['categoria']) || !isset($_POST['alergenos'])) {
    // Si falta alguno de los campos obligatorios, devolver un error
    echo json_encode(['status' => 'error', 'message' => Messages::ERROR_MISSING_FIELDS]);
    exit();
}

// Sanitizar y validar los datos recibidos
$nombre = htmlspecialchars(trim($_POST['nombre']));
$descripcion = isset($_POST['descripcion']) ? htmlspecialchars(trim($_POST['descripcion'])) : null; // Descripción es opcional
$categoria = htmlspecialchars(trim($_POST['categoria']));
$alergenos = htmlspecialchars(trim($_POST['alergenos']));
$valorNutricional = isset($_POST['valorNutricional']) ? htmlspecialchars(trim($_POST['valorNutricional'])) : null; // Valor Nutricional es opcional
$idProveedor = isset ($_POST['idProveedor']) ? htmlspecialchars(trim($_POST['idProveedor'])) : null; // Id Proveedor es opcional
$fechaActualizacion = date('Y-m-d H:i:s');
$stockDisponible = 0; // Se guarda un producto con Stock 0. Solo sumamos stock al hacer pedido.

// Validar los campos obligatorios
if (empty($nombre) || empty($categoria) || empty($alergenos)) {
    // Si algún campo obligatorio está vacío, devolver un error
    echo json_encode(['status' => 'error', 'message' => Messages::ERROR_VALIDATION_FAILED]);
    exit();
}

// Crear una instancia de la clase Producto
$producto = new Producto();

// Intentar insertar el producto en la base de datos
try {
    // Llamar al método insertaProducto() para guardar el producto
    $producto->insertaProducto($nombre, $descripcion, $categoria, $alergenos, $stockDisponible, $fechaActualizacion, $valorNutricional, $idProveedor);
    
    // Si todo va bien, devolver un mensaje de éxito
    echo json_encode(['status' => 'success', 'message' => Messages::SUCCESS_PRODUCT_SAVED]);
} catch (Exception $e) {
    // Si ocurre un error, devolver el mensaje de error
    echo json_encode(['status' => 'error', 'message' => Messages::ERROR_INSERT_PRODUCT]);
}

