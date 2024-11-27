<?php
require_once './include/Producto.php';
require_once './include/Messages.php';
header('Content-Type: application/json');
session_start();

try {
    $producto = new Producto();
    $primeros = $producto->getPrimerosPlatos();
    $segundos = $producto->getSegundosPlatos();
    $bebida = $producto->getBebidas();

    // Crear un array asociativo con los productos
    $productos = [
        'primerPlato' => $primeros,
        'segundoPlato' => $segundos,
        'postre' => $bebida
    ];

    // Devolver los productos como JSON
    echo json_encode(['status' => 'success', 'data' => $productos]);
} catch (Exception $e) {
    // Manejar cualquier excepción y enviar error
    echo json_encode(['status' => 'error', 'message' => Messages::LOAD_DATA_ERROR]);
}
