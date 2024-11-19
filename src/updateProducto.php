<?php
header('Content-Type: application/json');
require_once './include/Producto.php';
require_once './include/Proveedor.php';
session_start();



// Comprobar si los datos obligatorios están presentes
if (!isset($_POST['nombre']) || !isset($_POST['categoria']) || !isset($_POST['alergenos'])) 
{
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
$idProveedor = isset($_POST['idProveedor']) ? htmlspecialchars(trim($_POST['idProveedor'])) : null; // Id Proveedor es opcional
$fechaActualizacion = date('Y-m-d H:i:s');

// Validar los campos obligatorios
if (empty($nombre) || empty($categoria) || empty($alergenos)) 
{
    // Si algún campo obligatorio está vacío, devolver un error
    echo json_encode(['status' => 'error', 'message' => Messages::ERROR_VALIDATION_FAILED]);
    exit();
}

$producto = new Producto();
try 
{
    $idProdArray = $producto->getIdProductoByName($nombre);
    $idProd = $idProdArray[0]['Id_Producto'];
    //var_dump($idProd);
    $producto->updateProductById($nombre,$categoria,$alergenos,$valorNutricional,$descripcion,$idProd);

    echo json_encode(['status' => 'success', 'message' => Messages::UPDATE_PRODUCT_SUCCESS]);
} 
catch (PDOException $e) 
{
    echo json_encode(['status' => 'error', 'message' => Messages::UPDATE_PRODUCT_ERROR]);
}