<?php
require_once './include/Proveedor.php';
require_once './include/Messages.php';
header('Content-Type: application/json');
session_start();

try
{
    $proveedor = new Proveedor();
    $result = $proveedor->getNombresProveedores();

    // Almacenamos los proveedores en un array
    $nombre_proveedores = [];

    foreach($result as $nombre)
    {
        $nombre_proveedores[] = array_values($nombre);
    }
    echo json_encode($nombre_proveedores);
}catch(Exception $e)
{
    echo json_encode(['status' => 'error', 'message' => Messages::LOAD_DATA_ERROR]);
}
