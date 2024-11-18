<?php
header('Content-Type: application/json');

require_once './include/Proveedor.php';
require_once './include/Producto.php';
require_once './include/Messages.php';
session_start();

try
{
    if(isset($_GET['nombreProducto']))
    {
        $np = $_GET['nombreProducto'];
    }
    else 
    {
        throw new Exception(Messages::MISSING_ARGUMENTS);
    }
    $producto = new Producto();
    $arrayId = $producto->getIdProveedorByProductName($np);
    //var_dump($arrayId[0]['Id_Proveedor']);
    $idProveedor = $arrayId[0]['Id_Proveedor'];
    $proveedor = new Proveedor();
    $result = $proveedor->getNombreProveedorById($idProveedor);
    // Devolvemos el json con el nombre del proveedor
    echo json_encode($result);
}catch(Exception $e)
{
    echo json_encode(['status' => 'error', 'message' => Messages::LOAD_DATA_ERROR]);
}
