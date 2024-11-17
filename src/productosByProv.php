<?php
require_once './include/Proveedor.php';
header('Content-Type: application/json');
session_start();

try
{
    if(!isset($_POST['idProveedor']))
    {
        echo json_encode(['status' => 'error', 'message' => Messages::ERROR_MISSING_FIELDS]);
    }
    else
    {
        $id = $_POST['idProveedor'];
    }
    $proveedor = new Proveedor();
    $result = $proveedor->getProdByIdProveedor($id);

    // Almacenamos los proveedores en un array
    $nombre_productos = [];

    foreach($result as $nombre)
    {
        $nombre_productos[] = array_values($nombre);
    }
    echo json_encode($nombre_productos);
}catch(Exception $e)
{
    echo json_encode(['status' => 'error', 'message' => Messages::LOAD_DATA_ERROR]);
}
